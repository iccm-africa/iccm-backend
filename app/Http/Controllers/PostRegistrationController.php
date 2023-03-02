<?php

namespace App\Http\Controllers;

use App\Models\Postregistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mail;
use Swift_TransportException;

class PostRegistrationController extends Controller
{
	public function openMail($mail_id) {
		$user = User::where('mail_id', $mail_id)->first();
		if (!$user)
			abort(404);
		if ($post = $user->postregistration)
			return view('postregistration.edit')->with('post', $post)->with('mail_id', $mail_id);
		return view ('postregistration.create')->with('mail_id', $mail_id);
	}

	public function form_validate($request){

			$data = $request->validate([
			'share_acco' 		=> 'string|nullable',
			'traveling'  		=> 'string',
			'share_travelplans' => 'string|nullable',
			'emergency_name' 	=> 'string',
			'emergency_phone' 	=> 'string',
			'emergency_country' => 'string',
			'dietprefs' 		=> 'string|nullable',
			'shirtsize' 		=> 'string',
			'iccmelse' 			=> 'string|nullable',
  			'iccmelse_lastyear' => 'string|nullable',
			'iccmlocation' 		=> 'string|nullable',
			'knowiccm' 			=> 'string|nullable',
			'experince_itman' 	=> 'string|nullable',
			'expert_itman' 		=> 'string|nullable',
			'learn_itman' 		=> 'string|nullable',
			'tech_impl' 		=> 'string|nullable',
			'new_tech' 			=> 'string|nullable',
			'help_worship' 		=> 'string|nullable',
			'speakers' 			=> 'string|nullable',
			'help_iccm' 		=> 'string|nullable'
		]);

		return $data;

	}

	public function store(Request $request) {

		$data = $this->form_validate($request);

		$data = $request->all();
		$form = new Postregistration;
		$form->fill($data);

		$user = User::where('mail_id', $data['mail_id'])->first();
		$ticket = $request->file('ticket');
		if ($ticket) {
			$form->ticket_path = $ticket->store('tickets');
		}

		$user->postregistration()->save($form);

		return redirect()->route('thanks-post');
	}

	public function update(Request $request, $id) {

		$data = $this->form_validate($request);
		$data = $request->all();
		$user = User::where('mail_id', $id)->first();
		$form = $user->postregistration;
		$form->fill($data);

		$oldTicket = $form->ticket_path;
		$ticket = $request->file('ticket');
		if ($ticket) {
			$form->ticket_path = $ticket->store('tickets');
			if ($oldTicket) {
				Storage::delete($oldTicket);
			}
		}

		$form->save();
		try {
			Mail::send('emails.update', ['user' => $user], function ($m) use ($user) {
				$m->from(env('MAIL_FROM','noreply@iccm-africa.org'), env('APP_NAME','ICCM-Africa'));
				$m->to('info@kingdomit.nl')->subject($user->name . ' updated their post-registration');
			});
		}
		catch (Swift_TransportException $e) {
			Log::error($e->getMessage());
		}

		return redirect()->route('thanks-post');
	}

	public function file($path){
		if (strpos($path, 'tickets/') !== 0)
			abort(404);

		return Storage::download($path);
	}
}
