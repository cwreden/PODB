'use Strict';

angular.module('app', ['restangular'])
    .config(function(RestangularProvider) {
        RestangularProvider.setBaseUrl('/api/v1');
    });