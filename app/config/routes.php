<?php

use Phalcon\Mvc\Router\Annotations as RouterAnnotations;

$router = new RouterAnnotations(false);

// Read the annotations from ProductsController if the URI starts with /api/products
$router->addResource('App\\Controllers\\Books', '/api/books');

return $router;
