<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/admin', 'AdminController::index');
$routes->get('/admin/edit/(:num)', 'AdminController::edit/$1');
$routes->get('/admin/delete/(:num)', 'AdminController::delete/$1');
$routes->post('/admin/update', 'AdminController::updateData'); // New route for updating user data
$routes->get('/admin/add', 'AdminController::add'); // New route for displaying the add user form
$routes->post('/admin/store', 'AdminController::addData'); // Updated route for storing the user
$routes->get('/campaigns/home', 'CampaignController::index'); 

$routes->get('/login', 'LoginController::index');
$routes->post('/login/authenticate', 'LoginController::authenticate');
$routes->get('/logout', 'LoginController::logout');


$routes->get('/campaign/add', 'CampaignController::add'); 
$routes->post('/campaign/store', 'CampaignController::addData');
$routes->get('/campaign/edit/(:num)', 'CampaignController::edit/$1');
$routes->post('/campaign/update', 'CampaignController::updateData');
$routes->get('/campaign/delete/(:num)', 'CampaignController::delete/$1');

$routes->post('/admin/filter', 'AdminController::filter');
$routes->post('/campaign/filter', 'CampaignController::filter');

$routes->get('/chat/index', 'ChatController::index'); 



