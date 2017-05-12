<?php

$app->group('/api', function() use ($app,$container) {
    $app->post('/register', 'App\Controllers\Api\UserController:register')->setName('api.user.register');
    $app->get('/active', 'App\Controllers\Api\UserController:activeUser')->setName('api.user.active');
    $app->post('/login', 'App\Controllers\Api\UserController:login')->setName('api.user.login');
    $app->post('/password_reset', 'App\Controllers\Api\UserController:passwordReset')->setName('api.user.password.reset');
    $app->get('/renew_password', 'App\Controllers\Api\UserController:getReNewPassword')->setName('api.user.get.renew.password');
    $app->put('/renew_password', 'App\Controllers\Api\UserController:postReNewPassword')->setName('api.user.put.renew.password');
})->add(new \App\Middlewares\Api\AuthToken($container));

$app->group('', function() use ($app,$container) {
	$app->get('/active', 'App\Controllers\Web\UserController:activeUser')->setName('web.user.active');
    
    $app->get('/renew_password', 'App\Controllers\Web\UserController:getReNewPassword')->setName('web.user.renew.password');
});

?>
