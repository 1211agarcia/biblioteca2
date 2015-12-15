
angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null || val === ''
}
angular.isInvalide = function(type,val) {
    switch(type){
    	//Se verifica que el valor del select sea correcto
        case "school":
    		return ["Biología","Computación","Física","Matemática","Química"].indexOf(val) != -1;
    	break;
    }
}
/**/
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

tegApp.directive('stringToNumber', function() {
  return {
    require: 'ngModel',
    link: function(scope, element, attrs, ngModel) {
      ngModel.$parsers.push(function(value) {
        return '' + value;
      });
      ngModel.$formatters.push(function(value) {
        return parseFloat(value, 10);
      });
    }
  };
});
tegApp.config(function(tagsInputConfigProvider) {
  tagsInputConfigProvider.setDefaults('tagsInput', {
    placeholder: 'New tag',
    removeTagSymbol: '✖'
  })
});
tegApp.controller('inputTegController', function ($scope) {

 /*$scope.tags = new JSTagsCollection(["jsTag", "angularJS"]);

$scope.jsTagOptions = {
    "texts": {
      "inputPlaceHolder": "Escriba aquí"
    },
    "defaultTags": ["Default Tag #1", "Default Tag #2"],
    "tags": $scope.tags
  };*/
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
	$scope.label_author = "Agregar";
	$scope.tutors = [];

    $scope.remove = function(item) {
        $scope.keyWords.splice(item,1);
    };
    $scope.add = function(item) {
        if(item != ""){
            $scope.keyWords.push({'name':item});
        }
        console.log($scope.keyWords);
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
                //javascript:location.reload();
            }
        }
    };
    $scope.initCota = function(val) {
        $scope.cota_index = val.substring(2, 4);
    };
});
/*
tegApp.filter('trustAsResourceUrl', ['$sce', function($sce) {
    return function(val) {
        return $sce.trustAsResourceUrl(val);
    };
}]);
*/
tegApp.controller('showTegController', function ($scope, $sce) {

    $scope.trustSrc = function(src) {
        return $sce.trustAsResourceUrl(src);
    }
    $scope.chapters = [];
    $scope.addChapter = function(id, link, name) {
        if(link != ""){
            $scope.chapters.push({
                'id' : id,
                'name' :  name,
                'url' : $sce.trustAsResourceUrl(link)
                });
        }
        console.log($scope.chapters);

    };
    $scope.initViewer = function(link) {
        console.log(link);
        $scope.viewer = $sce.trustAsResourceUrl(link);
    };
    $scope.initChapterSelected = function (){
       $scope.chapterSelected = $scope.chapters[0].url;       
    }
    
    
    $scope.itemDetail = function(id){
        //$scope.searchResults[link].url

        link = $scope.chapters[id];
        console.log(link);
        //$scope.detailFrame = $scope.viewer + '#' +$sce.trustAsResourceUrl(link);
        $scope.detailFrame = $sce.trustAsResourceUrl(link);
        
        console.log($scope.detailFrame);
        //alert($scope.detailFrame);
        //console.log($scope.detailFrame);
        //console.log("asdasdadasds = ");
        //console.log($scope.viewer+'#'+$scope.detailFrame);
        //document.getElementById("viewer").contentDocument.location.reload(true);
        //window.document.getElementById('viewer').src = $scope.detailFrame;
        //var iframe = $("<iframe>").attr("src", $scope.detailFrame).attr("id", "viewer");
        //iframe.appendTo("capitulo");
        //$("#viewer").appendTo("form:eq(0)");
    };
});


tegApp.controller('searchTegController', function ($scope, $timeout) {
    
    $scope.rango = function() {
        $scope.fechaMin = angular.isUndefinedOrNull($scope.desde)?1998 : $scope.desde;
    }
    $scope.$watch($scope.rango);
    $scope.load = function($event) {
        $scope.loadingSubmit = true;
        $timeout(function() { $scope.loadingSubmit = false; }, 1000);
    };
    //console.log($scope.q);
    $scope.isInvalid = function() {        
        return (angular.isUndefinedOrNull($scope.q) && angular.isUndefinedOrNull($scope.desde) && angular.isUndefinedOrNull($scope.hasta) && angular.isUndefinedOrNull($scope.escuela));
    };
});

tegApp.directive('disabler', function($compile) {
    return {
        link: function(scope, elm, attrs) {
        var btnContents = $compile(elm.contents())(scope);
        scope.$watch(attrs.ngModel, function(value) {
        if (value) {
          //console.log(elm);
          scope.initial_value = elm.attr('value');
          //console.log(scope.initial_value);
          //elm.attr('value', scope.$eval(attrs.disabler));
          //elm.attr('disabled',true);
          setTimeout(function(){
            elm.attr('value', attrs.disabler);
            elm.attr('disabled',true);
            }, 0)
          
        } else {
              //elm.attr('value', scope.initial_value);
              //elm.attr('disabled',false);
              }
          });
        }
  }
});