'use Strict';

angular.module('PODB')
    .controller('UserListController', ['$scope', 'Restangular', function($scope, Restangular) {

        var api = Restangular.all('users');
        api.getList().then(function (list) {
            $scope.users = list;
        });
    }]);