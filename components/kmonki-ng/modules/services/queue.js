angular.module('kmSvcQueue', ['kmSvcEvents', 'kmSvcApi']).factory('kmQueue', ['kmEvents', 'kmApi', function(events, api) {

    var serviceName = 'kmQueueSvc',
        queue = {
            total: 0,
            ids: [],
            items: {}
        };

    var svc = {

        broadcast: events.getBroadcastFn(serviceName),
        on: events.getOnFn(serviceName),

        init: function() {
            api.request('/queue', 'get', {array_key:'id'}).then(function(data) {
                queue.items = data.data;
                queue.total = data.total;
                queue.ids = _.pluck(queue.items, 'id');
            });
        },

        get: function() {
            return queue;
        },
        isSet: function(recipeId) {
            return (_.indexOf(queue.ids, recipeId) >= 0);
        },
        toggle: function(recipeId) {
            if (svc.isSet(recipeId))
                svc.remove(recipeId);
            else
                svc.add(recipeId);
        },
        add: function(recipeId, servings) {
            if (!servings)
                servings = 0;
            if (!svc.isSet(recipeId)) {
                queue.ids.push(recipeId);
                svc.broadcast('queue.add.done');
                api.request('/queue/'+recipeId, 'post', {servings:servings}).then(function(data) {
                    if (svc.isSet(recipeId))
                        queue.items[data.recipe.id] = data.recipe;
                    svc.broadcast('queue.add.done.server', data);
                });
            }
        },
        remove: function(recipeId) {
            if (svc.isSet(recipeId)) {
                queue.ids = _.without(queue.ids, recipeId);
                delete queue.items[recipeId];
                svc.broadcast('queue.remove.done');
                api.request('/queue/'+recipeId, 'delete', {}).then(function(data) {
                    svc.broadcast('queue.remove.done.server', data);
                });
            }
        }
    };

    svc.init();

    return svc;

}]);