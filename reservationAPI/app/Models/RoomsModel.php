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
        $query = $this->roomTB->get()->getResult();
        return $query;
    }
}