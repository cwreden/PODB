'use Strict';

angular.module('PODB')
    .controller('UserListController', function($scope, Restangular) {
        $scope.users = [
            {
                index: 1,
                name: 'Max Mustermann'
            },
            {
                index: 2,
                name: 'Harry Hirsch'
            },
            {
                index: 3,
                name: 'Christian'
            }
        ];
    });