'use Strict';

angular.module('app').controller('UserMenuController', function($scope, Restangular) {
    $scope.menus = [
        {
            label: 'Login',
            url: '/user/login'
        }
    ]
});
