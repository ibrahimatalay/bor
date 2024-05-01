<?php

use CodeIgniter\HTTP\Response;

if (!function_exists('response_with')) {
    function response_with($code, $data)
    {
        $response = response();
        $response->setContentType('application/json');
        $response->setHeader("Content-Type", "application/json");
        $response->setStatusCode($code);
        return $response->setJSON($data);
    }
}
