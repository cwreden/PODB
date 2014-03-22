'use Strict';

/**
 * TODO
 */
angular.module('PODB')
    .controller('RegistrationController', ['$scope', '$http', 'apiBaseUrl', function($scope, $http, apiBaseUrl) {
        $scope.processingRegistration = false;
        $scope.registrationData = {};

        $scope.register = function () {
            $scope.processingRegistration = true;
            $http.post(apiBaseUrl + '/user/register', $scope.registrationData)
                .success(function (data) {
                    $scope.processingRegistration = false;
                })
                .error(function (data, status) {
                    $scope.processingRegistration = false;
                });
        };
    }]);