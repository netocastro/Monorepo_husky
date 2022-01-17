<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class Status extends DataLayer 
{
    public function __construct()
    {
        parent::__construct('status',['name'],'id',true);
    }
}
