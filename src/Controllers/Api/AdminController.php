<?php

namespace App\Controllers\Api;

/**
* 
*/
class AdminController extends \App\Controllers\BaseController
{
    public function addAdminCourse(Request $request, Response $response, $args)
    {
        foreach ($request->getParam('user_id') as $key => $value) {
            $user = new \App\Models\Users\UserRole;
            $update = ['role_id' => 2];
            $setRole = $user->update($update, 'user_id', $value);
        }

        $data = $this->responseDetail('Success change role', 200);

        return $data;
    }
}