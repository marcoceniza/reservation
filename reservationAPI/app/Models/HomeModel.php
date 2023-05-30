<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $roomTB;
    protected $customerTB;

    public function __construct()
    {
        parent::__construct();
        $this->roomTB = $this->db->table('room_type');
        $this->customerTB = $this->db->table('customer');
    }

    public function fetchRoom()
    {
        $query = $this->roomTB->get();
        return $query->getResult();
    }

    public function addRoomAndContactInfo($data)
    {
        $query = $this->customerTB->insert($data);
        return $query;
    }
}