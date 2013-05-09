// requires:
// - FB - global FB object from facebook js sdk
// - _ - lodash
// - fbInit - deferred that resolves on fb init

angular.module('kmSvcFacebook', ['kmSvcEvents']).factory('kmFacebook', ['kmEvents', '$rootScope', '$q', function(events, $rootScope, $q) {

    var serviceName = 'kmFacebook',
        appId,
        signedRequest;

    var svc = {

        broadcast: events.getBroadcastFn(serviceName),
        on: events.getOnFn(serviceName),

        init:function(appId, signedRequest) {
            svc.setAppId(appId);
            svc.setSignedRequest(signedRequest);
        },

        setAppId: function(value) {
            appId = value;
        },

        setSignedRequest: function(value) {
            signedRequest = value;
        },

        getSignedRequest: function() {
            return signedRequest;
        },

        login: function() {

            var dfd = $q.defer();

            FB.login(function(response) {
                if (response.authResponse.status == "connected") {
                    $rootScope.$apply(function() {
                        dfd.resolve(response);
                    });
                } else {
                    $rootScope.$apply(function() {
                        dfd.reject(response);
                    });
                }
            });

            return dfd.promise;

        },

        logout: function() {

            var dfd = $q.defer();

            FB.logout(function(response) {
                if (response) {
                    $rootScope.$apply(function() {
                        dfd.resolve(response);
                    });
                }
            });

            return dfd.promise;

        },

        getPage: function(id) {

            if (!id) id = signedRequest.page.id;
            if (!id) return false;

            var dfd = $q.defer();

            svc.broadcast('getPage.start');
            FB.api('/'+signedRequest.page.id, function(pageInfo) {
                $rootScope.$apply(function() {
                    svc.broadcast('getPage.done', pageInfo);
                    dfd.resolve(pageInfo);
                });
            });

            return dfd.promise;

        },

        reloadTab: function(appData) {

            svc.broadcast('reloadTab.start');

            svc.getPage().then(function(pageInfo) {
                var url = pageInfo.link+'?v=app_'+appId;
                if (appData)
                    url = url+'&app_data='+appData;
                svc.broadcast('reloadTab.done', url);
                top.location.href = url;
            });

        },

        setAppData: function(data) {
            svc.reloadTab(encodeURIComponent(angular.toJSON(data)));
        },

        getFriends: function(user_id) {

            if (!user_id) {
                user_id = 'me';
            }

            var dfd = $q.defer();

            FB.api('/'+user_id+'/friends', 'get', function(response) {
                $rootScope.$apply(function() {
                    dfd.resolve(response.data);
                });
            });

            return dfd.promise;

        }

    };

    fbInit.then(function() {

        FB.Canvas.setAutoGrow();

        FB.Event.subscribe('auth.statusChange', function(response) {

            if (response.status == 'not_authorized') {

            }
            if (response.status == 'connected') {
                // user was not previously logged in
                if (!signedRequest.user_id) {
                    svc.reloadTab();
                }
            }

        });

    });

    return svc;

}]);