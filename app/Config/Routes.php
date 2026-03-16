<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/products', 'Products::index');
$routes->get('/product-details', 'Products::details');

// Cart actions
$routes->post('/cart/add', 'Products::addToCart');
$routes->post('/cart/buy', 'Products::buyNow');
$routes->post('/cart/update', 'Products::updateCart');
$routes->post('/cart/remove', 'Products::removeFromCart');

$routes->get('/cart', 'Products::cart');
$routes->get('/checkout', 'Products::checkout');
$routes->get('/shipping', 'Products::shipping');
$routes->get('/payment', 'Products::payment');
$routes->get('/confirmation', 'Products::confirmation');
$routes->get('/login', 'Auth::login');
$routes->get('/register', 'Auth::register');
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/products', 'Admin::products');
$routes->get('/admin/orders', 'Admin::orders');

