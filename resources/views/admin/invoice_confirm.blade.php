@extends('layouts.app')

@section('title')
Admin area - Invoices
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm payment') }}</div>

                <div class="card-body">
					Do you want to set this invoice to paid and send the user a receipt?
					<table class="table table-striped">
						<thead>
							<tr>
								<td>Number</td>
								<td>Group</td>
								<td>Amount</td>
								<td>Method</td>
								<td>Paid</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{ $invoice->number }}</td>
								<td>{{ $invoice->group->name }}</td>
								<td>{{ $invoice->currencyString() }}</td>
								<td>{{ $invoice->method->type }}</td>
								<td>
									<form method="POST" action="{{ route('admin.invoices.pay', $invoice->id) }}">
										@csrf
										<input type="hidden" name="id" value="{{ $invoice->id }}" />
										<button type="submit" class="btn btn-primary">Set paid</button>
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
