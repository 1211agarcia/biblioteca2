newTeg.controller('newTegController', function ($scope) {
    $scope.formData = {};

	$scope.generar = function(){
		//console.log($scope.formData);
		$scope.cota_year = angular.isUndefinedOrNull($scope.formData.biblioteca_tegbundle_teg_publicacion_year) || isNaN($scope.formData.biblioteca_tegbundle_teg_publicacion_year)? "'Año'" : ("0" + (parseInt($scope.formData.biblioteca_tegbundle_teg_publicacion_year) % 100) ).slice (-2);

		$scope.cota_school = angular.isUndefinedOrNull($scope.formData.biblioteca_tegbundle_teg_escuela) || angular.isInvalide("school",$scope.biblioteca_tegbundle_teg_escuela)?"Escuela" :
        "D"+$scope.formData.biblioteca_tegbundle_teg_escuela.charAt(0);

        $scope.cota_index = angular.isUndefinedOrNull($scope.cota_index) ? "00" : ("0" + $scope.cota_index).slice (-2);

		$scope.cota = $scope.cota_school+$scope.cota_index+"/"+$scope.cota_year;
	}
 
	$scope.$watch($scope.generar);
	
    $scope.initCota = function(val) {
        $scope.cota_index = val.substring(2, 4);
    };

    $scope.tagError = false;
    $scope.tagErrorMensaje = "";
 	$scope.onTagAdding = function () {
 		if ($scope.keyWords.length === 15) {
 			$scope.tagErrorMensaje = "Se permite un maximo de 15 palabras claves";
 			$scope.tagError = true;
 			return false;
 		}
 		else
 			return true;
 	}
    $scope.submitForm = function (formData) {
        alert('Form submitted with' + JSON.stringify(formData));
    };
});/*Fin de newTegController*/
