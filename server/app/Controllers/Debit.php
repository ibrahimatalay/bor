<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Debit extends BaseController
{
    protected $debitModel;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        helper("response");
        if ($this->request->header("Authorization") == NULL) return response_with(401, ["error" => "Giriş yapınız"]);
        $auth = explode(" ", $this->request->header("Authorization")->getValue());
        if (!isset($auth[1])) return response_with(401, ["error" => "Giriş yapınız"]);
        helper("jwt");
        $decoded = jwt_decode($auth[1]);
        if (!is_object($decoded)) return response_with(401, ["error" => "Giriş yapınız"]);

        $this->debitModel = model("debitModel");
    }

    public function list()
    {
        return response_with(200, ["list" => $this->debitModel->list()]);
    }

    public function vehicle_and_employee_list()
    {
        return response_with(200, [
            "vehicle_list" => $this->debitModel->vehicle_list(),
            "employee_list" => $this->debitModel->employee_list()
        ]);
    }

    public function add_debit()
    {
        $post_data = $this->request->getPost();

        if (!isset($post_data["vehicle_id"]) || !is_numeric($post_data["vehicle_id"]) || !$post_data["vehicle_id"] > 0) return response_with(400, ["error" => "Araç seçiniz"]);
        if (!isset($post_data["employee_id"]) || !is_numeric($post_data["employee_id"]) || !$post_data["employee_id"] > 0) return response_with(400, ["error" => "Personel seçiniz"]);

        $checkVehicle = $this->debitModel->checkVehicle($post_data["vehicle_id"]);
        if ($checkVehicle > 0) return response_with(400, ["error" => "Araç daha önce zimmetlenmiş"]);

        $addDebit = $this->debitModel->addDebit($post_data["vehicle_id"], $post_data["employee_id"]);
        if ($addDebit) return response_with(200, ["success" => true]);

        return response_with(500, ["error" => "Hata"]);
    }

    public function remove_debit($id)
    {
        if ($this->debitModel->removeDebit($id)) return response_with(200, ["success" => true]);

        return response_with(500, ["error" => "Hata"]);
    }

    public function edit_debit($id)
    {
        if (is_numeric($id) && $id > 0) {
            $employee_id = $this->request->getRawInputVar("employee_id");
            if (is_numeric($employee_id) && $employee_id > 0 && $this->debitModel->editDebit($id, $employee_id)) return response_with(200, ["success" => true]);
        }

        return response_with(500, ["error" => "Hata"]);
    }
}
