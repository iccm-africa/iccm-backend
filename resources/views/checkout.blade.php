@extends('layouts.app')

@section('title')
Checkout
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Your booking') }}</div>

                <div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<td>Name</td>
								<td>Accommodation</td>
								<td>Cost</td>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $u)
								<tr>
									<td>{{ $u->name }}</td>
									<td>{{ $u->accommodation->name }}</td>
									<td>{{ $u->currencyString() }}</td>
								</tr>
							@endforeach
							<tr class="table-light">
								<td><b>Total</b></td>
								<td></td>
								<td>{{ $def->format($group->cost()) }}</td>
							</tr>
							@if(!$group->checked_out)
								<tr class="table-light">
									<td><b>Outstanding</b></td>
									<td></td>
									<td>{{ $def->format($group->outstanding()) }}</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
            <div class="card mt-3">
                <div class="card-header">{{ __('Payment method') }}</div>
                <form method="POST" action="{{ route('checkout_pay') }}">
					@csrf
				<table class="table card-body">
					<tbody>
						@foreach ($methods as $m)
						<tr>
							<td>
								<div class="form-check-inline">
									<input type="radio" name="method" value="{{ $m->id }}" class="form-check-input @error('method') is-invalid @enderror" required>
									<label class="form-check-label" for="method">{{ $m->name }}</label>
								</div>
								<br />
								<i>{{ $m->description }}</i>
							</td>
							<td style="white-space:nowrap;">{{ $m->currency->format($prices[$m->currency->code]) }}</td>
						</tr>
						@endforeach
						<tr>
							<td colspan="2">
								<button type="submit" class="btn btn-primary">Continue</button>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
