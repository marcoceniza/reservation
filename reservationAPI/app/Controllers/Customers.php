<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\CustomersModel;

class Customers extends BaseController
{
    public function fetchCustomersController()
    {
        try {

            $model = new CustomersModel();

            $result = $model->fetchCustomers();
    
            return $this->response->setJSON([
                'success' => true,
                'result' => $result
            ]);

        } catch (\Exception $error) {
            return $this->response->setJSON(['success' => false, 'result' => $error->getMessage()]);
        }
    }

    public function updateCustomersController()
    {
        try {
            
            $model = new CustomersModel();

            $post = $this->request->getPost(['customerID', 'firstname', 'lastname', 'email', 'phone']);

            if(empty($post['firstname']) || empty($post['lastname'])  || empty($post['email'])  || empty($post['phone'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'result' => 'All Fields are Required!'
                ]);
            }

            $data = [
                'first_name' => $post['firstname'],
                'last_name' => $post['lastname'],
                'email' => $post['email'],
                'phone' => $post['phone']
            ];

            $result = $model->updateCustomers($post['customerID'], $data);

            return $this->response->setJSON([
                'success' => true,
                'result' => 'Updated Successfully! Reloading...'
            ]);

        } catch (\Exception $error) {
            return $this->response->setJSON(['success' => false, 'result' => $error->getMessage()]);
        }
    }
}
