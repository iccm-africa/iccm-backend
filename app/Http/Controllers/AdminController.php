<?php

namespace App\Http\Controllers;

use App\Group;
use App\Currency;
use App\User;
use App\Invoice;
use App\Http\Controllers\Controller;
use Mail;
use Illuminate\Http\Request;
use Swift_TransportException;
use Illuminate\Support\Facades\Log;
use Storage;

class AdminController extends Controller
{
	public function __construct() {
		$this->middleware('admin');
	}
	public function index() {
		return view('admin.index');
	}
	public function users() {
		$users = User::orderBy('group_id', 'asc')->with('group', 'postregistration')->get();
		return view('admin.users', compact('users'));
	}
	public function user($id) {
		$user = User::find($id);
		return view('admin.user', compact('user'));
	}
	public function groups() {
		$groups = Group::all();
		return view('admin.groups', compact('groups'));
	}
	public function group($id) {
		$group = Group::find($id);
		return view('admin.group', compact('group'));
	}
	public function invoices() {
		$invoices = Invoice::with('group', 'method')->get();
		return view('admin.invoices', compact('invoices'));
	}
	public function downloadInvoice($uid) {
		$invoice = Invoice::where('mollie_uid', $uid)->first();
		return Storage::download($invoice->invoiceFile());
	}
	public function downloadReceipt($uid) {
		$invoice = Invoice::where('mollie_uid', $uid)->first();
		return Storage::download($invoice->receiptFile());
	}
	
	public function payInvoiceConfirm($id) {
		$invoice = Invoice::find($id);
		return view('admin.invoice_confirm', compact('invoice'));
	}
	public function payInvoice(Request $request) {
		$id = $request->get('id');
		$invoice = Invoice::find($id);
		$invoice->setPaid();
		$invoice->save();
		$admin = $invoice->group->admin();
		try {
			Mail::send('emails.receipt', ['invoice' => $invoice, 'admin' => $admin], function ($m) use ($admin, $invoice) {
				$m->from(env('MAIL_FROM', 'noreply@iccm-africa.org'), env('APP_NAME','ICCM-Africa'));
				$m->to($admin->email, $admin->name)->subject('Payment received for invoice ' . $invoice->number);
			});
		}
		catch (Swift_TransportException $e) {
			Log::error($e->getMessage());
		}

		return redirect()->route('admin.invoices');
	}
	public function refreshInvoiceConfirm($id) {
		$invoice = Invoice::find($id);
		return view('admin.refresh_confirm', compact('invoice'));
	}
	public function refreshInvoice(Request $request) {
		$id = $request->get('id');
		$invoice = Invoice::find($id);
		$invoice->genInvoicePdf();
		return redirect()->route('admin.invoices');
	}
}
	
