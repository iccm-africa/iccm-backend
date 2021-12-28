@extends('layouts.app')

@section('title')
Admin area - Groups
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
					<table class="table table-striped">
						<thead>
							<tr>
								<td>Name</td>
								<td>Participants</td>
								<td>Checked out</td>
							</tr>
						</thead>
						<tbody>
							@foreach($groups as $g)
								<tr>
									<td><a href="{{ route('admin.group', $g->id) }}">{{ $g->name }}</a></td>
									<td>{{ $g->users()->count() }}</td>
									<td>
										@if($g->checked_out)✔️@else❌@endif
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
