<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\RegisterModel;

class Register extends BaseController
{
    public function registerController()
    {
        $model = new RegisterModel();

        $post = $this->request->getPost(['email', 'password']);

        if(empty($post['email']) || empty($post['password'])) return $this->response->setJSON(['success' => false, 'result' => 'All Fields are Required!']);

        $data = [
            'email' => $post['email'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT),
            'user_type' => 0
        ];

        $result = $model->registerUser($data);

        return $this->response->setJSON(['success' => true, 'result' => 'Register Successfully!']);
    }
}
