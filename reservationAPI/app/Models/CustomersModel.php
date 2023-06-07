<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomersModel extends Model
{
    protected $customers;

    public function __construct()
    {
        parent::__construct();
        $this->customers = $this->db->table('customer');
    }

    public function fetchCustomers()
    {
        $query = $this->customers->get()->getResult();
        return $query;
    }

    public function updateCustomers($id, $data)
    {
        $query = $this->customers->where('customer_id', $id)->update($data);
        return $query;
    }
}