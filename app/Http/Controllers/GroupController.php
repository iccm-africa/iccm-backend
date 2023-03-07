<?php

namespace App\Http\Controllers;

use App\User;
use App\Accommodation;
use App\Currency;
use App\Group;
use App\Product;
use App\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;
use PDF;

class GroupController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
	public function index(Request $request, $uid = null) {
		$thanks = $request->headers->get('referer') == route('register');
		$userAdded = $request->headers->get('referer') == route('addUser');
		$group = Auth::user()->group;
		$msg = '';
		if ($uid) {
			$invoice = Invoice::where('mollie_uid', $uid)->first();
			if (!$invoice)
				abort(404);
			elseif($invoice->group != $group)
				abort(403);
			if ($invoice->paid)
				$msg = 'paid';
			elseif ($invoice->mollieFailed())
				$msg = 'failed';
			else
				$msg = 'toBePaid';
		}
		$group = Auth::user()->group;
		$users = $group->users()->where("checked_out", true)->get();
		$users_checkout = $group->users()->where("checked_out", false)->get();
		return view ('group', compact('group', 'users', 'users_checkout', 'thanks', 'userAdded', 'msg'));
	}
	public function form_validate($request){
		$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'passport' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'residence' => ['required', 'string', 'max:255'],
            'accommodation' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
	}
	public function addUser() {
		$organisation = Auth::user()->group->name;
		$accommodations = Accommodation::all();
		$def = Currency::def();
		$products = Product::all();
		return view ('auth.register', compact('accommodations', 'organisation', 'products', 'def'))->with('login', false);
	}
	public function saveUser(Request $request) {
		$this->form_validate($request);
		$data = $request->all();
		$user = new User;
		$user->fill([
            'name' 		=> $data['name'],
            'lastname'	=> $data['lastname'],
            'nickname'	=> $data['nickname'],
            'passport' 	=> $data['passport'],
            'gender'	=> $data['gender'],
            'residence'	=> $data['residence'],
            'email' 	=> $data['email'],
            'mail_id'	=> bin2hex(random_bytes(8)),
		]);
		$user->role = 'participant';
		$accommodation = Accommodation::find($data['accommodation']);
		$user->accommodation()->associate($accommodation);
		$keys = array_keys($data);
		$ids=[];
		foreach ($keys as $k) {
			if (preg_match("/^product_([0-9]+)$/", $k, $matches) === 1) {
				$ids[] = $matches[1];
			}
		}
		$group = Auth::user()->group;
		$group->checked_out = false;
		DB::transaction(function() use ($group, $user, $ids) {
			$group->save();
			$group->users()->save($user);
			$user->products()->sync($ids);
		});
		return redirect()->route('group');
	}

	public function downloadInvoice($uid) {
		$invoice = Invoice::where('mollie_uid', $uid)->first();
		if($invoice->group != Auth::user()->group)
			abort(403);
		return Storage::download($invoice->invoiceFile());
	}
	public function downloadReceipt($uid) {
		$invoice = Invoice::where('mollie_uid', $uid)->first();
		if($invoice->group != Auth::user()->group)
			abort(403);
		return Storage::download($invoice->receiptFile());
	}
}
