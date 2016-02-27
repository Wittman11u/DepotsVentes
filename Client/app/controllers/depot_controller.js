angular.module("DepotVente").controller('DepotController', ['$scope', '$location', 'Depot',
    function ($scope, $location, Depot) {

        $scope.newdepot = "";
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
            console.log("modifie");
            console.log($scope.newdepot);
            $scope.nom = $scope.newdepot.nom;
            $scope.prenom = $scope.newdepot.prenom;
            $scope.adresse = $scope.newdepot.adresse;
            $scope.mail = $scope.newdepot.mail;
            $scope.tel = $scope.newdepot.tel;
            $scope.editCoord = false;
        }


    }]);