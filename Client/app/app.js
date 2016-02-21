window.urlAPI = "http://localhost/DepotsVentes/Server/api/";
var app = angular.module("depotsventes", ['ngResource', 'ngRoute', 'ngSanitize']);


app.config(['$routeProvider', function ($routeProvider) {

    $routeProvider.when('/', {templateUrl: "", controller: ""});

}]);


app.controller('menuController', ['$scope', '$location', function ($scope, $location) {

}]);
