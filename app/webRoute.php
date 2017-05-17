<?php 

$app->group('', function() use($app,$container) {
	$app->get('/', 'App\Controllers\Web\HomeController:index')->setName('web.home');

	$app->get('/register', 'App\Controllers\Web\UserController:getRegister')->setName('web.user.register');
	$app->post('/register', 'App\Controllers\Web\UserController:postRegister');

	$app->get('/active', 'App\Controllers\Web\UserController:activeUser')->setName('web.user.active');

	$app->get('/login', 'App\Controllers\Web\UserController:getLogin')->setName('web.user.login');
	$app->post('/login', 'App\Controllers\Web\UserController:postLogin')->setName('web.post.user.login');

	$app->get('/logout', 'App\Controllers\Web\UserController:logout')->setName('web.user.logout');

	$app->get('/password_reset', 'App\Controllers\Web\UserController:getPasswordReset')->setName('web.user.password.reset');
	$app->post('/password_reset', 'App\Controllers\Web\UserController:postPasswordReset');

	$app->get('/renew_password', 'App\Controllers\Web\UserController:getReNewPassword')->setName('web.user.renew.password');
	$app->post('/renew_password', 'App\Controllers\Web\UserController:postReNewPassword');

	$app->get('/edit_profile', 'App\Controllers\Web\UserController:getEditProfile')->setName('web.user.edit_profile');
	$app->post('/edit_profile', 'App\Controllers\Web\UserController:postEditProfile');
})->add(new \App\Middlewares\Web\AuthWeb($container));



?>