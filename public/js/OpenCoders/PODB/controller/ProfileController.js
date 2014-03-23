'use Strict';

angular.module('PODB')
    .controller('ProfileController', ['$scope', '$http', function($scope, $http) {
        $scope.user = {
            'displayName': 'Max Mutter',
            'email': 'lalalala@lala.lalal',
            'company': 'The Org',
            'location': 'Oldenburg',
            'blog': 'the.web.de',
            'joinedOn': 12345678,
            'projectCount': 3,
            'gravatar': 'http://thetransformedmale.files.wordpress.com/2011/06/bruce-wayne-armani.jpg'
        };
        console.log('profile control');
    }]);