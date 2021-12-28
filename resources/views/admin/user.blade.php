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
					<h3>{{ $user->nameString() }}</h3>
					<table class="table table-borderless">
						<tbody>
							<tr>
								<td>{{ __('First name') }}</td>
								<td>{{ $user->name }}</td>
							</tr>
							<tr>
								<td>{{ __('Last name') }}</td>
								<td>{{ $user->lastname }}</td>
							</tr>
							<tr>
								<td>{{ __('Nickname') }}</td>
								<td>{{ $user->nickname }}</td>
							</tr>
							<tr>
								<td>{{ __('Gender') }}</td>
								<td>{{ $user->gender }}</td>
							</tr>
							<tr>
								<td>{{ __('E-mail address') }}</td>
								<td>{{ $user->email }}</td>
							</tr>
							<tr>
								<td>{{ __('Name in passport') }}</td>
								<td>{{ $user->passport }}</td>
							</tr>
							<tr>
								<td>{{ __('Country of residence') }}</td>
								<td>{{ $user->residence }}</td>
							</tr>
							<tr>
								<td>{{ __('Group') }}</td>
								<td><a href="{{ route('admin.group', $user->group->id) }}">{{ $user->group->name }}</a></td>
							</tr>
							<tr>
								<td>{{ __('Accommodation') }}</td>
								<td>{{ $user->accommodation->name }}</td>
							</tr>
							<tr>
								<td>{{ __('Role') }}</td>
								<td>{{ $user->role }}</td>
							</tr>
							<tr>
								<td>Checked out</td>
								<td>
									@if($user->checked_out)✔️@else❌@endif
								</td>
							</tr>
							<tr>
								<td>Post-registration</td>
								<td>
									@if($user->postregistration)✔️@else❌@endif
								</td>
							</tr>
							@if($user->postregistration)
								<tr>
									<td>{{ __('Shares accommodation with') }}</td>
									<td>{{ $user->postregistration->share_acco }}</td>
								</tr>
								<tr>
									<td>{{ __('Mode of travel') }}</td>
									<td>{{ $user->postregistration->traveling }}</td>
								</tr>
								<tr>
									<td>{{ __('Travel plans') }}</td>
									<td>{{ $user->postregistration->share_travelplans }}</td>
								</tr>
								<tr>
									<td>{{ __('Emergency contact') }}</td>
									<td>{{ $user->postregistration->emergency_name }}</td>
								</tr>
								<tr>
									<td>{{ __('Phone') }}</td>
									<td>{{ $user->postregistration->emergency_phone }}</td>
								</tr>
								<tr>
									<td>{{ __('Country') }}</td>
									<td>{{ $user->postregistration->emergency_country }}</td>
								</tr>
								<tr>
									<td>{{ __('Diet preferences / Special needs') }}</td>
									<td>{{ $user->postregistration->dietprefs }}</td>
								</tr>
								<tr>
									<td>{{ __('Shirt Size') }}</td>
									<td>{{ $user->postregistration->shirtsize }}</td>
								</tr>
								<tr>
									<td>{{ __('Visited ICCM before') }}</td>
									<td>@if($user->postregistration->iccmelse)✔️@else❌@endif</td>
								</tr>
								<tr>
									<td>{{ __('Year') }}</td>
									<td>{{ $user->postregistration->iccmelse_lastyear }}</td>
								</tr>
								<tr>
									<td>{{ __('Location') }}</td>
									<td>{{ $user->postregistration->iccmlocation }}</td>
								</tr>
								<tr>
									<td>{{ __('How did you hear about ICCM-Africa?') }}</td>
									<td>{{ $user->postregistration->knowiccm }}</td>
								</tr>
								<tr>
									<td>{{ __('Talents') }}</td>
									<td>{{ $user->postregistration->experince_itman }}</td>
								</tr>
								<tr>
									<td>{{ __('Expert of') }}</td>
									<td>{{ $user->postregistration->expert_itman }}</td>
								</tr>
								<tr>
									<td>{{ __('Would like to learn about') }}</td>
									<td>{{ $user->postregistration->learn_itman }}</td>
								</tr>
								<tr>
									<td>{{ __('Soon implement') }}</td>
									<td>{{ $user->postregistration->tech_impl }}</td>
								</tr>
								<tr>
									<td>{{ __('Very new technologies to learn about') }}</td>
									<td>{{ $user->postregistration->new_tech }}</td>
								</tr>
								<tr>
									<td>{{ __('Can help the worship team') }}</td>
									<td>{{ $user->postregistration->help_worship }}</td>
								</tr>
								<tr>
									<td>{{ __('Speaker for devotions') }}</td>
									<td>{{ $user->postregistration->speakers }}</td>
								</tr>
								<tr>
									<td>{{ __('Organisational tasks') }}</td>
									<td>{{ $user->postregistration->help_iccm }}</td>
								</tr>
								<tr>
									<td>Ticket</td>
									<td>
										@if($user->postregistration->ticket_path)
											<a href="{{ route('postregistration.file', $user->postregistration->ticket_path)}}"><button type="button" class="btn btn-primary">Ticket</button></a>
										@endif
									</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
