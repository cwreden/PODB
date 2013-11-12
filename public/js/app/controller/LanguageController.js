'use Strict';

angular.module('app')
    .controller('LanguageController', function($scope, Restangular) {
        $scope.tests = [2,4,'e','g',3,'d','c43',3,'g',43,'r'];
        $scope.name = 'test name';

        console.log('scope', $scope);
        console.log('REST', Restangular);
        $scope.createLang = function () {
            var User = $resource('/api/v1/language/:userId', {userId:'@id'});
            var user = User.get({userId:123}, function() {
                user.name = 'Gonto';
                user.locale = 'bla';
                user.$save();
            });
        };
        $scope.getLangs = function() {
            var languages = Restangular.all('language');
            console.log(languages);
        };
        bla = $scope;
        REST = Restangular;
});

/**

 CREATE
 REST.all('language').post({name: 'Deutsch', locale: 'de_DE'})

 DELETE
 REST.all('language').getList().then(function(list){list[0].remove()})

 LIST
 REST.all('language').getList().then(function(list){console.log(list);})

 UPDATE
 REST.all('language').getList().then(function(list){list[0].put()})


 */