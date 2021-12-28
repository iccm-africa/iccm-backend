@extends('layouts.app')

@section('title')
Directions
@endsection

@section('content')

       
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">{{ __('Directions') }}</div>
						
						<div class="card-body">
							Below are the directions and Google link to where <b>ICCM-Africa</b> will be hosted at <b>BTL Christian International Centre.</b>
<br/><br/>
BTL-CICC is a serene hospitality establishment lying in coffee plantations in the outskirts of Ruiru town.  The conference centre is located 25 Km from Nairobi and 25 Km from Jomo Kenyatta International Airport along Ruiru-Kiambu Rd, 6km off Thika Super Highway and and 6km from Ruiru Town.
							<!--Google map-->
<div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 500px">
 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.0074902894003!2d36.91278291527265!3d-1.1551365991574278!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f3f2b2978a1bf%3A0xe2bf346c6a02fd9b!2sBTL%20Christian%20International%20Conference%20Centre!5e0!3m2!1sen!2snl!4v1573863704769!5m2!1sen!2snl" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
</div>

<!--Google Maps-->
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
