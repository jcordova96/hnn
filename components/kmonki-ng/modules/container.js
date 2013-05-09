angular.module('kmDirectives', [
    'kmDirTagMenu'
]);
angular.module('kmServices', [
    'kmSvcApi',
    'kmSvcBookmark',
    'kmSvcFacebook',
    'kmSvcMetaData',
    'kmSvcQueue',
    'kmSvcRecipeSearch',
    'kmSvcTimer'
]);
angular.module('km', [
    'kmDirectives',
    'kmServices'
]);
