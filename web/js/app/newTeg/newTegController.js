newTeg.controller('newTegController', function ($scope) {

	$scope.generar = function(){

		$scope.cota_year = angular.isUndefinedOrNull($scope.biblioteca_tegbundle_teg_publicacion_year) || isNaN($scope.biblioteca_tegbundle_teg_publicacion_year)? "'Año'" : ("0" + (parseInt($scope.biblioteca_tegbundle_teg_publicacion_year) % 100) ).slice (-2);
		//alert($scope.biblioteca_tegbundle_teg_publicacion_year);
		$scope.cota_school =
        angular.isUndefinedOrNull($scope.biblioteca_tegbundle_teg_escuela) || !angular.isInvalide("school",$scope.biblioteca_tegbundle_teg_escuela)?
        "'Escuela'" :
        "D"+$scope.biblioteca_tegbundle_teg_escuela.charAt(0);

        $scope.cota_index = angular.isUndefinedOrNull($scope.cota_index) ? "00" : ("0" + $scope.cota_index).slice (-2);

		$scope.cota = $scope.cota_school+$scope.cota_index+"/"+$scope.cota_year;
	}
 
	$scope.$watch($scope.generar);
	
	$scope.keyWords = [];
	$scope.authors = [];
	$scope.tutors = [];

    $scope.initCota = function(val) {
        $scope.cota_index = val.substring(2, 4);
    };

    $scope.formData = {};
 
    $scope.submitForm = function (formData) {
        alert('Form submitted with' + JSON.stringify(formData));
        };
});/*Fin de newTegController*/

newTeg.controller('MainCtrl', function ($scope) {
  $scope.formData = {};
  
  $scope.submitForm = function (formData) {
    alert('Form submitted with' + JSON.stringify(formData));
  };
});