angular.module('kmSvcMetaData', ['LocalStorageModule','kmSvcApi']).factory('kmMetaData', ['kmApi','localStorageService','$q', function(api, localStorage, $q) {

    var svc = {
        tags: function(type) {

            var dfd = $q.defer();

            if (typeof type === 'undefined')
                type = 'nested';
            if (_.indexOf(['nested','flat','id','id_map'], type) === -1) {
                dfd.reject();
                return;
            }

            var key = 'tags_'+type;

            var tags = localStorage.get(key);
            if (localStorage.isSupported && tags) {

                tags = angular.fromJson(tags);
                dfd.resolve(tags);

            } else {

                var params = {
                    nested: (type === 'nested'),
                    id_map: (type === 'id_map')
                };

                api.request('/meta/tags', 'get', params, 0).then(function(data) {
                    tags = data.data;
                    if (type === 'id') {
                        var tags_new = {};
                        _.each(tags, function(v,i) {
                            tags_new[v.id] = v;
                        });
                        tags = tags_new;
                    }
                    localStorage.add(key, angular.toJson(tags));
                    dfd.resolve(tags);
                });

            }

            return dfd.promise;
        }
    };

    return svc;

}]);