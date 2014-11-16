'use strict';

/**
 * @ngdoc overview
 * @name Aisel
 *
 * @description
 * Product router
 */

define(['app',
    './controllers/page', './controllers/pagedetails',
    './services/page',
    './controllers/pagecategory', './controllers/pagecategorydetails',
    './services/pagecategory',
], function (app) {
    console.log('Page module loaded ...');
    app.config(function ($provide, $routeProvider, $locationProvider, $httpProvider) {
        $routeProvider

            // Pages
            .when('/:locale/pages/', {
                templateUrl: '/app/Aisel/Page/views/page.html',
                controller: 'PageCtrl'
            })
            .when('/:locale/page/view/:pageId/', {
                templateUrl: '/app/Aisel/Page/views/page-detail.html',
                controller: 'PageDetailCtrl'
            })
            // Categories
            .when('/:locale/page/categories/', {
                templateUrl: '/app/Aisel/Page/views/category.html',
                controller: 'PageCategoryCtrl'
            })
            .when('/:locale/page/category/:categoryId/', {
                templateUrl: '/app/Aisel/Page/views/category-detail.html',
                controller: 'PageCategoryDetailCtrl'
            })

    });
});