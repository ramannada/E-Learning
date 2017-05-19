<?php

$app->group('/api', function() use ($app,$container) {
	$app->post('/register', 'App\Controllers\Api\UserController:register')->setName('api.user.register');

	$app->get('/active', 'App\Controllers\Api\UserController:activeUser')->setName('api.user.active');

	$app->post('/login', 'App\Controllers\Api\UserController:login')->setName('api.user.login');

    $app->post('/password_reset', 'App\Controllers\Api\UserController:passwordReset')->setName('api.user.password.reset');
    $app->get('/renew_password', 'App\Controllers\Api\UserController:getReNewPassword')->setName('api.user.get.renew.password');
    $app->put('/renew_password', 'App\Controllers\Api\UserController:putReNewPassword')->setName('api.user.put.renew.password');

    $app->get('/braintree/token', 'App\Controllers\Api\BrainTreeController:token')->setName('braintree.token');

    $app->get('/profile/premium', 'App\Controllers\Api\UserController:getBuyPremium')->setName('api.user.premium');
    $app->post('/profile/premium', 'App\Controllers\Api\UserController:postBuyPremium')->setName('api.post.user.premium');
	
    $app->put('/profile/change_password', 'App\Controllers\Api\UserController:changePassword')->setName('api.user.password.change');

    $app->get('/profile/{id}/edit', 'App\Controllers\Api\UserController:getEditProfile')->setName('api.get.edit.profile.user');
    $app->post('/profile/{id}/edit', 'App\Controllers\Api\UserController:putEditProfile')->setName('api.put.edit.profile.user');

    $app->get('/{username}', 'App\Controllers\Api\UserController:otherAccount')->setName('api.user.other.account');
    
})->add(new \App\Middlewares\Api\AuthToken($container));
