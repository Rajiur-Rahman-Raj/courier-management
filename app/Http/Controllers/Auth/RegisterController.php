<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\UserSystemInfo;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Template;
use App\Models\UserProfile;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;

class RegisterController extends Controller
{
	use RegistersUsers;

	public function showRegistrationForm(Request $request)
	{
		$referral = $request->referral;
		$info = json_decode(json_encode(getIpInfo()), true);
		$country_code = null;
		if (!empty($info['code'])) {
			$country_code = $info['code'][0];
		}
		$countries = config('country');
		$template = Template::where('section_name', 'register')->first();
		return view(template() . 'auth.register', compact('countries', 'referral', 'country_code', 'template'));
	}

	protected $redirectTo = RouteServiceProvider::HOME;

	public function __construct()
	{
		$this->middleware('guest');
	}

	protected function validator(array $data)
	{
		$validateData = [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
			'username' => ['required', 'string', 'max:50', 'unique:users,username'],
			'password' => ['required', 'string', 'min:6', 'confirmed'],
			'phone' => ['required', 'string', 'unique:user_profiles,phone'],
		];

		if (basicControl()->reCaptcha_status_registration) {
			$validateData['g-recaptcha-response'] = ['required', 'captcha'];
		}

		return Validator::make($data, $validateData);
	}

	protected function create(array $data)
	{
		$ref_by = null;
		if (isset($data['referral'])) {
			$ref_by = User::where('username', $data['referral'])->first();
		}
		if (!isset($ref_by)) {
			$ref_by = null;
		}


		$ul['ip_address'] = UserSystemInfo::get_ip();
		$ul['browser'] = UserSystemInfo::get_browsers();
		$ul['os'] = UserSystemInfo::get_os();
		$ul['get_device'] = UserSystemInfo::get_device();

		$user = User::create([
			'name' => $data['name'],
			'ref_by' => $ref_by,
			'email' => $data['email'],
			'username' => $data['username'],
			'password' => Hash::make($data['password']),
			'language_id' => Language::select('id')->where('default_status', true)->first()->name ?? null,
			'email_verification' => (basicControl()->email_verification) ? 0 : 1,
			'sms_verification' => (basicControl()->sms_verification) ? 0 : 1,
			'browser_history' => $ul['browser'],
			'os_history' => $ul['os'],
			'device_history' => $ul['get_device'],
		]);

		$userProfile = UserProfile::firstOrCreate(['user_id' => $user->id]);
		$userProfile->phone_code = $data['phone_code'];
		$userProfile->phone = $data['phone'];
		$userProfile->save();

		return $user;
	}




//	protected function registered(Request $request, $user)
//	{
//		$user->last_login = Carbon::now();
//		$user->last_seen = Carbon::now();
//		$user->two_fa_verify = ($user->two_fa == 1) ? 0 : 1;
//		$user->save();
//
//		$info = @json_decode(json_encode(getIpInfo()), true);
//		$ul['user_id'] = $user->id;
//
//		$ul['longitude'] = (!empty(@$info['long'])) ? implode(',', $info['long']) : null;
//		$ul['latitude'] = (!empty(@$info['lat'])) ? implode(',', $info['lat']) : null;
//		$ul['country_code'] = (!empty(@$info['code'])) ? implode(',', $info['code']) : null;
//		$ul['location'] = (!empty(@$info['city'])) ? implode(',', $info['city']) . (" - " . @implode(',', @$info['area']) . "- ") . @implode(',', $info['country']) . (" - " . @implode(',', $info['code']) . " ") : null;
//		$ul['country'] = (!empty(@$info['country'])) ? @implode(',', @$info['country']) : null;
//
//		$ul['ip_address'] = UserSystemInfo::get_ip();
//		$ul['browser'] = UserSystemInfo::get_browsers();
//		$ul['os'] = UserSystemInfo::get_os();
//		$ul['get_device'] = UserSystemInfo::get_device();
//
//		UserLogin::create($ul);
//
//	}



	protected function registered(Request $request, $user)
	{

		$user->two_fa_verify = ($user->two_fa == 1) ? 0 : 1;
		$user->save();

	}
}
