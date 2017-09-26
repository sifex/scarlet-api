<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hash;

class InviteCode extends Model
{
    public function __construct()
    {
        parent::__construct();

        $length = 7;
        $characters = "0123456789ABCDEFGHJKLMNPQRSTUVWXYZ";


        for ($p = 0; $p < $length; $p++) {
            $this->invite_code .= $characters[mt_rand($length, strlen($characters)) - 1];
        }

    }
}
