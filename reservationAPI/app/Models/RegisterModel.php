<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterModel extends Model
{
    protected $userTB;

    public function __construct()
    {
        parent::__construct();
        $this->userTB = $this->db->table('user');
    }

    public function registerUser($data)
    {
        $query = $this->userTB->insert($data);
        return $query;
    }
}