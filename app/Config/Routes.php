<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/products', 'Products::index');
$routes->get('/product-details', 'Products::details');
$routes->get('/cart', 'Products::cart');
$routes->get('/checkout', 'Products::checkout');
$routes->get('/shipping', 'Products::shipping');
