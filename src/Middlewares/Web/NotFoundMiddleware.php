<?php 

namespace App\Middlewares\Web;

use App\Middlewares\BaseMiddleware;

class NotFoundMiddleware extends BaseMiddleware
{
	public function __invoke($request, $response, $next)
	{
		$response = $next($request, $response);

		if (404 === $response->getStatusCode() && 0 === $response->getBody()->getSize()) {
			$handler = $this->get('notFoundHandler');
			
			return $handler($request, $response);
		}
		
		return $response;
	}
}