/**
 * Created by vorace on 18/02/16.
 */
angular.module('DepotVente').factory('Depot', ['$resource', function ($resource) {
    var uri = window.urlAPI + 'depots/:id';
    return $resource(uri, {id: '@id'}, {
        update: {method: 'put'}
    });
}]);