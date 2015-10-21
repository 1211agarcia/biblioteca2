var tegApp = angular.module('tegApp', []);

tegApp.config(function($interpolateProvider){
		            $interpolateProvider.startSymbol('[[').endSymbol(']]');
        });

angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null 
}
angular.isInvalide = function(type,val) {
    switch(type){
    	case "school":
    	
    		return ["Biología","Computación","Física","Matemática","Química"].indexOf(val) != -1;
    	break;
    }
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
		alert($scope.biblioteca_tegbundle_teg_publicacion_year);
		$scope.cota_year = angular.isUndefinedOrNull($scope.biblioteca_tegbundle_teg_publicacion_year)? "'Año de Publicion'" : ("0" + (parseInt($scope.biblioteca_tegbundle_teg_publicacion_year) % 100) ).slice (-2);
		alert($scope.biblioteca_tegbundle_teg_publicacion_year);
		$scope.cota_school = angular.isUndefinedOrNull($scope.biblioteca_tegbundle_teg_escuela) || !angular.isInvalide("school",$scope.biblioteca_tegbundle_teg_escuela)? "'Escuela'" : "D"+$scope.biblioteca_tegbundle_teg_escuela.charAt(0);

		$scope.cota = $scope.cota_school +"-"+ (angular.isUndefinedOrNull($scope.cota_index)? "'Indice'" : $scope.cota_index ) +"-"+ $scope.cota_year;
		//alert($scope.cota_index);
	}
 
	$scope.$watch($scope.generar);

	
	$scope.wordkeys = [];
	$scope.authors = [''];
	$scope.label_author = "Agregar";
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

    $scope.addA = function() {
        if($scope.authors.length == 1)
        {
            $scope.authors.push('');
            $scope.label_author ="Quitar";
        }
        else
        {
        	if($scope.authors.length == 2)
	        {
	            $scope.authors.splice(1,1);
	            $scope.label_author ="Agregar";
	        }
	        else
	        {
	        	javascript:location.reload();
	        }
        }
    };
});