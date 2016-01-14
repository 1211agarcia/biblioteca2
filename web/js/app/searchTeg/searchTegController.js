searchTeg.controller('searchTegController', function ($scope, $timeout) {
    $scope.searchRequired = true;
    $scope.searchValid = false;
    $scope.load = function($event) {
        $scope.loadingSubmit = true;
        $timeout(function() { $scope.loadingSubmit = false; }, 1000);
    };
    //console.log($scope.q);
    $scope.isValid = function() {    
    $scope.searchValid = (
            (!angular.isUndefinedOrNull($scope.q) && $scope.search["search[q]"].$valid) ||
            (!angular.isUndefinedOrNull($scope.desde) && $scope.search["search[desde]"].$valid) || 
            (!angular.isUndefinedOrNull($scope.hasta) && $scope.search["search[hasta]"].$valid) || 
            (!angular.isUndefinedOrNull($scope.escuela) && $scope.search["search[escuela]"].$valid));
    console.log($scope.searchValid);
        /*$scope.searchRequired = ($scope.search["search[q]"].$invalid && $scope.search["search[desde]"].$invalid && $scope.search["search[hasta]"].$invalid && $scope.search["search[escuela]"].$invalid);*/
    };
    $scope.$watch($scope.isValid);


});