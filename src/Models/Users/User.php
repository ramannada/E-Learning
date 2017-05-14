<?php

namespace App\Models\Users;

class User extends \App\Models\BaseModel
{
    protected $table = 'users';
    protected $column = ['id', 'name', 'username', 'email', 'password', 'phone', 'active_token', 'is_active'];
    protected $check = ['username', 'email'];

    public function register(array $data)
    {
        $data = [
            'name'          =>  $data['name'],
            'username'      =>  $data['username'],
            'email'         =>  $data['email'],
            'password'      =>  password_hash($data['password'], PASSWORD_DEFAULT),
            'phone'         =>  $data['phone'],
            'active_token'  =>  md5(openssl_random_pseudo_bytes(12)),
        ];

        return $this->checkOrCreate($data);
    }

    public function resetPassword(array $data, $column, $value)
    {
        $data = [
            'password' => password_hash($data['password_hash'], PASSWORD_DEFAULT),
        ];

        return $this->updateOrCreate($data, $column, $value);
    }
}

?>