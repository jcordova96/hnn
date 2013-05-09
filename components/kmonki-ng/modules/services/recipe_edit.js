angular.module('kmSvcRecipeEdit', ['kmSvcApi', 'kmSvcTimer']).factory('recipeSvc', ['$rootScope', 'apiSvc', 'timerSvc', function($rootScope, apiSvc, timerSvc) {

    var serviceName = 'recipeSvc',
        changeDelay = 1000,
        recipe;

    var regExpEscape = function(str) {
        return (str+'').replace(/(\[.?\*+\^$[\]\\(\){}|\-])/g, "\\$1");
    };

    var ingredientPrep = function(data) {
        return {
            ingredient: {
                id: (data.ingredient_id ? data.ingredient_id : 0),
                name: (data.ingredient ? data.ingredient : ''),
                custom: (!data.ingredient_id)
            },
            prep: (data.prep ? data.prep : ''),
            quantity: (data.quantity ? data.quantity : 0),
            unit: {
                id: (data.unit_id ? data.unit_id : 0),
                name: (data.unit ? data.unit : '')
            }
        };
    };

    var svc = {
        broadcast: function() {
            var eventName = arguments[0];
            var events = eventName.split(' ');
            for (var i=0; i<events.length; i++) {
                var args = [].slice.call(arguments, 0);
                args[0] = serviceName+'.'+events[i];
                log(args);
                $rootScope.$broadcast.apply($rootScope, args);
            }
        },
        on: function(eventName, fn) {
            var events = eventName.split(' ');
            $.each(events, function(i,v) {
                eventName = events[i];
                $rootScope.$on(serviceName+'.'+eventName, function() {
                    var args = [].slice.call(arguments, 0);
                    var e = args[0];
                    e.service = serviceName;
                    e.serviceEvent = eventName;
                    args[0] = e;
                    fn.apply(null, args);
                });
            });
        },
        setData: function(data) {
            recipe = data;
            // replace step ingredients with references to recipe ingredients
            $.each(recipe.steps, function(i,step) {
                $.each(step.ingredients, function(ii,ing) {
                    step.ingredients[ii] = svc.getIngredient(ing.id);
                });
            });

            recipe._error = {};
            recipe._errors = [];
            recipe._dirty = {};
            svc.validate();
        },
        data: function() {
            return recipe;
        },
        getById: function(array, id, key, returnIndex) {
            key = key || 'id';
            var item = false;
            $.each(array, function(i,v) {
                if (parseInt(v[key], 10) === parseInt(id, 10)) {
                    item = returnIndex ? i : v;
                    return false;
                }
            });
            return item;
        },
        getStep: function(step_id, returnIndex) {
            return svc.getById(recipe.steps, step_id, 'id', returnIndex);
        },
        stepAdd: function(text) {
            var new_step = {
                description: (text || ""),
                ingredients: []
            };
            recipe.steps.push(new_step);
            var new_step_index = recipe.steps.indexOf(new_step);
            svc.broadcast('step.add.done');
            svc.validate();
            apiSvc.request('/recipe/'+recipe.id+'/step', 'post', {description:new_step.description,sequence:svc.stepMaxSequence()}, 10).then(function(data) {
                $rootScope.$apply(function() {
                    recipe.steps[new_step_index].id = data.step.id;
                    recipe.steps[new_step_index].sequence = data.step.sequence;
                });
                svc.broadcast('step.add.done.server', data);
            });
        },
        stepDelete: function(step_id) {
            $.each(recipe.steps, function(step_i,step) {
                if (step.id === step_id) {
                    var unassign_ids = [];
                    $.each(step.ingredients, function(i,v) {
                        unassign_ids.push(v.id);
                    });
                    $.each(unassign_ids, function(i,v) {
                        svc.stepIngredientUnassign(v);
                    });
                    recipe.steps.splice(step_i, 1);
                    return false;
                }
            });
            svc.broadcast('step.delete.done', step_id);
            svc.validate();
            apiSvc.request('/recipe/'+recipe.id+'/step/'+step_id, 'delete', {}, changeDelay).then(function(data) {
                svc.broadcast('step.delete.done.server', data);
            });
        },
        stepDescriptionUpdate: function(step_id, description) {
            recipe._dirty[['step',step_id,'description'].join('.')] = true;
            var params = {steps:[{
                id: step_id,
                description: description
            }]};
            svc.broadcast('step.description_update.done');
            svc.validate();
            timerSvc.start(changeDelay, 'stepDescriptionUpdate', step_id).then(function() {
                apiSvc.request('/recipe/'+recipe.id, 'put', {data:JSON.stringify(params)}).then(function(data) {
                    svc.broadcast('step.description_update.done.server', data);
                });
            });
        },
        stepMaxSequence: function() {
            var max = 0;
            $.each(recipe.steps, function(i,v) {
                max = v.sequence > max ? v.sequence : max;
            });
            return max*1+1;
        },
        getStepIngredient: function(recipe_ingredient_id, returnIndex) {
            var ing = svc.getIngredient(recipe.ingredients, recipe_ingredient_id);
            var step_index = svc.getStep(recipe.steps, ing.recipe_step_id, true);
            return svc.getById(recipe.steps[step_index].ingredients, recipe_ingredient_id, 'id', returnIndex);
        },
        getIngredient: function(recipe_ingredient_id, returnIndex) {
            return svc.getById(recipe.ingredients, recipe_ingredient_id, 'id', returnIndex);
        },
        applySequence: function() {
            var step_ing_sequence = 0;
            var step_sequence = 0;
            $.each(recipe.ingredients, function(i,v) {
                if (!v.recipe_step_id) {
                    v.sequence = step_ing_sequence;
                    step_ing_sequence++;
                }
            });
            $.each(recipe.steps, function(i,v) {
                v.sequence = step_sequence;
                step_sequence++;
                $.each(v.ingredients, function(ii,vv) {
                    if (vv.recipe_step_id) {
                        vv.sequence = step_ing_sequence;
                        step_ing_sequence++;
                    }
                });
            });
            svc.broadcast('sequence.save.done');
            svc.validate();

            var params = {};
            params.ingredients = [];
            $.each(recipe.ingredients, function(i,v) {
                if (v.id)
                    params.ingredients.push({id:v.id,sequence:v.sequence});
            });
            params.steps = [];
            $.each(recipe.steps, function(i,v) {
                if (v.id)
                    params.steps.push({id:v.id,sequence:v.sequence});
            });

            if (params.steps.length || params.ingredients.length) {
                apiSvc.request('/recipe/'+recipe.id, 'put', {data:JSON.stringify(params)}, changeDelay).then(function(response) {
                    svc.broadcast('sequence.save.done.server', response);
                });
            }
        },
        ingredientAdd: function(data) {
            var ing = ingredientPrep(data);
            var index = recipe.ingredients.push(ing)-1;
            svc.broadcast('ing.add.done');
            svc.validate();
            var params = {
                step_id: 0,
                sequence: 0,
                ingredient_custom: (!data.ingredient_id ? 1 : 0),
                quantity: data.quantity,
                ingredient_id: data.ingredient_id,
                unit_id: data.unit_id,
                prep: data.prep
            };
            if (params.ingredient_custom)
                params.ingredient_custom_name = data.ingredient;
            apiSvc.request('/recipe/'+recipe.id+'/ingredient', 'post', params, changeDelay).then(function(data) {
                $rootScope.$apply(function() {
                    recipe.ingredients[index] = data.ingredient;
                });
                svc.broadcast('ing.add.done.server', data);
            });
        },
        ingredientUpdate: function(data) {
            var ing = ingredientPrep(data);
            var recipe_ing = svc.getIngredient(data.editing_ingredient);
            recipe_ing.id = 0;
            recipe_ing.quantity = data.quantity;
            recipe_ing.ingredient.custom = (!data.ingredient_id ? 1 : 0);
            recipe_ing.ingredient.name = data.ingredient;
            recipe_ing.ingredient.id = data.ingredient_id;
            recipe_ing.unit.name = data.unit;
            recipe_ing.unit.id = data.unit_id;
            recipe_ing.prep = data.prep;

            svc.broadcast('ing.update.done');
            svc.validate();

            var params_ing = {
                id: data.editing_ingredient,
                ingredient_custom: (!data.ingredient_id ? 1 : 0),
                quantity: data.quantity,
                ingredient_id: data.ingredient_id,
                unit_id: data.unit_id,
                prep: data.prep
            };
            if (params_ing.ingredient_custom)
                params_ing.ingredient_custom_name = data.ingredient;
            var params = {ingredients:[params_ing]};

            apiSvc.request('/recipe/'+recipe.id, 'put', {data:JSON.stringify(params)}, changeDelay).then(function(response) {
                $rootScope.$apply(function() {
                    recipe_ing.id = data.editing_ingredient;
                });
                svc.broadcast('ing.update.done.server', response);
            });
        },
        ingredientDelete: function(id) {
            // id - recipe ingredient id
            var success = false;
            $.each(recipe.ingredients, function(i,v) {
                if (v.id === id) {
                    recipe.ingredients.splice(i,1);
                    return false;
                }
            });
            $.each(recipe.steps, function(step_i,step) {
                $.each(step.ingredients, function (i,v) {
                    if (v.id === id) {
                        step.ingredients.splice(i,1);
                        return false;
                    }
                });
            });
            svc.broadcast('ing.delete.done');
            svc.validate();
            apiSvc.request('/recipe/'+recipe.id+'/ingredient/'+id, 'delete', {}, changeDelay).then(function(data) {
                svc.broadcast('ing.delete.done.server', data);
            });
        },
        ingredientDeleteAll: function() {
            var ids = [];
            $.each(recipe.ingredients, function(i,v) {
                ids.push(v.id);
            });
            $.each(ids, function(i,v) {
                svc.ingredientDelete(v);
            });
        },
        getUnassignedIngredients: function() {
            var ings = [];
            $.each(recipe.ingredients, function(i,v) {
                if (!v.recipe_step_id)
                    ings.push(v);
            });
            return ings;
        },
        stepIngredientMove: function(step_index_old, ing_index_old, step_index_new, ing_index_new) {
            recipe.steps[step_index_new].ingredients.splice(ing_index_new, 0, recipe.steps[step_index_old].ingredients.splice(ing_index_old, 1)[0]);

            var step = recipe.steps[step_index_new];
            var ing = step.ingredients[ing_index_new];

            ing.recipe_step_id = step.id;

            svc.broadcast('step_ing.move.done', step_index_old, ing_index_old, step_index_new, ing_index_new, ing);
            svc.validate();

            var params = {};
            params.ingredients = [];
            params.ingredients.push({id:ing.id,recipe_step_id:ing.recipe_step_id});
            apiSvc.request('/recipe/'+recipe.id, 'put', {data:JSON.stringify(params)}, changeDelay).then(function(response) {
                svc.broadcast('step_ing.move.done.server', step_index_old, ing_index_old, step_index_new, ing_index_new, ing);
            });
        },
        stepIngredientAssign: function(ing_id, step_id) {
            var step = svc.getStep(step_id);
            var ing = svc.getIngredient(ing_id);
            ing.recipe_step_id = step.id;
            step.ingredients.push(ing);
            svc.broadcast('step_ing.assign.done', ing, step);
            svc.validate();

            var params = {ingredients:[{
                id: ing_id,
                recipe_step_id: step_id
            }]};
            apiSvc.request('/recipe/'+recipe.id, 'put', {data:JSON.stringify(params)}, changeDelay).then(function(data) {
                svc.broadcast('step_ing.assign.done.server', ing, step);
            });
        },
        stepIngredientUnassign: function(ing_id) {
            var id = ing_id;
            $.each(recipe.steps, function(step_index, step) {
                $.each(step.ingredients, function(ing_index, ing) {
                    if (ing.id === id) {
                        step.ingredients.splice(ing_index, 1);
                        return false;
                    }
                });
            });
            $.each(recipe.ingredients, function(i,v) {
                if (v.id === id) {
                    v.recipe_step_id = 0;
                    return false;
                }
            });
            svc.broadcast('step_ing.unassign.done', id);
            svc.validate();

            var params = {ingredients:[{
                id: ing_id,
                recipe_step_id: 0
            }]};
            apiSvc.request('/recipe/'+recipe.id, 'put', {data:JSON.stringify(params)}, changeDelay).then(function(data) {
                svc.broadcast('step_ing.unassign.done.server', id);
            });
        },
        parseAddIngredients: function(text) {
            svc.broadcast('ing.parse.start');
            var dfd = $.Deferred();
            if (!text) {
                dfd.resolve(false);
            } else {
                $.post('/ajax_common/temp_parser', {text:text}, function(data) {
                    $.each(data, function(i, parsed) {
                        var ing = {};
                        var name = "";
                        var prep = parsed.preprep;

                        if (parsed.ings.length) {
                            name = parsed.ings[0].name_common;
                            var replace = [];
                            var first_ing = parsed.ings[0];
                            if (first_ing.name_plural.length) replace.push(regExpEscape(first_ing.name_plural));
                            if (first_ing.name_common.length) replace.push(regExpEscape(first_ing.name_common));
                            if (first_ing.name_nomenclature.length) replace.push(regExpEscape(first_ing.name_nomenclature));
                            var leftover = parsed.ing_leftover
                                .replace(new RegExp('\\b'+replace.join('\\b|\\b')+'\\b', 'ig'), ' ')
                                .replace(/[^A-Za-z0-9 ]/g, '') // remove commas and stuff
                                .replace(/\s+/g, ' ') // remove double spaces
                                .replace(/^[\s\uFEFF]+|[\s\uFEFF]+$/g,''); // trim
                            if (leftover.length)
                                prep.unshift(leftover);
                            ing.ingredient = name;
                            ing.ingredient_custom = 0;
                            ing.ingredient_id = parsed.ings[0].id;
                        } else {
                            ing.ingredient = parsed.ing_leftover;
                            ing.ingredient_custom = 1;
                            ing.ingredient_id = 0;
                        }

                        if (parsed.unit) {
                            ing.unit = parsed.unit.name;
                            ing.unit_id = parsed.unit.id;
                        }

                        ing.prep = prep.join(', ');
                        ing.quantity = Math.round(parsed.quantity*1000)/1000;

                        svc.ingredientAdd(ing);
                    });
                    dfd.resolve(true);
                    svc.broadcast('ing.parse.done ing.parse.done.server', data);
                    svc.validate();
                }, 'json');
            }
            return dfd.promise();
        },
        parseAddSteps: function(text) {
            svc.broadcast('step.parse.start');
            var dfd = $.Deferred();

            if (!text) {
                dfd.resolve(false);
            } else {
                // using a short timeout so this can be called in the same $.when() as parseAddIngredients without triggering angular's digest in progress error
                setTimeout(function() {
                    var steps = text.split(/\s*\n\s*/);
                    $.each(steps, function(i,v) {
                        // remove 1. 2) 3.) 4). at beginning
                        v = v.replace(/^\d{1,3}(\.|\)|\.\)|\)\.)*\s+/, '');
                        svc.stepAdd(v);
                    });

                    dfd.resolve(true);
                    svc.broadcast('step.parse.done', steps);
                    svc.validate();
                }, 50);
            }
            return dfd.promise();
        },
        parseUrl: function(url) {
            svc.broadcast('url.parse.start');
            return $.post('/adder/ripper', {url:url}, function() {
                svc.broadcast('url.parse.done');
            }, 'json').promise();
        },
        fieldUpdate: function(field, value) {
            recipe._dirty[field] = true;
            svc.validate();
            var field_error = !!recipe._error[field];//_.chain(recipe._errors).pluck('field').contains(field).value();
            if (!field_error) {
                svc.broadcast('field.update.done');
                var params = {};
                params[field] = value;
                timerSvc.start(changeDelay, 'fieldUpdate', field).then(function() {
                    apiSvc.request('/recipe/'+recipe.id, 'put', {data:JSON.stringify(params)}).then(function(data) {
                        svc.broadcast('field.update.done.server', data);
                    });
                });
            }
        },
        tagsUpdate: function(ids) {
            var params = {
                tags: ids
            };
            apiSvc.request('/recipe/'+recipe.id, 'put', {data:JSON.stringify(params)}).then(function(data) {
                var updated_tags = data.updated_tags;
                if (updated_tags && updated_tags.length) {
                    updated_tags.sort(function (a,b) {
                        return a.name > b.name;
                    });
                }
                recipe.tags = updated_tags;
                svc.broadcast('tags.update.done tags.update.done.server');
                svc.validate();
            });
        },
        photoDelete: function(id) {
            $.each(recipe.photos, function(i,v) {
                if (v.id === id) {
                    recipe.photos.splice(i,1);
                    return false;
                }
            });

            svc.broadcast('photo.delete.done');
            svc.validate();

            apiSvc.request('/photo/'+id, 'delete', {}).then(function(data) {
                svc.broadcast('photo.delete.done.server', data);
            });
        },
        photoMakeMain: function(id) {
            var main_photo_index = 0;

            $.each(recipe.photos, function(i,v) {
                if (v.id === id) {
                    v.is_main = true;
                    main_photo_index = i;
                } else {
                    v.is_main = false;
                }
            });

            recipe.photos.splice(0, 0, recipe.photos.splice(main_photo_index, 1)[0]);

            svc.broadcast('photo.make_main.done');
            svc.validate();

            apiSvc.request('/photo/'+id, 'post', {is_main:1}).then(function(data) { // TODO: change to PUT when it's changed on api
                svc.broadcast('photo.make_main.done.server', data);
            });
        },
        sharedWithUpdate: function(ids) {

            // accepts [1,2,3] or [{id:1},{id:2},{id:3}] (unaffected by other props)
            ids = _(ids).map(function(v) {
                return (typeof v === 'object' && v.id) ? parseInt(v.id, 10) : parseInt(v, 10);
            }).compact().value();

            svc.broadcast('recipe.shared_with.update.done');
            svc.validate();

            var params = {shared_with:ids};

            apiSvc.request('/recipe/'+recipe.id, 'put', {data:JSON.stringify(params)}, changeDelay).then(function(data) {
                if (data.success) {
                    $rootScope.$apply(function() {
                        recipe.shared_with = data.updated_shared_with;
                    });
                    svc.broadcast('recipe.shared_with.update.done.server', data);
                }
            });

        },
        publish: function() {

            svc.broadcast('recipe.publish.done');
            svc.validate();

            apiSvc.request('/recipe/'+recipe.id+'/publish', 'put', {}, changeDelay).then(function(data) {
                if (data.success) {
                    $rootScope.$apply(function() {
                        recipe.is_published = true;
                        recipe.created = data.created_time;
                        recipe.modified = data.modified_time;
                    });
                    svc.broadcast('recipe.publish.done.server', data);
                } else {
                    svc.broadcast('recipe.publish.fail', data);
                }
            });

        },
        validate: function() {
            recipe._errors = [];
            recipe._error = {};
            var setError = function(field, message) {
                var err = {
                    'field': field,
                    'message': message,
                    'dirty': !!recipe._dirty[field],
                    'pristine': !recipe._dirty[field]
                };
                recipe._errors.push(err);
                if (!recipe._error[field])
                    recipe._error[field] = [];
                recipe._error[field].push(err);
            };

            if (!recipe.title || recipe.title.length === 0) {
                setError('title', 'The recipe title is required');
            } else if (!recipe.title.match(/[A-Za-z]+.*[A-Za-z]+.*[A-Za-z]/)) {
                setError('title', 'The recipe title needs at least 3 letters');
            }

            _.each(recipe.steps, function(v) {
                if (!v.description) {
                    setError(['step',v.id,'description'].join('.'), 'Step '+(recipe.steps.indexOf(v)+1)+' has no text');
                }
            });

            var unassigned = svc.getUnassignedIngredients().length;
            if (unassigned) {
                setError('unassigned.ingredients', 'You still have '+unassigned+' unassigned ingredients');
            }

            return recipe._errors.length === 0;
        }
    };

    svc.on('ing.add.done.server step_ing.move.done step_ing.assign.done step_ing.unassign.done ing.parse.done step.delete.done', function(e) {
        svc.applySequence();
    });

    return svc;

}]);