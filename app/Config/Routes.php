<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('register','Home::register');
$routes->get('login', 'Home::login');
$routes->get('registraion', 'Home::getregister');
$routes->post('dologin','Home::dologin');
$routes->get('coustmordashboard', 'Home::coustmordashboard');
$routes->get('profile', 'Home::profile');
$routes->post('Updateprofile','Home::Updateprofile');
$routes->get('order', 'Home::order');
$routes->get('AdminDashboard', 'Home::AdminDashboard');
$routes->get('addproduct', 'Home::addproduct');
$routes->post('add_product','Home::add_product');
$routes->get('productlist', 'Home::produact_list');
$routes->post('addproduct/(:any)', 'Home::addproduct/$1');
$routes->get('addproduct/(:any)', 'Home::addproduct/$1');
$routes->post('deleteproduct','Home::deleteproduct');
$routes->get('logout', 'Home::logout');
$routes->get('addCoustmer', 'Home::addCoustmer');
$routes->get('addCoustmers', 'Home::addCoustmers');
$routes->post('addCoustmersbyadmin','Home::addCoustmersbyadmin');
$routes->get('Receivedorder', 'Home::Receivedorder');
$routes->get('orderpayment', 'Home::orderpayment');
$routes->get('allotdelivery', 'Home::allotdelivery');

$routes->get('produactlist', 'Home::produact_list');
$routes->post('updatepaymentstatus', 'Home::updatepaymentstatus');
$routes->post('deliverypaymentcollect', 'Home::deliverypaymentcollect');
$routes->get('userlist', 'Home::userlist');
$routes->get('deliveredorder', 'Home::deliveredorder');

$routes->get('coustmerlisting', 'Home::coustmerlisting');
$routes->get('Staffdelivery', 'Home::Staffdelivery');
$routes->get('Orderlist', 'Home::Orderlist');
$routes->get('yourorder', 'Home::yourorder');
$routes->post('updateorderstatus','Home::updateorderstatus');
$routes->post('deletuser','Home::deletuser');

$routes->get('adduser', 'Home::adduser');
$routes->get('adduser/(:any)', 'Home::adduser/$1');

$routes->post('addstaff','Home::addstaff');
$routes->post('allotpartners','Home::allotpartners');

$routes->get('addmenu', 'Home::addmenu');
$routes->post('set_menu','Home::setmenu');
$routes->post('orderbook','Home::orderbook');
$routes->get('ordehistory', 'Home::ordehistory');
$routes->get('Subscriptions', 'Home::Subscriptions');
$routes->post('Subscriptionsbook','Home::Subscriptionsbook');

$routes->post('Home/paymentsucess','Home::paymentsucess');