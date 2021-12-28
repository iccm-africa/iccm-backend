@extends('layouts.app')

@section('title')
Welcome
@endsection

@section('content')

       
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">{{ __('Welcome') }}</div>

						<div class="card-body">
							<div class="alert alert-primary" role="alert">
							<b>Sorry, we are still working on this website (layout, content and system).<br/>
							However the registration is open!
							</b>
							</div>

							<p>
							The International Conference on Computing and Mission (ICCM) is an annual informal (NO ties allowed ;-) ) gathering of women and men who have a common interest in computers and mission. We share a vision of cooperation for effective use of technology, bringing the Gospel to every nation.
							</p>
							<b>ICCM Africa, Nairobi Kenya
							ICCM Africa March 18-21, 2020 – Wed – Sat
							LOCATION:  BTL Christan International Conference Centre
							Ruiru, Kenya (25 km from Jomo Kenyatta International Airport)</b>
							<br/><br/>
							<center><a href="{{ route('registration') }}"><button type="button" class="btn btn-success">Register for ICCM-Africa 2020</button></a></center>
<br/><br/> <img src="{{ asset('img/iccm_meeting.jpg') }}"  class="img-thumbnail">
							<br/>
							<br/>
							<h2>Other ICCM's world wide</h2>
							<ul>
							<li><a href="https://fr.iccm.org/" target="_blank">Conférence Internationale sur L’informatique et la Mission </a>
							CILM – April 29-02 May, 2020, Yaounde, Cameroon</li>
							<li><a href="http://iccm-australia.org/" target="_blank">ICCM Australia</a> - Dates and Location later </li>
							<li><a href="https://asia.iccm.org" target="_blank">ICCM Asia</a> - 14 – 17 November 2019, Baptist Camp, Pattaya, Thailand</li>
							<li><a href="https://iccm-europe.org/" target="_blank">ICCM Europe</a> - 5 – 8 February, 2020,  Burbach-Holzhausen, Germany</li>
							<li><a href="https://iccm.org/" target="_blank">ICCM Americas</a> - June 26-29, 2019 - Hannibal LaGrange, Hannibal MO, </li>
							</ul>
							<b>The relationships you build and renew at ICCM will carry far beyond the conference!</b>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
