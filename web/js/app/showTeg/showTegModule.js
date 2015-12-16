var showTeg = angular.module('showTegModule', ['chieffancypants.loadingBar']);

showTeg.config(function($interpolateProvider){
                $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

showTeg.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeBar = true;
    cfpLoadingBarProvider.latencyThreshold = 500;
  });

showTeg.controller('LoadCtrl', function ($scope, $http, $timeout, cfpLoadingBar) {
    $scope.posts = [];
    $scope.section = null;
    $scope.subreddit = null;
    
    $scope.start = function() {
      cfpLoadingBar.start();
    };

    $scope.complete = function () {
      cfpLoadingBar.complete();
    }

    // fake the initial load so first time users can see it right away:
    $scope.start();
    $scope.fakeIntro = true;
    $timeout(function() {
      $scope.complete();
      $scope.fakeIntro = false;
    }, 750);

  });

angular.element(document).ready(function() {
      angular.bootstrap(document, ['showTegModule']);
});