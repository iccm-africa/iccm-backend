@extends('layouts.app')

@section('title')
{{ __('Post-registration') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<form method="POST" action="{{  action('PostRegistrationController@store') }}" enctype="multipart/form-data">
				
			<input type="hidden" name="mail_id" value="{{ $mail_id }}" />
            @csrf
				<div class="card">
                <div class="card-header">{{ __('Privacy') }}</div>

                <div class="card-body">

					<div class="alert alert-info">
							<b>Privacy notice:</b><br />
							At the conference, we will produce printed lists of attendants including your name (replaced by a nickname if you have entered one), e-mail, name of organisation and IT skills.<br />
							<br />
							If you do not wish to be included, please contact us by e-mail.<br />
							<br />
							We do not distribute this data in any digital form.
						</div>
				</div>
			</div>
            <div class="card mt-3">
                <div class="card-header">{{ __('Accommodation / Travel Questions') }}</div>

                <div class="card-body">
					<div class="form-group row">
                            <label for="share_acco" class="col-md-6 col-form-label text-md-left">
								{{ __("I would like to share accommodation with:") }}
							</label>
						
                            <div class="col-md-6">
								<input id="share_acco" type="text" class="form-control" name="share_acco" value="{{ old('share_acco') }}" autocomplete="share_acco" autofocus>
								@error('share_acco') 
								<div class="alert alert-danger" role="alert">
									{{ $message }} 
								</div>
								@enderror
							</div>
                    </div>
                </div>
                <div class="card-body">
					<div class="form-group row">
                            <label for="traveling" class="col-md-6 col-form-label text-md-left">
								{{ __("How will you be traveling to the conference:") }} *
							</label>
						
                            <div class="col-md-6">
								<div class="form-check form-check-inline">
  									<input class="form-check-input @error('traveling') is-invalid @enderror" type="radio" name="traveling" id="traveling" value="car">
								    <label class="form-check-label" for="traveling">{{ __('Car') }}</label>
								</div>
								<div class="form-check form-check-inline">
  									<input class="form-check-input @error('traveling') is-invalid @enderror" type="radio" name="traveling" id="traveling" value="air">
								    <label class="form-check-label" for="traveling">{{ __('Air') }}</label>
								</div>
								<div class="form-check form-check-inline">
  									<input class="form-check-input @error('traveling') is-invalid @enderror" type="radio" name="traveling" id="traveling" value="bus">
								    <label class="form-check-label" for="traveling">{{ __('Bus') }}</label>
								</div>
								<div class="form-check form-check-inline">
  									<input class="form-check-input @error('traveling') is-invalid @enderror" type="radio" name="traveling" id="traveling" value="other">
								    <label class="form-check-label" for="traveling">{{ __('Other') }}</label>
								</div>
								@error('traveling') 
								<div class="alert alert-danger" role="alert">
									{{ $message }} 
								</div>
								@enderror
                            </div>
                        </div>
					</div>
					<div class="card-body">
						<div class="form-group row">
                            <label for="share_travelplans" class="col-md-6 col-form-label text-md-left">
								{{ __("Please share your travel plans with us:") }}
							</label>
					
                            <div class="col-md-6">
								<textarea class="form-control" id="share_travelplans" name="share_travelplans" rows="3"></textarea>
								@error('share_travelplans') 
								<div class="alert alert-danger" role="alert">
									{{ $message }} 
								</div>
								@enderror
                            </div>
                        </div>
						<div class="form-group row">
                            <label for="ticket" class="col-md-6 col-form-label text-md-left">
								{{ __("Please upload your flight ticket here if you are paying on arrival:") }}
							</label>
					
                            <div class="col-md-6">
								<input type="file" name="ticket" id="ticket">
								@error('ticket') 
								<div class="alert alert-danger" role="alert">
									{{ $message }} 
								</div>
								@enderror
                            </div>
                        </div>
					</div>
		    </div>
		    <br/>
		    <div class="card">
                <div class="card-header">{{ __('In case of emergency') }}</div>

                <div class="card-body">
					<div class="form-group row">
						<label for="name" class="col-md-6 col-form-label text-md-left">{{ __('Contact Name') }} *</label>
							<div class="col-md-6">
								<input id="emergency_name" type="text" class="form-control" name="emergency_name" value="{{ old('emergency_name') }}" autocomplete="emergency_name" autofocus>
								@error('emergency_name') 
								<div class="alert alert-danger" role="alert">
									{{ $message }} 
								</div>
								@enderror
							</div>
                     </div>   
                     <div class="form-group row">
						<label for="emergency_phone" class="col-md-6 col-form-label text-md-left">{{ __('Full international contact phone number:') }} *</label>
							<div class="col-md-6">
								<input id="emergency_phone" type="text" class="form-control" name="emergency_phone" value="{{ old('emergency_phone') }}" autocomplete="emergency_phone" autofocus>
								@error('emergency_phone') 
								<div class="alert alert-danger" role="alert">
									{{ $message }} 
								</div>
								@enderror
							</div>
                     </div>   
                     <div class="form-group row">
						<label for="emergency_country" class="col-md-6 col-form-label text-md-left">{{ __('Contact Country:') }} *</label>
							<div class="col-md-6">
								<input id="emergency_country" type="text" class="form-control" name="emergency_country" value="{{ old('emergency_country') }}" autocomplete="emergency_country" autofocus>
								@error('emergency_country') 
								<div class="alert alert-danger" role="alert">
									{{ $message }} 
								</div>
								@enderror
							</div>
                     </div>       
                </div> 
		    </div>
		    <br/>
		    <div class="card">
                <div class="card-header">{{ __('Diet preferences / Special needs') }}</div>

                <div class="card-body">
					<div class="form-group row">
						<textarea class="form-control" id="dietprefs" name="dietprefs" rows="3"></textarea>
						@error('dietprefs') 
						<div class="alert alert-danger" role="alert">
							{{ $message }} 
						</div>
						@enderror
                     </div>       
                </div> 
		    </div>
		    <br/>
		    <div class="card">
                <div class="card-header">{{ __('ICCM Questions') }}</div>

                <div class="card-body">
					<div class="form-group row">
						<label for="shirtsize" class="col-md-6 col-form-label text-md-left">{{ __('Shirt Size') }} *</label>
							<div class="col-md-6">
								<select name="shirtsize">
								  <option value='S'>Small (S)</option>
								  <option value='M'>Medium (M)</option>
								  <option value='L' selected='selected'>Large (L)</option>
								  <option value='XL'>Extra Large (XL)</option>
								  <option value='XXL'>Extra Extra Large (XXL)</option>
								  <option value='XXXL'>Free Size (XXXL)</option>
								</select> 
								@error('shirtsize') 
									<div class="alert alert-danger" role="alert">
									{{ $message }} 
									</div>
								@enderror
							</div>
                     </div>   
                     <div class="form-group row">
						<label for="iccmelse" class="col-md-6 col-form-label text-md-left">{{ __('Have you ever visited an ICCM Conference elsewhere?:') }}</label>
							<div class="col-md-6">
								<div class="form-check form-check-inline">
									@error('iccmelse') 
										<div class="alert alert-danger" role="alert">
										{{ $message }} 
										</div>
									@enderror
  									<input class="form-check-input @error('iccmelse') is-invalid @enderror" type="radio" name="iccmelse" id="iccmelse" value="no">
								    <label class="form-check-label" for="traveling">{{ __('No') }}</label>
								</div>
								<div class="form-check form-check-inline">
  									<input class="form-check-input @error('iccmelse') is-invalid @enderror" type="radio" name="iccmelse" id="iccmelse" value="yes">
								    <label class="form-check-label" for="iccmelse">{{ __('Yes, my last ICCM was in (year):') }}</label>
								</div>
								
								    <input id="iccmelse_lastyear" type="text" class="form-control" name="iccmelse_lastyear" value="{{ old('iccmelse_lastyear') }}" autocomplete="iccmelse_lastyear" autofocus>
								    @error('iccmelse_lastyear') 
										<div class="alert alert-danger" role="alert">
										{{ $message }} 
										</div>
									@enderror
								    <label class="form-check-label" for="iccmlocation">{{ __('and located in:') }}</label>
								    <select name="iccmlocation">
										<option value='KENYA' selected='selected'>KENYA</option>
										<option value='BURKINA'>FASO</option>
										<option value='USA'>USA</option>
										<option value='EUROPE'>EUROPE</option>
										<option value='AUSTRALIA'>AUSTRALIA</option>
										<option value='ASIA'>ASIA</option>
										<option value='OTHER'>OTHER</option>
								    </select> 
								    @error('iccmlocation') 
										<div class="alert alert-danger" role="alert">
										{{ $message }} 
										</div>
									@enderror
								
							</div>
                     </div>   
                     <div class="form-group row">
						<label for="knowiccm" class="col-md-6 col-form-label text-md-left">
							{{ __('	
									How did you hear about ICCM-Africa?
									(From a website / ICCM USA / Friend / Leaflet / etc)
								 ') }} 
						</label>
							<div class="col-md-6">
								<textarea class="form-control" id="knowiccm" name="knowiccm" rows="3"></textarea>
								@error('knowiccm') 
									<div class="alert alert-danger" role="alert">
									{{ $message }} 
									</div>
								@enderror
							</div>
                     </div>       
                </div> 
		    </div>
		    <br/>
            <div class="card">
                <div class="card-header">{{ __('Can you help shape the conference?') }}</div>

                <div class="card-body">
				        
                        <div>
							<p class="h3">{{ __('Please help us shape this conference based on your preferences') }}</p>
							<p>
							{{ __("
								   We are organizing the tracks for the conference with leadership, web technology and general technology themes.\n
								   This will only cover a small part of the technology industry and how it can be used in mission. Time is given within\n
								   the programme for Birds of a Feather (as in \"flock together\") or BOF sessions. These allow us to have structured\n
								   time for as yet undefined topics depending on the needs of the attendees. By completing information in this\n
								   section, we can define some of these areas before the conference and get a better idea of what would be helpful\n
								   to you as attendees.
						    ") }}
							</p>
                        </div>

                        <div class="form-group row">
                            <label for="experince_itman" class="col-md-12 col-form-label text-md-center">
									<p>
									{{ __("
									Can you describe (with keywords)
									The IT and/or management areas you have some experience of:
									(e.g.: Web development, Training, Managing a Team, Open Source,
									Sharepoint, Programming , Security, Email systems, Networks, Ubuntu Linux)
									") }}
									</p>
									<p>
									<i>{{ __("Privacy exception 3A: This will be listed on the attendee list under 'Talents'") }}</i>
									</p>
							</label>
						</div>
						<div class="form-group row">
                            <div class="col-md-12">
								<textarea class="form-control" id="experince_itman" name="experince_itman" rows="3"></textarea>
								@error('experince_itman') 
									<div class="alert alert-danger" role="alert">
										{{ $message }} 
									</div>
								@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="expert_itman" class="col-md-12 col-form-label text-md-center">
								{{ __("
								Can you describe (with keywords)
								The IT and/or management areas you can consider yourself to be an expert in
								and maybe want to help train and educate others in:
								We use this answer to find workshop speakers.
								") }}
							</label>
						</div>
						<div class="form-group row">
                            <div class="col-md-12">
								<textarea class="form-control" id="expert_itman" name="expert_itman" rows="3"></textarea>
								@error('expert_itman') 
								<div class="alert alert-danger" role="alert">
									{{ $message }} 
								</div>
								@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="learn_itman" class="col-md-12 col-form-label text-md-center">
							<p>
							{{ __("
								Can you describe (with keywords)
								The IT and/or management areas you would like to learn about at ICCM-Africa:"
							) }}</p>
								<p><i>{{ __("Privacy exception 3B: This will be listed on the attendee list under 'Would like to learn about'") }}</i></p>
							</label>
						</div>
						<div class="form-group row">
                            <div class="col-md-12">
								<textarea class="form-control" id="learn_itman" name="learn_itman" rows="3"></textarea>
								@error('learn_itman') 
									<div class="alert alert-danger" role="alert">
										{{ $message }} 
									</div>
								@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tech_impl" class="col-md-12 col-form-label text-md-center">
								<p>{{ __("
								Can you describe (with keywords)
								Areas of IT Technology you plan to be implementing in the coming year:
								(e.g.: Mobile website, Office 365, Fiber optic networks, Tablet evangelism campain, Bluetooth literature-sharing server)
								") }}</p>
								<p><i>{{ __("
								Privacy exception 3C: This will be listed on the attendee list under 'Soon implement'
								") }}</p></i>
							</label>
						</div>
						<div class="form-group row">
                            <div class="col-md-12">
								<textarea class="form-control" id="tech_impl" name="tech_impl" rows="3"></textarea>
								@error('tech_impl') 
									<div class="alert alert-danger" role="alert">
										{{ $message }} 
									</div>
								@enderror
                            </div>
                        </div>
						<div class="form-group row">
                            <label for="new_tech" class="col-md-12 col-form-label text-md-center">
								{{ __("
									Can you describe (with keywords) 
									Very new technologies you have heard of that you would like to know more about:
									(e.g.: Mesh wifi networks, Windows 8.1, Cloud security)
								") }}</label>
						</div>
						<div class="form-group row">
                            <div class="col-md-12">
								<textarea class="form-control" id="new_tech" name="new_tech" rows="3"></textarea>
								@error('new_tech') 
									<div class="alert alert-danger" role="alert">
										{{ $message }} 
									</div>
								@enderror
                            </div>
                        </div>
						<div>
							<p class="h3">{{ __('Please help us on organisation the conference ') }}</p>
						    <p>
								{{ __("
								   The worship team at ICCM-Africa is made up of attendees. We have someone heading this up, but can you help? \n
								   If you take part regularly at your local church in worship, either as a musician, singer, projectionist or PA person,\n
								   then you could well become involved in making ICCM-Africa very special for reasons other than technology.\n
								   Please complete in the box below details of how you are prepared to help including any instruments\n
								   you can play or use (including your voice!)
						    ") }}
							</p>
                        </div> 
                        <div class="form-group row">
                            <label for="speakers" class="col-md-12 col-form-label text-md-center">{{ __('I can help the worship team by:') }}</label>
						</div>
						<div class="form-group row">
                            <div class="col-md-12">
								<textarea class="form-control" id="help_worship" name="help_worship" rows="3"></textarea>
								@error('help_worship') 
									<div class="alert alert-danger" role="alert">
										{{ $message }} 
									</div>
								@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-12 col-form-label text-md-center">
								{{ __("
									Do you preach sermons, give Bible studies etc?\n
									We are looking for speakers who can do short\n
									morning devotions. Would you like to do that?\n
									Please answer in this box:
								") }}
							</label>
						</div>
						<div class="form-group row">
                            <div class="col-md-12">
								<textarea class="form-control" id="speakers" name="speakers" rows="3"></textarea>
								@error('speakers') 
									<div class="alert alert-danger" role="alert">
										{{ $message }} 
									</div>
								@enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="help_iccm" class="col-md-12 col-form-label text-md-center">
								{{ __("
									If you have been to ICCM before, did you help with any organizational tasks? \n
									Would you like to help in similar areas? Please answer in this box:
								") }}
							</label>
						</div>
						<div class="form-group row">
                            <div class="col-md-12">
								<textarea class="form-control" id="speakers" name="help_iccm" rows="3"></textarea>
								@error('help_iccm') 
									<div class="alert alert-danger" role="alert">
										{{ $message }} 
									</div>
								@enderror
                            </div>
                        </div>
						
						
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
