<?php

use Slim\Container;
use Slim\Views\Twig as View;
use Slim\Views\TwigExtension as ViewExt;
use RandomLib\Factory as Random;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$container = $app->getContainer();

$container['db'] = function (Container $container) {
	$setting = $container->get('settings');

	$config = new \Doctrine\DBAL\Configuration();

	$connect = \Doctrine\DBAL\DriverManager::getConnection($setting['db'],
		$config);

	return $connect;
};

$container['validator'] = function (Container $container) {
	$setting = $container->get('settings')['lang']['default'];
	$params = $container['request']->getParams();

	return new \Valitron\Validator($params, [], $setting);
};

$container['view'] = function (Container $container) {
	$setting = $container->get('settings')['view'];

	$view = new View($setting['path'], $setting['twig']);
	$view->addExtension(new ViewExt($container->router, $container->request->getUri()));

	$view->getEnvironment()->addGlobal('flash', $container->flash);

	$view->getEnvironment()->addGlobal('baseUrl', 'http://localhost:8080');

	return $view;
};

$container['flash'] = function (Container $container) {
	return new \Slim\Flash\Messages;
};

$container['csrf'] = function (Container $container) {
	return new \Slim\Csrf\Guard;
};

$container['mailer'] = function (Container $container) {
	$setting = $container->get('settings')['mailer'];

	$mailer = new \PHPMailer;
	$mailer->isSMTP();
	$mailer->Host = $setting['host'];
	$mailer->SMTPAuth = $setting['smtp_auth'];
	$mailer->SMTPSecure = $setting['smtp_secure'];
	$mailer->Port = $setting['port'];
	$mailer->Username = $setting['username'];
	$mailer->Password = $setting['password'];

	$mailer->setFrom($setting['username'], $setting['name']);


	return new \App\Extensions\Mailers\Mailer($container['view'], $mailer);
};

$container['random'] = function (Container $container) {
	$random = new Random;
	return $random->getMediumStrengthGenerator();
};

$container['testing'] = function (Container $container) {
	return new Client(['base_uri' => 'http://localhost:8080/public/', 'headers' => ['Content-type' => 'application/json']]);
};