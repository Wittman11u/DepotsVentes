angular.module("DepotVente").controller('DepotController', ['$scope', '$location', 'Depot',
    function ($scope, $location, Depot) {
        
        // $scope.depot = Depot.get({id:});

        $scope.newdepot="";
        $scope.listObjet = {
            objet : []
        };
        $scope.editCoord = false;

        $scope.createDepot = function () {
            console.log("cree");
            $scope.nom = $scope.newdepot.nom;
            $scope.prenom = $scope.newdepot.prenom;
            $scope.adresse = $scope.newdepot.adresse;
            $scope.mail = $scope.newdepot.mail;
            $scope.tel = $scope.newdepot.tel;
            $scope.isplay = true;
            var depot = new Depot();
            depot.name = $scope.newdepot.nom;
            depot.firstname = $scope.newdepot.prenom;
            depot.email = $scope.newdepot.adresse;
            depot.address = $scope.newdepot.mail;
            depot.phone = $scope.newdepot.tel;
            depot.$save(function (res) {
                console.log(res);
            });

        };

        $scope.EditCoord = function () {
            $scope.editCoord = true;
        };

        $scope.updateCoord = function () {
            //depot.update
            console.log("modifie");
            console.log($scope.newdepot);
            $scope.nom = $scope.newdepot.nom;
            $scope.prenom = $scope.newdepot.prenom;
            $scope.adresse = $scope.newdepot.adresse;
            $scope.mail = $scope.newdepot.mail;
            $scope.tel = $scope.newdepot.tel;
            $scope.editCoord = false;
        }

        $scope.addObject = function(){
            // save depot.products 
            console.log("ajout objet");
            console.log($scope.objet);
            console.log($scope.listObjet);
            $scope.listObjet.objet.push($scope.objet);
            $scope.objet="";
        }

        $scope.deleteObject = function(obj){
            // Depot.delete(product selectionné);
            for(i in $scope.listObjet.objet){
                if($scope.listObjet.objet[i] === obj){
                    $scope.listObjet.objet.splice(i, 1);
                    break;
                }
            }
        } 

        $scope.editObject = function(objet){
            objet.isediting=true;
        }

        $scope.updObject = function(objet){
            console.log($scope.listObjet);
            objet.isediting=false;
        }

}]);
