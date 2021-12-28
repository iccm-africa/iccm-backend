<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
	protected $table='currencies';
	protected $primaryKey = 'code';
	public $incrementing = false;
	protected $fillable=['code','name','symbol','rate','cost','default'];
	public function convert($amount) {
		return round($amount * $this->rate, 2);
	}
	public function format($amount) {
		return $this->symbol . ' ' . number_format($amount, 2);
	}
	public static function def() {
		return self::where('def', true)->first();
	}
}
