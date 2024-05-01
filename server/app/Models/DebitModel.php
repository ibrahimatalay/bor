<?php

namespace App\Models;

use CodeIgniter\Model;

class DebitModel extends Model
{
    public function list()
    {
        $builder = $this->db->table("v_to_e");
        $builder->select("v_to_e.id, v_id, e_id, vehicle.name as v_name, employee.name as e_name");
        $builder->join("vehicle", "vehicle.id = v_to_e.v_id");
        $builder->join("employee", "employee.id = v_to_e.e_id");
        return $builder->get()->getResultArray();
    }

    public function vehicle_list()
    {
        $builder = $this->db->table("vehicle");
        return $builder->get()->getResultArray();
    }

    public function employee_list()
    {
        $builder = $this->db->table("employee");
        return $builder->get()->getResultArray();
    }

    public function checkVehicle($vehicle_id)
    {
        $builder = $this->db->table("v_to_e");
        $builder->where(["v_id" => $vehicle_id]);
        return $builder->countAllResults();
    }

    public function addDebit($vehicle_id, $employee_id)
    {
        $builder = $this->db->table("v_to_e");
        return $builder->insert(["v_id" => $vehicle_id, "e_id" => $employee_id]);
    }

    public function removeDebit($id)
    {
        $builder = $this->db->table("v_to_e");
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function editDebit($id, $e_id)
    {
        $builder = $this->db->table("v_to_e");
        $builder->set("e_id", $e_id);
        $builder->where('id', $id);
        return $builder->update();
    }
}
