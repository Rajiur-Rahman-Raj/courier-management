<!-- sidebar -->
<div id="sidebar" class="">
	<div class="sidebar-top">
		<a class="navbar-brand" href="{{url('/')}}"> <img src="{{ getFile(config('basic.default_file_driver'),config('basic.logo_image')) }}" alt="@lang('logo image')" /></a>
		<button class="sidebar-toggler d-md-none" onclick="toggleSideMenu()">
			<i class="fal fa-times"></i>
		</button>
	</div>

	<div class="search_area">
		<input type="text" class="form-control" placeholder="Tracking number">
		<div class="icon_area">
			<i class="far fa-search"></i>
		</div>

	</div>
	<ul class="main">
		<li>
			<a class="{{menuActive('user.dashboard')}}" href="{{route('user.dashboard')}}"><i class="fal fa-th-large"></i>@lang('Dashboard')</a>
		</li>
		<li>
			<a href="edit_profile.html"><i class="fal fa-user-edit"></i>Edit Profile</a>
		</li>

		<li>
			<a class="dropdown-toggle" data-bs-toggle="collapse" href="#dropdownCollapsible" role="button"
			   aria-expanded="false" aria-controls="collapseExample">
				<i class="fal fa-sign-out-alt"></i>Dropdown
			</a>
			<div class="collapse" id="dropdownCollapsible">
				<ul class="">
					<li>
						<a href="#"><i class="fal fa-th-large"></i>Dropdown 1</a>
					</li>
					<li>
						<a href="#"><i class="fal fa-th-large"></i>Dropdown 2</a>
					</li>
					<li>
						<a href="#"><i class="fal fa-th-large"></i>Dropdown 3</a>
					</li>
				</ul>
			</div>
		</li>
	</ul>
</div>
