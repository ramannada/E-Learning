<?php
namespace App\Controllers\Web;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \GuzzleHttp\Exception\BadResponseException as GuzzleException;

class ArticleController extends \App\Controllers\BaseController
{
    public function getCreate(Request $request, Response $response)
    {
        $client = $this->testing->request('GET',
                  $this->router->pathFor('api.get.create.article'));
        $content = json_decode($client->getBody()->getContents(),true);
        if ($content['data']) {
            return $this->view->render($response, 'articles/add_article.twig',
            ['category' => $content['data']]);
        } else {
            return $this->view->render($response, 'articles/add_article.twig');
        }
    }
    public function postCreate(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        $client = $this->testing->request('POST',
                  $this->router->pathFor('api.create.article'),['json' => $body]);

        // try {
        //
        //
            if ($client->getStatusCode() == 201) {
                // return $response->withRedirect($this->router->pathFor('web.list.article'));
                echo "sukses";
            }
        //
        // } catch (Exception $e) {
        //     $error = json_decode($e->getResponse()->getBody()->getContents())->data;
        //
        //     $this->flash->addMessage('errors', $error);
        //
        //     return $response->withRedirect($this->router->pathFor('web.get.create.article'));
        // }

    }
    public function getArticleByUserId(Request $request, Response $response)
    {
        $article = $this->testing->request('GET',
                    $this->router->pathFor('api.get.my.article'));
        $article = json_decode($article->getBody()->getContents(), true);

        return $this->view->render($response, 'articles/list_article.twig',
                ["article" => $article['data']['data']]);
    }

    public function getUpdate(Request $request, Response $response, $args)
    {
        $article = $this->testing->request('GET',
                    $this->router->pathFor('api.get.update.article',['slug' =>  $args['slug']]));
        $article = json_decode($article->getBody()->getContents(), true);

        return $this->view->render($response, 'articles/edit_article.twig',
                ["article" => $article['data']]);

    }

}
