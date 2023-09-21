@extends($theme.'layouts.user')
@section('page_title',__('Profile'))

@push('extra_styles')
	<style>
		.user_banner_area {
			height: 260px;
			background: linear-gradient(rgb(28, 78, 178, 0.9), rgb(102, 145, 231, 0.9)), url({{ asset($themeTrue.'images/user_panel/profile/profile-bg.jpg') }});
		}
	</style>
@endpush

@section('content')
	<!-- main -->
	<div class="container-fluid">
		<div class="main row">
			<div class="col">
				<!-- profile setting -->
				<div class="profile-setting">
					<div class="row g-4">
						<div class="col-xxl-3 col-lg-4">
							<div class="sidebar-wrapper">
								<form method="post" action="{{ route('user.updateProfile') }}" enctype="multipart/form-data">
									@csrf
									<div class="profile">
										<div class="img  mx-auto">
											<img id="profile"
												 src="{{getFile($userProfile->driver,$userProfile->profile_picture) }}"
												 alt=""
												 class="img-fluid"/>
											<button class="upload-img">
												<i class="fal fa-camera"></i>
												<input class="form-control" accept="image/*" type="file"
													   onchange="previewImage('profile')"/>
											</button>
										</div>
										<div class="text">
											<h5 class="name">@lang(ucfirst($user->name))</h5>
											<span>@lang($user->username)</span>
										</div>
										<div class="btn_area">
											<button type="submit" class="cmn_btn">@lang('Update')</button>
										</div>
									</div>
								</form>

							</div>
						</div>
						<div class="col-xxl-9 col-lg-8">
							<div class="profile_card">
								<div class="profile-navigator">
									<button tab-id="tab1"
											class="tab {{ $errors->has('profile') ? 'active' : (($errors->has('password') || $errors->has('identity') || $errors->has('addressVerification')) ? '' : ' active') }}">
										<i class="fal fa-user"></i> @lang('Profile Information')
									</button>
									<button tab-id="tab2" class="tab {{ $errors->has('password') ? 'active' : '' }}">
										<i class="fal fa-key"></i> @lang('Password Setting')
									</button>
									@if($basic->identity_verification == 1)
										<button tab-id="tab3"
												class="tab {{ $errors->has('identity') ? 'active' : '' }}">
											<i class="fal fa-id-card"></i> @lang('Identity Verification')
										</button>
									@endif

									@if($basic->address_verification == 1)
										<button tab-id="tab4"
												class="tab {{ $errors->has('addressVerification') ? 'active' : '' }}">
											<i class="fal fa-map-marked-alt"></i>
											@lang('Address Verification')
										</button>
									@endif
								</div>

								<div id="tab1"
									 class="content {{ $errors->has('profile') ? ' active' : (($errors->has('password') || $errors->has('identity') || $errors->has('addressVerification')) ? '' :  ' active') }}">
									<form action="{{ route('user.updateInformation')}}" method="post">
										@method('put')
										@csrf
										<div class="row g-4">
											<div class="input-box col-md-12">
												<label for="">@lang('Full Name')</label>
												<input type="text" class="form-control" name="name"
													   placeholder="@lang('full name')"
													   value="{{ old('name', $user->name) }}"/>
												@if($errors->has('name'))
													<div
														class="error text-danger">@lang($errors->first('name'))
													</div>
												@endif
											</div>

											<div class="input-box col-md-6">
												<label for="">@lang('Username')</label>
												<input type="text" class="form-control" id="username"
													   name="username"
													   placeholder="@lang('username')"
													   value="{{ old('username', $user->username) }}"/>
												@if($errors->has('username'))
													<div
														class="error text-danger">@lang($errors->first('username'))
													</div>
												@endif
											</div>

											<div class="input-box col-md-6">
												<label for="">@lang('Email')</label>
												<input class="form-control" type="email"
													   id="email"
													   name="email"
													   placeholder="@lang('email')"
													   value="{{ old('email', $user->email) }}"/>
												@if($errors->has('email'))
													<div
														class="error text-danger">@lang($errors->first('email'))
													</div>
												@endif
											</div>
											<div class="input-box col-md-6">
												<label for="">@lang('Phone')</label>
												<input type="text" class="form-control"
													   id="phone"
													   name="phone"
													   placeholder="@lang('phone')"
													   value="{{ old('phone', $userProfile->phone) }}"/>
												@if($errors->has('phone'))
													<div
														class="error text-danger">@lang($errors->first('phone'))
													</div>
												@endif
											</div>
											<div class="input-box col-md-6">
												<label for="language_id">@lang('Preferred Language')</label>
												<select class="form-select" aria-label="Default select example"
														name="language_id"
														id="language_id">
													<option selected disabled>@lang('select language')</option>
													@foreach($languages as $la)
														<option
															value="{{$la->id}}" {{ old('language_id', $user->language_id) == $la->id ? 'selected' : '' }}> @lang($la->name)</option>
													@endforeach
												</select>
												@if($errors->has('language_id'))
													<div
														class="error text-danger">@lang($errors->first('language_id'))
													</div>
												@endif
											</div>

											<div class="input-box col-12">
												<label for="">@lang('Address')</label>
												<textarea class="form-control @error('address') is-invalid @enderror"
														  id="address"
														  name="address"
														  type="text"
														  placeholder="@lang('address')"
														  value="{{ old('address', $userProfile->address) }}">{{ old('address', $userProfile->address) }}</textarea>
												@if($errors->has('address'))
													<div
														class="error text-danger">@lang($errors->first('address'))
													</div>
												@endif
											</div>
											<div class="input-box col-12">
												<button class="cmn_btn">@lang('Update')</button>
											</div>
										</div>
									</form>
								</div>
								<div id="tab2" class="content">
									<form method="post" action="{{ route('user.updatePassword') }}">
										@csrf
										<div class="row g-4">
											<div class="input-box col-md-6">
												<label for="">@lang('Current Password')</label>
												<input type="password"
													   id="current_password"
													   name="current_password"
													   autocomplete="off"
													   class="form-control"
													   placeholder="@lang('Enter Current Password')"/>
												@if($errors->has('current_password'))
													<div
														class="error text-danger">@lang($errors->first('current_password'))</div>
												@endif
											</div>
											<div class="input-box col-md-6">
												<label for="">@lang('New Password')</label>
												<input type="password"
													   id="password"
													   name="password"
													   autocomplete="off"
													   class="form-control"
													   placeholder="@lang('Enter New Password')"/>
												@if($errors->has('password'))
													<div
														class="error text-danger">@lang($errors->first('password'))</div>
												@endif
											</div>
											<div class="input-box col-md-6">
												<label for="password_confirmation">@lang('Confirm Password')</label>
												<input type="password"
													   id="password_confirmation"
													   name="password_confirmation"
													   autocomplete="off"
													   class="form-control"
													   placeholder="@lang('Confirm Password')"/>
												@if($errors->has('password_confirmation'))
													<div
														class="error text-danger">@lang($errors->first('password_confirmation'))</div>
												@endif
											</div>
											<div class="input-box col-12">
												<button class="cmn_btn">@lang('Update Password')</button>
											</div>
										</div>
									</form>
								</div>

								<div id="tab3" class="content {{ $errors->has('identity') ? 'active' : '' }}">
									@if(in_array($user->identity_verify,[0,3]))
										@if($user->identity_verify == 3)
											<div class="alert mb-0">
												<i class="fal fa-times-circle"></i>
												<span>@lang('Your previous request has been rejected')</span>
											</div>
										@endif
										<form method="post" action="{{route('user.verificationSubmit')}}"
											  enctype="multipart/form-data">
											@csrf
											<div class="col-md-12 mb-3">
												<div class="input-box col-md-12">
													<label for="identity_type">@lang('Identity Type')</label>
													<select class="form-select"
															name="identity_type" id="identity_type"
															aria-label="Default select example">
														<option value="" disabled>@lang('Select Language')</option>
														@foreach($identityFormList as $sForm)
															<option
																value="{{$sForm->slug}}" {{ old('identity_type', @$identity_type) == $sForm->slug ? 'selected' : '' }}> @lang($sForm->name) </option>
														@endforeach
													</select>
													@error('identity_type')
													<div class="error text-danger">@lang($message) </div>
													@enderror
												</div>
											</div>

											@if(isset($identityForm))
												@foreach($identityForm->services_form as $k => $v)
													@if($v->type == "text")
														<div class="input-box col-md-12">
															<label for="{{$k}}">
																{{trans($v->field_level)}}
																@if($v->validation == 'required')
																	<span class="text-danger">*</span>
																@endif
															</label>
															<input type="text" name="{{$k}}"
																   class="form-control "
																   value="{{old($k)}}" id="{{$k}}"
																   @if($v->validation == 'required') required @endif/>
															@if($errors->has($k))
																<div
																	class="error text-danger">@lang($errors->first($k))</div>
															@endif
														</div>

													@elseif($v->type == "textarea")
														<div class="input-box col-12 mt-2">
															<label for="{{$k}}">
																{{trans($v->field_level)}}
																@if($v->validation == 'required')
																	<span class="text-danger">*</span>
																@endif
															</label>
															<textarea
																name="{{$k}}"
																id="{{$k}}"
																class="form-control"
																cols="30"
																rows="3"
																placeholder="{{trans('Type Here')}}"
                                                            @if($v->validation == 'required')@endif>{{old($k)}}</textarea>
															@error($k)
															<div class="error text-danger">
																{{trans($message)}}
															</div>
															@enderror
														</div>
													@elseif($v->type == "file")
														<div class="col-md-12 mb-2">
															<div class="form-group">
																<label class="golden-text">
																	{{trans($v->field_level)}}
																	@if($v->validation == 'required')
																		<span class="text-danger">*</span>
																	@endif
																</label>

																<br>
																<div class="fileinput fileinput-new "
																	 data-provides="fileinput">
																	<div class="fileinput-new thumbnail "
																		 data-trigger="fileinput">
																		<img class="custom-verification-img"
																			 src="{{ getFile(config('location.default')) }}"
																			 alt="@lang('not found')"
																			 style="width: 200px">
																	</div>
																	<div
																		class="fileinput-preview fileinput-exists thumbnail wh-200-150 ">
																	</div>

																	<div class="img-input-div">
                                                                    <span class="btn btn-success btn-file">
                                                                        <span
																			class="fileinput-new"> @lang('Select') {{$v->field_level}}</span>
                                                                        <span
																			class="fileinput-exists"> @lang('Change')</span>
                                                                        <input type="file" name="{{$k}}"
																			   value="{{ old($k) }}"
																			   accept="image/*" @if($v->validation == "required")@endif>
                                                                    </span>
																		<a href="#"
																		   class="btn btn-danger fileinput-exists"
																		   data-dismiss="fileinput"> @lang('Remove')</a>
																	</div>
																</div>

																@error($k)
																<div class="error text-danger">
																	{{trans($message)}}
																</div>
																@enderror
															</div>
														</div>
													@endif
												@endforeach

												<button type="submit" class="gold-btn mt-2 cmn_btn">
													@lang('Submit')
												</button>
											@endif
										</form>
									@elseif($user->identity_verify == 1)
										<div class="alert mb-0">
											<i class="fal fa-times-circle"></i>
											<span> @lang('Your KYC submission has been pending')</span>
										</div>
									@elseif($user->identity_verify == 2)
										<div class="alert mb-0">
											<i class="fal fa-check-circle"></i>
											<span> @lang('Your KYC already verified')</span>
										</div>
									@endif
								</div>

								<div id="tab4"
									 class="content {{ $errors->has('addressVerification') ? 'active' : '' }}">
									@if(in_array($user->address_verify,[0,3])  )
										@if($user->address_verify == 3)
											<div class="alert mb-0">
												<i class="fal fa-times-circle"></i>
												<span> @lang('You previous request has been rejected')</span>
											</div>
										@endif


										<form method="post" action="{{route('user.addressVerification')}}"
											  enctype="multipart/form-data">
											@csrf
											<div class="col-md-12 mb-2">
												<div class="form-group">
													<label class="form-label golden-text">{{trans('Address Proof')}}
														<span
															class="text-danger">*</span> </label><br>

													<div class="fileinput fileinput-new "
														 data-provides="fileinput">
														<div class="fileinput-new thumbnail "
															 data-trigger="fileinput">
															<img class="custom-verification-img"
																 src="{{ getFile(config('location.default')) }}"
																 alt="..." style="height: 200px">
														</div>
														<div
															class="fileinput-preview fileinput-exists thumbnail wh-200-150 "></div>

														<div class="img-input-div">
                                                        <span class="btn btn-success btn-file">
                                                            <span
																class="fileinput-new "> @lang('Select Image') </span>
                                                            <span
																class="fileinput-exists"> @lang('Change')</span>
                                                            <input type="file" name="addressProof"
																   value="{{ old('addressProof')}}"
																   accept="image/*">
                                                        </span>
															<a href="#" class="btn btn-danger fileinput-exists"
															   data-dismiss="fileinput"> @lang('Remove')</a>
														</div>

													</div>

													@error('addressProof')
													<div class="error text-danger">
														{{trans($message)}}
													</div>
													@enderror
												</div>
											</div>

											<button type="submit" class="gold-btn cmn_btn">
												@lang('Submit')
											</button>

										</form>

									@elseif($user->address_verify == 1)
										<div class="alert mb-0">
											<i class="fal fa-times-circle"></i>
											<span> @lang('Your KYC submission has been pending')</span>
										</div>
									@elseif($user->address_verify == 2)
										<div class="alert mb-0">
											<i class="fal fa-check-circle"></i>
											<span> @lang('Your KYC already verified')</span>
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('css-lib')
	<link rel="stylesheet" href="{{asset($themeTrue.'css/bootstrap-fileinput.css')}}">
@endpush

@section('scripts')
	<script src="{{asset($themeTrue.'js/bootstrap-fileinput.js')}}"></script>
	<script>
		'use strict'
		$(document).on('change', "#identity_type", function () {
			let value = $(this).find('option:selected').val();
			window.location.href = "{{route('user.profile')}}/?identity_type=" + value
		});
	</script>
@endsection
