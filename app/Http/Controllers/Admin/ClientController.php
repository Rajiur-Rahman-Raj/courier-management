<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Branch;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Models\UserProfile;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class ClientController extends Controller
{
	use Upload, Notify;

//	public function clientList(Request $request)
//	{
//		$authenticateUser = Auth::user();
////		$branchId = $authenticateUser->role_id != null ? optional($authenticateUser->branch)->branch_id : null;
//		$branchId = null;
//		if ($authenticateUser->role_id == null){
//			$branchId = null;
//		}
//		if ($authenticateUser->role_id != null && $authenticateUser->branch != null) {
//			$branchId = optional($authenticateUser->branch)->branch_id;
//		}elseif ($authenticateUser->role_id != null && $authenticateUser->branch == null){
//			$branchId = 0;
//		}
//
//		$search = $request->all();
//		$data['allClients'] = User::with('profile')->whereIn('user_type', [1, 2])
//			->when($branchId != null && $authenticateUser->branch != null && $branchId != 0, function ($query) use ($branchId) {
//				return $query->whereHas('profile', function ($q) use ($branchId) {
//					$q->where('branch_id', $branchId);
//				});
//			})
//			->when($branchId == 0, function ($query) use($branchId){
//
//			})
//
//			->when(isset($search['name']), function ($query) use ($search) {
//				return $query->whereRaw("name REGEXP '[[:<:]]{$search['name']}[[:>:]]'");
//			})
//			->when(isset($search['phone']), function ($q) use ($search) {
//				return $q->where('phone', $search['phone']);
//			})
//			->when(isset($search['email']), function ($q2) use ($search) {
//				return $q2->where('email', $search['email']);
//			})
//			->when(isset($search['client_type']) && $search['client_type'] == 1, function ($q3) use ($search) {
//				return $q3->where('user_type', 1);
//			})
//			->when(isset($search['client_type']) && $search['client_type'] == '2', function ($q4) use ($search) {
//				return $q4->where('user_type', 2);
//			})
//			->when(isset($search['status']) && $search['status'] == 'active', function ($q3) use ($search) {
//				return $q3->where('status', 1);
//			})
//			->when(isset($search['status']) && $search['status'] == 'deactive', function ($q4) use ($search) {
//				return $q4->where('status', 0);
//			})
//			->limit(0)->get();
////			->latest()->paginate(config('basic.paginate'));
//		dd($data['allClients']);
//		return view('admin.clients.index', $data);
//	}


	public function clientList(Request $request)
	{
		$authenticateUser = Auth::guard('admin')->user();
		$branchId = null;
		if ($authenticateUser->role_id == null) {
			$branchId = null;
		}
		if ($authenticateUser->role_id != null && $authenticateUser->branch != null) {
			$branchId = optional($authenticateUser->branch)->branch_id;
		} elseif ($authenticateUser->role_id != null && $authenticateUser->branch == null) {
			$branchId = 'not-assign';
		}

		$search = $request->all();

		$query = User::with('profile', 'branch')->whereIn('user_type', [1, 2])
			->when($branchId != null && $authenticateUser->branch != null && $branchId != 0, function ($query) use ($branchId) {
				return $query->whereHas('profile', function ($q) use ($branchId) {
					$q->where('branch_id', $branchId);
				});
			});

		// Apply other search conditions
		if (isset($search['name'])) {
			$query->whereRaw("name REGEXP '[[:<:]]{$search['name']}[[:>:]]'");
		}

		if (isset($search['phone'])) {
			$query->where('phone', $search['phone']);
		}

		if (isset($search['email'])) {
			$query->where('email', $search['email']);
		}

		if (isset($search['client_type']) && $search['client_type'] == 1) {
			$query->where('user_type', 1);
		} elseif (isset($search['client_type']) && $search['client_type'] == '2') {
			$query->where('user_type', 2);
		}

		if (isset($search['status']) && $search['status'] == 'active') {
			$query->where('status', 1);
		} elseif (isset($search['status']) && $search['status'] == 'deactive') {
			$query->where('status', 0);
		}

		if ($branchId == 'not-assign' && $branchId != null) {
			$data['allClients'] = [];   // kono branch er under e ei role user/manager ti nei.
		} elseif ($branchId != null && $authenticateUser->branch != null) {
			$data['allClients'] = $query->whereHas('profile', function ($q) use ($authenticateUser) {
				$q->where('branch_id', optional($authenticateUser->branch)->id);
			})->latest()->paginate(config('basic.paginate')); // for branch manager
		} else {
			$data['allClients'] = $query->latest()->paginate(config('basic.paginate')); // for admin
		}

		return view('admin.clients.index', $data, compact('authenticateUser'));
	}


	public function createClient()
	{
		$authenticateUser = Auth::guard('admin')->user();
		$data['allBranches'] = Branch::with('branchManager')
			->when(isset($authenticateUser->role_id), function ($query) use ($authenticateUser) {
				return $query->whereHas('branchManager', function ($q) use ($authenticateUser) {
					$q->where('admin_id', $authenticateUser->id);
				});
			})
			->where('status', 1)->get();
		$data['allCountires'] = Country::where('status', 1)->get();
		return view('admin.clients.create', $data, compact('authenticateUser'));
	}

	public function clientStore(Request $request)
	{

		$purifiedData = Purify::clean($request->except('_token', '_method', 'image'));

		$rules = [
			'name' => ['required', 'string', 'max:255'],
			'username' => ['required', 'string', 'max:50', 'unique:users,username'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
			'phone' => ['required', 'string', 'unique:user_profiles,phone'],
			'national_id' => ['nullable', 'max:100', 'min:6'],
			'password' => ['required', 'string', 'min:6'],
			'branch_id' => ['required', 'exists:branches,id'],
			'country_id' => ['required', 'exists:countries,id'],
			'state_id' => ['required', 'exists:states,id'],
			'city_id' => ['nullable', 'exists:cities,id'],
			'area_id' => ['nullable', 'exists:areas,id'],
			'address' => ['nullable', 'max:1000'],
			'image' => ['nullable', 'max:3072', 'mimes:jpg,jpeg,png']
		];

		$message = [
			'name.required' => 'Name field is required',
			'username.required' => 'User name field is required',
			'email.required' => 'Email field is required',
			'phone.required' => 'Phone Number is required',
			'password.required' => 'Password field is required',
			'branch_id.required' => 'Please select a branch',
			'country_id.required' => 'Please select a country',
			'state_id.required' => 'Please select a state'
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$user = new User();

		$user->name = $request->name;
		$user->username = $request->username;
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->user_type = (int)$request->client_type;
		$user->status = $request->status;

		$user->save();

		$userProfile = UserProfile::firstOrCreate(['user_id' => $user->id]);
		$userProfile->phone = $request->phone;
		$userProfile->address = $request->address;
		$userProfile->national_id = $request->national_id;
		$userProfile->branch_id = $request->branch_id;
		$userProfile->country_id = $request->country_id;
		$userProfile->state_id = $request->state_id;
		$userProfile->city_id = $request->city_id;
		$userProfile->area_id = $request->area_id;

		if ($request->hasFile('image')) {
			try {
				$image = $this->fileUpload($request->image, config('location.user.path'));
				if ($image) {
					$userProfile->profile_picture = $image['path'] ?? null;
					$userProfile->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $exp) {
				return back()->with('error', 'Image could not be uploaded.');
			}
		}

		$userProfile->save();

		return back()->with('success', 'Client Created Successfully!');
	}

	public function clientEdit($id)
	{
		$authenticateUser = Auth::guard('admin')->user();
		$data['allBranches'] = Branch::where('status', 1)->get();
		$data['allCountries'] = Country::where('status', 1)->get();
		$data['allStates'] = State::where('status', 1)->get();
		$data['allCities'] = City::where('status', 1)->get();
		$data['allAreas'] = Area::where('status', 1)->get();
		$data['singleClientInfo'] = User::with('profile', 'profile.branch', 'profile.country', 'profile.state', 'profile.city', 'profile.area')
			->when($authenticateUser->role_id != null, function ($query) use ($authenticateUser){
				$query->whereHas('profile', function ($q) use ($authenticateUser) {
					$q->where('branch_id', optional($authenticateUser->branch)->branch_id);
				});
			})
			->findOrFail($id);
		return view('admin.clients.edit', $data);
	}

	public function clientUpdate(Request $request, $id)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method', 'image'));

		$rules = [
			'name' => ['required', 'string', 'max:255'],
			'username' => ['required', 'string', 'max:50'],
			'email' => ['required', 'string', 'email', 'max:255'],
			'phone' => ['required', 'string'],
			'national_id' => ['nullable', 'max:100', 'min:6'],
			'password' => ['nullable', 'min:6', 'max:50'],
			'branch_id' => ['required', 'exists:branches,id'],
			'country_id' => ['required', 'exists:countries,id'],
			'state_id' => ['required', 'exists:states,id'],
			'city_id' => ['nullable', 'exists:cities,id'],
			'area_id' => ['nullable', 'exists:areas,id'],
			'address' => ['nullable', 'max:1000'],
			'image' => ['nullable', 'max:3072', 'mimes:jpg,jpeg,png']
		];

		$message = [
			'name.required' => 'Name field is required',
			'username.required' => 'User name field is required',
			'email.required' => 'Email field is required',
			'phone.required' => 'Phone Number is required',
			'branch_id.required' => 'Please select a branch',
			'country_id.required' => 'Please select a country',
			'state_id.required' => 'Please select a state'
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$user = User::findOrFail($id);


		$user->name = $request->name;
		$user->username = $request->username;
		$user->email = $request->email;
		$user->password = $request->password == null ? $user->password : Hash::make($request->password);
		$user->user_type = (int)$request->client_type;
		$user->status = $request->status;

		$user->save();

		$userProfile = UserProfile::firstOrCreate(['user_id' => $user->id]);
		$userProfile->phone = $request->phone;
		$userProfile->address = $request->address;
		$userProfile->national_id = $request->national_id;
		$userProfile->branch_id = $request->branch_id;
		$userProfile->country_id = $request->country_id;
		$userProfile->state_id = $request->state_id;
		$userProfile->city_id = $request->city_id;
		$userProfile->area_id = $request->area_id;

		if ($request->hasFile('image')) {
			try {
				$image = $this->fileUpload($request->image, config('location.user.path'));
				if ($image) {
					$userProfile->profile_picture = $image['path'] ?? null;
					$userProfile->driver = $image['driver'] ?? null;
				}
			} catch (\Exception $exp) {
				return back()->with('error', 'Image could not be uploaded.');
			}
		}

		$userProfile->save();

		return back()->with('success', 'Client Updated Successfully!');
	}

}
