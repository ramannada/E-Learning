<?php

$app->group('/api', function() use ($app,$container) {
	$app->post('/register', 'App\Controllers\Api\UserController:register');
	$app->get('/active', 'App\Controllers\Api\UserController:activeUser')->setName('api.user.active');
	$app->post('/login', 'App\Controllers\Api\UserController:login');

	$app->group('/admin', function() use ($app,$container) {
		$app->post('/create_article', 'App\Controllers\Api\ArticleController:createArticle')->setName('api.create.article');
		$app->get('/article/{slug}/edit', 'App\Controllers\Api\ArticleController:getUpdateArticle')->setName('api.get.update.article');
		$app->put('/article/{slug}/edit', 'App\Controllers\Api\ArticleController:putUpdateArticle')->setName('api.put.update.article');
	});
});

$app->group('', function() use ($app,$container) {
	$app->get('/register', 'App\Controllers\Web\UserController:getRegister')->setName('web.user.register');
    $app->post('/register', 'App\Controllers\Web\UserController:postRegister');
	$app->get('/active', 'App\Controllers\Web\UserController:activeUser')->setName('web.user.active');
	$app->get('/login', 'App\Controllers\Web\UserController:getLogin')->setName('web.user.login');
    $app->post('/login', 'App\Controllers\Web\UserController:postLogin')->setName('web.post.user.login');
});

?>