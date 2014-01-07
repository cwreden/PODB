'use Strict';

var testController;
angular.module('app').controller('TestController', function($scope, Restangular) {

    $scope.getAll = function (objectType) {
        $scope.createdObject = Restangular.all(objectType).getList();
    };
    $scope.getObject = function (objectType, identifier) {
        $scope.oneObject = Restangular.one(objectType, identifier).get();
    };
    $scope.createObject = function (objectType, data) {
        $scope.createdObject = Restangular.all(objectType).post(data);
    };
    $scope.updateObject = function (objectType, data) {
//        $scope.updatedObject = Restangular.all(objectType).put(data);
    };
    $scope.deleteObject = function (objectType, identifer) {
//        $scope.deletedObject = Restangular.one(objectType, identifer).get();
//        $scope.deletedObject.remove();
    };

    testController = $scope;
});
