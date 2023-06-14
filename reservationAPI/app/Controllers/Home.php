<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\HomeModel;

class Home extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = model(HomeModel::class);
    }

    public function index()
    {
        $result = $this->model->fetchRoom();

        return $this->response->setJSON([
            'success' => true,
            'result' => $result
        ]);
    }

    public function addRoomAndContactInfoController()
    {
        $post = $this->request->getPost(['first_name', 'last_name', 'email', 'phone', 'reserved_date', 'roomID', 'confirm']);

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
            'reserved_date' => date('Y-m-d H:i:s'),
            'room_type_id' => $post['roomID']
        ];

        $result = $this->model->addRoomAndContactInfo($data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Submitted Successfully!'
        ]);
    }
}
