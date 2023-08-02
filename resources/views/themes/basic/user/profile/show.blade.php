@extends($theme.'layouts.user')
@section('page_title',__('Profile'))

@push('extra_styles')
	<style>
		.user_banner_area{
			height: 260px;
			background: linear-gradient(rgb(28, 78, 178,0.9),rgb(102, 145, 231,0.9)), url({{ asset($themeTrue.'images/user_panel/profile/profile-bg.jpg') }});
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
								<div class="profile">
									<div class="img  mx-auto">
										<img id="profile" src="{{ asset($themeTrue.'images/user_panel/profile/profile.jpg') }}" alt=""
											 class="img-fluid" />
										<button class="upload-img">
											<i class="fal fa-camera"></i>
											<input class="form-control" accept="image/*" type="file"
												   onchange="previewImage('profile')" />
										</button>
									</div>
									<div class="text">
										<h5 class="name">Adam Gill</h5>
										<span>Businessman</span>
									</div>
									<div class="btn_area">
										<a href="" class="cmn_btn">Update</a>
									</div>
								</div>
								<div class="profile_portfolio mt-30">
									<div class="d-flex align-items-center mb-4 justify-content-between">
										<div>
											<h5 class="card-title mb-0">Portfolio</h5>
										</div>
										<div>
											<a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="fal fa-plus"></i> Add</a>
										</div>
									</div>
									<div class="mb-3 d-flex align-items-center">
										<div class="avatar-xs d-block flex-shrink-0 me-3">
                                                        <span class="avatar-title rounded-circle fs-16 bg-dark text-light">
                                                            <i class="fab fa-github"></i>
                                                        </span>
										</div>
										<input type="email" class="form-control" id="gitUsername" placeholder="Username" value="@daveadame" />
									</div>
									<div class="mb-3 d-flex align-items-center">
										<div class="avatar-xs d-block flex-shrink-0 me-3">
                                                        <span class="avatar-title rounded-circle fs-16 bg-primary">
                                                            <i class="fal fa-globe"></i>
                                                        </span>
										</div>
										<input type="text" class="form-control" id="websiteInput" placeholder="www.example.com"
											   value="www.velzon.com" />
									</div>
									<div class="mb-3 d-flex align-items-center">
										<div class="avatar-xs d-block flex-shrink-0 me-3">
                                                        <span class="avatar-title rounded-circle fs-16 bg-success">
                                                            <i class="fab fa-dribbble"></i>
                                                        </span>
										</div>
										<input type="text" class="form-control" id="dribbleName" placeholder="Username" value="@dave_adame" />
									</div>
									<div class="d-flex">
										<div class="avatar-xs d-block flex-shrink-0 me-3">
                                                        <span class="avatar-title rounded-circle fs-16 bg-danger">
                                                            <i class="fab fa-pinterest"></i>
                                                        </span>
										</div>
										<input type="text" class="form-control" id="pinterestName" placeholder="Username" value="Advance Dave" />
									</div>
								</div>
							</div>
						</div>
						<div class="col-xxl-9 col-lg-8">
							<div class="profile_card">
								<div class="profile-navigator">
									<button tab-id="tab1" class="tab active">
										<i class="fal fa-user"></i> Profile information
									</button>
									<button tab-id="tab2" class="tab">
										<i class="fal fa-key"></i> Password setting
									</button>
									<button tab-id="tab3" class="tab">
										<i class="fal fa-id-card"></i> identity verification
									</button>
									<button tab-id="tab4" class="tab">
										<i class="fal fa-map-marked-alt"></i>
										address verification
									</button>
								</div>
								<div id="tab1" class="content active">
									<form action="">
										<div class="row g-4">
											<div class="input-box col-md-6">
												<label for="">First name</label>
												<input type="text" class="form-control" placeholder="Mr. John" />
											</div>
											<div class="input-box col-md-6">
												<label for="">last name</label>
												<input type="text" class="form-control" placeholder="Doe" />
											</div>
											<div class="input-box col-md-6">
												<label for="">username</label>
												<input type="text" class="form-control" placeholder="johndoe" />
											</div>
											<div class="input-box col-md-6">
												<label for="">email address</label>
												<input type="email" class="form-control"
													   placeholder="example@gmail.com" />
											</div>
											<div class="input-box col-md-6">
												<label for="">phone number</label>
												<input type="text" class="form-control" placeholder="01234567891" />
											</div>
											<div class="input-box col-md-6">
												<label for="">preferred language</label>
												<select class="form-select" aria-label="Default select example">
													<option selected>select language</option>
													<option value="1">English</option>
													<option value="2">spanish</option>
													<option value="3">french</option>
												</select>
											</div>
											<div class="input-box col-12">
												<label for="">select file</label>
												<div class="attach-file">
													<span class="prev"> choose file </span>
													<input class="form-control" accept="image/*" type="file" />
												</div>
											</div>
											<div class="input-box col-12">
												<label for="">address</label>
												<textarea class="form-control" cols="30" rows="3"
														  placeholder="457 MORNINGVIEW, NEW YORK USA"></textarea>
											</div>
											<div class="input-box col-12">
												<button class="cmn_btn">submit</button>
											</div>
										</div>
									</form>
								</div>
								<div id="tab2" class="content">
									<form action="">
										<div class="row g-4">
											<div class="input-box col-md-6">
												<label for="">Current Password</label>
												<input type="password" class="form-control" placeholder="" />
											</div>
											<div class="input-box col-md-6">
												<label for="">New Password</label>
												<input type="password" class="form-control" placeholder="" />
											</div>
											<div class="input-box col-md-6">
												<label for="">Confirm Password</label>
												<input type="password" class="form-control" placeholder="" />
											</div>
											<div class="input-box col-12">
												<button class="cmn_btn">change password</button>
											</div>
										</div>
									</form>
								</div>
								<div id="tab3" class="content">
									<div class="alert mb-0">
										<i class="fal fa-times-circle"></i>
										<span>Your address is not verified</span>
									</div>
								</div>
								<div id="tab4" class="content">
									<div class="alert mb-0">
										<i class="fal fa-check-circle"></i>
										<span>Your identity already verified</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('extra_scripts')
@endpush

@section('scripts')
@endsection
