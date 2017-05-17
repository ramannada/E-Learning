<?php 

$app->get('/', 'App\Controllers\Web\HomeController:index')->setName('web.home');

$app->get('/register', 'App\Controllers\Web\UserController:getRegister')->setName('web.user.register');
$app->post('/register', 'App\Controllers\Web\UserController:postRegister');

$app->get('/active', 'App\Controllers\Web\UserController:activeUser')->setName('web.user.active');

$app->get('/login', 'App\Controllers\Web\UserController:getLogin')->setName('web.user.login');
$app->post('/login', 'App\Controllers\Web\UserController:postLogin')->setName('web.post.user.login');

$app->get('/renew_password', 'App\Controllers\Web\UserController:getReNewPassword')->setName('web.user.renew.password');

$app->group('', function() use($app,$container) {
	$app->get('/logout', 'App\Controllers\Web\UserController:logout')->setName('web.user.logout');
})->add(new \App\Middlewares\Web\UserMiddleware($container));



?>