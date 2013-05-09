angular.module('kmSvcApi', ['kmSvcEvents']).factory('kmApi', ['kmEvents', '$http', '$q', function(events, $http, $q) {

    var serviceName = 'kmApi';
    var requestQueue = [];
    var defaultDelay = 1000;
    var callInProgress = false;
    var host = '/proxy';

    var svc = {

        broadcast: events.getBroadcastFn(serviceName),
        on: events.getOnFn(serviceName),

        request: function(path, method, params, delay) {
            delay = delay ? delay : defaultDelay;
            params = $.extend(params, {path:path,method:method});
            var dfd = $q.defer();
            requestQueue.push({params:params,dfd:dfd});
            svc.broadcast('queue.change', params);
            svc.broadcast('queueNum.change', requestQueue.length);
            setTimeout(function() {
                svc.processQueue();
            }, delay);
            return dfd.promise;
        },

        processQueue: function() {
            if (callInProgress) {
                setTimeout(svc.processQueue, 200);
            } else {
                var currentQueue = requestQueue;
                requestQueue = [];
                var params = [];
                _.each(currentQueue, function(v,i) {
                    params.push(v.params);
                });
                svc.broadcast('processQueue', params);
                if (currentQueue.length) {
                    svc.broadcast('callInProgress.change', true);
                    svc.broadcast('callInProgressNum.change', currentQueue.length);

                    $http.post(host, {batch:JSON.stringify(params)}, {
                        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
                        transformRequest: function(data) {
                            return $.param(data);
                        },
                        transformResponse: function(data) {
                            return $.parseJSON(data);
                        }
                    }).then(function(response) {
                        var data = response.data;
                        _.each(currentQueue, function(v,i) {
                            v.dfd.resolve(data[i]);
                            svc.broadcast('complete', v.params, data[i]);
                            svc.broadcast('callInProgress.change', false);
                            svc.broadcast('callInProgressNum.change', 0);
                            svc.broadcast('queueNum.change', requestQueue.length);
                        });
                    });
                }
            }
        },

        callInProgress: function() {
            return callInProgress;
        },

        setHost: function(value) {
            host = value;
            svc.broadcast('setHost', value);
        }

    };

    svc.on('callInProgress.change', function(e, status) {
        callInProgress = status;
    });

    return svc;

}]);