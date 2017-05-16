<?php

$app->group('/api', function() use ($app,$container) {
	$app->post('/register', 'App\Controllers\Api\UserController:register');

	$app->get('/active', 'App\Controllers\Api\UserController:activeUser')->setName('api.user.active');

	$app->post('/login', 'App\Controllers\Api\UserController:login');

    $app->post('/password_reset', 'App\Controllers\Api\UserController:passwordReset')->setName('api.user.password.reset');
    $app->get('/renew_password', 'App\Controllers\Api\UserController:getReNewPassword')->setName('api.user.get.renew.password');
    $app->put('/renew_password', 'App\Controllers\Api\UserController:putReNewPassword')->setName('api.user.put.renew.password');
	
    $app->get('/profile/{id}/edit', 'App\Controllers\Api\UserController:getEditProfile')->setName('api.get.edit.profile.user');
    $app->put('/profile/{id}/edit', 'App\Controllers\Api\UserController:putEditProfile')->setName('api.put.edit.profile.user');

    $app->put('/change_password', 'App\Controllers\Api\UserController:changePassword')->setName('api.user.password.change');

    $app->group('/admin', function() use ($app,$container) {
        $app->group('/course', function() use ($app,$container) {
            $app->get('/add_admin_course', 'App\Controllers\Api\AdminController:getAddAdminCourse')->setName('api.get.add.admin.course');
            $app->put('/add_admin_course', 'App\Controllers\Api\AdminController:putAddAdminCourse')->setName('api.post.add.admin.course');
        });
    })->add(new \App\Middlewares\Api\AdminMiddleware($container));
    
})->add(new \App\Middlewares\Api\AuthToken($container));
