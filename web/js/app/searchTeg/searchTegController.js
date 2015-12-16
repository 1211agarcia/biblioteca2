searchTeg.controller('searchTegController', function ($scope, $timeout) {
    
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