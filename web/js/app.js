var tegApp = angular.module('tegApp', ['chieffancypants.loadingBar'])
  .config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = true;
  });
tegApp.config(function($interpolateProvider){
                $interpolateProvider.startSymbol('[[').endSymbol(']]');
        });

tegApp.controller('LoadCtrl', function ($scope, $http, $timeout, cfpLoadingBar) {
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
