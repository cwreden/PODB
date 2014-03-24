'use strict';

angular.module('PODB')
    .service('currentUser', ['$http', '$location', 'apiBaseUrl', function($http, $location, apiBaseUrl) {
        var me = this;
        this.isLoggedIn = false;
        this.processingLogIn = false;
        this.processingLogOut = false;
        this.displayName = null;
        this.username = null;
        this.password = null;

        this.login = function() {
            me.processingLogIn = true;
            $http.post(apiBaseUrl + '/authentication/login', {
                username: this.username,
                password: this.password
            })
                .success(function (response) {
                    me.displayName = response.displayName;
                    me.processingLogIn = false;
                    me.isLoggedIn = true;
                    me.password = null;
                }).error(function () {
                    me.processingLogIn = false;
                    me.isLoggedIn = false;
                    me.password = null;
                });
        };

        this.logout = function () {
            me.processingLogOut = true;
            $http.post(apiBaseUrl + '/authentication/logout')
                .success(function () {
                    me.processingLogOut = false;
                    me.isLoggedIn = false;
                    $location.path( "/dashboard" );
                }).error(function () {
                    me.processingLogOut = false;
                    me.isLoggedIn = true;
                });
        };

        this.checkLoginState = function () {
            me.processingLogIn = true;
            $http.get(apiBaseUrl + '/authentication/isLoggedIn')
                .success(function (response) {
                    me.processingLogIn = false;
                    me.isLoggedIn = response.isLoggedIn;
                    me.displayName = response.displayName;
                    me.username = response.username;
                })
                .error(function () {
                    me.processingLogIn = false;
                    me.isLoggedIn = false;
                });
        };

        this.openProfile = function () {
            if (me.username != null) {
                $location.path('/user/' + me.username);
            }
        };

        this.lock = function () {
            $http.post(apiBaseUrl + '/authentication/lock')
                .success(function (response) {
                    $location.url('/');
                });
        };

        this.checkLoginState();
    }]
);