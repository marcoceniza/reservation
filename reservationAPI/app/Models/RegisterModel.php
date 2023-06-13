<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterModel extends Model
{
    protected $userTB;
    protected $profileTB;

    public function __construct()
    {
        parent::__construct();
        $this->userTB = $this->db->table('user');
        $this->profileTB = $this->db->table('profile');
    }

    public function registerUser($data)
    {
        $query = $this->userTB->insert($data);
        return $query;
    }

    public function createProfile($data)
    {
        $query = $this->profileTB->insert($data);
        return $this->db->insertID();
    }

    public function fetchAdmin()
    {
        $query = $this->userTB->join('profile', 'profile.profile_id = user.profile_id')
                              ->get()
                              ->getResult();

        return $query;
    }

    public function updateAdmin($id, $data)
    {
        // $this->userTB->where('user_id', $id)->update($data);
        $query = $this->profileTB->where('user_id', $id)->update($data);
        return $query;
    }
}