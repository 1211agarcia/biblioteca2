showTeg.controller('showTegController', function ($scope, $sce) {

    $scope.trustSrc = function(src) {
        return $sce.trustAsResourceUrl(src);
    }
    $scope.chapters = [];
    $scope.addChapter = function(id, link, name) {
        /* esto se hace con la finalidad que para los datos de prueba tome los archuivos de ejemplo */
        if (UrlExists(link)) {
            url = link;
        }
        else {
            var aux = link.split("/");/* se separa la url */
            aux[aux.length-1] = "capitulo"+(parseInt(id)+1)+".pdf"; /*se cambia el ultimo tramo de la url donde se indica el nombre el archivo*/
            //aux.join("/");
            url = "";
            for (var i = 1; i < aux.length; i++) {
                url = url + "/" + aux[i];
            }
            console.log(url);
            
        }
        if(url != ""){
            $scope.chapters.push({
                'id' : id,
                'name' :  name,
                'url' : $sce.trustAsResourceUrl(url)
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

    function UrlExists(url)
    {
        var http = new XMLHttpRequest();
        http.open('HEAD', url, false);
        http.send();
        return http.status!=404;
    }
});