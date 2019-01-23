(function() {
	var app = angular.module('turkceme', ['ngRoute', 'filters', 'ngSanitize']);
	
	app.config(['$routeProvider',
		function($routeProvider) {
			$routeProvider
				.when('/', {
					controller: 'TurkceAppController'
				})
				.when('/form', {
					templateUrl: 'partials/form.html',
					controller: 'FormController'
				})
				.when('/goruntule/:item', {
					templateUrl: 'partials/result.html',
					controller: 'ResultController'
				})
				.when('/hakkinda', {
					templateUrl:'partials/about.html',
					controller: 'HakkindaController'
				})
				.otherwise('/');
	}]);

  angular.module('filters', []).filter('htmlToPlaintext', function() {
    return function(text) {
      return String(text).replace(/<[^>]+>/gm, '');
    }
  });
  
  app.directive('keyTrap', function() {
	  return function( scope, elem ) {
	    elem.bind('keydown', function( event ) {
	      scope.$broadcast('keydown', event.keyCode );
	    });
	  };
	});

	app.controller('FormController', ['$rootScope', '$scope', '$http', '$location', function ($rootScope, $scope, $http, $location) {
		$scope.locutions = [""];
		$scope.secure = "";

		if($rootScope.searchKey.length < 1) {
			$location.path("/");
		}
		
		$scope.submit = function name() {
			var request = {searchKey: $rootScope.searchKey, locutions: $scope.locutions, captcha: $scope.secure};
			if($scope.secure.length == 0) {
				$scope.formError = true;
				$scope.errorMessage = "Güvenlik kodu zprunludur.";
			}
			else {
				$http.post('create', request).then(function(response){
					if(response.data.isSuccess) {
						$location.path("/goruntule/"+response.data.locution_key);
					}
					else {
						$scope.formError = true;
						$scope.errorMessage = response.data.message;
						$("#captcha-img").attr("src", "./api/captcha.php"); //reload
						$scope.secure = "";
					}
					
				});
			}
		};

		$scope.addMoreLocutions = function() {
			$scope.locutions.push("");
		};

		$scope.removeLocution = function(index) {
			$scope.locutions.splice(index, 1);
		};

	}]);
	
	app.controller('ResultController', ['$rootScope', '$scope', '$location', '$http', '$routeParams', function ($rootScope,$scope, $location, $http, $routeParams) {
		$rootScope.isSearchVisible = false;
		$scope.close = function() {
			$rootScope.searchKey="";
			$scope.$parent.cleanUp();
			$location.path("/");
		};

//		$routeParams.item
		$http.get('get?key='+$routeParams.item).then(function(response) {
			$scope.selectedItem = response.data;
			if($scope.selectedItem.locution.name == null) {
				$scope.close();
			}
		});

	}]);

	app.controller('HakkindaController', ['$rootScope', '$scope', '$location', function ($rootScope,$scope, $location) {
		$rootScope.isSearchVisible = false;
		$scope.close = function() {
			$rootScope.searchKey="";
			$scope.$parent.cleanUp();
			$location.path("/");
		};
	}]);

  app.controller('TurkceAppController', ['$rootScope', '$scope', '$http', '$sce', '$location', function($rootScope, $scope, $http, $sce, $location) {
	  $rootScope.searchKey="";
	  $scope.searchResult = [];
		$scope.focusIndex = null;
		$rootScope.isSearchVisible = true;
	  
	  $scope.search = function() {
		  if($rootScope.searchKey.length > 0) {
			  $http.get('search?query='+$rootScope.searchKey).then(function(response) {
					$scope.cleanUp(0, response.data.locutions);
					if(response.data.locutions.length == 0) {
						$location.path('/form');
						$scope.locutions.push("");
					}else {
						$location.path('/');
					}
			  });
		  }
		  else {
			 $location.path("/");
			 $scope.cleanUp(null, []);
			}
		};

		$scope.cleanUp = function(focusIndex, searchResult) {
			$scope.locutions = [];
			$scope.searchResult = searchResult;
			$scope.focusIndex = focusIndex;
			$rootScope.isSearchVisible = true;
		};
	  
	  $scope.highlight = function(text, search) {
		  if (!search) {
			  return $sce.trustAsHtml(text);
		  }
		  return $sce.trustAsHtml(text.replace(new RegExp(search, 'gi'), '<span class="highlightedText">$&</span>'));
	  };
	  
	  $scope.open = function ( itemKey ) {
			$rootScope.isSearchVisible = false;
			$rootScope.itemKey = itemKey;
			$location.path('/goruntule/'+itemKey);
		};
	  
	  $scope.keys = [];
	  $scope.keys.push({ code: 13, action: function() { 
			if($location.path() === "/") {
				var itemToOpen = $scope.searchResult[$scope.focusIndex].locution_key;
				$scope.open( itemToOpen ); 
			}
			
		}});
	  $scope.keys.push({ code: 27, action: function() { 
		  	$scope.searchResult = [];	  	
		  }
	  });
	  $scope.keys.push({ code: 38, action: function() { 
		  if ($scope.focusIndex == 0) {
			  $scope.focusIndex = $scope.searchResult.length-1; 
		  }
	  	  else {
	  		  $scope.focusIndex--;
	  	  }
	  	}
	  });
	  $scope.keys.push({ code: 40, action: function() { 
		  if ($scope.focusIndex == $scope.searchResult.length-1) {
			  $scope.focusIndex = 0; 
		  }
	  	  else {
	  		  $scope.focusIndex++;
	  	  }
	  	}
	  });
	  
	  $scope.$on('keydown', function( msg, code ) {
	    $scope.keys.forEach(function(o) {
	      if ( o.code !== code ) { return; }
	      o.action();
	      $scope.$apply();
	    });
	  });
	  
  }]);

})();