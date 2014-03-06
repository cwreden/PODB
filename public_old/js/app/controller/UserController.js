'use Strict';

angular.module('app').controller('UserController', function($scope, Restangular) {
    $scope.users = Restangular.all('user');
    console.log($scope);

    $scope.newUserData = {
        displayname: 'Mr. Test',
        username: 'Test',
        email: 'test@test.com',
        password: 'bla',
        state: true
    };

    $scope.createUser = function () {
        $scope.people = Restangular.all('user').post($scope.newUserData);
//        var user = Restangular.create
//        var user = $resource('/api/v1/user', {userId:'@id'});
//        var user = User.get({userId:123}, function() {
//            user.name = 'Gonto';
//            user.locale = 'bla';
//            user.$save();
        console.log($scope);
    };

    userScope = $scope;
});
