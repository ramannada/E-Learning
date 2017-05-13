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

    public function joinUserAndRole()
    {
        $qb = $this->getBuilder();
        $result = $qb->select('u.name, u.username, u.email')
            ->from($this->table, 'u')
            ->join('u', 'user_role', 'ur', 'u.id=ur.user_id')
            ->where('role_id', 3)
            ->execute();

        return $result->fetchAll();
    }
}

?>