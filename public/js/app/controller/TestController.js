'use Strict';

var testController;
angular.module('app').controller('TestController', function($scope, Restangular) {

    $scope.getAll = function (objectType) {
        $scope.allObjects = Restangular.all(objectType).getList();
    };
    $scope.getObject = function (objectType, identifier) {
        $scope.oneObject = Restangular.one(objectType, identifier).get();
    };
    $scope.createObject = function (objectType, data) {
        $scope.createdObject = Restangular.all(objectType).post(data);
    };
    $scope.updateObject = function (objectType, identifier, data) {
        Restangular.one(objectType, identifier).get().then(function (object) {
            Object.keys(data).forEach(function (key) {
                object[key] = data[key];
            });
            $scope.updatedObject = object.put();
        });
    };
    $scope.deleteObject = function (objectType, identifer) {
        $scope.deletedObject = Restangular.one(objectType, identifer).get().then(function (object) {
            object.remove();
        });
    };

    testController = $scope;
});
