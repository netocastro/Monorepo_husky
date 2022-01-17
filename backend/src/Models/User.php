<?php

namespace Source\Models;

use Stonks\DataLayer\DataLayer;

class User extends DataLayer 
{
    public function __construct()
    {
        parent::__construct('users',['name','address'],'id',true);
    }
}
