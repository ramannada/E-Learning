<?php

namespace App\Middlewares\Web;

class AuthWeb extends \App\Middlewares\BaseMiddleware
{
	public function __invoke($request, $response, $next)
	{
		$whiteList = ['/', 'register', 'login', 'active', 'logout'];

		if (!in_array($request->getUri()->getPath(), $whiteList)) {
			if (!isset($_SESSION['login'])) {
				//store current page
				$_SESSION['url'] = (string) $request->getUri();

				$this->flash->addMessage('errors', 'You must Login to access that page');

				return $response->withRedirect($this->container->router->pathFor('web.user.login'));
			} elseif ($_SESSION['login']['data']['is_active'] == 0) {
				$this->flash->addMessage('errors', 'You must Activate Your Account');

				return $response->withRedirect($this->container->router->pathFor('web.user.login'));
			}
		}

		$response = $next($request, $response);

		unset($_SESSION['url']);

		return $response;
	}
}
