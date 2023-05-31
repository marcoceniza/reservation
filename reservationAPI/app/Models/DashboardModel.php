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
        $query = $this->roomTB->join('customer', 'customer.room_type_id = room_type.room_type_id')
                              ->get()
                              ->getResult();
        return $query;
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