<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    public function checkUser($username, $password)
    {
        $builder = $this->db->table("user");
        $builder->select("id");
        $builder->where(["username" => $username, "password" => md5($password)]);
        return $builder->get()->getResultArray();
    }
}
