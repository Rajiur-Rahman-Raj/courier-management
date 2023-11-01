<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Branch;
use App\Models\City;
use App\Models\Country;
use App\Models\Fund;
use App\Models\Language;
use App\Models\Payout;
use App\Models\Shipment;
use App\Models\State;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserProfile;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	use Upload, Notify;

	public function index()
	{
		$users = User::with('profile')->latest()->paginate();
		return view('admin.user.index', compact('users'));
	}

	public function inactiveUserList()
	{
		$users = User::where('status', 0)
			->with('profile')
			->latest()
			->paginate();
		return view('admin.user.inactive', compact('users'));
	}

	public function search(Request $request)
	{
		$search = $request->all();
		$created_date = isset($search['created_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['created_at']) : 0;
		$last_login_at = isset($search['last_login_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['last_login_at']) : 0;

		$active = isset($search['status']) ? preg_match("/active/", $search['status']) : 0;
		$inactive = isset($search['status']) ? preg_match("/inactive/", $search['status']) : 0;

		$users = User::with('profile')
			->when(isset($search['name']), function ($query) use ($search) {
				return $query->where('name', 'LIKE', "%{$search['name']}%");
			})
			->when(isset($search['email']), function ($query) use ($search) {
				return $query->where('email', 'LIKE', "%{$search['email']}%");
			})
			->when($active == 1, function ($query) use ($search) {
				return $query->where("status", 1);
			})
			->when($inactive == 1, function ($query) use ($search) {
				return $query->where("status", 0);
			})
			->when($created_date == 0, function ($query) use ($search) {
				return $query->whereDate("created_at", $search['created_at']);
			})
			->when($last_login_at == 1, function ($query) use ($search) {
				return $query->whereHas('profile', function ($qry) use ($search) {
					$qry->whereDate("last_login_at", $search['last_login_at']);
				});
			})
			->when(isset($search['phone']), function ($query) use ($search) {
				return $query->whereHas('profile', function ($qry) use ($search) {
					$qry->where('phone', 'LIKE', "%{$search['phone']}%");
				});
			})
			->latest()
			->paginate();
		$users->appends($search);
		return view('admin.user.index', compact('search', 'users'));
	}

	public function inactiveUserSearch(Request $request)
	{
		$search = $request->all();
		$created_date = isset($search['created_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['created_at']) : 0;
		$last_login_at = isset($search['last_login_at']) ? preg_match("/^[0-9]{2,4}-[0-9]{1,2}-[0-9]{1,2}$/", $search['last_login_at']) : 0;

		$active = isset($search['status']) ? preg_match("/active/", $search['status']) : 0;
		$inactive = isset($search['status']) ? preg_match("/inactive/", $search['status']) : 0;

		$users = User::where('status', 0)->with('profile')
			->when(isset($search['name']), function ($query) use ($search) {
				return $query->where('name', 'LIKE', "%{$search['name']}%");
			})
			->when(isset($search['email']), function ($query) use ($search) {
				return $query->where('email', 'LIKE', "%{$search['email']}%");
			})
			->when($active == 1, function ($query) use ($search) {
				return $query->where("status", 1);
			})
			->when($inactive == 1, function ($query) use ($search) {
				return $query->where("status", 0);
			})
			->when($created_date == 1, function ($query) use ($search) {
				return $query->whereDate("created_at", $search['created_at']);
			})
			->when($last_login_at == 1, function ($query) use ($search) {
				return $query->whereHas('profile', function ($qry) use ($search) {
					$qry->whereDate("last_login_at", $search['last_login_at']);
				});
			})
			->when(isset($search['phone']), function ($query) use ($search) {
				return $query->whereHas('profile', function ($qry) use ($search) {
					$qry->where('phone', 'LIKE', "%{$search['phone']}%");
				});
			})
			->latest()
			->paginate();
		$users->appends($search);
		return view('admin.user.inactive', compact('search', 'users'));
	}

	public function edit(Request $request, user $user)
	{
		$userProfile = UserProfile::firstOrCreate(['user_id' => $user->id]);
		$languages = Language::get();
		if ($request->isMethod('get')) {
			$userId = $user->id;
			$countries = config('country');

			$data['allBranches'] = Branch::where('status', 1)->get();
			$data['allCountries'] = Country::where('status', 1)->get();
			$data['allStates'] = State::where('status', 1)->get();
			$data['allCities'] = City::where('status', 1)->get();
			$data['allAreas'] = Area::where('status', 1)->get();

			$shipments = Shipment::selectRaw('COUNT(shipments.id) AS totalShipments')
				->selectRaw('COUNT(CASE WHEN shipments.shipment_identifier = 1 THEN shipments.id END) AS totalOperatorCountryShipments')
				->selectRaw('COUNT(CASE WHEN shipments.shipment_identifier = 2 THEN shipments.id END) AS totalInternationallyShipments')
				->selectRaw('COUNT(CASE WHEN shipments.status = 0 THEN shipments.id END) AS totalPendingShipments')
				->selectRaw('COUNT(CASE WHEN shipments.status = 1 THEN shipments.id END) AS totalInQueueShipments')
				->selectRaw('COUNT(CASE WHEN shipments.status = 4 THEN shipments.id END) AS totalDeliveredShipments')
				->selectRaw('COUNT(CASE WHEN shipments.status = 11 THEN shipments.id END) AS totalReturnShipments')
				->where('sender_id', $userId)
				->get()
				->toArray();

			$data['shipmentRecord'] = collect($shipments)->collapse();

			$shipmentTransactions = Transaction::selectRaw('SUM(CASE WHEN shipment_id IS NOT NULL THEN amount ELSE 0 END) AS totalShipmentTransactions')
				->where('user_id', $userId)
				->get()
				->toArray();

			$data['transactionRecord'] = collect($shipmentTransactions)->collapse();

			$data['totalDeposit'] = getAmount($user->funds()->whereStatus(1)->sum('amount'));
			$data['totalPayout'] = getAmount($user->payouts()->whereStatus(2)->sum('amount'));

			return view('admin.user.show', $data, compact('user', 'userProfile', 'countries', 'languages'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->except('_token', '_method', 'image'));

			$validator = Validator::make($purifiedData, [
				'name' => 'required|min:3|max:100|string',
				'username' => 'required|min:5|max:50|unique:users,username,' . $user->id,
				'email' => 'required|email|min:5|max:100|unique:users,email,' . $user->id,
				'phone' => 'required|max:32',
				'national_id' => ['nullable', 'max:100', 'min:6'],
				'password' => 'nullable|min:5|max:50',
				'branch_id' => ['nullable', 'exists:branches,id'],
				'country_id' => ['nullable', 'exists:countries,id'],
				'state_id' => ['nullable', 'exists:states,id'],
				'city_id' => ['nullable', 'exists:cities,id'],
				'area_id' => ['nullable', 'exists:areas,id'],
				'address' => ['nullable', 'max:1000'],
				'language' => 'required|numeric|not_in:0',
				'image' => ['nullable', 'max:3072', 'mimes:jpg,jpeg,png']
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;

			$user->name = $purifiedData->name;
			$user->username = $purifiedData->username;
			$user->email = $purifiedData->email;
			$user->password = $purifiedData->password == null ? $user->password : Hash::make($request->password);
			$user->language_id = $purifiedData->language;
			$user->user_type = (int)$purifiedData->client_type;
			$user->email_verification = $purifiedData->email_verification;
			$user->sms_verification = $purifiedData->sms_verification;
			$user->status = $purifiedData->status;

			$user->save();


			$userProfile->phone = $purifiedData->phone;
			$userProfile->phone_code = isset($purifiedData->phone_code) ? $purifiedData->phone_code : null;
			$userProfile->address = empty($purifiedData->address) ? null : $purifiedData->address;
			$userProfile->national_id = empty($purifiedData->national_id) ? null : $purifiedData->national_id;
			$userProfile->branch_id = isset($purifiedData->branch_id) ? $purifiedData->branch_id : null;
			$userProfile->country_id = isset($purifiedData->country_id) ? $purifiedData->country_id : null;
			$userProfile->state_id = isset($purifiedData->state_id) ? $purifiedData->state_id : null;
			$userProfile->city_id = isset($purifiedData->city_id) ? $purifiedData->city_id : null;
			$userProfile->area_id = isset($purifiedData->area_id) ? $purifiedData->area_id : null;

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

			return back()->with('success', 'Profile Update Successfully');
		}
	}


	public function vendorEdit(Request $request, user $user)
	{
		$authenticateUser = Auth::guard('admin')->user();

		if (optional($authenticateUser->branch)->branch_id == optional($user->profile)->branch_id || $authenticateUser->role_id == null){
			$userProfile = UserProfile::firstOrCreate(['user_id' => $user->id]);
		}else{
			return abort(404);
		}

		$languages = Language::get();
		if ($request->isMethod('get')) {
			$userId = $user->id;
			$countries = config('country');

			$data['allBranches'] = Branch::where('status', 1)->get();
			$data['allCountries'] = Country::where('status', 1)->get();
			$data['allStates'] = State::where('status', 1)->get();
			$data['allCities'] = City::where('status', 1)->get();
			$data['allAreas'] = Area::where('status', 1)->get();

			$shipments = Shipment::selectRaw('COUNT(shipments.id) AS totalShipments')
				->selectRaw('COUNT(CASE WHEN shipments.shipment_identifier = 1 THEN shipments.id END) AS totalOperatorCountryShipments')
				->selectRaw('COUNT(CASE WHEN shipments.shipment_identifier = 2 THEN shipments.id END) AS totalInternationallyShipments')
				->selectRaw('COUNT(CASE WHEN shipments.status = 0 THEN shipments.id END) AS totalPendingShipments')
				->selectRaw('COUNT(CASE WHEN shipments.status = 1 THEN shipments.id END) AS totalInQueueShipments')
				->selectRaw('COUNT(CASE WHEN shipments.status = 4 THEN shipments.id END) AS totalDeliveredShipments')
				->selectRaw('COUNT(CASE WHEN shipments.status = 11 THEN shipments.id END) AS totalReturnShipments')
				->where('sender_id', $userId)
				->get()
				->toArray();

			$data['shipmentRecord'] = collect($shipments)->collapse();


			$shipmentTransactions = Transaction::selectRaw('SUM(CASE WHEN shipment_id IS NOT NULL THEN amount ELSE 0 END) AS totalShipmentTransactions')
				->where('user_id', $userId)
				->get()
				->toArray();

			$data['transactionRecord'] = collect($shipmentTransactions)->collapse();

			$data['totalDeposit'] = getAmount($user->funds()->whereStatus(1)->sum('amount'));
			$data['totalPayout'] = getAmount($user->payouts()->whereStatus(2)->sum('amount'));


			return view('admin.user.show', $data, compact('user', 'userProfile', 'countries', 'languages'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->except('_token', '_method', 'image'));

			$validator = Validator::make($purifiedData, [
				'name' => 'required|min:3|max:100|string',
				'username' => 'required|min:5|max:50|unique:users,username,' . $user->id,
				'email' => 'required|email|min:5|max:100|unique:users,email,' . $user->id,
				'phone' => 'required|max:32',
				'national_id' => ['nullable', 'max:100', 'min:6'],
				'password' => 'nullable|min:5|max:50',
				'branch_id' => ['nullable', 'exists:branches,id'],
				'country_id' => ['nullable', 'exists:countries,id'],
				'state_id' => ['nullable', 'exists:states,id'],
				'city_id' => ['nullable', 'exists:cities,id'],
				'area_id' => ['nullable', 'exists:areas,id'],
				'address' => ['nullable', 'max:1000'],
				'language' => 'required|numeric|not_in:0',
				'image' => ['nullable', 'max:3072', 'mimes:jpg,jpeg,png']
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;

			$user->name = $purifiedData->name;
			$user->username = $purifiedData->username;
			$user->email = $purifiedData->email;
			$user->password = $purifiedData->password == null ? $user->password : Hash::make($request->password);
			$user->language_id = $purifiedData->language;
			$user->user_type = (int)$purifiedData->client_type;
			$user->email_verification = $purifiedData->email_verification;
			$user->sms_verification = $purifiedData->sms_verification;
			$user->status = $purifiedData->status;

			$user->save();


			$userProfile->phone = $purifiedData->phone;
			$userProfile->phone_code = isset($purifiedData->phone_code) ? $purifiedData->phone_code : null;
			$userProfile->address = empty($purifiedData->address) ? null : $purifiedData->address;
			$userProfile->national_id = empty($purifiedData->national_id) ? null : $purifiedData->national_id;
			$userProfile->branch_id = isset($purifiedData->branch_id) ? $purifiedData->branch_id : null;
			$userProfile->country_id = isset($purifiedData->country_id) ? $purifiedData->country_id : null;
			$userProfile->state_id = isset($purifiedData->state_id) ? $purifiedData->state_id : null;
			$userProfile->city_id = isset($purifiedData->city_id) ? $purifiedData->city_id : null;
			$userProfile->area_id = isset($purifiedData->area_id) ? $purifiedData->area_id : null;

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

			return back()->with('success', 'Profile Update Successfully');
		}
	}


	public function sendMailUser(Request $request, user $user = null)
	{
		if ($request->isMethod('get')) {
			return view('admin.user.sendMail', compact('user'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'subject' => 'required|min:5',
				'template' => 'required|min:10',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;
			$subject = $purifiedData->subject;
			$template = $purifiedData->template;

			if (isset($user)) {
				$this->mail($user, null, [], $subject, $template);
			} else {
				$users = User::all();
				foreach ($users as $user) {
					$this->mail($user, null, [], $subject, $template);
				}
			}
			return redirect(route('user-list'))->with('success', 'Email Send Successfully');
		}
	}

	public function userBalanceUpdate(Request $request, $id)
	{
		$userData = Purify::clean($request->all());
		if ($userData['balance'] == null) {
			return back()->with('error', 'Balance Value Empty!');
		} else {
			$control = (object)config('basic');
			$user = User::findOrFail($id);

			$trx = strRandom();

			if ($userData['add_status'] == "1") {
				$user->balance += $userData['balance'];
				$user->save();

				$fund = new Fund();
				$fund->user_id = $user->id;
				$fund->amount = $userData['balance'];
				$fund->admin_id = auth()->id();
				$fund->status = 1;
				$fund->email = $user->email ?? null;
				$fund->utr = $trx;
				$fund->save();

				$transaction = new Transaction();
				$transaction->amount = getAmount($userData['balance']);
				$transaction->charge = 0;
				$fund->transactional()->save($transaction);

				$msg = [
					'amount' => getAmount($userData['balance']),
					'currency' => $control->base_currency,
					'main_balance' => $user->balance,
					'transaction' => $trx
				];
				$action = [
					"link" => '#',
					"icon" => "fa fa-money-bill-alt text-white"
				];

				$this->userPushNotification($user, 'ADD_BALANCE', $msg, $action);

				$this->sendMailSms($user, 'ADD_BALANCE', [
					'amount' => getAmount($userData['balance']),
					'currency' => $control->base_currency,
					'main_balance' => $user->balance,
					'transaction' => $trx
				]);
				return back()->with('success', 'Balance Add Successfully.');

			} else {

				if ($userData['balance'] > $user->balance) {
					return back()->with('error', 'Insufficient Balance to deducted.');
				}
				$user->balance -= $userData['balance'];
				$user->save();

				$fund = new Fund();
				$fund->user_id = $user->id;
				$fund->admin_id = auth()->id();
				$fund->amount = $userData['balance'];
				$fund->status = 1;
				$fund->email = $user->email ?? null;
				$fund->utr = $trx;
				$fund->save();

				$transaction = new Transaction();
				$transaction->amount = getAmount($userData['balance']);
				$transaction->charge = 0;
				$fund->transactional()->save($transaction);

				$msg = [
					'amount' => getAmount($userData['balance']),
					'currency' => $control->base_currency,
					'main_balance' => $user->balance,
					'transaction' => $trx
				];
				$action = [
					"link" => '#',
					"icon" => "fa fa-money-bill-alt text-white"
				];

				$this->userPushNotification($user, 'DEDUCTED_BALANCE', $msg, $action);

				$this->sendMailSms($user, 'DEDUCTED_BALANCE', [
					'amount' => getAmount($userData['balance']),
					'currency' => $control->base_currency,
					'main_balance' => $user->balance,
					'transaction' => $trx,
				]);
				return back()->with('success', 'Balance deducted Successfully.');
			}
		}
	}

	public function asLogin($id)
	{
		Auth::guard('web')->loginUsingId($id);
		return redirect()->route('user.dashboard');
	}












}
