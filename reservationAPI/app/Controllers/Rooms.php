<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");

use App\Models\RoomsModel;

class Rooms extends BaseController
{
    public function fetchRoomController()
    {
        $model = model(RoomsModel::class);

        $result = $model->fetchRoom();

        return $this->response->setJSON([
            'success' => true,
            'result' => $result
        ]);
    }
}
