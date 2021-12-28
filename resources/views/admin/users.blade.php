@extends('layouts.app')

@section('title')
Admin area
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
							<a class="nav-link active" href="{{ route('admin.users') }}">{{ __('Users') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('admin.groups') }}">{{ __('Groups') }}</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="{{ route('admin.invoices') }}">{{ __('Invoices') }}</a>
						</li>
					</ul>
                </div>

                <div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<td>Name</td>
								<td></td>
								<td>Organisation</td>
								<td>Accommodation</td>
								<td>Role</td>
								<td>Checked out</td>
								<td>Post-registration</td>
								<td>Ticket</td>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $u)
								<tr>
									<td><a href="{{ route('admin.user', $u->id) }}">{{ $u->nameString() }}</a></td>
									<td> @if($u->gender=='m')♂️@elseif($u->gender=='f')♀️@endif</td>
									<td><a href="{{ route('admin.group', $u->group->id) }}">{{ $u->group->name }}</a></td>
									<td>{{ $u->accommodation->name }}</td>
									<td>{{ $u->role }}</td>
									<td>
										@if($u->checked_out)✔️@else❌@endif
									</td>
									<td>
										@if($u->postregistration)✔️@else❌@endif
									</td>
									<td>
										@if($u->postregistration)
											@if($u->postregistration->ticket_path)
												<a href="{{ route('postregistration.file', $u->postregistration->ticket_path)}}"><button type="button" class="btn btn-primary">Ticket</button></a>
											@endif
										@endif
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
