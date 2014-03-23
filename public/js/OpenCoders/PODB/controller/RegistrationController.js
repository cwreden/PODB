'use Strict';

/**
 * TODO
 */
angular.module('PODB')
    .controller('RegistrationController', ['$scope', '$http', 'apiBaseUrl', function($scope, $http, apiBaseUrl) {
        $scope.processingRegistration = false;
        $scope.registrationData = {};
        $scope.success = false;

        $scope.register = function () {
            $scope.processingRegistration = true;
            $http.post(apiBaseUrl + '/user/register', $scope.registrationData)
                .success(function (data) {
                    $scope.processingRegistration = false;
                    $scope.success = true;
                    $scope.registrationData = {};
                })
                .error(function (data, status) {
                    $scope.processingRegistration = false;
                });
        };
    }]);