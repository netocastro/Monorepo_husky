<?php

namespace Source\Controllers;

use Source\Models\Delivery;
use Source\Models\Status;

class Web
{

    public function doc()
    {
        $path = BASE_PATH ."/doc.json";

        echo
         "<!doctype html> <!-- Important: must specify -->
            <html>
                <head>
                    <meta charset='utf-8'> <!-- Important: rapi-doc uses utf8 characters -->
                    <script type='module' src='https://unpkg.com/rapidoc/dist/rapidoc-min.js'></script>
                </head>
                <body>
                    <rapi-doc spec-url = '{$path}'> </rapi-doc>
                </body>
            </html>";
        
    }
    public function filterDeliveries($data)
    {
        $data = filter_var_array($data, [
            "status_id" => FILTER_SANITIZE_NUMBER_INT,
            "motoboy_id" => FILTER_SANITIZE_NUMBER_INT
        ]);

        if ($data['status_id'] == 0 && $data['motoboy_id'] != 0) {
            $deliveriesFilter = (new Delivery())->find(
                "motoboy_id = :m", "m={$data['motoboy_id']}")->fetch(true);
            if ($deliveriesFilter) {
                foreach ($deliveriesFilter as $value) {
                    $value->data()->user_name = $value->user_name();
                    $value->data()->motoboy_name = $value->motoboy_name();
                    $value->data()->status_name = $value->status_name();
                }
                echo json_encode(objectToArray($deliveriesFilter));
                return;
            }
            echo json_encode([]);
        }

        if ($data['motoboy_id'] == 0 && $data['status_id'] != 0) {
            $deliveriesFilter = (new Delivery())->find("status = :s", "s={$data['status_id']}")->fetch(true);
            if ($deliveriesFilter) {
                foreach ($deliveriesFilter as $value) {
                    $value->user_name = $value->user_name();
                    $value->data()->motoboy_name = $value->motoboy_name();
                    $value->data()->status_name = $value->status_name();
                }
                echo json_encode(objectToArray($deliveriesFilter));
                return;
            }
            echo json_encode([]);
        }

        if ($data['motoboy_id'] == 0 && $data['status_id'] == 0) {
            $deliveriesFilter = (new Delivery())->find()->fetch(true);
            if ($deliveriesFilter) {
                foreach ($deliveriesFilter as $value) {
                    $value->data()->user_name = $value->user_name();
                    $value->data()->motoboy_name = $value->motoboy_name();
                    $value->data()->status_name = $value->status_name();
                }
                echo json_encode(objectToArray($deliveriesFilter));
                return;
            }
            echo json_encode([]);
        }

        if ($data['motoboy_id'] != 0 && $data['status_id'] != 0) {
            $deliveriesFilter = (new Delivery())->find("status = :s and motoboy_id = :m", "s={$data['status_id']}&m={$data['motoboy_id']}")->fetch(true);
            if ($deliveriesFilter) {
                foreach ($deliveriesFilter as $value) {
                    $value->data()->user_name = $value->user_name();
                    $value->data()->motoboy_name = $value->motoboy_name();
                    $value->data()->status_name = $value->status_name();
                }
                echo json_encode(objectToArray($deliveriesFilter));
                return;
            }
            echo json_encode([]);
        }
    }

    public function changeStatusDelivery($data)
    {
        $data = filter_var_array($data,[
            "delivery_id" => FILTER_SANITIZE_NUMBER_INT,
            "status_id" => FILTER_SANITIZE_NUMBER_INT
        ]);

        $status = (new Delivery())->findById($data['delivery_id']);
        if($status){

            $status->status = $data['status_id'];
            $status->change()->save();

            if($status->fail()){
                echo json_encode($status->fail());
            }
        }

        echo json_encode('status_atualizado');  
    }

    public function changeMotoboyDelivery($data)
    {
        $data = filter_var_array($data,[
            "delivery_id" => FILTER_SANITIZE_NUMBER_INT,
            "motoboy_id" => FILTER_SANITIZE_NUMBER_INT
        ]);

        $motoboyId = null;
        if ($data['motoboy_id'] != 0) {
            $motoboyId = filter_var($data['motoboy_id'], FILTER_SANITIZE_NUMBER_INT);
        }   

        $motoboy = (new Delivery())->findById($data['delivery_id']);

        if($motoboy){

            $motoboy->motoboy_id = $motoboyId;
            $motoboy->change()->save();

            if($motoboy->fail()){
                echo json_encode($motoboy->fail());
            }
        }
        echo json_encode('motoboy_atualizado');  
    }
}
