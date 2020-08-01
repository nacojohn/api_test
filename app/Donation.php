<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    // protected $primaryKey = 'donation_ref';

    public function generateDonationRef() {
        $number = "DON" . mt_rand(100000000, 999999999); // better than rand()
    
        // call the same function if the barcode exists already
        if ($this->orderNumberExists($number)) {
            return $this->generateDonationRef();
        }
    
        // otherwise, it's valid and can be used
        return $number;
    }
    
    public function orderNumberExists($number) {
        return Donation::where('donation_ref', $number)->first();
    }

    public function transaction()
    {
        return $this->belongsTo('App\Transaction', 'donation_ref', 'order_id');
    }
}
