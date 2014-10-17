'use strict';

/**
 * @ngdoc overview
 * @name aiselApp
 *
 * @description
 * ...
 */

define(['app'], function (app) {
    app.service('categoryService', ['$http', '$routeParams', 'API_URL',
        function ($http, $routeParams, API_URL) {
            return {
                getCategories: function ($scope) {
                    var locale = location.pathname.substr(1, 2);
                    var url = API_URL + '/' + locale + '/page/category/list.json?limit=' + $scope.pageLimit + '&current=' + $scope.paginationPage;
                    console.log(url);
                    return $http.get(url);
                },
                getCategory: function (categoryId) {
                    var locale = location.pathname.substr(1, 2);
                    var url = API_URL + '/' + locale + '/page/category/view/' + categoryId + '.json';
                    console.log(url);
                    return $http.get(url);
                }
            };
        }]);
});