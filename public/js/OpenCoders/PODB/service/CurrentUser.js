'use strict';

angular.module('PODB')
    .service('currentUser', function() {
        this.loggedIn = false;

        this.login = function(username, password) {
            this.loggedIn = !this.loggedIn;

            // TODO Request
        };

        this.checkLoginState = function () {

        };

        this.checkLoginState();
    }
);