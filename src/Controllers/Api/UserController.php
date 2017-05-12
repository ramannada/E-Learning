<?php

namespace App\Controllers\Api;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class UserController extends \App\Controllers\BaseController
{
    public function register(Request $request, Response $response)
    {
        $user = new \App\Models\Users\User;

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
            'lengthMin' => [
                ['username', 6],
                ['password', 6],
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $addUser = $user->register($request->getParsedBody());

            if (is_int($addUser)) {
                $find = $user->find('id', $addUser)->fetch();

                $role = new \App\Models\Users\UserRole;
                $role->createRole($find['id']);

                $this->mailer->send('templates/mailer/register.twig', ['user' => $find], function($message) use ($find) {
                        $message->to($find['email']);
                        $message->subject('Active Your Account');
                });
                return $this->responseDetail("Register Success", 201, $find);
            } else {
                return $this->responseDetail($addUser . " already used", 400);
            }
        }  else {
            return $this->responseDetail("Error", 400, $this->validator->errors());
        }
    }

    public function activeUser(Request $request, Response $response)
    {
        $user = new \App\Models\Users\User;

        $token = $request->getQueryParam('token');

        $findUser = $user->find('active_token', $token)->fetch();

        if ($findUser && $findUser['is_active'] == 0) {
            $update = ['is_active' => 1,];

            $user->update($update, 'id', $findUser['id']);

            return $this->responseDetail("Verification Success", 200);
        } elseif ($findUser && $findUser['is_active'] == 1) {
            return $this->responseDetail("You account is verified", 400);
        } else {
            return $this->responseDetail("Data Not Found", 404);
        }
    }

    public function login(Request $request, Response $response)
    {
        $user = new \App\Models\Users\User;

        $login = $user->find('username', $request->getParsedBody()['username'])->fetch();

        if (empty($login)) {
            $data = $this->responseDetail("Error", 401, "Username Not Registered");
        } else {
            $check = password_verify($request->getParsedBody()['password'], $login['password']);

            if ($check) {
                $token = new \App\Models\Users\UserToken;

                $getToken = $token->setToken($login['id']);

                if (is_int($getToken)) {
                    $getToken = $token->find('id', $getToken);
                }

                $role = new \App\Models\Users\UserRole;
                $findRole = $role->find('user_id', $getToken['user_id'])->fetch();

                $key = [
                    'token' => $getToken,
                    'role'  => $findRole['role_id'],
                ];

                return $this->responseDetail("Login Success", 200, $login, $key);
            } else {
                return $this->responseDetail("Error", 401, "Wrong Password");
            }
        }
    }

    public function passwordReset(Request $request, Response $response)
    {
        $user = new \App\Models\Users\User;

        $rule = [
            'required' => [
                ['email'],
            ],
            'email' => [
                ['email'],
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $find = $user->find('email', $request->getParam('email'))->fetch();

            if (!$find) {
                $data = $this->responseDetail("Email not registered", 400);
            } else {
                $passwordReset = new \App\Models\Users\PasswordReset;
                $setToken = $passwordReset->setToken($find['id']);

                if (is_int($setToken)) {
                    $findToken = $passwordReset->find('id', $setToken)->fetch();
                } else {
                    $findToken = $setToken;
                }

                $this->mailer->send('templates/mailer/password_reset.twig', ['token' => $findToken], function($message) use ($find) {
                        $message->to($find['email']);
                        $message->subject('Reset your password');
                });

                return $this->responseDetail("Check your email for reset password", 201);
            }
        } else {
            return $this->responseDetail("Error", 400, $this->validator->errors());
        }
    }

    public function getReNewPassword(Request $request, Response $response)
    {
        $pass = new \App\Models\Users\PasswordReset;

        $token = $request->getQueryParam('token');

        $find = $pass->find('token', $token)->fetch();

        if ($find) {
            return $this->responseDetail("Success Get Token", 200);
        } else {
            return $this->responseDetail("Data Not Found", 404);
        }
    }

    public function postReNewPassword(Request $request, Response $response)
    {
        $user = new \App\Models\Users\User;

        $rule = [
            'required' => [
                ['password'],
                ['retype_password'],
            ],
            'lengthMin' => [
                ['password', 6],
                ['retype_password', 6],
            ],
            'equals' => [
                ['retype_password', 'password']
            ],
        ];

        $this->validator->rules($rule);

        if ($this->validator->validate()) {
            $passwordToken = new \App\Models\Users\PasswordReset;

            $token = $request->getQueryParam('token');

            $findUserId = $passwordToken->find('token', $token)->fetch();
            
            $req = $request->getParsedBody();
            
            $updatePassword = $user->resetPassword($req, 'id', $findUserId['user_id']);

            $passwordToken->hardDelete('token', $token);

            return $this->responseDetail('Success Update Password', 200);
        } else {
            return $this->responseDetail('Error', 400, $this->validator->errors());
        }
    }
}

?>
