'use Strict';

/**
 * @Deprecated
 */
angular.module('PODB')
    .controller('LoginController', ['$scope', 'currentUser', function($scope, currentUser) {
        $scope.currentUser = currentUser;

        $scope.loggedIn = currentUser.loggedIn;

        $scope.$watch('currentUser.loggedIn', function (newValue, oldValue, scope) {
            console.log('watch', newValue, oldValue, scope);

            if (newValue == undefined) {
                return;
            }

            $scope.loggedIn = newValue;
        });

    }]);