'use strict';

angular.module('app').filter('isMenuActive', function($location) {
    return function(menu) {
        var needed = '^#$';
        if ($location.path() != '') {
            needed = '#' + $location.path();
        }
        return menu.url.match(needed) ? 'active' : '';
    };
});
