<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('login', 'Login::loginController');
$routes->post('register', 'Register::registerController');

// Dashboard 
$routes->get('fetchCustomerReserve', 'Dashboard::fetchCustomerReserveController');
$routes->post('addCustomerReserve', 'Dashboard::addCustomerReserveController');
$routes->post('updateCustomerReserve', 'Dashboard::updateCustomerReserveController');
$routes->post('deleteCustomerReserve', 'Dashboard::deleteCustomerReserveController');

// Home
$routes->post('reserveRoom', 'Home::addRoomAndContactInfoController');

// Rooms
$routes->get('fetchRooms', 'Rooms::fetchRoomController');
$routes->post('addRoom', 'Rooms::addRoomController');
$routes->post('updateRoom', 'Rooms::updateRoomController');
$routes->post('deleteRoom', 'Rooms::deleteRoomController');

// Schedule
$routes->get('fetchSchedule', 'Schedule::fetchScheduleController');
$routes->post('addSchedule', 'Schedule::addScheduleController');
$routes->post('updateSchedule', 'Schedule::updateScheduleController');

// set Status
$routes->post('setStatus', 'Dashboard::setCreatedStatusController');

// customers 
$routes->get('fetchCustomers', 'Customers::fetchCustomersController');
$routes->post('updateCustomers', 'Customers::updateCustomersController');

// admin
$routes->get('fetchAdmin', 'Register::fetchAdminController');
$routes->post('updateAdmin', 'Register::updateAdminController');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
