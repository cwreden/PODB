'use strict';

angular.module('PODB')
    .service('currentUser', ['$http', function($http) {
        var me = this;
        this.isLoggedIn = false;
        this.processingLogIn = false;
        this.processingLogOut = false;
        this.displayName = null;
        this.username = null;
        this.password = null;

        this.login = function() {
            me.processingLogIn = true;
            $http.post('/login', {
                params: {
                    username: this.username,
                    password: this.password
                }
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
            $http.get('/logout')
                .success(function () {
                    me.processingLogOut = false;
                    me.isLoggedIn = false;
                }).error(function () {
                    me.processingLogOut = false;
                    me.isLoggedIn = true;
                });
        };

        this.checkLoginState = function () {

        };

        this.checkLoginState();
    }]
);