var tegApp = angular.module('tegApp', []);

tegApp.config(function($interpolateProvider){
		            $interpolateProvider.startSymbol('[[').endSymbol(']]');
        });

angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null 
}
tegApp.directive('ngEnter', function() {
        return function(scope, element, attrs) {
            element.bind("keydown keypress", function(event) {
                if(event.which === 13) {
                        scope.$apply(function(){
                                scope.$eval(attrs.ngEnter);
                        });
                        
                        event.preventDefault();
                }
            });
        };
});



tegApp.controller('inputTegController', function ($scope) {

	$scope.generar = function(){
		$scope.cota_year = angular.isUndefinedOrNull($scope.biblioteca_tegbundle_teg_publicacion_year)? "'Año de Publicion'" : ("0" + (parseInt($scope.biblioteca_tegbundle_teg_publicacion_year) % 100) ).slice (-2);
		
		$scope.cota_school = angular.isUndefinedOrNull($scope.biblioteca_tegbundle_teg_escuela)? "'Escuela'" : "D"+$scope.biblioteca_tegbundle_teg_escuela.charAt(0);

		$scope.cota = $scope.cota_school +"-"+ $scope.cota_index +"-"+ $scope.cota_year;
	}
 
	$scope.$watch($scope.generar);

	
	$scope.wordkeys = [];
	$scope.authors = [];
	$scope.tutors = [];

    $scope.remove = function(item) {
        $scope.wordkeys.splice(item,1);
    };
    $scope.add = function(item) {
        if(item != ""){
            $scope.wordkeys.push(item);
        }
        $scope.newWordkey = "";
    };

    $scope.removeA = function() {
        $scope.authors.splice(1,1);
    };
    $scope.addA = function(item) {
        if(item != "" && $scope.authors.leag == 1)
        {
            $scope.authors.push(item);
        }
        //$scope.newWordkey = "";
    };
});