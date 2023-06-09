<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\RegisterModel;

class Register extends BaseController
{
    public function registerController()
    {
        $model = new RegisterModel();

        $post = $this->request->getPost(['email', 'password', 'firstname', 'lastname', 'age', 'phone', 'address']);

        // if(empty($post['email']) || empty($post['password'])) return $this->response->setJSON(['success' => false, 'result' => 'All Fields are Required!']);

        $profileData = [
            'first_name' => $post['firstname'],
            'last_name' => $post['lastname'],
            'age' => $post['age'],
            'phone' => $post['phone'],
            'address' => $post['address']
        ];

        $profileID = $model->createProfile($profileData);

        if($profileID) {
            $userData = [
                'email' => $post['email'],
                'password' => password_hash($post['password'], PASSWORD_DEFAULT),
                'user_type' => 0,
                'profile_id' => $profileID
            ];
    
            $result = $model->registerUser($userData);
    
            if ($result) {
                return $this->response->setJSON(['success' => true, 'result' => 'Registered Successfully!']);
            }
        }

        return $this->response->setJSON(['success' => false, 'result' => 'Registration Failed!']);
    }
}
