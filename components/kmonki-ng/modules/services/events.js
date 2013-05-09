angular.module('kmSvcEvents', []).factory('kmEvents', ['$rootScope', function($rootScope) {

    var svc = {

        debug: true,

        setDebug: function(val) {
            svc.debug = val;
        },

        broadcast: function(namespace, eventName) {
            var events = eventName.split(' ');
            for (var i=0; i<events.length; i++) {
                var args = [].slice.call(arguments, 1);
                args[0] = namespace+'.'+events[i];
                if (svc.debug && console && console.log)
                    console.log("event broadcast", arguments);
                $rootScope.$broadcast.apply($rootScope, args);
            }
        },

        on: function(namespace, eventName, fn) {
            if (svc.debug && console && console.log)
                console.log("event attach", arguments);
            var events = eventName.split(' ');
            _.each(events, function(eventName) {
                $rootScope.$on(namespace+'.'+eventName, function() {
                    var args = [].slice.call(arguments, 0);
                    var e = args[0];
                    e.service = namespace;
                    e.serviceEvent = eventName;
                    args[0] = e;
                    fn.apply(null, args);
                });
            });
        },

        getBroadcastFn: function(namespace) {
            return _.partial(svc.broadcast, namespace);
        },

        getOnFn: function(namespace) {
            return _.partial(svc.on, namespace);
        }

    };

    return svc;

}]);