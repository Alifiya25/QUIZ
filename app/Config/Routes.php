<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
    $routes->get('/', 'Auth::login');
 $routes->get('/login', 'Auth::login');
 $routes->post('/processLogin', 'Auth::processLogin');
 $routes->get('/register', 'Auth::register');
 $routes->post('/processRegister', 'Auth::processRegister');
 $routes->get('/logout', 'Auth::logout');
 
 // Dashboard redirect routes
 $routes->get('/dashboard/admin', 'Dashboard::admin'); // Buat controller ini juga
 $routes->get('/dashboard/peserta', 'Dashboard::peserta'); // Buat controller ini juga

 // Forgot Password Routes
$routes->get('/forgot-password', 'Auth::forgotPassword');  // Show forgot password form
$routes->post('/forgot-password', 'Auth::sendResetLink');  // Handle sending reset password link

// Reset Password Routes
$routes->get('/reset-password/(:segment)', 'Auth::resetPassword/$1');  // Show reset password form
$routes->post('/reset-password', 'Auth::processResetPassword');

$routes->get('google-redirect', 'GoogleAuth::redirect');
$routes->get('google-callback', 'GoogleAuth::callback');

$routes->get('/atur-password', 'GoogleAuth::aturPassword');
$routes->post('/atur-password', 'GoogleAuth::simpanPassword');

$routes->get('soal', 'Soal::index');
$routes->post('soal/tambah', 'Soal::tambah');
$routes->post('soal/update/(:num)', 'Soal::update/$1');
$routes->post('soal/hapus/(:num)', 'Soal::hapus/$1');

$routes->get('/soal/index', 'BuatQuiz::index');
$routes->post('/buatquiz/create', 'BuatQuiz::create');

