'use strict';

angular.module('PODB')
    .directive('currentUserMenu', function() {
        return {
            restrict: 'A',
            templateUrl: '/template/currentUserMenu.html',
            controller: function ($scope, currentUser) {
                $scope.currentUser = currentUser;
            }
        };
    });