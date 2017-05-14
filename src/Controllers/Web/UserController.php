<?php

namespace App\Controllers\Web;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \GuzzleHttp\Exception\BadResponseException as GuzzleException;

class UserController extends \App\Controllers\BaseController
{
    public function getRegister(Request $request, Response $response)
    {
        return $this->view->render($response,'user/register.twig');
    }

    public function postRegister(Request $request, Response $response)
    {
        $req = $request->getParsedBody();

        try {
            $client = $this->testing->request('POST',
                      $this->router->pathFor('api.user.register'),
                      ['json' => $req]);

            $this->flash->addMessage(
                'success','Success registered please check your email'
            );

            $resp = $response->withRedirect($this->router->pathFor(
                   'web.user.register'));
        } catch (GuzzleException $e) {
            $data = json_decode($e->getResponse()->getBody()->getContents(), true);

            $error = $data['data'] ? $data['data'] : $data['message'];

            if (is_array($error)) {
                foreach ($error as $key => $val) {
                    $_SESSION['errors'][$key] = $val;
                }
            } else {
                $errorArr = explode(' ', $error);

                $_SESSION['errors'][lcfirst($errorArr[0])][] = $error;
            }

            $this->flash->addMessage('errors', 'Failed check your data');

            return $response->withRedirect($this->router->pathFor('web.user.register'));
        }
    }

    public function activeUser(Request $request, Response $response)
    {
        $options = [
            'query' => [
                'token' => $request->getQueryParam('token'),
            ]
        ];

        try {
            $activation = $this->testing->request('GET', $this->router->pathFor('api.user.active'), $options);

            if ($activation->getStatusCode() == 200) {
                $this->flash->addMessage('success','success! your account activated');
                return $response->withRedirect(
                    $this->router->pathFor('web.home'));
            } else {
                $this->flash->addMessage('errors','Failed your account is not activated');
                return $response->withRedirect(
                    $this->router->pathFor('web.home'));
            }
        } catch (GuzzleException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);

            $this->flash->addMessage('errors', $error['message']);

            return $response->withRedirect(
                $this->router->pathFor('web.home'));
        }
    }

    public function getLogin (Request $request, Response $response)
    {
        return $this->view->render($response, 'user/login.twig');
    }

    public function postLogin(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        try {
            $login = $this->testing->request('POST', $this->router->pathFor('api.user.login'),['json' => $body]);

            if ($login->getStatusCode() == 200) {
                $_SESSION['login'] = json_decode($login->getBody()->getContents())->data;

                $resp = $response->withRedirect($this->router->pathFor('web.home'));

            } else {
                $this->flash->addMessage('errors', 'Failed to login');

                $resp = $response->withRedirect($this->router->pathFor('web.user.login'));
            }
        } catch (GuzzleException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents())->data;

            $this->flash->addMessage('errors', $error);

            return $response->withRedirect($this->router->pathFor('web.user.login'));
        }
    }

    public function logout(Request $request, Response $response)
    {
        unset($_SESSION['login']);
        return $response->withRedirect($this->router->pathFor('web.home'));
    }

    public function getPasswordReset(Request $request, Response $response)
    {
        return $this->view->render($response, 'user/resetpassword.twig');
    }

    public function postPasswordReset(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        try {
            $reset = $this->testing->request('POST', $this->router->pathFor('api.user.password.reset'), ['json' => $body]);
            
            if ($reset->getStatusCode() == 201) {
                $this->flash->addMessage('success', 'Check your mail for reset password');

                $resp = $response->withRedirect($this->router->pathFor('web.user.password.reset'));
            }
        } catch (GuzzleException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents());

            if ($error->data) {
                $errors = $error->data->email[0];
            } else {
                $errors = $error->message;
            }

            $this->flash->addMessage('errors', $errors);

            $resp = $response->withRedirect($this->router->pathFor('web.user.password.reset'));
        }

        return $resp;
    }

    public function getReNewPassword(Request $request, Response $response)
    {
        $options = [
            'query' => [
                'token' => $request->getQueryParam('token'),
            ]
        ];

        try {
            $reNewPassword = $this->testing->request('GET', $this->router->pathFor('api.user.get.renew.password'), $options);

            if ($reNewPassword->getStatusCode() == 200) {
                $this->view->render($response, 'user/newpassword.twig');
            }
        } catch (GuzzleException $e) {
            throw new \Slim\Exception\NotFoundException($request, $response);
        }
    }

    public function postReNewPassword(Request $request, Response $response)
    {
        $body = $request->getParsedBody();

        try {
            $reNewPassword = $this->testing->request('PUT', $this->router->pathFor('api.user.put.renew.password'), ['json' => $body]);

            if ($reNewPassword->getStatusCode() == 200) {
                $this->flash->addMessage('success', 'Password Has Been Change');

                $resp = $this->response->withRedirect($this->router->pathFor('web.user.login')); 
            }
        } catch (GuzzleException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);

            if (is_array($error['data'])) {
                foreach ($error['data'] as $key => $val) {
                    $_SESSION['errors'][$key] = $val;
                }
            } else {
                $errorArr = explode(' ', $error);

                $_SESSION['errors'][lcfirst($errorArr[0])][] = $error;
            }

            $resp = $this->view->render($response, 'user/newpassword.twig'); 
        }

        return $resp;
    }
}
