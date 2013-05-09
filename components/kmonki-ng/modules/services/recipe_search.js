angular.module('kmSvcRecipeSearch', ['kmSvcEvents', 'kmSvcApi', 'kmSvcTimer', 'kmSvcMetaData']).factory('kmRecipeSearch', ['kmEvents', '$q', 'kmApi', 'kmTimer', 'kmMetaData', function(events, $q, api, timer, metaData) {

    return function() {

        var svc = this,
            serviceName = 'kmRecipeSearch',
            sortPristine = true,
            changeDelay = 1000,
            instantiationTime = (new Date().getTime());

        svc.broadcast = events.getBroadcastFn(serviceName+'.'+instantiationTime);
        svc.on = events.getOnFn(serviceName+'.'+instantiationTime);

        svc.searchParams = {
            return_fields: [
                'id',
                'title',
                'url_perma',
                'is_published',
                'is_public',
                'created',
                'rating',
                'source',
                'source_link',
                'servings',
                'description_snippet',
                'has_photo',
                'main_photo_url',
                'ingredients.ingredient.name',
                'tags',
                'user.id',
                'user.name_display',
                'views',
                'comments_count'
            ],
            text: '',
            tags: [],
            mine: 0,
            photo: 0,
            bookmarked: 0,
            queued: 0,
            friends: 0,
            ingredients: [],
            photo_width: 200,
            photo_height: 150,
            adaptive: 1
        };

        svc.tags = {
            id: {},
            flat: [],
            nested: [],
            id_tags: []
        };

        metaData.tags('nested').then(function(tags) {
            svc.tags.nested = tags;
        });
        metaData.tags('flat').then(function(tags) {
            svc.tags.flat = tags;
        });
        metaData.tags('id').then(function(tags) {
            svc.tags.id = tags;
        });
        metaData.tags('id_map').then(function(tags) {
            svc.tags.id_map = tags;
        });

        svc.searchInProgress = false;
        svc.searchResults = [];

        svc.on('search.done.timer', function(e) {
            svc.searchInProgress = true;
        });

        svc.on('search.done.server', function(e, data) {
            svc.searchInProgress = false;
            svc.searchResults = data;
        });

        svc.search = function() {

            var sendParams = angular.copy(svc.searchParams);

            sendParams.tags = svc.prepareTagIds(sendParams.tags);
            sendParams.tags = angular.toJson(sendParams.tags);
            sendParams.return_fields = sendParams.return_fields.join(',');

            if (sortPristine) {
                svc.clearSort();
            }
            sendParams.sortcol = svc.searchParams.sortcol;
            sendParams.sortdir = svc.searchParams.sortdir;

            sendParams.ingredients = angular.toJson(_.pluck(sendParams.ingredients, 'id'));

            svc.broadcast('search.done', sendParams);
            timer.start(changeDelay, 'doSearch', instantiationTime).then(function() {
                svc.broadcast('search.done.timer', sendParams);
                api.request('/recipe/search', 'get', sendParams).then(function(data) {
                    svc.broadcast('search.done.server', data, sendParams);
                });
            });

            return svc;
        };

        /* start ingredients */

        /**
         * @param ing format: {id:123} other object keys are OK
         */
        svc.addIngredient = function(ing) {
            svc.searchParams.ingredients.push(ing);
        };

        /* end ingredients */

        /* start tags */

        svc.isTagAdded = function(id) {
            return (_.indexOf(svc.searchParams.tags, id) >= 0);
        };

        svc.addTag = function(id) {
            if (!svc.isTagAdded(id))
                svc.searchParams.tags.push(id);
        };

        svc.removeTag = function(id) {
            svc.searchParams.tags = _.without(svc.searchParams.tags, id);
        };

        svc.toggleTag = function(id) {
            if (svc.isTagAdded(id))
                svc.removeTag(id);
            else
                svc.addTag(id);
        };

        svc.getTag = function(id) {
            var tag;
            _.each(svc.tags.nested, function(v,i) {
                if (id === v.id)
                    tag = v;
                _.each(v.children, function(vv,ii) {
                    if (id === vv.id)
                        tag = vv;
                });
            });
            return tag;
        };

        svc.prepareTagIds = function(ids) {
            var allTags = [];
            _.each(ids, function(id) {
                tag = svc.getTag(id);
                if (tag.id) {
                    allTags.push(tag.id);
                    if (tag.children) {
                        _.each(tag.children, function(child) {
                            allTags.push(child.id);
                        });
                    }
                }
            });
            return _(svc.tags.id_map)
                .map(function(arr) {
                    return _.intersection(arr, allTags);
                })
                .filter(function(arr) {
                    return !_.isEmpty(arr);
                })
                .value();
        };

        /* end tags */

        svc.setSort = function(col, dir, keepPristine) {
            if (!dir) {
                if (svc.searchParams.sortcol == col && svc.searchParams.sortdir == 'asc')
                    dir = 'desc';
                else
                    dir = 'asc';
            }
            svc.searchParams.sortcol = col;
            svc.searchParams.sortdir = dir;
            if (!keepPristine)
                sortPristine = false;
        };

        svc.clearSort = function() {
            if (svc.searchParams.text)
                svc.setSort('relevance', 'desc', true);
            else
                svc.setSort('created', 'desc', true);
            sortPristine = true;
        };

    };

}]);