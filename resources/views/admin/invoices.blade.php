@extends('layouts.app')

@section('title')
Admin area - Invoices
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
			<h3>{{ __('Admin area') }}</h3>
            <div class="card">
				<div class="card-header">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item">
							<a class="nav-link" href="{{ route('admin') }}">{{ __('Dashboard') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('admin.users') }}">{{ __('Users') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('admin.groups') }}">{{ __('Groups') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" href="{{ route('admin.invoices') }}">{{ __('Invoices') }}</a>
						</li>
					</ul>
                </div>

                <div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<td>Number</td>
								<td>Group</td>
								<td>Amount</td>
								<td>Method</td>
								<td>Paid</td>
								<td>Invoice</td>
								<td>Receipt</td>
								<td></td>
							</tr>
						</thead>
						<tbody>
							@foreach($invoices as $i)
								<tr>
									<td>{{ $i->number }}</td>
									<td>{{ $i->group->name }}</td>
									<td>{{ $i->currencyString() }}</td>
									<td>{{ $i->method->type }}</td>
									<td>
										@if($i->paid)
											✔️
										@elseif($i->method->type == 'cash' || $i->method->type == 'bank')
											<a class="btn btn-primary" href="{{ route('admin.invoices.confirmPaid', $i->id) }}">Set paid</a>
										@else
											❌
										@endif
									</td>
									<td>
									 	<a href="{{ route('admin.invoices.download', $i->mollie_uid) }}" class="btn btn-primary">{{ __('Invoice') }}</a>
									</td>
									<td>
									    @if($i->paid) <a href="{{ route('admin.invoices.receipt', $i->mollie_uid) }}" class="btn btn-primary">{{ __('Receipt') }}</a>@else not paid yet @endif
									</td>
									<td>
										<a href="{{ route('admin.invoices.refreshConfirm', $i->id) }}" class="btn btn-primary">{{ __('Refresh') }}</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
