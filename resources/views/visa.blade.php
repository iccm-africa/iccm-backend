@extends('layouts.app')

@section('title')
Visa information
@endsection

@section('content')

       
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">{{ __('VISA') }}</div>
						
						<div class="card-body">
							Participants from outside Kenya usually need to request an eVisa to enter the country.
							For more information, see: <a href="http://evisa.go.ke/evisa.html">http://evisa.go.ke/evisa.html</a>.<br />
							<br />
							To register a eVisa account, please visit this link: <a href="https://accounts.ecitizen.go.ke/register">https://accounts.ecitizen.go.ke/register</a>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
