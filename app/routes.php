<?php

$app->post('/api/register', 'App\Controllers\Api\UsersController:register');

$app->get('/active', 'App\Controllers\Api\UsersController:activeUser')->setName('user.active');

$app->post('/api/login', 'App\Controllers\Api\UsersController:login');

?>