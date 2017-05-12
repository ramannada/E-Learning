<?php

$app->group('/api', function() use ($app,$container) {
	$app->post('/register', 'App\Controllers\Api\UserController:register');
	$app->get('/active', 'App\Controllers\Api\UserController:activeUser')->setName('api.user.active');
	$app->post('/login', 'App\Controllers\Api\UserController:login');
})->add(new \App\Middlewares\Api\AuthToken($container));

$app->group('', function() use ($app,$container) {
	$app->get('/active', 'App\Controllers\Web\UserController:activeUser')->setName('web.user.active');
});

?>