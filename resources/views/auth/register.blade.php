@extends('layouts.app')

@section('title')
{{ __('Registration') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="@if($login) {{ route('register') }} @else {{ route('saveUser') }} @endif">
                        @csrf

						<div class="alert alert-info">
							<b>Privacy notice:</b><br />
							At the conference, we will produce printed lists of attendants including your name (replaced by a nickname if you enter one), e-mail, name of organisation and IT skills.<br />
							<br />
							If you do not wish to be included, please contact us by e-mail.<br />
							<br />
							We do not distribute this data in any digital form.
						</div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }} *</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }} *</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
	 
						<div class="form-group row">
                            <label for="nickname" class="col-md-4 col-form-label text-md-right">{{ __('Nickname') }}</label>

                            <div class="col-md-6">
                                <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ old('nickname') }}" autocomplete="nickname" autofocus>

                                @error('nickname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						
						<div class="form-group row">
						    <label for="passport" class="col-md-4 col-form-label text-md-right">{{ __('Name on Passport') }} *</label>
        					
							<div class="col-md-6">
                				<input id="passport" type="text" class="form-control @error('passport') is-invalid @enderror" name="passport" value="{{ old('passport') }}" required autocomplete="passport" autofocus>
                
                				@error('passport')
                        			<span class="invalid-feedback" role="alert">
                                		<strong>{{ $message }}</strong>
                        			</span>
                				@enderror
        					</div>
						</div>

						<div class="form-group row">
						    <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }} *</label>
        					
							<div class="col-md-6">
								<div class="form-check">
  									<input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender" value="m" {{ old('gender') == 'm'? 'checked' : '' }} required>
								    <label class="form-check-label" for="gender">{{ __('Male') }}</label>
								</div>
								<div class="form-check">
  									<input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gender" value="f" {{ old('gender') == 'f'? 'checked' : '' }} required>
								    <label class="form-check-label" for="gender">{{ __('Female') }}</label>
								</div>
                
                				@error('gender')
                        			<span class="invalid-feedback" role="alert">
                                		<strong>{{ $message }}</strong>
                        			</span>
                				@enderror
        					</div>
						</div>
						
						<div class="form-group row">
						    <label for="residence" class="col-md-4 col-form-label text-md-right">{{ __('Country of residence') }} *</label>
        					
							<div class="col-md-6">
                				<input id="residence" type="text" class="form-control @error('residence') is-invalid @enderror" name="residence" value="{{ old('residence') }}" required autocomplete="residence" autofocus>
                
                				@error('residence')
                        			<span class="invalid-feedback" role="alert">
                                		<strong>{{ $message }}</strong>
                        			</span>
                				@enderror
        					</div>
						</div>
						
						@if($login)
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Organisation') }} *</label>

                            <div class="col-md-6">
                                <input id="organisation" type="text" class="form-control @error('organisation') is-invalid @enderror" name="organisation" value="{{ old('organisation') }}" required autocomplete="name" autofocus><i>If you don't have an organisation, use your lastname</i>

                                @error('organisation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
						</div>

						<div class="form-group row">
                            <label for="website" class="col-md-4 col-form-label text-md-right">{{ __('Website') }}</label>

                            <div class="col-md-6">
                                <input id="website" type="text" class="form-control" name="website" value="{{ old('website') }}" autocomplete="website" autofocus>
                            </div>
						</div>
					
						<div class="form-group row">
						    <label for="orgtype" class="col-md-4 col-form-label text-md-right">{{ __('Organisation Type') }} *</label>
        					
							<div class="col-md-6">
								<div class="form-check">
  									<input class="form-check-input @error('orgtype') is-invalid @enderror" type="radio" name="orgtype" id="orgtype" value="mission" required {{ old('orgtype') == 'mission'? 'checked' : '' }}>
								    <label class="form-check-label" for="orgtype">{{ __('Mission') }}</label>
								</div>
								<div class="form-check">
  									<input class="form-check-input @error('orgtype') is-invalid @enderror" type="radio" name="orgtype" id="orgtype" value="church" required {{ old('orgtype') == 'church'? 'checked' : '' }}>
								    <label class="form-check-label" for="orgtype">{{ __('Church') }}</label>
								</div>
               					<div class="form-check">
  									<input class="form-check-input @error('orgtype') is-invalid @enderror" type="radio" name="orgtype" id="orgtype" value="education" required {{ old('orgtype') == 'education'? 'checked' : '' }}>
								    <label class="form-check-label" for="orgtype">{{ __('Education') }}</label>
								</div>	
               					<div class="form-check">
  									<input class="form-check-input @error('orgtype') is-invalid @enderror" type="radio" name="orgtype" id="orgtype" value="business" required {{ old('orgtype') == 'business'? 'checked' : '' }}>
								    <label class="form-check-label" for="orgtype">{{ __('Business') }}</label>
								</div>	
								<div class="form-check">
  									<input class="form-check-input @error('orgtype') is-invalid @enderror" type="radio" name="orgtype" id="orgtype" value="non-profit" required {{ old('orgtype') == 'non-profit'? 'checked' : '' }}>
								    <label class="form-check-label" for="orgtype">{{ __('Non-profit') }}</label>
								</div>
								<div class="form-check">
  									<input class="form-check-input @error('orgtype') is-invalid @enderror" type="radio" name="orgtype" id="orgtype" value="other" required {{ old('orgtype') == 'other'? 'checked' : '' }}>
								    <label class="form-check-label" for="orgtype">{{ __('Other, please specify') }}</label>	
                                    <input id="orgtypeother" type="text" class="form-control @error('orgtypeother') is-invalid @enderror" name="orgtypeother" value="{{ old('orgtypeother') }}" autocomplete="orgtypeother" autofocus>
								</div>

                				@error('orgtype')
                        			<span class="invalid-feedback" role="alert">
                                		<strong>{{ $message }}</strong>
                        			</span>
                				@enderror
        					</div>
						</div>
						

						<div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Billing Address') }} *</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="name" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
						</div>

						<div class="form-group row">
                            <label for="town" class="col-md-4 col-form-label text-md-right">{{ __('Town/City') }} *</label>

                            <div class="col-md-6">
                                <input id="town" type="text" class="form-control @error('town') is-invalid @enderror" name="town" value="{{ old('town') }}" required autocomplete="town" autofocus>

                                @error('town')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
						</div>

						<div class="form-group row">
                            <label for="state" class="col-md-4 col-form-label text-md-right">{{ __('Province/County/State') }}</label>

                            <div class="col-md-6">
                                <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" autocomplete="state" autofocus>

                                @error('town')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
						</div>

						<div class="form-group row">
                            <label for="zipcode" class="col-md-4 col-form-label text-md-right">{{ __('Postcode/Zip') }} *</label>

                            <div class="col-md-6">
                                <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode') }}" required autocomplete="zipcode" autofocus>

                                @error('zipcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
						</div>
						
						<div class="form-group row">
                            <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }} *</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" required autocomplete="country" autofocus>

                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
						</div>
						
						<div class="form-group row">
                            <label for="telephone" class="col-md-4 col-form-label text-md-right">{{ __('Telephone') }} *</label>

                            <div class="col-md-6">
                                <input id="telephone" type="text" class="form-control @error('country') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required autocomplete="telephone" autofocus>

                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
						</div>


						@else

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Organisation') }} *</label>
								<label class="col-md-6 col-form-label">{{ $organisation }}</label>
                        </div>

						@endif

                        <div class="form-group row">
							<label for="accommodation" class="col-md-4 col-form-label text-md-right">{{ __('Accommodation') }} *</label>
							
							<div class="col-md-8">
								<table class="table table-striped">
									<tbody>
										@foreach ($accommodations as $acc)
										<tr>
											<td>
												<div class="form-check-inline">
													<input type="radio" name="accommodation" value="{{ $acc->id }}" class="form-check-input @error('accommodation') is-invalid @enderror" required {{ old('accommodation') == $acc->id ? 'checked' : '' }}>
													<label class="form-check-label" for="accommodation">{{ $acc->name }}</label>
												</div>
												<br />
												<i>{{ $acc->description }}</i>
											</td>
											<td style="white-space:nowrap;" class="text-right">{{ $def->format($acc->cost) }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
                        </div>

                        <div class="form-group row">
							<label for="products" class="col-md-4 col-form-label text-md-right">{{ __('Additional products') }}</label>
							
							<div class="col-md-8">
								<table class="table table-striped">
									<tbody>
										@foreach ($products as $p)
											<tr>
												<td>
													<div class="form-check-inline">
														<input type="checkbox" name="product_{{ $p->id }}" id="product_{{ $p->id }}" class="form-check-input" {{ old('product_' . $p->id)? 'checked' : '' }}>
														<label class="form-check-label" for="product_{{ $p->id }}">{{ $p->name }}</label>
													</div>
													<br />
													<i>{{ $p->description }}</i>
												</td>
												<td style="white-space:nowrap;" class="text-right">{{ $def->format($p->cost) }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
                                @error('products')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }} *</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

						@if($login)
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }} *</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }} *</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
						@endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
