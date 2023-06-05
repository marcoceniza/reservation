<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $reserveRoomTB;
    protected $customerDB;

    public function __construct()
    {
        parent::__construct();
        $this->customerDB = $this->db->table('customer');
    }

    public function fetchRoom()
    {
        $query = $this->customerDB->join('room_type', 'room_type.room_type_id = customer.room_type_id')
                                  ->get()
                                  ->getResult();
        return $query;
    }

    public function setCreatedStatus($id, $data)
    {
        $query = $this->customerDB->where('customer_id', $id)->update($data);
        return $query;
    }

    public function addRoom($data)
    {
        $query = $this->reserveRoomTB->insert($data);
        return $query;
    }

    public function updateRoom($id, $data)
    {
        $query = $this->reserveRoomTB->where('room_type_id', $id);
        return $query->update($data);
    }

    public function deleteRoom($id)
    {
        $query = $this->reserveRoomTB->where('room_type_id', $id);
        return $query->delete();
    }
}