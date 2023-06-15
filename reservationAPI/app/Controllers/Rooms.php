<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\RoomsModel;

class Rooms extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = model(RoomsModel::class);
    }

    public function fetchRoomController()
    {
        $result = $this->model->fetchRoom();

        return $this->response->setJSON([
            'success' => true,
            'result' => $result
        ]);
    }

    public function addRoomController()
    {
        $post = $this->request->getPost(['name', 'capacity', 'price', 'category', 'location']);
        $file = $this->request->getFile('photo');

        if(empty($post['name']) || empty($post['capacity']) || empty($post['price'])  || $post['category'] === ''  || empty($post['location']) || empty($file)) {
            return $this->response->setJSON([
                'success' => false,
                'result' => 'All Fields are Required!'
            ]);
        }

        if($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $newName);
            
            $data = [
                'name' => $post['name'],
                'capacity' => $post['capacity'],
                'price' => $post['price'],
                'category' => $post['category'],
                'location' => $post['location'],
                'created_at' => date('Y-m-d H:i:s'),
                'photo' => $newName
            ];
        }

        $result = $this->model->addRoom($data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Added Room Successfully!',
            'data' => $result
        ]);
    }

    public function updateRoomController()
    {
        $post = $this->request->getPost(['roomID', 'name', 'capacity', 'price', 'category', 'location']);
        $file = $this->request->getFile('photo');

        if(empty($post['name']) || empty($post['capacity']) || empty($post['price'])  || $post['category'] === ''  || empty($post['location'])) {
            return $this->response->setJSON([
                'success' => false,
                'result' => 'All Fields are Required!'
            ]);
        }

        if(!empty($file)) {
            if($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/uploads', $newName);
                
                $data = [
                    'name' => $post['name'],
                    'capacity' => $post['capacity'],
                    'price' => $post['price'],
                    'category' => $post['category'],
                    'location' => $post['location'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'photo' => $newName
                ];
            }
        }else {
            $data = [
                'name' => $post['name'],
                'capacity' => $post['capacity'],
                'price' => $post['price'],
                'category' => $post['category'],
                'location' => $post['location'],
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        $result = $this->model->updateRoom($post['roomID'], $data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Updated Successfully!'
        ]);
    }

    public function deleteRoomController()
    {
        $post = $this->request->getPost(['roomID']);

        $data = [
            'room_type_id' => $post['roomID']
        ];

        $result = $this->model->deleteRoom($data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Deleted Successfully!'
        ]);
    }
}
