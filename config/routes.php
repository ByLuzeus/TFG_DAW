<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('', function (RouteBuilder $builder) {
        $builder->redirect(
            '/',
            ['controller' => 'Adminusers', 'action' => 'login'],
            ['persist' => true]
            // Or ['persist'=>['id']] for default routing where the
            // view action expects $id as an argument.
        );
        $builder->connect('/media', ['controller' => 'Multimedia', 'action' => 'index']);
        $builder->connect('/login', ['controller' => 'Adminusers', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Adminusers', 'action' => 'logout']);
        $builder->connect('/forgotpass', ['controller' => 'Adminusers', 'action' => 'forgotpass']);
        $builder->connect('/resetpsw/*', ['controller' => 'Adminusers', 'action' => 'resetpsw']);
        $builder->connect('/licenses/email-search', ['controller' => 'Licenses', 'action' => 'emailSearch']);


        $builder->scope('/api', function (RouteBuilder $builder) {
            $builder->setExtensions(['json']);

            // /api/listsons 
            $builder->connect('/listsons', ['prefix' => 'Api', 'controller' => 'Api', 'action' => 'listsons']);
            // /api/registerfather
            $builder->connect('/registerfather', ['prefix' => 'Api', 'controller' => 'Api', 'action' => 'registerfather']);
            // /api/get-notifs-request
            $builder->connect('/get-notifs-request', ['prefix' => 'Api', 'controller' => 'Api', 'action' => 'getNotifsRequest']);
            $builder->connect('/remove-request', ['prefix' => 'Api', 'controller' => 'Api', 'action' => 'removeRequest']);
            $builder->connect('/update-profile', ['prefix' => 'Api', 'controller' => 'Api', 'action' => 'updateProfile']);
            $builder->connect('/registryson', ['prefix' => 'Api', 'controller' => 'Api', 'action' => 'registrySon']);
            $builder->connect('/userdetails/*', ['prefix' => 'Api', 'controller' => 'Api', 'action' => 'userdetails']);


        });
        $builder->connect('/famhapp/home', ['controller' => 'Famhapp', 'action' => 'home']);
        $builder->connect('/famhapp/configuration', ['controller' => 'Famhapp', 'action' => 'configuration']);
        $builder->connect('/famhapp/logout', ['controller' => 'Famhapp', 'action' => 'logout']);
        $builder->connect('/famhapp/adduser', ['controller' => 'Famhapp', 'action' => 'adduser']);
        $builder->connect('/famhapp/userdetails/*', ['controller' => 'Famhapp', 'action' => 'userdetails']);




        
        //$routes->redirect('/', '/admin/articles');
        $builder->fallbacks('DashedRoute');
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */
};
