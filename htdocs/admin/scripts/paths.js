// create the module and name it myRst
	var myRst = angular.module('myRst', ['ngRoute']);

	// configure our routes
	myRst.config(function($routeProvider) {
		$routeProvider

			// route for the about page
			.when('/gallery', {
				templateUrl : 'D_pages/gallery.html',
				controller  : 'galleryController'
			})
                        // route for the about page
			.when('/grid', {
				templateUrl : 'D_pages/basic-grid.html',
				controller  : 'homeController'
			})
                        // route for the about page
			.when('/full-width', {
				templateUrl : 'D_pages/full-width.html',
				controller  : 'homeController'
			})
                        // route for the about page
			.when('/sidebar-left', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'homeController'
			})
                        // route for the about page
			.when('/sidebar-right', {
				templateUrl : 'D_pages/sidebar-right.html',
				controller  : 'homeController'
			})
			// route for the contact page
			.when('/width', {
				templateUrl : 'D_pages/full-width.html',
				controller  : 'widthController'
			})
                        //functions sidebar left *******************************
                        // users----------------********************************
                        .when('/functions/users', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'userController'
			})
                        .when('/editUser/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'userUpdateController'
			})
                        // followers----------------****************************
                        .when('/functions/signed_up_users', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'SignedUpController'
			})
                        // restaurant & orders----------------******************
                        .when('/functions/restaurant', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'restaurantController'
			})
                        .when('/edit/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'restaurantEditController'
			})
                        .when('/functions/order', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'orderController'
			})
                        .when('/functions/orderInternet', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'orderInternetController'
			})
                        .when('/functions/orderall', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'orderallController'
			})
                        .when('/editOrderRes/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'orderResEditController'
			})
                        .when('/editOrder/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'orderEditController'
			})
                        .when('/functions/profit', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'ProfitController'
			})
                        // employers----------------****************************
                        .when('/functions/functions', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'functionsController'
			})
                        .when('/editFunction/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'functionsEditController'
			})
                        .when('/functions/employers', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'employersController'
			})
                        .when('/editEmployers/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'employersEditController'
			})
                        .when('/functions/selectOrder', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'selectOrderController'
			})
                        .when('/addWorkersForOrder/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'addWorkersForOrderController'
			})
                        .when('/functions/viewOrderEmp', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'viewOrderEmpSelectOrdController'
			})
                        .when('/editWorkersForOrder/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'editWorkersForOrderController'
			})
                        // menu----------------*********************************
                        .when('/functions/add_menu', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'add_menuController'
			})
                        .when('/functions/menu/toOrder/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'add_menu_to_orderResController'
			})
                        .when('/functions/menu', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'menuController'
			})
                        .when('/editMenu/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'menuEditController'
			})
                        .when('/editCategory/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'categoryEditController'
			})
                        .when('/functions/category', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'categoryController'
			})
                        .when('/editProduct/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'productsEditController'
			})
                        .when('/functions/products', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'productsController'
			})
                         // dishes----------------******************************
                        .when('/functions/dishes', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'diishesController'
			})
                        .when('/functions/dishesOrdered', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'diishesOrderedController'
			})
                        .when('/ViewEditDishesMenu/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'ViewEditDishesMenuController'
			})
                        .when('/add_dishesToMenu/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'add_dishesToMenuController'
			})
                        .when('/editDishes/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'diishesEditController'
			})
                        .when('/functions/dishesToCategory', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'diishesToCatController'
			})
                        .when('/chooseCategory/:id/:name', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'diishesINCatController'
			})
                        .when('/functions/ProdInDish', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'ProdInDishController'
			})
                        .when('/functions/ProdInDish/:id/:name', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'ProdInDishCategoryController'
			})
                        .when('/functions/ProdInDish/:id/:name/:id_d', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'ProdInDishCategoryDishController'
			})
                        .when('/editProdDish/:id/:name/:id_d/:id_p', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'ProdInDishCategoryEditController'
			})
                        .when('/functions/popularDishes', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'popularDishesController'
			})
                         // warehaus----------------****************************
                        .when('/functions/warehouse', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'warehousController'
			})
                        .when('/editWarehouse/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'warehousEditController'
			})
                        .when('/functions/provider', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'providerController'
			})
                        .when('/editProvider/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'providerEditController'
			})
                        .when('/functions/productsInDeposit', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'productsInDepositController'
			})
                        .when('/chooseWarehouse/:id', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'warehouseChosenController'
			})
                        .when('/editProductInWarehouse/:id/:product/:w/:u/:prc/:prd', {
				templateUrl : 'D_pages/sidebar-left.html',
				controller  : 'editProductInWarehouseController'
			})
			// route for the home page *****************************
			.when('/', {
				templateUrl : 'D_pages/home.html',
				controller  : 'homeController'
			});             
	});

	// create the controller for pages
	myRst.controller('mainController', ['$scope', function($scope) {
                
        }]);
        
        myRst.controller('homeController', function($scope) {
                $scope.image = '../images/demo/';
	});
        
	myRst.controller('galleryController', function($scope) {
		$scope.message = 'Look! I am an about page.';
	});

	myRst.controller('widthController', function($scope) {
		$scope.message = 'Contact us! JK. This is just a demo.';
	});
        // controllers for sidebar left
        myRst.controller('userController', function($scope, $http, $routeParams) {
                $scope.var = "users";
                
                $scope.users = [];
                $http.get("http://master-restauran.byethost22.com/php/select_users.php")
                    .then(function(response) {
                        $scope.users = response.data;
                });
	});
        myRst.controller('userUpdateController', function($scope, $http, $routeParams) {
                
                $scope.users = [];
                $http.get("http://master-restauran.byethost22.com/php/select_users.php")
                    .then(function(response) {
                        $scope.users = response.data;
                });
 
                    $scope.var = "usersUpdate";
                    $scope.id = $routeParams.id;
                    
                    $scope.user = [];
                    $http.get("http://master-restauran.byethost22.com/php/select_oneUser.php?id="+$scope.id)
                        .then(function(response) {
                            $scope.user = response.data;
                    });
                
	});
        myRst.controller('restaurantController', function($scope, $http, $routeParams) {
                $scope.var = "restaurants";
                
                $scope.restns = [];
                $http.get("http://master-restauran.byethost22.com/php/select_restaurants.php")
                    .then(function(response) {
                        $scope.restns = response.data;
                });
                
                $scope.message = $routeParams.id;
                                
	});
        myRst.controller('restaurantEditController', function($scope, $http, $routeParams) {
                $scope.var = "restaurantsEdit";
                
                $scope.restns = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_restaurants.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.restns = response.data;
                });
                                                          
	});
        myRst.controller('SignedUpController', function($scope, $http, $routeParams) {
                $scope.var = "SignUpUsersView";
                
                $scope.users = [];
                $http.get("http://master-restauran.byethost22.com/php/select_sign_up_users.php")
                    .then(function(response) {
                        $scope.users = response.data;
                });
                                                          
	});
        myRst.controller('add_menuController', function($scope, $http) {
                $scope.var = "add_menu";
                
                $scope.order = [];
                $http.get("http://master-restauran.byethost22.com/php/select_ordersResWithoutMenu.php")
                    .then(function(response) {
                        $scope.order = response.data;
                });                                       
	});
        myRst.controller('menuController', function($scope, $http) {
                $scope.var = "menuView";
                
                $scope.menus = [];
                $http.get("http://master-restauran.byethost22.com/php/select_menu.php")
                    .then(function(response) {
                        $scope.menus = response.data;
                });                                       
	});
        myRst.controller('add_menu_to_orderResController', function($scope, $routeParams) {
                $scope.var = "add_menu_to_orderRes";
                
                $scope.id = $routeParams.id;                                          
	});
        myRst.controller('menuEditController', function($scope, $http, $routeParams) {
                $scope.var = "menuEdit";
                
                $scope.menu = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_menuOne.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.menu = response.data;
                });
                
                $scope.menus = [];
                $http.get("http://master-restauran.byethost22.com/php/select_menu.php")
                    .then(function(response) {
                        $scope.menus = response.data;
                });
                                                          
	});
        myRst.controller('categoryController', function($scope, $http) {
                $scope.var = "categoryView";
                
                $scope.categories = [];
                $http.get("http://master-restauran.byethost22.com/php/select_categories.php")
                    .then(function(response) {
                        $scope.categories = response.data;
                });                                          
	});
        myRst.controller('categoryEditController', function($scope, $http, $routeParams) {
                $scope.var = "categoryEdit";
                
                $scope.cat = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_categories.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.cat = response.data;
                });
                
                $scope.categories = [];
                $http.get("http://master-restauran.byethost22.com/php/select_categories.php")
                    .then(function(response) {
                        $scope.categories = response.data;
                });
                                                          
	});
        myRst.controller('warehousController', function($scope, $http) {
                $scope.var = "warehousesView";
                
                $scope.warehouses = [];
                $http.get("http://master-restauran.byethost22.com/php/select_warehouses.php")
                    .then(function(response) {
                        $scope.warehouses = response.data;
                });                                          
	});
        myRst.controller('warehousEditController', function($scope, $http, $routeParams) {
                $scope.var = "warehousEdit";
                
                $scope.warehous = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_warehouses.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.warehous = response.data;
                });
                
                $scope.warehouses = [];
                $http.get("http://master-restauran.byethost22.com/php/select_warehouses.php")
                    .then(function(response) {
                        $scope.warehouses = response.data;
                });
                                                          
	});
        myRst.controller('providerController', function($scope, $http) {
                $scope.var = "providersView";
                
                $scope.providers = [];
                $http.get("http://master-restauran.byethost22.com/php/select_providers.php")
                    .then(function(response) {
                        $scope.providers = response.data;
                });                                          
	});
        myRst.controller('providerEditController', function($scope, $http, $routeParams) {
                $scope.var = "providerEdit";
                
                $scope.provider = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_providers.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.provider = response.data;
                });
                
                $scope.providers = [];
                $http.get("http://master-restauran.byethost22.com/php/select_providers.php")
                    .then(function(response) {
                        $scope.providers = response.data;
                });
                                                          
	});
        myRst.controller('functionsController', function($scope, $http) {
                $scope.var = "functionsView";
                
                $scope.functions = [];
                $http.get("http://master-restauran.byethost22.com/php/select_functions.php")
                    .then(function(response) {
                        $scope.functions = response.data;
                });                                          
	});
        myRst.controller('functionsEditController', function($scope, $http, $routeParams) {
                $scope.var = "functionsEdit";
                
                $scope.fun = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_functions.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.fun = response.data;
                });
                
                $scope.functions = [];
                $http.get("http://master-restauran.byethost22.com/php/select_functions.php")
                    .then(function(response) {
                        $scope.functions = response.data;
                });
                                                          
	});
        myRst.controller('employersController', function($scope, $http) {
                $scope.var = "employersView";
                
                $scope.employers = [];
                $http.get("http://master-restauran.byethost22.com/php/select_employers.php")
                    .then(function(response) {
                        $scope.employers = response.data;
                });
                //select restaurants
                    $scope.restns = [];
                    $http.get("http://master-restauran.byethost22.com/php/select_restaurants.php")
                        .then(function(response) {
                            $scope.restns = response.data;
                        });
                //select functions
                    $scope.functions = [];
                    $http.get("http://master-restauran.byethost22.com/php/select_functions.php")
                        .then(function(response) {
                            $scope.functions = response.data;
                        });
	});
        myRst.controller('employersEditController', function($scope, $http, $routeParams) {
                $scope.var = "employersEdit";
                
                $scope.emp = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_employers.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.emp = response.data;
                });
                
                $scope.employers = [];
                $http.get("http://master-restauran.byethost22.com/php/select_employers.php")
                    .then(function(response) {
                        $scope.employers = response.data;
                });
                //select restaurants
                    $scope.restns = [];
                    $http.get("http://master-restauran.byethost22.com/php/select_restaurants.php")
                        .then(function(response) {
                            $scope.restns = response.data;
                        });
                //select functions
                    $scope.functions = [];
                    $http.get("http://master-restauran.byethost22.com/php/select_functions.php")
                        .then(function(response) {
                            $scope.functions = response.data;
                        });
                                                          
	});
        myRst.controller('selectOrderController', function($scope, $http) {
                $scope.var = "selectOrder";
                
                $scope.ordersRes = [];
                $http.get("http://master-restauran.byethost22.com/php/select_ordersRes.php")
                    .then(function(response) {
                        $scope.ordersRes = response.data;
                });
	});
        myRst.controller('addWorkersForOrderController', function($scope, $http, $routeParams) {
                $scope.var = "addWorkersForOrder";
                
                $scope.id = $routeParams.id;
                $scope.employers = [];
                $http.get("http://master-restauran.byethost22.com/php/select_employersNotInOrder.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.employers = response.data;
                });
	});
        myRst.controller('viewOrderEmpSelectOrdController', function($scope, $http) {
                $scope.var = "viewOrderEmpSelectOrd";
                
                $scope.ordersRes = [];
                $http.get("http://master-restauran.byethost22.com/php/select_ordersRes.php")
                    .then(function(response) {
                        $scope.ordersRes = response.data;
                });
	});
        myRst.controller('editWorkersForOrderController', function($scope, $http, $routeParams) {
                $scope.var = "editWorkersForOrder";
                
                $scope.id = $routeParams.id;
                $scope.employers = [];
                $http.get("http://master-restauran.byethost22.com/php/select_EmplInOrder.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.employers = response.data;
                });
	});
        myRst.controller('productsController', function($scope, $http) {
                $scope.var = "productsView";
                
                $scope.products = [];
                $http.get("http://master-restauran.byethost22.com/php/select_products.php")
                    .then(function(response) {
                        $scope.products = response.data;
                });
	});
        myRst.controller('productsEditController', function($scope, $http, $routeParams) {
                $scope.var = "productsEdit";
                
                $scope.product = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_products.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.product = response.data;
                });  
                $scope.products = [];
                $http.get("http://master-restauran.byethost22.com/php/select_products.php")
                    .then(function(response) {
                        $scope.products = response.data;
                });
	});
        myRst.controller('productsInDepositController', function($scope, $http) {
                $scope.var = "productsInDepositView";
                
                $scope.warehouses = [];
                $http.get("http://master-restauran.byethost22.com/php/select_warehouses.php")
                    .then(function(response) {
                        $scope.warehouses = response.data;
                });
	});
        myRst.controller('warehouseChosenController', function($scope, $http, $routeParams) {
                $scope.var = "productsWarehouseView";
                
                $scope.products = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_prodWareh.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.products = response.data;
                });
                $scope.prod = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_products_NoExistInDep.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.prod = response.data;
                }); 
                $scope.providers = [];
                $http.get("http://master-restauran.byethost22.com/php/select_providers.php")
                    .then(function(response) {
                        $scope.providers = response.data;
                });
	});
        myRst.controller('editProductInWarehouseController', function($scope, $http, $routeParams) {
                $scope.var = "editProductInWarehouse";
                
                $scope.products = [];
                $scope.id = $routeParams.id;
                $scope.product = $routeParams.product;
                $scope.w = $routeParams.w;
                $scope.u = $routeParams.u;
                $scope.prc = $routeParams.prc;
                $scope.prd = $routeParams.prd;
                
                $http.get("http://master-restauran.byethost22.com/php/select_prodWareh.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.products = response.data;
                });
                $scope.prod = [];
                $http.get("http://master-restauran.byethost22.com/php/select_products_NoExistInDep.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.prod = response.data;
                }); 
                $scope.providers = [];
                $http.get("http://master-restauran.byethost22.com/php/select_providers.php")
                    .then(function(response) {
                        $scope.providers = response.data;
                });
	});
        myRst.controller('diishesController', function($scope, $http) {
                $scope.var = "dishesView";
                
                $scope.dishes = [];
                $http.get("http://master-restauran.byethost22.com/php/select_dishes.php")
                    .then(function(response) {
                        $scope.dishes = response.data;
                });
	});
        myRst.controller('popularDishesController', function($scope, $http) {
                $scope.var = "dishesPopularView";
                
                $scope.dishes = [];
                $http.get("http://master-restauran.byethost22.com/php/select_dishesPopular.php")
                    .then(function(response) {
                        $scope.dishes = response.data;
                });
	});
        myRst.controller('diishesOrderedController', function($scope, $http) {
                $scope.var = "dishesOrdered";
                
                $scope.dishesOrd = [];
                $http.get("http://master-restauran.byethost22.com/php/select_menu.php")
                    .then(function(response) {
                        $scope.dishesOrd = response.data;
                });
	});
        myRst.controller('ViewEditDishesMenuController', function($scope, $http, $routeParams) {
                $scope.var = "ViewEditDishesMenu";
                
                $scope.id = $routeParams.id;
                $scope.dishesOrd = [];
                $http.get("http://master-restauran.byethost22.com/php/select_DishesInMenu.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.dishesOrd = response.data;
                });
	});
        myRst.controller('add_dishesToMenuController', function($scope, $http, $routeParams) {
                $scope.var = "add_dishesToMenu";
  
                $scope.id = $routeParams.id;
                $scope.dishes = [];
                $http.get("http://master-restauran.byethost22.com/php/select_dishesInCategoryForMenu.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.dishes = response.data;
                });
	});
        myRst.controller('diishesEditController', function($scope, $http, $routeParams) {
                $scope.var = "dishesEdit";
                
                $scope.dis = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_dishes.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.dis = response.data;
                });
                $scope.dishes = [];
                $http.get("http://master-restauran.byethost22.com/php/select_dishes.php")
                    .then(function(response) {
                        $scope.dishes = response.data;
                });
	});
        myRst.controller('diishesToCatController', function($scope, $http, $routeParams) {
                $scope.var = "dishesToCat";
                
                $scope.dishes = [];
                $http.get("http://master-restauran.byethost22.com/php/select_dishesNotInCategory.php")
                    .then(function(response) {
                        $scope.dishes = response.data;
                });
                $scope.categories = [];
                $http.get("http://master-restauran.byethost22.com/php/select_categories.php")
                    .then(function(response) {
                        $scope.categories = response.data;
                });
	});
        myRst.controller('diishesINCatController', function($scope, $http, $routeParams) {
                $scope.var = "dishesINCat";
                
                $scope.name = $routeParams.name;
                $scope.dishesall = [];
                $scope.id = $routeParams.id;
                $http.get("http://master-restauran.byethost22.com/php/select_dishesInCategory.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.dishesall = response.data;
                });
               
	});
        myRst.controller('ProdInDishController', function($scope, $http, $routeParams) {
                $scope.var = "ProdInDish";
                
                $scope.name = $routeParams.name;
                $scope.categories = [];
                $http.get("http://master-restauran.byethost22.com/php/select_categories.php")
                    .then(function(response) {
                        $scope.categories = response.data;
                });
               
	});
        myRst.controller('ProdInDishCategoryController', function($scope, $http, $routeParams) {
                $scope.var = "ProdInDishCategory";
                
                $scope.id = $routeParams.id;
                $scope.name = $routeParams.name;
                
                $scope.dishesall = [];
                $http.get("http://master-restauran.byethost22.com/php/select_dishesInCategory.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.dishesall = response.data;
                });
               
	});
        myRst.controller('ProdInDishCategoryDishController', function($scope, $http, $routeParams) {
                $scope.var = "ProdInDishCategoryDish";
                
                $scope.id = $routeParams.id;
                $scope.name = $routeParams.name;
                $scope.id_d = $routeParams.id_d;
                
                $scope.products = [];
                $http.get("http://master-restauran.byethost22.com/php/select_productInDish.php?id="+$scope.id_d)
                    .then(function(response) {
                        $scope.products = response.data;
                });
                $scope.prod = [];
                $http.get("http://master-restauran.byethost22.com/php/select_productNoneInDish.php?id="+$scope.id_d)
                    .then(function(response) {
                        $scope.prod = response.data;
                });
               
	});
        myRst.controller('ProdInDishCategoryEditController', function($scope, $http, $routeParams) {
                $scope.var = "ProdInDishCategoryEdit";
                
                $scope.id = $routeParams.id;
                $scope.name = $routeParams.name;
                $scope.id_d = $routeParams.id_d;
                $scope.id_p = $routeParams.id_p;
                
                $scope.productsall = [];
                $http.get("http://master-restauran.byethost22.com/php/select_productInDish.php?id="+$scope.id_d)
                    .then(function(response) {
                        $scope.productsall = response.data;
                });
                $scope.productOne = [];
                $http.get("http://master-restauran.byethost22.com/php/select_productInDish.php?id="+$scope.id_d+"&id_p="+$scope.id_p)
                    .then(function(response) {
                        $scope.productOne = response.data;
                });
                $scope.prodRemainder = [];
                $http.get("http://master-restauran.byethost22.com/php/select_productNoneInDish.php?id="+$scope.id_d)
                    .then(function(response) {
                        $scope.prodRemainder = response.data;
                });
               
	});
        myRst.controller('orderController', function($scope, $http, $routeParams) {
                $scope.var = "orderReservView";
                
                $scope.ordersRes = [];
                $http.get("http://master-restauran.byethost22.com/php/select_ordersRes.php")
                    .then(function(response) {
                        $scope.ordersRes = response.data;
                });
	});
        myRst.controller('orderallController', function($scope, $http, $routeParams) {
                $scope.var = "orderAllView";
                
                $scope.ordersall = [];
                $http.get("http://master-restauran.byethost22.com/php/select_orders.php")
                    .then(function(response) {
                        $scope.ordersall = response.data;
                });
	});
        myRst.controller('orderResEditController', function($scope, $http, $routeParams) {
                $scope.var = "orderResEdit";
                
                $scope.id = $routeParams.id;
                
                $scope.order = [];
                $http.get("http://master-restauran.byethost22.com/php/select_ordersRes.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.order = response.data;
                });
                $scope.rests = [];
                $http.get("http://master-restauran.byethost22.com/php/select_ordersRestaurants.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.rests = response.data;
                });
	});
         myRst.controller('orderInternetController', function($scope, $http, $routeParams) {
                $scope.var = "orderInternetView";
                
                $scope.ordersInt = [];
                $http.get("http://master-restauran.byethost22.com/php/select_ordersInt.php")
                    .then(function(response) {
                        $scope.ordersInt = response.data;
                });
	});
        myRst.controller('orderEditController', function($scope, $http, $routeParams) {
                $scope.var = "orderEdit";
                
                $scope.id = $routeParams.id;
                $scope.orderEdit = [];
                $http.get("http://master-restauran.byethost22.com/php/select_orders.php?id="+$scope.id)
                    .then(function(response) {
                        $scope.orderEdit = response.data;
                });
	});
        myRst.controller('ProfitController', function($scope, $http) {
                $scope.var = "EditProfit";
                
                $scope.profit = [];
                $http.get("http://master-restauran.byethost22.com/php/select_profit.php")
                    .then(function(response) {
                        $scope.profit = response.data;
                });
	});
        