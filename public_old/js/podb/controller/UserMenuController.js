'use Strict';

angular.module('poDB').controller('UserMenuController', function($scope, Restangular) {
    $scope.menus = [
        {
            label: 'Login',
            url: '/user/login'
        }
    ]
});
