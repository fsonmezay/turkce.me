(function() {
  var app = angular.module('turkceme', ['ngRoute', 'filters', 'ngSanitize']);

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

  app.controller('TurkceAppController', ['$scope', '$http', '$sce', function($scope, $http, $sce) {
	  $scope.searchKey="";
	  $scope.searchResult = [];
		$scope.focusIndex = null;
		$scope.locutions = [""];
	  
	  $scope.search = function(value) {
		  if(value.length > 0) {
			  $http.post('search', {query: value}).then(function(response) {
					$scope.cleanUp(0, response.data);
			  });
		  }
		  else {
			 $scope.cleanUp(null, []);
		  }
		};
		
		$scope.addMoreLocutions = function() {
			$scope.locutions.push("");
		};

		$scope.cleanUp = function(focusIndex, searchResult) {
			$scope.locutions = [""];
			$scope.searchResult = searchResult;
			$scope.focusIndex = focusIndex;
		};
	  
	  $scope.highlight = function(text, search) {
		  if (!search) {
			  return $sce.trustAsHtml(text);
		  }
		  return $sce.trustAsHtml(text.replace(new RegExp(search, 'gi'), '<span class="highlightedText">$&</span>'));
	  };
	  
	  $scope.open = function ( index ) {
	    console.log('opening : ', $scope.searchResult[index].locution_key );
	  };
	  
	  $scope.keys = [];
	  $scope.keys.push({ code: 13, action: function() { $scope.open( $scope.focusIndex ); }});
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