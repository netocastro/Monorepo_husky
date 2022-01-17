<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class Delivery extends DataLayer
{
    public function __construct()
    {
        parent::__construct('deliveries', ['user_id', 'status', 'collection_address', 'destination_address'], 'id', true);
    }

    public function user_name(): String
    {
        return (new User())->findById($this->user_id)->name;
    }

    public function motoboy_name(): String
    {
        if (!empty($this->motoboy_id)) {
            return (new Motoboy())->findById($this->motoboy_id)->name;
        }
        return " - ";
    }

    public function status_name(): String
    {
        return (new Status())->findById($this->status)->name;
    }

}
