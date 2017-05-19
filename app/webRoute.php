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

	$app->get('/profile', 'App\Controllers\Web\UserController:myAccount')->setName('web.user.my.account');

	$app->get('/profile/edit', 'App\Controllers\Web\UserController:getEditProfile')->setName('web.user.edit_profile');
	$app->post('/profile/edit', 'App\Controllers\Web\UserController:postEditProfile');

	$app->get('/profile/change_password', 'App\Controllers\Web\UserController:getChangePassword')->setName('web.user.change.password');
	$app->post('/profile/change_password', 'App\Controllers\Web\UserController:postChangePassword');

    $app->group('/admin', function() use ($app,$container) {
    	$app->group('/course', function() use ($app,$container) {
            $app->get('/add_admin_course', 'App\Controllers\Web\AdminController:getAddAdminCourse')->setName('web.get.add.admin.course');
            $app->put('/add_admin_course', 'App\Controllers\Web\AdminController:putAddAdminCourse')->setName('web.post.add.admin.course');
        });

		$app->group('/article', function() use($app, $container) {
			$app->get('/all', 'App\Controllers\Web\ArticleController:showAll')->setName('web.get.all.article');

			$app->get('/my_article', 'App\Controllers\Web\ArticleController:getArticleByUserId')->setName('web.get.my.article');

			$app->get('/trash', 'App\Controllers\Web\ArticleController:showTrashByIdUser')->setName('web.get.trash.article');

            $app->get('/create', 'App\Controllers\Web\ArticleController:getCreate')->setName('web.get.create.article');
			$app->post('/create', 'App\Controllers\Web\ArticleController:postCreate')->setName('web.post.create.article');

			$app->get('/{slug}/edit', 'App\Controllers\Web\ArticleController:getUpdate')->setName('web.get.update.article');
			$app->put('/{slug}/edit', 'App\Controllers\Web\ArticleController:putUpdate')->setName('web.put.update.article');

			$app->post('/{slug}/soft_delete', 'App\Controllers\Web\ArticleController:softDelete')->setName('web.post.soft.delete.article');

			$app->delete('/{slug}/hard_delete', 'App\Controllers\Web\ArticleController:hardDelete')->setName('web.post.soft.delete.article');
		});
	});

	$app->get('/{username}', 'App\Controllers\Web\UserController:otherAccount')->setName('web.user.other.account');

})->add(new \App\Middlewares\Web\AuthWeb($container));
?>
