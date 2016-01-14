angular.isUndefinedOrNull = function(val) {
    return angular.isUndefined(val) || val === null || val === ''
}

var searchTeg = angular.module('searchTegModule', ['chieffancypants.loadingBar']);

searchTeg.config(function($interpolateProvider){
                $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

searchTeg.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeBar = true;
    cfpLoadingBarProvider.latencyThreshold = 500;
  });

searchTeg.controller('LoadCtrl', function ($scope, $http, $timeout, cfpLoadingBar) {
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

searchTeg.directive('disabler', function($compile) {
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

angular.element(document).ready(function() {
      angular.bootstrap(document, ['searchTegModule']);
});