<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $userTB;

    public function __construct()
    {
        parent::__construct();
        $this->userTB = $this->db->table('user');
    }

    public function loginUser($data)
    {
        $query = $this->userTB->where('email', $data)->get();
        return $query;
    }
}