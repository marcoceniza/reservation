<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\RegisterModel;

class Register extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = model(RegisterModel::class);
    }

    public function registerController()
    {
        $post = $this->request->getPost(['email', 'password', 'firstname', 'lastname', 'age', 'phone', 'address']);

        if(empty($post['firstname']) || empty($post['lastname']) || empty($post['age']) || empty($post['phone']) || empty($post['address']) || empty($post['email']) || empty($post['password'])) {
            return $this->response->setJSON([
                'success' => false,
                'result' => 'All Fields are Required!'
            ]);
        }

        $profileData = [
            'first_name' => $post['firstname'],
            'last_name' => $post['lastname'],
            'age' => $post['age'],
            'phone' => $post['phone'],
            'address' => $post['address']
        ];

        $profileID = $this->model->createProfile($profileData);

        if($profileID) {
            $userData = [
                'email' => $post['email'],
                'password' => password_hash($post['password'], PASSWORD_DEFAULT),
                'user_type' => 0,
                'profile_id' => $profileID
            ];
    
            $result = $this->model->registerUser($userData);
    
            if ($result) {
                return $this->response->setJSON(['success' => true, 'result' => 'Registered Successfully!']);
            }
        }

        return $this->response->setJSON(['success' => false, 'result' => 'Registration Failed!']);
    }

    public function fetchAdminController()
    {
        $result = $this->model->fetchAdmin();

        return $this->response->setJSON([
            'success' => true,
            'result' => $result
        ]);
    }

    public function updateAdminController()
    {
        $post = $this->request->getPost(['userID', 'firstname', 'lastname', 'age', 'phone', 'address', 'email', 'password']);

        if(empty($post['firstname']) || empty($post['lastname']) || empty($post['age']) || empty($post['phone']) || empty($post['address']) || empty($post['email']) || empty($post['password'])) {
            return $this->response->setJSON([
                'success' => false,
                'result' => 'All Fields are Required!'
            ]);
        }

        $userData = [
            'email' => $post['email'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT)
        ];

        $profileData = [
            'first_name' => $post['firstname'],
            'last_name' => $post['lastname'],
            'age' => $post['age'],
            'phone' => $post['phone'],
            'address' => $post['address']
        ];

        $result = $this->model->updateAdmin($post['userID'], $userData, $profileData);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Updated Successfully.',
            'data' => $result
        ]);
    }
}
