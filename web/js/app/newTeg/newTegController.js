newTeg.controller('newTegController', function ($scope) {
    $scope.files = [];
    $scope.formData = {};
    $scope.formData.biblioteca_tegbundle_teg_keyWords = [];
    $scope.pasoUnoValid = false;
    $scope.pasoDosValid = false;
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
    $scope.add = function(item) {
        console.log($scope.formData.biblioteca_tegbundle_teg_keyWords);
        if(item != ""){
            $scope.formData.biblioteca_tegbundle_teg_keyWords.push({'word':item});
        }
    };

    $scope.isValid = function(item) {
        switch(item){
            case "biblioteca_tegbundle_teg[authors]":
                console.log($scope.formInputTeg[item+"[1][name]"]);
                return $scope.formInputTeg[item+"[0][name]"].$valid &&
                $scope.formInputTeg[item+"[0][lastname]"].$valid &&
                ($scope.segundoA ?
                angular.isDefined($scope.formInputTeg[item+"[1][name]"]) &&
                $scope.formInputTeg[item+"[1][name]"].$valid &&
                $scope.formInputTeg[item+"[1][lastname]"].$valid : true);
                
            break;
            case "biblioteca_tegbundle_teg[tuthors]":
                return $scope.formInputTeg[item+"[0][name]"].$valid &&
                $scope.formInputTeg[item+"[0][lastname]"].$valid &&
                ($scope.segundoT ?
                angular.isDefined($scope.formInputTeg[item+"[1][name]"]) &&
                $scope.formInputTeg[item+"[1][name]"].$valid &&
                $scope.formInputTeg[item+"[1][lastname]"].$valid : true);
                
            break;
            case "biblioteca_tegbundle_teg[capitulos]":
            console.log("0 = "+$scope.formInputTeg[item+"[0][file]"].$valid);
            console.log("1 = "+$scope.formInputTeg[item+"[1][file]"].$valid);
            console.log("2 = "+$scope.formInputTeg[item+"[2][file]"].$valid);
            console.log("3 = "+$scope.formInputTeg[item+"[3][file]"].$valid);
            console.log("4 = "+$scope.formInputTeg[item+"[4][file]"].$valid);
            console.log("all = "+(
                $scope.formInputTeg[item+"[0][file]"].$valid &&
                $scope.formInputTeg[item+"[1][file]"].$valid &&
                $scope.formInputTeg[item+"[2][file]"].$valid &&
                $scope.formInputTeg[item+"[3][file]"].$valid &&
                $scope.formInputTeg[item+"[4][file]"].$valid));
                return (
                $scope.formInputTeg[item+"[0][file]"].$valid &&
                $scope.formInputTeg[item+"[1][file]"].$valid &&
                $scope.formInputTeg[item+"[2][file]"].$valid &&
                $scope.formInputTeg[item+"[3][file]"].$valid &&
                $scope.formInputTeg[item+"[4][file]"].$valid);
            break;
            default:
                return $scope.formInputTeg[item].$valid;
            break;
        }
    };
   
    $scope.formValid = function () {
        $scope.pasoUnoValid =
            ($scope.isValid('biblioteca_tegbundle_teg[titulo]') &&
            $scope.isValid('biblioteca_tegbundle_teg[escuela]') &&
            $scope.isValid('biblioteca_tegbundle_teg[keyWords]') &&
            $scope.isValid('biblioteca_tegbundle_teg[resumen]') &&
            $scope.isValid('biblioteca_tegbundle_teg[authors]') &&
            $scope.isValid('biblioteca_tegbundle_teg[tuthors]') &&
            $scope.isValid('biblioteca_tegbundle_teg[publicacion]'));
        console.log("pafiles "+$scope.isValid('biblioteca_tegbundle_teg[capitulos]'));

        $scope.pasoDosValid = (
            $scope.pasoUnoValid &&
            $scope.isValid('biblioteca_tegbundle_teg[capitulos]') && 
            $scope.isValid('biblioteca_tegbundle_teg[published]')
            //&& $scope.isValid('biblioteca_tegbundle_teg[cota]')
            );
        console.log("paso 2 "+($scope.pasoUnoValid &&
            $scope.isValid('biblioteca_tegbundle_teg[capitulos]') && 
            $scope.isValid('biblioteca_tegbundle_teg[published]')
            //&& $scope.isValid('biblioteca_tegbundle_teg[cota]')
            ));
        console.log("paso 2 "+$scope.pasoDosValid);
    
    };
    $scope.$watch($scope.formValid);
    
    $scope.submitForm = function (formData) {
        alert('Form submitted with' + JSON.stringify(formData));
    };
});/*Fin de newTegController*/
