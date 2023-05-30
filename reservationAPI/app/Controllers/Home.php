<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\HomeModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new HomeModel();

        $result = $model->fetchRoom();

        return $this->response->setJSON([
            'success' => true,
            'result' => $result
        ]);
    }

    public function addRoomAndContactInfoController()
    {
        $model = new HomeModel();

        $post = $this->request->getPost(['first_name', 'last_name', 'email', 'phone', 'roomID', 'confirm']);

        if(empty($post['first_name']) || empty($post['last_name']) || empty($post['email']) || empty($post['phone']) || empty($post['confirm'])) {
            return $this->response->setJSON([
                'success' => false,
                'result' => 'All Fields are Required!'
            ]);
        }

        $data = [
            'first_name' => $post['first_name'],
            'last_name' => $post['last_name'],
            'email' => $post['email'],
            'phone' => $post['phone'],
            'room_type_id' => $post['roomID']
        ];

        $result = $model->addRoomAndContactInfo($data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Added Successfully! Reloading...'
        ]);
    }
}
