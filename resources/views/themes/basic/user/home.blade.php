@extends($theme.'layouts.user')
@section('page_title',__('Dashboard'))

@push('extra_styles')

@endpush

@section('content')
	<!-- main -->
	<div class="container-fluid">
		<div class="main row">
			<div class="col-12">
				<div class="d-flex justify-content-between align-items-center">
					<h2 class="mb-0">Dashboard</h2>
					<div class="btn_area">
						<button class="cmn_btn">Button</button>
					</div>
				</div>

				<div class="dashboard-box-wrapper mt-20">
					<div class="row g-4 mb-4">
						<div class="col-xxl-3 col-md-6 box">
							<div class="dashboard-box d-flex justify-content-between">
								<div class="text_area">
									<h5>Outcome Percels</h5>
									<h3>48</h3>
									<span><strong class="color_success"><i class="fal fa-long-arrow-up small_icon color_success"></i> 25.36%</strong> Since last month</span>
								</div>
								<div class="icon_area">
									<i class="fal fa-arrow-circle-left"></i>
								</div>
							</div>
						</div>
						<div class="col-xxl-3 col-md-6 box">
							<div class="dashboard-box d-flex justify-content-between">

								<div class="text_area">
									<h5>Income Percels</h5>
									<h3>12</h3>
									<span><strong class="color_success"><i class="fal fa-long-arrow-up small_icon color_success"></i> 25.36%</strong> Since last month</span>
								</div>
								<div class="icon_area">
									<i class="fal fa-arrow-circle-right"></i>
								</div>
							</div>
						</div>
						<div class="col-xxl-3 col-md-6 box">
							<div class="dashboard-box d-flex justify-content-between">

								<div class="text_area">
									<h5>Bonus Point</h5>
									<h3>30</h3>
									<span><strong class="color_success"><i class="fal fa-long-arrow-up small_icon color_success"></i> 25.36%</strong> Since last month</span>
								</div>
								<div class="icon_area">
									<i class="fal fa-atom"></i>
								</div>
							</div>
						</div>
						<div class="col-xxl-3 col-md-6 box">
							<div class="dashboard-box d-flex justify-content-between">

								<div class="text_area">
									<h5>Total Delivery</h5>
									<h3>30</h3>
									<span><strong class="color_success"><i class="fal fa-long-arrow-up small_icon color_success"></i> 25.36%</strong> Since last month</span>
								</div>
								<div class="icon_area">
									<i class="fal fa-truck"></i>
								</div>
							</div>
						</div>
					</div>
				</div>



				<!-- table -->
				<div class="table-parent table-responsive">
					<table class="table table-striped">
						<thead>
						<tr>
							<th scope="col">SL No.</th>
							<th scope="col">Date</th>
							<th scope="col">Status</th>
							<th scope="col">Delivery</th>
							<th scope="col">Tracking Number</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td data-label="SL No.">1</td>
							<td data-label="Date">
                                                <span class="">
                                                    22 April - 24 April
                                                </span>
							</td>
							<td data-label="Status">
                                                <span class="badge text-bg-primary">
                                                    In Delivery
                                                </span>
							</td>
							<td data-label="Delivery">Dhl</td>
							<td data-label="Tracking Number">PR1852454</td>
						</tr>
						<tr>
							<td data-label="SL No.">2</td>
							<td data-label="Date">
                                                <span class="currency">
                                                    22 April - 24 April
                                                </span>
							</td>
							<td data-label="Status">
                                                <span class="badge text-bg-secondary">
                                                    Delivering
                                                </span>
							</td>
							<td data-label="Delivery">Dhl</td>
							<td data-label="Tracking Number">PR1852454</td>
						</tr>
						<tr>
							<td data-label="SL No.">3</td>
							<td data-label="Date">
                                                <span class="currency">
                                                    22 April - 24 April
                                                </span>
							</td>
							<td data-label="Status">
                                                <span class="badge text-bg-success">
                                                    Deliverd
                                                </span>
							</td>
							<td data-label="Delivery">Ups</td>
							<td data-label="Tracking Number">PR6545651852454</td>
						</tr>
						<tr>
							<td data-label="SL No.">4</td>
							<td data-label="Date">
                                                <span class="currency">
                                                    22 April - 24 April
                                                </span>
							</td>
							<td data-label="Status">
                                                <span class="badge text-bg-danger">
                                                    Deliverd
                                                </span>
							</td>
							<td data-label="Delivery">Amazon</td>
							<td data-label="Tracking Number">PR1852454</td>
						</tr>
						<tr>
							<td data-label="SL No.">4</td>
							<td data-label="Date">
                                                <span class="currency">
                                                    22 April - 24 April
                                                </span>
							</td>
							<td data-label="Status">
                                                <span class="badge text-bg-warning">
                                                    Deliverd
                                                </span>
							</td>
							<td data-label="Delivery">Amazon</td>
							<td data-label="Tracking Number">PR1852454</td>
						</tr>
						<tr>
							<td data-label="SL No.">4</td>
							<td data-label="Date">
                                                <span class="currency">
                                                    22 April - 24 April
                                                </span>
							</td>
							<td data-label="Status">
                                                <span class="badge text-bg-info">
                                                    Deliverd
                                                </span>
							</td>
							<td data-label="Delivery">Amazon</td>
							<td data-label="Tracking Number">PR1852454</td>
						</tr>


						</tbody>
					</table>
				</div>
				<div class="pagination_area pt-50 pb-50">
					<nav aria-label="...">
						<ul class="pagination justify-content-center">
							<li class="page-item">
								<a class="page-link" href="#"><i class="far fa-long-arrow-left"></i></a>
							</li>
							<li class="page-item"><a class="page-link" href="#">1</a></li>
							<li class="page-item active" aria-current="page">
								<a class="page-link" href="#">2</a>
							</li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item"><a class="page-link" href="#">4</a></li>
							<li class="page-item"><a class="page-link" href="#">5</a></li>
							<li class="page-item">
								<a class="page-link" href="#"><i class="far fa-long-arrow-right"></i></a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('extra_scripts')

@endpush

@section('scripts')

@endsection
