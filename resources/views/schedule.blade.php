@extends('layouts.app')

@section('title')
Schedule
@endsection

@section('content')

       
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">{{ __('Schedule') }}</div>

						<div class="card-body">
						We are still working on the schedule, this is our first draft version: <a href="{{ asset('pdf/schedule-draft1.pdf') }}" target="_blank">Draft Schedule</a> 
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
