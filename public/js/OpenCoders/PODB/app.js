'use Strict';

angular.module('PODB', ['restangular', 'ngRoute'])
    .config(['RestangularProvider', '$routeProvider',
        function (RestangularProvider, $routeProvider) {
            RestangularProvider.setBaseUrl('/api/v1');

        $routeProvider
            .when('/dashboard', {
                templateUrl: '/template/dashboard.html',
                controller: 'DashboardController'
            })
            .when('/users', {
                templateUrl: '/template/users/list.html',
                controller: 'UserListController'
            })
            .when('/login', {
                templateUrl: '/template/login.html',
                controller: 'LoginController'
            })
            .otherwise({
                redirectTo: '/dashboard'
            });
        }
    ]);
