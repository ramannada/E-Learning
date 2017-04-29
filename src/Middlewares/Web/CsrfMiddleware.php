<?php 

namespace App\Middlewares\Web;

use App\Middlewares\BaseMiddleware

class CsrfMiddleware extends BaseMiddleware
{
	public function __invoke($request, $response, $next)
	{

		$this->view->getEnvironment()->addGlobal('csrf', [
			'field'	=> '
				<input type="hidden" name="'. $this->container->csrf->getTokenNameKey() .'" value="'. $this->container->csrf->getTokenName() .'">
				<input type="hidden" name="'. $this->container->csrf->getTokenValueKey() .'" value="'. $this->container->csrf->getTokenValue() .'">
				',
			]);
		
		$response = $next($request, $response);
		return $response;
	}
}