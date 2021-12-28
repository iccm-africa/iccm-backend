@extends('layouts.app')

@section('title')
{{ __('Admin area - Users') }}
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
							<a class="nav-link active" href="{{ route('admin.groups') }}">{{ __('Groups') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('admin.invoices') }}">{{ __('Invoices') }}</a>
						</li>
					</ul>
                </div>

                <div class="card-body">
					<h3>{{ $group->name }}</h3>
					<table class="table table-borderless">
						<tbody>
							<tr>
								<td>{{ __('Name') }}</td>
								<td>{{ $group->name }}</td>
							</tr>
							<tr>
								<td>{{ __('Website') }}</td>
								<td>{{ $group->website }}</td>
							</tr>
							<tr>
								<td>{{ __('Organisation Type') }}</td>
								<td>{{ $group->org_type }}</td>
							</tr>
							<tr>
								<td>{{ __('Billing Address') }}</td>
								<td>{{ $group->address }}</td>
							</tr>
							<tr>
								<td>{{ __('Town/City') }}</td>
								<td>{{ $group->town }}</td>
							</tr>
							<tr>
								<td>{{ __('Province/County/State') }}</td>
								<td>{{ $group->state }}</td>
							</tr>
							<tr>
								<td>{{ __('Postcode/Zip') }}</td>
								<td>{{ $group->zipcode }}</td>
							</tr>
							<tr>
								<td>{{ __('Country') }}</td>
								<td>{{ $group->country }}</td>
							</tr>
							<tr>
								<td>{{ __('Telephone') }}</td>
								<td>{{ $group->telephone }}</td>
							</tr>
							<tr>
								<td>Checked out</td>
								<td>
									@if($group->checked_out)✔️@else❌@endif
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
