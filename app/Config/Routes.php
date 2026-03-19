<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('/products', 'Products::index');
$routes->get('/product-details', 'Products::details');

$routes->post('/cart/add', 'Products::addToCart');
$routes->post('/cart/buy', 'Products::buyNow');
$routes->post('/cart/update', 'Products::updateCart');
$routes->post('/cart/remove', 'Products::removeFromCart');

$routes->get('/cart', 'Products::cart');
$routes->get('/checkout', 'Products::checkout');
$routes->post('/checkout/save', 'Products::saveCustomerInfo');
$routes->post('/checkout/place', 'Products::placeOrder');
$routes->get('/shipping', 'Products::shipping');
$routes->post('/shipping/save', 'Products::saveShipping');
$routes->get('/payment', 'Products::payment');
$routes->get('/confirmation', 'Products::confirmation');

/* AUTH */
$routes->get('/login', 'Auth::login');
$routes->post('/login/auth', 'Auth::authenticate');

$routes->get('/register', 'Auth::register');
$routes->post('/register/save', 'Auth::saveUser');

$routes->get('/logout', 'Auth::logout');

/* ADMIN */
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/products', 'Admin::products');
$routes->get('/admin/orders', 'Admin::orders');
