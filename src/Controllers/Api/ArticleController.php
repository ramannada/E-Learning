<?php

namespace App\Controllers\Api;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class ArticleController extends \App\Controllers\BaseController
{
	public function createArticle(Request $request, Response $response)
	{
		$post = $request->getParams();

		$token = $request->getHeader('Authorization')[0];

		$userToken = new \App\Models\Users\UserToken;

		$post['user_id'] = $userToken->find('token', $token)->fetch()['user_id'];

		$rule = [
            'required' => [
                ['title'],
                ['content'],
                ['category'],
            ],
            'lengthMin' => [
                ['content', 10],
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $article = new \App\Models\Articles\Article;

            $create = $article->add($post);

            if (!is_int($create)) {
                return $this->responseDetail("Title have already used", 400);
            }

            $categories = $request->getParam('category');
            $category = new \App\Models\Categories\Category;
            $createCategory = $category->add($categories);

            $articleCategory = new \App\Models\Articles\ArticleCategory;
            $articleCategory->add($create, $createCategory);

            return $this->responseDetail("Article Created", 201);
        } else {
            return $this->responseDetail("Error", 400, $this->validator->errors());
        }
	}

    public function getUpdateArticle(Request $request, Response $response, $args)
    {
        $token = $request->getHeader('Authorization')[0];

        $userToken = new \App\Models\Users\UserToken;
        $userId = $userToken->find('token', $token)->fetch()['user_id'];

        $article = new \App\Models\Articles\Article;
        $getArticle = $article->getUpdateArticle($args['slug']);
        
        if ($userId != $getArticle['user_id']) {
            return $this->responseDetail("You have not Authorized to edit this article", 401);
        }

        return $this->responseDetail("Data Available", 200, $getArticle);
    }

    public function putUpdateArticle(Request $request, Response $response, $args)
    {
        $token = $request->getHeader('Authorization')[0];

        $userToken = new \App\Models\Users\UserToken;
        $userId = $userToken->find('token', $token)->fetch()['user_id'];

        $article = new \App\Models\Articles\Article;
        $getArticle = $article->getUpdateArticle($args['slug']);
        
        if ($userId != $getArticle['user_id']) {
            return $this->responseDetail("You have not Authorized to edit this article", 401);
        }

        $post = $request->getParams();

        $rule = [
            'required' => [
                ['title'],
                ['content'],
                ['category'],
            ],
            'lengthMin' => [
                ['content', 10],
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $article = new \App\Models\Articles\Article;
            $update = $article->edit($post, $args['slug']);

            if (!is_array($update)) {
                return $this->responseDetail("Title already used", 400);
            }

            $categories = $request->getParam('category');
            $category = new \App\Models\Categories\Category;
            $updateCategory = $category->add($categories);

            $articleCategory = new \App\Models\Articles\ArticleCategory;
            $articleCategory->edit($update['id'], $updateCategory);

            return $this->responseDetail("Article has updated", 200);
        } else {
            return $this->responseDetail("Error", 400, $this->validator->errors());
        }
    }

}