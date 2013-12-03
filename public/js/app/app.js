'use Strict';

angular.module('app', ['restangular', 'ngRoute'])
    .config(['RestangularProvider', '$routeProvider',
        function (RestangularProvider, $routeProvider) {
            RestangularProvider.setBaseUrl('/api/v1');

        $routeProvider
            .when('/home', {
                templateUrl: '/template/home.html',
                controller: 'HomeController'
            })
            .when('/users', {
                templateUrl: '/template/users/users.html',
                controller: 'UserController'
            })
            .otherwise({
                redirectTo: '/home'
            });
    }]);
