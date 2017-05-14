<?php 

$app->group('', function() use ($app,$container) {
	$app->get('/active', 'App\Controllers\Web\UserController:activeUser')->setName('web.user.active');
});

?>