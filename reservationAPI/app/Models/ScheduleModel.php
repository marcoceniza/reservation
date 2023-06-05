<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $schedule;

    public function __construct()
    {
        parent::__construct();
        $this->schedule = $this->db->table('reservation');
    }

    public function fetchSchedule()
    {
        $query = $this->schedule->join('customer', 'customer.customer_id = reservation.customer_id')
                                ->join('room_type', 'room_type.room_type_id = reservation.room_type_id')
                                ->get()
                                ->getResult();

        return $query;
    }

    public function addSchedule($data)
    {
        $query = $this->schedule->insert($data);
        return $query;
    }

    public function updateSchedule($id, $data)
    {
        $query = $this->schedule->where('reservation_id', $id)->update($data);
        return $query;
    }
}