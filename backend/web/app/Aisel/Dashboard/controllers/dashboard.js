'use strict';

/**
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @name            AiselDashboard
 * @description     ...
 */

define(['app'], function (app) {
    app.controller('DashboardCtrl', ['$location', '$scope', '$routeParams', '$rootScope',
        function ($location, $scope, $routeParams, $rootScope) {
            $scope.content = 'some important information ...';
        }]);
});