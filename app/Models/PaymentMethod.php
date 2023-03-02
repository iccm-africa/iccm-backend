<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    protected $fillable = ['name', 'type', 'description', 'instructions', 'order'];
    public function currency() {
		return $this->belongsTo('App\Models\Currency', 'currency_code', 'code');
	}
}
