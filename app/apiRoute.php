<?php

$app->group('/api', function() use ($app,$container) {
	$app->post('/register', 'App\Controllers\Api\UserController:register')->setName('api.user.register');

	$app->get('/active', 'App\Controllers\Api\UserController:activeUser')->setName('api.user.active');

	$app->post('/login', 'App\Controllers\Api\UserController:login')->setName('api.user.login');

    $app->post('/password_reset', 'App\Controllers\Api\UserController:passwordReset')->setName('api.user.password.reset');
    $app->get('/renew_password', 'App\Controllers\Api\UserController:getReNewPassword')->setName('api.user.get.renew.password');
    $app->put('/renew_password', 'App\Controllers\Api\UserController:putReNewPassword')->setName('api.user.put.renew.password');

    $app->put('/profile/change_password', 'App\Controllers\Api\UserController:changePassword')->setName('api.user.password.change');

    $app->get('/profile/{id}/edit', 'App\Controllers\Api\UserController:getEditProfile')->setName('api.get.edit.profile.user');
    $app->put('/profile/{id}/edit', 'App\Controllers\Api\UserController:putEditProfile')->setName('api.put.edit.profile.user');

    $app->group('/admin', function() use ($app,$container) {
    	$app->group('/course', function() use ($app,$container) {
            $app->get('/add_admin_course', 'App\Controllers\Api\AdminController:getAddAdminCourse')->setName('api.get.add.admin.course');
            $app->put('/add_admin_course', 'App\Controllers\Api\AdminController:putAddAdminCourse')->setName('api.post.add.admin.course');
        });

		$app->group('/article', function() use($app, $container) {
			$app->get('/all', 'App\Controllers\Api\ArticleController:showAll')->setName('api.get.all.article');

			$app->get('/my_article', 'App\Controllers\Api\ArticleController:showByIdUser')->setName('api.get.my.article');

			$app->get('/trash', 'App\Controllers\Api\ArticleController:showTrashByIdUser')->setName('api.get.trash.article');

            $app->get('/create', 'App\Controllers\Api\ArticleController:getCreate')->setName('api.get.create.article');
			$app->post('/create', 'App\Controllers\Api\ArticleController:create')->setName('api.create.article');

			$app->get('/{slug}/edit', 'App\Controllers\Api\ArticleController:getUpdate')->setName('api.get.update.article');
			$app->put('/{slug}/edit', 'App\Controllers\Api\ArticleController:putUpdate')->setName('api.put.update.article');

			$app->post('/{slug}/soft_delete', 'App\Controllers\Api\ArticleController:softDelete')->setName('api.post.soft.delete.article');

			$app->delete('/{slug}/hard_delete', 'App\Controllers\Api\ArticleController:hardDelete')->setName('api.post.soft.delete.article');
		});
	})->add(new \App\Middlewares\Api\AdminMiddleware($container));

    $app->get('/{username}', 'App\Controllers\Api\UserController:otherAccount')->setName('api.user.other.account');
})->add(new \App\Middlewares\Api\AuthToken($container));
