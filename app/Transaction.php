<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function donation()
    {
        return $this->hasOne('App\Donation', 'donation_ref', 'order_id');
    }
}
