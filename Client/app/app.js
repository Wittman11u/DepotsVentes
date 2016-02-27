window.urlAPI = "http://localhost/DepotsVentes/Server/api/";
var app = angular.module("DepotVente", ['ngResource', 'ngRoute', 'ngSanitize']);


app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider.when('/', {templateUrl: "app/templates/connexion.html", controller: ""});
    $routeProvider.when('/depot/new', {templateUrl: "app/templates/newdepot.html", controller: "DepotController"});
    $routeProvider.when('/depot/gestion', {templateUrl: "app/templates/gestionDepot.html", controller: ""});
    $routeProvider.when('/vente', {templateUrl: "app/templates/vente.html", controller: ""});
    $routeProvider.when('/admin/config', {templateUrl: "app/templates/adminConfig.html", controller: ""});
    $routeProvider.when('/admin/tableauBord', {templateUrl: "app/templates/adminTableauBord.html", controller: ""});
    $routeProvider.when('/admin/gestionStaff', {templateUrl: "app/templates/adminGestionStaff.html", controller: ""});
}]);