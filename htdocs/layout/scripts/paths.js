// create the module and name it myRst
	var myRst = angular.module('myRst', ['ngRoute']);

	// configure our routes
	myRst.config(function($routeProvider) {
		$routeProvider
                        
			// route for the home page
			.when('/', {
				templateUrl : 'pages/home.html',
				controller  : 'mainController'
			})
                        
			// route for the about page
			.when('/gallery', {
				templateUrl : 'pages/gallery.html',
				controller  : 'galleryController'
			})

			// route for the contact page
			.when('/width', {
				templateUrl : 'pages/full-width.html',
				controller  : 'widthController'
			})
                        
                        // login----------------
                        .when('/login/:error', {
				templateUrl : 'pages/login.html',
				controller  : 'loginController'
			})
                        .when('/login', {
				templateUrl : 'pages/login.html',
				controller  : 'loginController'
			})
                        .otherwise({
			redirectTo: '/'
                        });
	});

	// create the controller and inject Angular's $scope
	myRst.controller('mainController', function($scope) {
		// create a message to display in our view
		$scope.message = 'Everyone come and see how good I look!';
	});

	myRst.controller('galleryController', function($scope) {
		$scope.message = 'Look! I am an about page.';
	});

	myRst.controller('widthController', function($scope) {
		$scope.message = 'Contact us! JK. This is just a demo.';
	});
        
        myRst.controller('loginController', function($scope, $routeParams) {
            if($routeParams.error == "error"){
                $scope.message = "Error for user Login. Login & pass are wrong";
            }                   
	});