@extends('layouts.app')

@section('title')
{{ __('Your booking') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
			@if($thanks)
			<div class="alert alert-success"><strong>Thanks for registering!</strong> You can now add other members of your group. Do not forget to check out at the end.</div>
			@elseif($userAdded)
			<div class="alert alert-success"><strong>Thanks for registering another participant!</strong> Do not forget to check out.</div>
			@elseif($msg == 'paid')
			<div class="alert alert-success"><strong>Payment successful.</strong> You can now download your invoice and receipt at the bottom.</div>
			@elseif($msg == 'failed')
			<div class="alert alert-success"><strong>Payment failed.</strong> Please use the link at the bottom of the page to retry. Alternatively you can view your invoice and contact us to change your payment method.</div>
			@elseif($msg == 'toBePaid')
			<div class="alert alert-success"><strong>Thanks for checking out!</strong> You can now find the payment instructions on your invoice at the bottom.</div>
			@endif
			@if (!$group->checked_out)
			<div class="card mt-3">
				<div class="card-header">{{ __('Not Checked Out / Pending Registrations') }}</div>
				
				<div class="card-body">
 					<table class="table table-striped">
						<thead>
							<tr>
								<td>{{ __('Name') }}</td>
								<td>{{ __('Accommodation') }}</td>
								<td>{{ __('Cost') }}</td>
							</tr>
						</thead>
						<tbody>
							@foreach($users_checkout as $u)
								<tr>
									<td>{{ $u->nameString() }}</td>
									<td>{{ $u->accommodation->name }}</td>
									<td>{{ $u->currencyString() }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<a href="{{ route('checkout') }}" class="btn float-right btn-success">{{ __('Checkout') }}</a>
					<a href="{{ route('addUser') }}" class="btn float-right btn-primary mr-2">{{ __('Add participant') }}</a>
				</div>
			</div>
			@endif
			@if ($users->count() > 0)
            <div class="card mt-3">
                <div class="card-header">{{ __('Your booking') }}</div>

                <div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<td>{{ __('Name') }}</td>
								<td>{{ __('Accommodation') }}</td>
								<td>{{ __('Provided extra information') }}</td>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $u)
								<tr>
									<td>{{ $u->nameString() }}</td>
									<td>{{ $u->accommodation->name }}</td>
									<td>@if($u->postregistration)✔️@else❌@endif</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					@if($group->checked_out)
					<a href="{{ route('addUser') }}" class="btn float-right btn-primary">{{ __('Add participant') }}</a>
					@endif
				</div>
			</div>
			@endif
			@if ($group->invoices->count() > 0)
			<div class="card mt-3">
				<div class="card-header">{{ __('Your invoices') }}</div>
				
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<td>Number</td>
							<td>Amount</td>
							<td>Paid</td>
							<td>Details</td>
							<td>Downloads</td>
						</thead>
						<tbody>
							@foreach ($group->invoices as $i)
								<tr>
									<td>{{ $i->number }}</td>
									<td>{{ $i->currencyString() }}</td>
									<td>@if($i->paid)✔️@else❌@endif</td>
									<td>
										{{ $i->method->name }}
										@if($i->mollie_status)
											<br />Status: {{ $i->mollie_status }}
											@if($i->mollieFailed())
												<a href="{{ route('mollie_retry', $i->mollie_uid) }}" class="btn btn-primary">Retry</a>
											@elseif($i->molliePending())
												<a href="{{ route('mollie_redirect', $i->mollie_uid) }}" class="btn btn-primary">{{ __('Refresh') }}</a>												
											@endif
										@endif
									</td>
									<td>
										<a href="{{ route('downloadInvoice', $i->mollie_uid) }}" class="btn btn-primary">{{ __('Invoice PDF') }}</a>	
										@if($i->paid) <a href="{{ route('downloadReceipt', $i->mollie_uid) }}" class="btn btn-primary">{{ __('Receipt PDF') }}</a>@endif	
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection
