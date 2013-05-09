angular.module('kmDirTagMenu', []).directive('kmTagMenu', [function () {
    return {
        link: function(scope, el, attrs) {
            var children = el.find(attrs.kmTagMenu);
            children.css({
                position: 'absolute',
                display: 'none'
            });
            children.mouseleave(function() {
                children.hide();
            });
            el.click(function() {
                children.show();
            });
            return el;
        }
    };
}]);