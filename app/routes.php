<?php

$app->group('/api', function() use ($app,$container) {
    $app->post('/register', 'App\Controllers\Api\UserController:register')->setName('api.user.register');
	$app->post('/login', 'App\Controllers\Api\UserController:login')->setName('api.user.login');
	$app->get('/active', 'App\Controllers\Api\UserController:activeUser')->setName('api.user.active');

    $app->get('/user/role[/{role_id}]', 'App\Controllers\Api\UserController:getUserByRole')->setName('api.user.role'); // Get user by role
    $app->post('/user/role', 'App\Controllers\Api\UserController:setRoleAdminCourse')->setName('api.users.role');
});

$app->group('', function() use ($app,$container) {
    $app->get('/', 'App\Controllers\Web\HomeController:index')->setName('web.home');

	$app->get('/register', 'App\Controllers\Web\UserController:getRegister')->setName('web.user.register');
    $app->post('/register', 'App\Controllers\Web\UserController:postRegister');

	$app->get('/active', 'App\Controllers\Web\UserController:activeUser')->setName('web.user.active');

	$app->get('/login', 'App\Controllers\Web\UserController:getLogin')->setName('web.user.login');
    $app->get('/logout', 'App\Controllers\Web\UserController:logout')->setName('web.user.logout');
    $app->post('/login', 'App\Controllers\Web\UserController:postLogin')->setName('web.post.user.login');

    $app->get('/reset', 'App\Controllers\Web\UserController:getResetPassword')->setName('web.user.reset');
    $app->post('/reset', 'App\Controllers\Web\UserController:postResetPassword')->setName('web.post.user.reset');

    $app->get('/user/role[/{role_id}]', 'App\Controllers\Web\UserController:getRoleEdit')->setName('web.user.role');

    $app->get('/user/admincourse/add', 'App\Controllers\Web\UserController:getAddAdminCourse')->setName('web.user.get.add.admin');
    $app->post('/user/admincourse/add', 'App\Controllers\Web\UserController:postAddAdminCourse')->setName('web.user.post.add.admin');
});

?>
