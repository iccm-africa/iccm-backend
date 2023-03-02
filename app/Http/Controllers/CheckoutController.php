<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Invoice;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mollie\Laravel\Facades\Mollie;

class CheckoutController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
	public function index() {
		$group = Auth::user()->group;
		if ($group->checked_out) return redirect()->route('group');
		$users = $group->users()->with('products', 'accommodation')->get();
		$cost = $group->outstanding();
		$prices = [];
		$currencies = [];
		$def = null;
		foreach (Currency::all() as $c) {
			$currencies[$c->code] = $c;
			$prices[$c->code] = $c->convert($cost);
			if ($c->def) $def = $c;
		}
		$methods = PaymentMethod::orderBy('order', 'asc')->get();
		return view('checkout', compact('users', 'group', 'currencies', 'prices', 'def', 'methods'));
	}
	public function pay(Request $request) {
		$request->validate(['method' => 'required']);
		$group = Auth::user()->group;
		if ($group->checked_out) return redirect()->route('group');
		$users = $group->users()->where('checked_out', false)->get();
		$data = $request->all();
		$method = PaymentMethod::find($data['method']);
		switch ($method->type) {
			case 'bank':
			case 'cash':
				$invoice = $this->cash_bank_invoice($group, $method);
				$ret = redirect()->route('group', ['uid' => $invoice->mollie_uid], 303);
				break;
			case 'mollie':
				$ret = $this->mollie_invoice($group, $method);
				break;
		}
		// Pass UID to the group page so it can show a thanks message appropriate for the invoice
		ReminderController::mailUsers($users);
		return $ret;
	}
	/*
	 * No payment portal, just an invoice with instructions
	 */
	private function cash_bank_invoice($group, $method) {
		$invoice = Invoice::forGroup($group, $method);
		DB::transaction(function() use ($group, $invoice) {
			$group->push(); // checked_out=true on group and users
			$group->invoices()->save($invoice);
			$invoice->genInvoicePDF();
		});
		return $invoice;
	}
	/*
	 * The first time you try to pay
	 */
	private function mollie_invoice($group, $method) {
		$invoice = Invoice::forGroup($group, $method);

		$url = $this->mollie_pay($invoice);

		DB::transaction(function() use ($group, $invoice) {
			$group->push(); // checked_out=true on group and users
			$group->invoices()->save($invoice);
			$invoice->genInvoicePDF();
		});

		return redirect($url, 303);
	}
	/*
	 * The second time you try to pay
	 */
	public function mollieRetry($uid) {
		$invoice = Invoice::where('mollie_uid', $uid)->first();
		if ($invoice->group != Auth::user()->group)
			abort(403);

		$url = $this->mollie_pay($invoice);

		$invoice->save(); // A new mollie ID has been assigned

		return redirect($url, 303);
	}
	/*
	 * The actual Mollie code
	 * You need to set the uid on the invoice before calling this
	 * You need to save the invoice after calling this
	 *
	 * Return value: redirect to payment portal
	 */
	private function mollie_pay($invoice) {
		$payment = Mollie::api()->payments()->create([
			'amount' => [
				'currency' => 'EUR',
				'value' => number_format($invoice->converted_amount, 2, '.', ''),
			],
			'description' => 'ICCM-Africa',
//			'webhookUrl' => route('mollie_webhook'),
			'redirectUrl' => route('mollie_redirect', ['uid' => $invoice->mollie_uid]),
		]);

		$invoice->mollie_id = $payment->id;
		$invoice->mollie_status = $payment->status;

		return $payment->getCheckoutUrl();
	}
	public function mollieRedirect($uid) {
		// UID was used to create redirect URL
		$invoice = Invoice::where('mollie_uid', $uid)->first();
		$payment = Mollie::api()->payments()->get($invoice->mollie_id);

        $invoice->mollie_status = $payment->status;
        $invoice->setPaid($payment->isPaid());
        $invoice->save();
		return redirect()->route('group', ['uid' => $uid], 303);
	}
}

