showTeg.controller('showTegController', function ($scope, $sce) {

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