<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class Motoboy extends DataLayer 
{
    public function __construct()
    {
        parent::__construct('motoboys',['name'],'id',true);
    }
}
