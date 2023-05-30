<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\LoginModel;

class Login extends BaseController
{
    public function loginController()
    {
        $model = new LoginModel();

        $post = $this->request->getPost(['email', 'password']);

        if(empty($post['email']) || empty($post['password'])) return $this->response->setJSON(['result' => 'All Fields are Required!']);

        $query = $model->loginUser($post['email']);

        $user = $query->getRow();

        if($query->getNumRows() === 0) return $this->response->setJSON(['result' => 'Email does not exist!']);

        // if(!password_verify($post['password'], $user->password)) return $this->response->setJSON(['result' => 'Incorrect Password!']);

        $token = bin2hex(random_bytes(16));

        return $this->response->setJSON([
            'success' => true,
            'user' => $user,
            'token' => $token,
            'result' => 'Successfully Login. Redirecting...'
        ]);
    }
}
