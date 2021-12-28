<?php

namespace App;

use App\Currency;
use PDF;
use Storage;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	protected $table='invoices';
	protected $fillable=['number','paid','amount','currency','converted_amount','mollie_id','mollie_status','mollie_uid', 'payment_date'];
    protected $casts = [
        'payment_date' => 'datetime',
    ];
	public function group()
	{
		return $this->belongsTo('App\Group');
	}
	public function method() {
		return $this->belongsTo('App\PaymentMethod');
	}
	public function getCurrency()
	{
		return Currency::find($this->currency);
	}
	public function currencyString() {
		return $this->getCurrency()->format($this->converted_amount);
	}
	public function mollieFailed()
	{
		$s = $this->mollie_status;
		return $s == 'expired' || $s == 'canceled' || $s == 'failed';
	}
	public function molliePending()
	{
		$s = $this->mollie_status;
		return $s == 'open' || $s == 'pending';
	}
	public function setPaid($paid = true) {
		$old = $this->paid;
		if ($paid && !$old) {
			$this->paid = true;
			$this->payment_date = now();
			$this->genReceiptPDF();
		}
	}
	public static function forGroup($group, $method) {
		$cost = $group->outstanding();
		$invoice = new Invoice;
		$invoice->fill([
			'number' => self::invoiceNumber(),
			'amount' => $cost,
			'currency' => $method->currency_code,
			'converted_amount' => $method->currency->convert($cost),
			'mollie_uid'=> bin2hex(random_bytes(8)),
		]);
		$invoice->method()->associate($method);
		$group->checked_out = true;
		foreach($group->users as $u)
			$u->checked_out = true;

		return $invoice;
	}
	
	public function genInvoicePDF() {
		$groupadmin = $this->group->admin();
		$def = Currency::def();
	    $pdf = PDF::loadView('invoice', ['invoice' => $this, 'groupadmin' => $groupadmin, 'def' => $def ]);
        Storage::disk('local')->put($this->invoiceFile(), $pdf->output());
	}
	
	public function genReceiptPDF() {
		$groupadmin = $this->group->admin();
		$def = Currency::def();
	    $pdf = PDF::loadView('receipt', ['invoice' => $this, 'groupadmin' => $groupadmin, 'def' => $def ]);
        Storage::disk('local')->put($this->receiptFile(), $pdf->output());
	}

	public function invoiceFile() {
		return $this->mollie_uid . "_invoice.pdf";
	}

	public function receiptFile() {
		return $this->mollie_uid . "_receipt.pdf";
	}
	
	private static function invoiceNumber() {
		$highest = self::orderBy('number', 'desc')->first();
		if ($highest == null)
			return 2020001; // The first invoice number of this year
		$number = (int) $highest->number;
		return $number + 1;
	}

}
