<?php

namespace App\Controllers\Api;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class UsersController extends \App\Controllers\BaseController
{
    public function register(Request $request, Response $response)
    {
        $user = new \App\Models\Users\Users($this->db);
        
        $rule = [
            'required' => [
                ['name'],
                ['username'],
                ['email'],
                ['password'],
            ],
            'email' => [
                ['email'],
            ],
            'numeric' => [
                ['phone_number'],
            ],
            'lengthMin' => [
                ['username', 6],
                ['password', 6],
            ],
            'lengthMax' => [
                ['phone_number', 12],
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $addUser = $user->register($request->getParsedBody());
            
            if (is_int($addUser)) {
                $find = $user->find('id', $addUser)->fetch();
                $this->mailer->send('email/register.twig', ['user' => $find], function($message) use ($find) {
                        $message->to($find['email']);
                        $message->subject('Active Your Account');
                });
                $data = $this->responseDetail("Register Success", 201, $find);
            } else {
                $data = $this->responseDetail($addUser . " already used", 400);
            }
        }  else {
            $data = $this->responseDetail("Error", 400, $this->validator->errors());
        }

        return $data;
    }

    public function activeUser(Request $request, Response $response)
    {
        $user = new \App\Models\Users\Users($this->db);

        $token = $request->getQueryParam('token');
        
        $findUser = $user->find('active_token', $token)->fetch();

        if ($findUser) {
            $update = ['is_active' => 1,];

            $user->update($update, 'id', $findUser['id']);

            $data = $this->responseDetail("Verification Success", 200);
        } else {
            $data = $this->responseDetail("Data Not Found", 404);
        }

        return $data;
    }

    public function login(Request $request, Response $response)
    {
        $user = new \App\Models\Users\Users($this->db);

        $login = $user->find('username', $request->getParsedBody()['username'])->fetch();

        if (empty($login)) {
            $data = $this->responseDetail("Error", 401, "Username Not Registered");
        } else {
            $check = password_verify($request->getParsedBody()['password'], $login['password']);

            if ($check) {
                $token = new \App\Models\Users\UserToken($this->db);

                $getToken = $token->setToken($login['id']);

                $key = [
                    'meta' => $getToken,
                ];

                $data = $this->responseDetail("Login Success", 200, $login, $key);
            } else {
                $data = $this->responseDetail("Error", 401, "Wrong Password");
            }
        }

        return $data;
    }
}

?>