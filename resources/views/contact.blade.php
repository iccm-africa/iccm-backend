@extends('layouts.app')

@section('title')
Contact
@endsection

@section('content')

       
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">{{ __('Contact') }}</div>

						<div class="card-body">
							<p>
							If you have any questions, feel free to contact us at <a href="mailto:info@example.com"><i>Contact e-mail</i></a>
							</p>
							<br />
							<p>
							The ICCM-Africa Confrence is being hosted by <i>organiser</i> this year.
							</p>
							<p>
							You can contact <i>organiser</i> directly via:
							</p>
							<i>Name</i><br />
							<i>Address</i><br/>
							</p>
							<p>
							Email: <a href="mailto:info@example.com"><i>Contact e-mail</i></a>
							</p>
							<p>
							<i>legal text</i>
							</p>
							<p>
								<i>link to contact page</i>
							</P>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
