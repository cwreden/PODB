'use Strict';

var podb = angular.module('PODB', ['restangular', 'ngRoute'])
    .config(['RestangularProvider', '$routeProvider',
        function (RestangularProvider, $routeProvider) {
            RestangularProvider.setBaseUrl('/api/v1');

        $routeProvider
            .when('/dashboard', {
                title: 'Dashboard',
                templateUrl: '/template/dashboard.html',
                controller: 'DashboardController'
            })
            .when('/users', {
                title: 'Users',
                templateUrl: '/template/users/list.html',
                controller: 'UserListController'
            })
//            .when('/login', {
//                templateUrl: '/template/login.html',
//                controller: 'LoginController'
//            })
            .otherwise({
                redirectTo: '/dashboard'
            });
        }
    ]);

podb.run(['$location', '$rootScope', function($location, $rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        if (current != undefined && current.$$route != undefined && current.$$route.title != undefined) {
            $rootScope.title = current.$$route.title + ' | PO-Database';
        } else {
            $rootScope.title = 'PO-Database';
        }
    });
}]);