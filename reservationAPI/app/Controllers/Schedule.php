<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\ScheduleModel;

class Schedule extends BaseController
{
    public function fetchScheduleController()
    {
        $model = model(ScheduleModel::class);

        $result = $model->fetchSchedule();

        return $this->response->setJSON([
            'success' => true,
            'result' => $result
        ]);
    }

    public function addScheduleController()
    {
        $model = new ScheduleModel();

        $post = $this->request->getPost(['startDate', 'endDate', 'customerID', 'roomID']);
    
        $data = [
            'start_date' => $post['startDate'],
            'end_date' => $post['endDate'],
            'customer_id' => $post['customerID'],
            'room_type_id' => $post['roomID']
        ];
    
        $result = $model->addSchedule($data);
    
        return $this->response->setJSON([
            'success' => true,
            'result' => 'Created Successfully! Reloading...'
        ]);
    }
}
