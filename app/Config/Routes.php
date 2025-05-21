<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/processLogin', 'Auth::processLogin');

// File: app/Config/Routes.php
$routes->get('/register', 'Auth::register');
$routes->post('/processRegister', 'Auth::processRegister');

//Logout
$routes->get('/logout', 'Auth::logout');

//Profile
$routes->get('/profile', 'Profile::index');
$routes->post('/profile/update', 'Profile::update');

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

$routes->get('/soal', 'Soal::index');
$routes->get('/api/soal', 'BuatQuiz::getSoal');
$routes->post('/buatquiz/create', 'BuatQuiz::create');
$routes->get('/buatquiz/list', 'BuatQuiz::list');

$routes->get('soal/list_quiz', 'BuatQuiz::list');

$routes->get('quiz/hasil_quiz', 'QuizController::hasilquiz');

$routes->get('/admin/daftar_peserta', 'Admin::daftar_peserta');
$routes->get('/admin/daftar_admin', 'Admin::daftar_admin');
$routes->get('/admin/form_tambah_admin', 'Admin::create_admin');
$routes->post('/admin/save', 'Admin::save');
$routes->get('/admin/about_us', 'Admin::about_us');

$routes->get('/admin/form_edit_admin/(:num)', 'Admin::edit_admin/$1');
$routes->post('/admin/update_admin/(:num)', 'Admin::update_admin/$1');


$routes->get('/admin/form_edit_peserta/(:num)', 'Admin::edit_peserta/$1');
$routes->post('/admin/update_peserta/(:num)', 'Admin::update_peserta/$1');

$routes->get('/admin/delete_admin/(:num)', 'Admin::delete_admin/$1');
$routes->get('/admin/delete_peserta/(:num)', 'Admin::delete_peserta/$1');

$routes->get('/quiz-ready', 'QuizController::quizReady');
$routes->post('/join-quiz', 'QuizController::joinQuiz');
$routes->get('quiz-show/(:num)/(:num)', 'QuizController::quizShow/$1/$2');
$routes->get('quiz-show/(:num)', 'QuizController::quizShow/$1');

$routes->post('/submit-answer', 'QuizController::submitAnswer');
$routes->get('/quiz-selesai', 'QuizController::quizSelesai');

$routes->get('/leaderboard', 'LeaderboardController::index');

//Tampilan Leaderboard
$routes->get('quiz/quiz_selesai', 'QuizController::quizSelesai');
$routes->get('/dashboard/leaderboard', 'Dashboard::leaderboard');

$routes->get('quiz/sertifikat/(:num)/(:num)', 'QuizController::sertifikat/$1/$2');
$routes->get('quiz/download_sertifikat/(:num)/(:num)', 'QuizController::downloadSertifikat/$1/$2');
