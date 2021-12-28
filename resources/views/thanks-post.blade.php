@extends('layouts.app')
@section('title')
{{ _('Thanks') }}
@endsection
@section('content')

       
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">{{ __('Thanks!') }}</div>

						<div class="card-body">
							<p>
							Thanks for your post registration information.
							</p>
							<p>
							If you like to edit your post registration form, you can click on the link in the email again.
							</p>

							If you have any questions, feel free to contact us at info@iccm-africa.org
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
