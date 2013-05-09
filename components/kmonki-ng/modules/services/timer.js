angular.module('kmSvcTimer', []).factory('kmTimer', ['$q', '$rootScope', function($q, $rootScope) {

    // usage:
    // timerSvc.start(delay, 'mykey', 'myattr', ...).done(function() {
    //  - run this function when delay has elapsed, and cancel any in the queue with matching .start() arguments
    // });

    // queue of deferreds to do
    var queue = {};

    var svc = {
        start: function(delay) {
            var args = [].splice.call(arguments, 0);
            // arguments form a key to identify a timer set
            var cancelKey = args.join('|');
            var dfd = $.Deferred();

            // go through the whole queue
            $.each(queue, function(i,v) {
                // delete anything in the queue from the same timer set, they will not be resolved
                if (v.cancelKey === cancelKey) {
                    clearTimeout(i);
                    delete queue[i];
                }
            });

            // start timeout
            var timeoutId = setTimeout(function() {
                // resolve the deferred
                dfd.resolve(args);
                // remove from queue
                delete queue[timeoutId];
                $rootScope.$apply();
            }, delay);
            // add item to queue, with cancel key
            queue[timeoutId] = {cancelKey:cancelKey};
            // return promise object to set the .done() function outside
            return dfd.promise();
        }
    };

    return svc;

}]);