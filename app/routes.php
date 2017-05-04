<?php

$app->get('/', 'App\Controllers\Views\View:index')->setName('home');
$app->get('/article', 'App\Controllers\Views\View:article')->setName('article');
$app->get('/article/detail', 'App\Controllers\Views\View:articleDetail')->setName('article.detail');
$app->get('/login', 'App\Controllers\Views\View:login')->setName('signin');
$app->get('/register', 'App\Controllers\Views\View:register')->setName('register');
$app->get('/resetpassword', 'App\Controllers\Views\View:resetPassword')->setName('resetpassword');
$app->get('/newpassword', 'App\Controllers\Views\View:newPassword')->setName('newpassword');
$app->get('/upgrade', 'App\Controllers\Views\View:upgrade')->setName('upgrade');
$app->get('/dashboard', 'App\Controllers\Views\View:dashboard')->setName('dashboard');
$app->get('/dashboard/detail', 'App\Controllers\Views\View:dashboardDetail')->setName('dashboard.detail');
$app->get('/dashboard/account', 'App\Controllers\Views\View:getAccount')->setName('dashboard.account');
$app->get('/dashboard/profile', 'App\Controllers\Views\View:getAnotherProfile')->setName('dashboard.profile');
$app->get('/dashboard/profile/another', 'App\Controllers\Views\View:getAnotherProfile')->setName('dashboard.profile.another');
$app->get('/dashboard/password', 'App\Controllers\Views\View:getpassword')->setName('dashboard.password');

?>