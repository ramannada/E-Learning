<?php

$app->group('/api', function() use ($app,$container) {
	$app->post('/register', 'App\Controllers\Api\UserController:register');
	$app->get('/active', 'App\Controllers\Api\UserController:activeUser')->setName('api.user.active');
	$app->post('/login', 'App\Controllers\Api\UserController:login');

	$app->group('/admin', function() use ($app,$container) {
		$app->group('/article', function() use($app, $container) {
			$app->get('/all', 'App\Controllers\Api\ArticleController:showAll')->setName('api.get.all.article');
			$app->get('/my_article', 'App\Controllers\Api\ArticleController:showByIdUser')->setName('api.get.my.article');
			$app->get('/article/trash', 'App\Controllers\Api\ArticleController:showTrashByIdUser')->setName('api.get.trash.article');
			$app->post('/create', 'App\Controllers\Api\ArticleController:create')->setName('api.create.article');
			$app->get('/{slug}/edit', 'App\Controllers\Api\ArticleController:getUpdate')->setName('api.get.update.article');
			$app->put('/{slug}/edit', 'App\Controllers\Api\ArticleController:putUpdate')->setName('api.put.update.article');
			$app->post('/{slug}/soft_delete', 'App\Controllers\Api\ArticleController:softDelete')->setName('api.post.soft.delete.article');
			$app->post('/{slug}/hard_delete', 'App\Controllers\Api\ArticleController:hardDelete')->setName('api.post.soft.delete.article');
		});
		
	});
})->add(new \App\Middlewares\Api\AuthToken($container));
$app->group('', function() use ($app,$container) {
	$app->get('/active', 'App\Controllers\Web\UserController:activeUser')->setName('web.user.active');
});

?>