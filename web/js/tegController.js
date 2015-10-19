var tegApp = angular.module('tegApp', []);
tegApp.config(function($interpolateProvider){
		            $interpolateProvider.startSymbol('[[').endSymbol(']]');
		        });

angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null 
}

tegApp.controller('inputTegController', function ($scope) {


$scope.pepe = $scope.biblioteca_tegbundle_teg_escuela;

$scope.generar = function(){
	$scope.cota_year = angular.isUndefinedOrNull($scope.biblioteca_tegbundle_teg_publicacion_year)? "'Año de Publicion'" : ("0" + (parseInt($scope.biblioteca_tegbundle_teg_publicacion_year) % 100) ).slice (-2);
	
	$scope.cota_school = angular.isUndefinedOrNull($scope.biblioteca_tegbundle_teg_escuela)? "'Escuela'" : "D"+$scope.biblioteca_tegbundle_teg_escuela.charAt(0);

	$scope.cota = $scope.cota_school +"-"+ $scope.cota_index +"-"+ $scope.cota_year;
}
 
	$scope.$watch($scope.generar);
});