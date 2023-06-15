<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = model(DashboardModel::class);
    }

    public function fetchCustomerReserveController()
    {
        $result = $this->model->fetchRoom();

        return $this->response->setJSON([
            'success' => true,
            'result' => $result
        ]);
    }

    public function addCustomerReserveController()
    {
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

        $result = $this->model->addRoom($data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Reserved Successfully!'
        ]);
    }

    public function setCreatedStatusController() 
    {
        $post = $this->request->getPost(['customerID', 'status']);

        $data = [
            'created_status' => $post['status']
        ];

        $result = $this->model->setCreatedStatus($post['customerID'], $data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Update Created Status Successfully'
        ]);
    }

    public function updateCustomerReserveController()
    {
        $post = $this->request->getPost(['roomID', 'name', 'capacity', 'price', 'category', 'location']);
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

        $result = $this->model->updateRoom($post['roomID'], $data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Updated Successfully!'
        ]);
    }

    public function deleteCustomerReserveController()
    {
        $post = $this->request->getPost(['customerID']);

        $data = [
            'customer_id' => $post['customerID']
        ];

        $result = $this->model->deleteRoom($data);

        return $this->response->setJSON([
            'success' => true,
            'result' => 'Deleted Successfully!'
        ]);
    }
}
