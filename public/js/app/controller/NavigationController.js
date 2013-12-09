'use Strict';

angular.module('app').controller('NavigationController', function($scope, Restangular) {
    $scope.menus = [
        {
            label: 'Home',
            url: '/#/home',
            active: 1
        },
        {
            label: 'Users',
            url: '/#/users'
        },
        {
            label: 'Projects',
            url: '/#/projects'
        },
        {
            label: 'Domains',
            url: '/#/domains'
        },
        {
            label: 'Languages',
            url: '/#/languages'
        }
    ];
});
