<?php 
namespace Drupal\hello_drupal8\Routing;

use Symfony\Component\Routing\Route;

/**
 * Defines dynamic routes.
 */
class ExampleRoutes {
    
    /**
     * {@inheritdoc}
     */
    public function routes() {
        $routes = [];
        // Declares a single route under the name 'example.content'.
        // Returns an array of Route objects.
        $routes['example.content'] = new Route(
            // Path to attach this route to:
            '/test',
            // Route defaults:
            [
                '_controller' => '\Drupal\hello_drupal8\Controller\ExampleController::content',
                '_title' => 'Hello'
            ],
            // Route requirements:
            [
                '_permission'  => 'access content',
            ]
            );
        $routes['hi.content'] = new Route(
            // Path to attach this route to:
            '/hi',
            // Route defaults:
            [
                '_controller' => '\Drupal\hello_drupal8\Controller\SayHelloToDrupal8::hi',
                '_title' => 'Hello'
            ],
            // Route requirements:
            [
                '_permission'  => 'access content',
            ]
            );
        return $routes;
    }
    
}