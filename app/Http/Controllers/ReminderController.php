<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Mail;
use Swift_TransportException;

class ReminderController extends Controller
{
    # Reminder function for post registration. If user did not fill in the post registration form
	public function postregistration(){
		$users_checkout = User::where("checked_out", true)->get();
		$this->mailUsers($users_checkout);
	}
	public static function mailUsers($users_checkout) {
		foreach($users_checkout as $u) {
			if($u->postregistration == NULL ) {
				try {
					Mail::send('emails.postreminder', ['user' => $u], function ($m) use ($u) {
						$m->from(env('MAIL_FROM', 'noreply@iccm-africa.org'), env('APP_NAME','ICCM-Africa'));
						$m->to($u->email, $u->name)->subject('Your registration for ICCM-Africa is almost complete');
					});
				}
				catch (Swift_TransportException $e) {
					Log::error($e->getMessage());
				}

				# Sleep for rate limit mailtrap
				if(config('app.env')=='local')
					sleep(5);
			}
		}
	}

	public function checkout() {
		$admins = User::where('role','groupadmin')->orWhere('role', 'admin')->get();

		foreach($admins as $admin) {
			$u = $admin->group->users()->where("checked_out", false)->get(); #check if create date is older then 30min to prevent reminder during checkout

			if(count($u) > 0 ) {
				try {
					Mail::send('emails.checkoutreminder', ['admin' => $admin, 'users' => $u], function ($m) use ($u, $admin) {
						$m->from(env('MAIL_FROM', 'noreply@iccm-africa.org'), env('APP_NAME','ICCM-Africa'));
						$m->to($admin->email, $admin->name)->subject('Your Checkout is still pending');
					});
				}
				catch (Swift_TransportException $e) {
					Log::error($e->getMessage());
				}
			}

				# Sleep for rate limit mailtrap
				sleep(5);
		}
	}

	public function invoices() {

		$admins = User::where('role','groupadmin')->orWhere('role', 'admin')->get();

		foreach($admins as $admin) {
			$open_bank = $admin->group->invoices()->where('paid', false)->whereHas('method', function($q) {
				$q->where('type', 'bank'); // query on payment method
			})->get();

			$open_mollie = $admin->group->invoices()->where('paid', false)->whereHas('method', function($q) {
				$q->where('type', 'mollie'); // query on payment method
			})->get();

			# are their open invoices? if yes, then continue
			if(count($open_bank) > 0) {
				try {
					Mail::send('emails.invoicesreminder_bank', ['admin' => $admin, 'invoices' => $open_bank], function ($m) use ($admin) {
						$m->from(env('MAIL_FROM', 'noreply@iccm-africa.org'), env('APP_NAME','ICCM-Africa'));
						$m->to($admin->email, $admin->name)->subject('Unpaid invoices');
					});
				}
				catch (Swift_TransportException $e) {
					Log::error($e->getMessage());
				}
				sleep(5);
			}
			if(count($open_mollie) > 0) {
				try {
					Mail::send('emails.invoicesreminder_mollie', ['admin' => $admin, 'invoices' => $open_mollie], function ($m) use ($admin) {
						$m->from(env('MAIL_FROM', 'noreply@iccm-africa.org'), env('APP_NAME','ICCM-Africa'));
						$m->to($admin->email, $admin->name)->subject('Unpaid invoices');
					});
				}
				catch (Swift_TransportException $e) {
					Log::error($e->getMessage());
				}
				sleep(5);
			}
		}
	}
}
