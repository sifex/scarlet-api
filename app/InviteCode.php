<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hash;

class InviteCode extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->invite_code = substr((rand(1, 1000)), 0, 7);
        var_dump($this->invite_code);
    }
}
