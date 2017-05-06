<?php

$app->group('/api', function() use ($app,$container) {
    $app->post('/register', 'App\Controllers\Api\UserController:register')->setName('api.user.register');
    $app->get('/active', 'App\Controllers\Api\UserController:activeUser')->setName('api.user.active');
    $app->post('/login', 'App\Controllers\Api\UserController:login')->setName('api.user.login');
    $app->post('/password_reset', 'App\Controllers\Api\UserController:passwordReset')->setName('api.user.password.reset');
    $app->get('/renew_password', 'App\Controllers\Api\UserController:getReNewPassword')->setName('api.user.get.renew.password');
    $app->put('/renew_password', 'App\Controllers\Api\UserController:postReNewPassword')->setName('api.user.put.renew.password');
});

$app->group('', function() use ($app,$container) {
    $app->get('/', 'App\Controllers\Web\HomeController:index')->setName('web.home');

	$app->get('/register', 'App\Controllers\Web\UserController:getRegister')->setName('web.user.register');
    $app->post('/register', 'App\Controllers\Web\UserController:postRegister');

	$app->get('/active', 'App\Controllers\Web\UserController:activeUser')->setName('web.user.active');

	$app->get('/login', 'App\Controllers\Web\UserController:getLogin')->setName('web.user.login');
    $app->get('/logout', 'App\Controllers\Web\UserController:logout')->setName('web.user.logout');
    $app->post('/login', 'App\Controllers\Web\UserController:postLogin')->setName('web.post.user.login');

    $app->get('/password_reset', 'App\Controllers\Web\UserController:getPasswordReset')->setName('web.user.password.reset');
    $app->post('/password_reset', 'App\Controllers\Web\UserController:postPasswordReset');
    
    $app->get('/renew_password', 'App\Controllers\Web\UserController:getReNewPassword')->setName('web.user.renew.password');
    $app->post('/renew_password', 'App\Controllers\Web\UserController:postReNewPassword');
});

?>
