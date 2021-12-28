@extends('layouts.app')

@section('title')
Registration
@endsection

@section('content')

       
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">{{ __('Registration') }}</div>
						
						<div class="card-body">
						Welcome to the new registration form of ICCM-Africa.
						<br />
						<div class="alert alert-info"><b>If you are coming as part of a group, we would prefer that one group member creates an account and registers all members of the group.</b>
						This helps us to automate the registration process and reduce the administrative workload.
						This registration form is for individual and groups.
							<br /><br />
							<b>Privacy notice:</b><br />
							For the purpose of registration, your data will be handled by KingdomIT, The Netherlands, and will be stored on servers located inside the European Union.
						</div>
						<br/>
						<h3>Step 1: Register yourself</h3>
						On the registration form, you will be asked to provide some details about yourself and your organisation.
						<br />
						<br />
						<h3>Step 2: Add extra participants (if coming with a group)</h3>
						If you come with a group, you can add more participants. You only need to provide the full name, choice of accommodation and e-mail address.
						Participants will be asked to provide more information by e-mail, such as their IT skills and how they can help shape the conference.
						<br />
						<br />
						<h3>Step 3: Checkout</h3>
						After adding all participants, you can go to checkout and select a payment method:
						<ul>
						<li>Online Payment (PayPal/iDeal)</li>
						<li>MPesa / Bank deposit (Kenya)</li>
						<li>Bank transfer (Europe)</li>
						<li>Bank transfer (USA)</li>
						<li>Cash on Arrival</li>
						</ul> 
						Online payments will for now be handled in Euro currency. We hope to process these in Kenyan shilling in a later edition of ICCM.<br />
						<br />
						After checking out, you can download an invoice in your account. If you select Cash on Arrival, your registration will be pending until you have sent us a travel document (plane ticket, visa request) as proof.
						After completing payment, you can download a receipt in your account.
						<br/>
						<br/>
						<h3>Step 4: Post-registration</h3>
						After registration, every participant will get a request by email to fill in additional information, such as their IT skills and how they can help shape the conference.<br />
						<br />
						<h3>Pricing</h3>
						<table class="table table-striped">
							<tbody>
								@foreach ($accommodations as $acc)
								<tr>
									<td>
										{{ $acc->name }}
										<br />
										<i>{{ $acc->description }}</i>
									</td>
									<td style="white-space:nowrap;" class="text-right">{{ $def->format($acc->cost) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<br/>
						<h3>Click here to login or register:</h3>
						@guest
						If you have already registered for the conference, please log in. If this is your first time, please register a new account.<br />
						<a href="{{ route('login') }}" class="btn center-block btn-primary mr-2">{{ __('Login') }}</a>
						<a href="{{ route('register') }}" class="btn center-block btn-primary">{{ __('Register a new account') }}</a>
						@else
						You are already logged in. Click here to view your booking:<br />
						<a href="{{ route('group') }}" class="btn center-block btn-primary">{{ __('Your booking') }}</a><br />
						@endguest
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
