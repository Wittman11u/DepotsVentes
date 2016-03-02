angular.module("DepotVente").controller('VenteController',['$scope', 'Vente', function($scope, Vente){
		
		// $scope.vente = Vente.get();
		$scope.objet="";
		$scope.listObjet = {
			objet : []
		};
		$scope.prixtotale="10";

		$scope.addObject = function(){
			console.log("ajout objet");
			console.log($scope.objet);
			console.log($scope.listObjet);
			$scope.listObjet.objet.push($scope.objet);
			$scope.objet="";
		}

		$scope.deleteObject = function(obj){
			for(i in $scope.listObjet.objet){
		    	if($scope.listObjet.objet[i] === obj){
		        	$scope.listObjet.objet.splice(i, 1);
		        	break;
		    	}
			}
		}
}]);