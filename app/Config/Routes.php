<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


/*
|--------------------------------------------------------------------------
| PUBLIC WEBSITE
|--------------------------------------------------------------------------
*/

$routes->get('/', 'Home::index');


/*
|--------------------------------------------------------------------------
| PRODUCTS
|--------------------------------------------------------------------------
*/

$routes->get('/products', 'Products::index');
$routes->get('/product-details', 'Products::details');


/*
|--------------------------------------------------------------------------
| CART
|--------------------------------------------------------------------------
*/

$routes->post('/cart/add', 'Products::addToCart');
$routes->post('/cart/buy', 'Products::buyNow');

$routes->post('/cart/update', 'Products::updateCart');
$routes->post('/cart/remove', 'Products::removeFromCart');

$routes->get('/cart', 'Products::cart');


/*
|--------------------------------------------------------------------------
| CHECKOUT PROCESS
|--------------------------------------------------------------------------
*/

$routes->get('/checkout', 'Products::checkout');
$routes->post('/checkout/save', 'Products::saveCustomerInfo');

$routes->get('/shipping', 'Products::shipping');
$routes->post('/shipping/save', 'Products::saveShipping');

$routes->get('/payment', 'Products::payment');
$routes->get('/confirmation', 'Products::confirmation');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

$routes->get('/login', 'Auth::login');
$routes->post('/login/auth', 'Auth::authenticate');

$routes->get('/register', 'Auth::register');
$routes->post('/register/save', 'Auth::saveUser');

$routes->get('/logout', 'Auth::logout');


/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/

$routes->get('/admin', 'Admin::index');

/* PRODUCTS MANAGEMENT */

$routes->get('/admin/products', 'Admin::products');
$routes->get('/admin/orders', 'Admin::orders');

/* PRODUCT CRUD */
$routes->post('/admin/products/store', 'Admin::storeProduct');
$routes->post('/admin/products/update/(:num)', 'Admin::updateProduct/$1');
$routes->get('/admin/products/delete/(:num)', 'Admin::deleteProduct/$1');

$routes->get('/admin/orders', 'Admin::orders');
