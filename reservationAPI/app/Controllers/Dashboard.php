<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    public function fetchRoomController()
    {
        $model = model(DashboardModel::class);

        $result = $model->fetchRoom();

        return $this->response->setJSON([
            'success' => true,
            'result' => $result
        ]);
    }

    public function addRoomController()
    {
        $model = new DashboardModel();

        $post = $this->request->getPost(['name', 'capacity', 'price', 'category', 'location']);
        $file = $this->request->getFile('photo');

        if(empty($post['name']) || empty($post['capacity']) || empty($post['price']) || empty($file)) {
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
                'photo' => $newName,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        $result = $model->addRoom($data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Reserve Successfully! Reloading...'
        ]);
    }

    public function setCreatedStatusController() 
    {
        $model = new DashboardModel();

        $post = $this->request->getPost();

        $data = [
            'created_status' => $post['status']
        ];

        $result = $model->setCreatedStatus($post['customerID'], $data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Update Created Status Successfully'
        ]);
    }

    public function updateRoomController()
    {
        $model = new DashboardModel();

        $post = $this->request->getPost(['name', 'capacity', 'price', 'category', 'location']);
        $id = $this->request->getPost('roomID');
        $file = $this->request->getFile('photo');

        if(empty($post['name']) || empty($post['capacity']) || empty($post['price']) || empty($post['location'])) {
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
                    'photo' => $newName,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }else {
            $data = [
                'name' => $post['name'],
                'capacity' => $post['capacity'],
                'price' => $post['price'],
                'category' => $post['category'],
                'location' => $post['location'],
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        $result = $model->updateRoom($id, $data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Updated Successfully! Reloading...'
        ]);
    }

    public function deleteRoomController()
    {
        $model = new DashboardModel();

        $post = $this->request->getPost(['roomID']);

        $data = [
            'room_type_id' => $post['roomID']
        ];

        $result = $model->deleteRoom($data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Deleted Successfully! Reloading...'
        ]);
    }
}
