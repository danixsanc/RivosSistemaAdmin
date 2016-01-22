var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster']);

app.config(['$routeProvider',
  function ($routeProvider) {
        $routeProvider.
       
        when('/login', {
            title: 'Login',
            templateUrl: 'partials/login.html',
            controller: 'authCtrl'
        })
            .when('/logout', {
                title: 'Logout',
                templateUrl: 'partials/login.html',
                controller: 'logoutCtrl'
            })
            .when('/signup', {
                title: 'Signup',
                templateUrl: 'partials/signup.html',
                controller: 'authCtrl'
            })
            .when('/dashboard', {
                title: 'Dashboard',
                templateUrl: 'partials/dashboard.html',
                controller: 'authCtrl'
            })
            .when('/', {
                title: 'Login',
                templateUrl: 'partials/login.html',
                controller: 'authCtrl',
                role: '0'
            })
            .when('/root', {
                title: 'Root',
                templateUrl: 'partials/root.html',
                controller: 'rootCtrl'
            })
            .when('/admin', {
                title: 'Admin',
                templateUrl: 'partials/admin.html',
                controller: 'adminCtrl'
            })
            .when('/cabbie', {
                title: 'Cabbie',
                templateUrl: 'partials/cabbie.html',
                controller: 'cabbieCtrl'
            })
            
            .when('/colony', {
                title: 'Colony',
                templateUrl: 'partials/colony.html',
               controller: 'colonyCtrl'
            })
            
            .when('/request', {
                title: 'Solicitudes',
                templateUrl: 'partials/request.html',
                controller: 'requestCtrl'
            })



            .otherwise({
                redirectTo: '/login'
            });
  }])
    .run(function ($rootScope, $location, Data) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            Data.get('session').then(function (results) {
                if (results.uid) {
                    $rootScope.authenticated = true;
                    $rootScope.uid = results.uid;
                    $rootScope.name = results.name;
                    $rootScope.email = results.email;
                } else {
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/signup' || nextUrl == '/login') {

                    } else {
                        $location.path("/login");
                    }
                }
            });
        });
    });