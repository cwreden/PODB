'use Strict';

/**
 * TODO
 */
angular.module('PODB')
    .controller('RegistrationController', ['$scope', '$http', function($scope, $http) {
        $scope.processingRegistration = false;
        $scope.registrationData = {};

        $scope.register = function () {
            $scope.processingRegistration = true;
            $http.post('/api/user/register', $scope.registrationData)
                .success(function (data) {
                    console.log('reg true', data);
                    $scope.processingRegistration = false;
                })
                .error(function (data, status) {
                    console.log('reg false', data, status);
                    $scope.processingRegistration = false;
                });
        };
    }]);