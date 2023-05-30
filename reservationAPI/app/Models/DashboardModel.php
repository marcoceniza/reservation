<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $roomTB;

    public function __construct()
    {
        parent::__construct();
        $this->roomTB = $this->db->table('room_type');
    }

    public function fetchRoom()
    {
        $query = $this->roomTB->get();
        return $query->getResult();
    }

    public function addRoom($data)
    {
        $query = $this->roomTB->insert($data);
        return $query;
    }

    public function updateRoom($id, $data)
    {
        $query = $this->roomTB->where('room_type_id', $id);
        return $query->update($data);
    }

    public function deleteRoom($id)
    {
        $query = $this->roomTB->where('room_type_id', $id);
        return $query->delete();
    }
}