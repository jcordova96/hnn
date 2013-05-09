angular.module('kmSvcBookmark', ['kmSvcEvents', 'kmSvcApi']).factory('kmBookmark', ['kmEvents', 'kmApi', function(events, api) {

    var serviceName = 'kmBookmark',
        bookmarks = {
            total: 0,
            ids: [],
            items: {}
        };

    var svc = {

        broadcast: events.getBroadcastFn(serviceName),
        on: events.getOnFn(serviceName),

        init: function() {
            api.request('/bookmark', 'get', {array_key:'id'}).then(function(data) {
                bookmarks.items = data.data;
                bookmarks.total = data.total;
                bookmarks.ids = _.pluck(bookmarks.items, 'id');
            });
        },

        get: function() {
            return bookmarks;
        },
        isSet: function(recipeId) {
            return (_.indexOf(bookmarks.ids, recipeId) >= 0);
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
                bookmarks.ids.push(recipeId);
                svc.broadcast('bookmark.add.done');
                api.request('/bookmark/'+recipeId, 'post', {servings:servings}).then(function(data) {
                    if (svc.isSet(recipeId))
                        bookmarks.items[data.recipe.id] = data.recipe;
                    svc.broadcast('bookmark.add.done.server', data);
                });
            }
        },
        remove: function(recipeId) {
            if (svc.isSet(recipeId)) {
                bookmarks.ids = _.without(bookmarks.ids, recipeId);
                delete bookmarks.items[recipeId];
                svc.broadcast('bookmark.remove.done');
                api.request('/bookmark/'+recipeId, 'delete', {}).then(function(data) {
                    svc.broadcast('bookmark.remove.done.server', data);
                });
            }
        }
    };

    svc.init();

    return svc;

}]);