<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PostRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Swift_TransportException;

class PostRegistrationController extends Controller
{

    public function __construct(protected PostRegistrationService $postregistration)
    {
    }

    public function openMail($mail_id) {
		$user = User::where('mail_id', $mail_id)->first();
		if (!$user)
			abort(404);
		if ($post = $user->postregistration)
			return view('postregistration.edit')->with('post', $post)->with('mail_id', $mail_id);
		return view ('postregistration.create')->with('mail_id', $mail_id);
	}

	public function store(Request $request) {

        $data = $request->all();
        $user = User::where('mail_id', $data['mail_id'])->first();

        $form = $this->postregistration->createPostRegistration($data, $user);

		$ticket = $request->file('ticket');
		if ($ticket) {
			$form->ticket_path = $ticket->store('tickets');
		}

		return redirect()->route('thanks-post');
	}

	public function update(Request $request, $id) {

		$data = $this->postregistration->validateOnCreate($request->all());

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
