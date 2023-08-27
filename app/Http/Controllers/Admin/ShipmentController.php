<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShipmentRequest;
use App\Models\Shipment;
use App\Traits\OCShipmentStoreTrait;
use App\Traits\Notify;
use App\Traits\Upload;
use App\Models\BasicControl;
use App\Models\Branch;
use App\Models\Country;
use App\Models\DefaultShippingRateInternationally;
use App\Models\DefaultShippingRateOperatorCountry;
use App\Models\OCSAttatchment;
use App\Models\OperatorCountryShipment;
use App\Models\Package;
use App\Models\ParcelType;
use App\Models\ShippingDate;
use App\Models\ShippingRateInternationally;
use App\Models\ShippingRateOperatorCountry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Stevebauman\Purify\Facades\Purify;

class ShipmentController extends Controller
{
	use Upload, Notify, OCShipmentStoreTrait;

	public function shipmentList(Request $request, $type = null)
	{
		$shipmentManagement = config('shipmentManagement');
		$types = array_keys($shipmentManagement);
		abort_if(!in_array($type, $types), 404);
		$data['title'] = $shipmentManagement[$type]['title'];

		$data['allShipments'] = Shipment::with('senderBranch','receiverBranch','sender','receiver','fromState','fromCity','fromArea','toState','toCity','toArea')
		->when($type == 'operator_country', function ($query){
			$query->where('shipment_identifier', 1);
		})
		->when($type == 'internationally', function ($query){
			$query->where('shipment_identifier', 2);
		})
		->paginate(config('basic.paginate'));

		return view($shipmentManagement[$type]['shipment_view'], $data);
	}

	public function createShipment()
	{
		$data['shipmentTypeList'] = config('shipmentTypeList');

		$data['allBranches'] = Branch::where('status', 1)->get();
		$data['users'] = User::where('user_type', '!=', '0')->get();
		$data['senders'] = $data['users']->where('user_type', 1);
		$data['receivers'] = $data['users']->where('user_type', 2);
		$data['allCountries'] = Country::where('status', 1)->get();
		$data['basicControl'] = BasicControl::with('operatorCountry')->first();
		$data['packageList'] = Package::where('status', 1)->get();
		$data['parcelTypes'] = ParcelType::where('status', 1)->get();
		$data['defaultShippingRateOC'] = DefaultShippingRateOperatorCountry::first();

		return view('admin.shipments.create', $data);
	}

	public function editShipment($id){
		$data['shipmentTypeList'] = config('shipmentTypeList');
		$data['allBranches'] = Branch::where('status', 1)->get();
		$data['users'] = User::where('user_type', '!=', '0')->get();
		$data['senders'] = $data['users']->where('user_type', 1);
		$data['receivers'] = $data['users']->where('user_type', 2);
		$data['allCountries'] = Country::where('status', 1)->get();
		$data['basicControl'] = BasicControl::with('operatorCountry')->first();
		$data['packageList'] = Package::where('status', 1)->get();
		$data['parcelTypes'] = ParcelType::where('status', 1)->get();
		$data['defaultShippingRateOC'] = DefaultShippingRateOperatorCountry::first();

		$data['singleShipment'] = Shipment::findOrFail($id);

		return view('admin.shipments.edit', $data);
	}

	public function shipmentStore(ShipmentRequest $request)
	{
		try {
			DB::beginTransaction();
			$shipment = new Shipment();
			$shipmentId = strRandom();
			$fillData = $request->only($shipment->getFillable());
			$fillData['shipment_id'] = $shipmentId;
			$fillData['receive_amount'] = $request->receive_amount != null ? $request->receive_amount : null;
			$fillData['from_city_id'] = $request->from_city_id ?? null;
			$fillData['from_area_id'] = $request->from_area_id ?? null;
			$fillData['to_city_id'] = $request->to_city_id ?? null;
			$fillData['to_area_id'] = $request->to_area_id ?? null;

			if ($request->packing_service == 'yes'){
				$this->storePackingService($request, $shipment);
			}else{
				$fillData['packing_services'] = null;
			}

			if ($request->shipment_type == 'drop_off' || $request->shipment_type == 'pickup'){
				$this->storeParcelInformation($request, $shipment);
			}else{
				$fillData['parcel_information'] = null;
			}

			if ($request->shipment_type == 'condition') {
				$fillData['parcel_details'] = $request->parcel_details;
			}

			if ($request->payment_type == 'wallet') {
				$this->walletPaymentCalculation($request, $shipmentId);
			}

			$shipment->fill($fillData)->save();

			if ($request->hasFile('shipment_image')){
				$getShipmentAttachments = $this->storeShipmentAttatchments($request, $shipment);
				if ($getShipmentAttachments['status'] == 'error'){
					throw new \Exception($getShipmentAttachments['message']);
				}
			}

			DB::commit();

			$basic = basicControl();
			$amount = $request->total_pay;
			$sender = User::findOrFail($request->sender_id);
			$date = Carbon::now();
			$msg = [
				'currency' => $basic->currency_symbol,
				'amount' => $amount,
				'shipment_id' => $shipmentId,
			];

			$action = [
				"link" => "#",
				"icon" => "fa fa-money-bill-alt text-white"
			];

			$adminAction = [
				"link" => "#",
				"icon" => "fa fa-money-bill-alt text-white"
			];

			$this->userPushNotification($sender, 'USER_NOTIFY_COURIER_SHIPMENT', $msg, $action);
			$this->adminPushNotification('ADMIN_NOTIFY_COURIER_SHIPMENT', $msg, $adminAction);

			$this->sendMailSms($sender, $type = 'USER_MAIL_COURIER_SHIPMENT', [
				'amount' => getAmount($amount),
				'currency' => $basic->currency_symbol,
				'shipment_id' => $shipmentId,
				'date' => $date,
			]);

			return back()->with('success', 'Shipment created successfully');

		} catch (\Exception $exp) {
			DB::rollBack();
			return back()->with('error', $exp->getMessage());
		}
	}


	public function shipmentTypeList()
	{
		$data['allShipmentType'] = config('shipmentTypeList');
		return view('admin.shipmentType.index', $data);
	}

	public function shipmentTypeUpdate(Request $request, $id)
	{
		$filePath = base_path('config/shipmentTypeList.php');

		$shipmentTypeList = config('shipmentTypeList');

		foreach ($shipmentTypeList as & $typeList) {
			if ($typeList['id'] == $id) {
				$typeList['shipment_type'] = $request->shipment_type;
				$typeList['title'] = $request->title;
				break;
			}
		}

		$exportedArray = var_export($shipmentTypeList, true);
		$content = "<?php\n\nreturn $exportedArray;";

		file_put_contents($filePath, $content);

		// Clear cache and return response
		session()->flash('success', 'Updated Successfully');
		Artisan::call('optimize:clear');
		return back();
	}

	public function defaultRate()
	{
		$data['basicControl'] = BasicControl::with('operatorCountry')->first();
		$data['allShippingDates'] = ShippingDate::where('status', 1)->get();
		$data['allParcelTypes'] = ParcelType::where('status', 1)->get();
		$data['defaultShippingRateOperatorCountry'] = DefaultShippingRateOperatorCountry::first();
		$data['defaultShippingRateInternationally'] = DefaultShippingRateInternationally::first();
		return view('admin.shippingRate.defaultRate', $data);
	}

	public function defaultShippingRateOperatorCountryUpdate(Request $request, $id)
	{

		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'operator_country_id' => ['required', 'exists:countries,id'],
			'shipping_date_id' => ['required', 'exists:shipping_dates,id'],
			'pickup_cost' => ['numeric', 'min:0'],
			'supply_cost' => ['numeric', 'min:0'],
			'shipping_cost' => ['numeric', 'min:0'],
			'return_shipment_cost' => ['numeric', 'min:0'],
			'default_tax' => ['numeric', 'min:0'],
			'default_insurance' => ['numeric', 'min:0'],
		];

		$message = [
			'operator_country_id.required' => 'Please select a operator country',
			'shipping_date_id.required' => 'Please select shipping date',
			'parcel_type_id.required' => 'Please select a parcel type',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$defaultShippingRateOperatorCountry = DefaultShippingRateOperatorCountry::findOrFail($id);

		$defaultShippingRateOperatorCountry->country_id = $request->operator_country_id;
		$defaultShippingRateOperatorCountry->shipping_date_id = $request->shipping_date_id;
		$defaultShippingRateOperatorCountry->pickup_cost = $request->pickup_cost;
		$defaultShippingRateOperatorCountry->supply_cost = $request->supply_cost;
		$defaultShippingRateOperatorCountry->shipping_cost = $request->shipping_cost;
		$defaultShippingRateOperatorCountry->return_shipment_cost = $request->return_shipment_cost;
		$defaultShippingRateOperatorCountry->default_tax = $request->default_tax;
		$defaultShippingRateOperatorCountry->default_insurance = $request->default_insurance;

		$defaultShippingRateOperatorCountry->save();

		return back()->with('success', 'Default rate update successfully');
	}

	public function defaultShippingRateInternationallyUpdate(Request $request, $id)
	{

		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'shipping_date_id' => ['required', 'exists:shipping_dates,id'],
			'pickup_cost' => ['numeric', 'min:0'],
			'supply_cost' => ['numeric', 'min:0'],
			'shipping_cost' => ['numeric', 'min:0'],
			'return_shipment_cost' => ['numeric', 'min:0'],
			'default_tax' => ['numeric', 'min:0'],
			'default_insurance' => ['numeric', 'min:0'],
		];

		$message = [
			'shipping_date_id.required' => 'Please select a Shipping date',
			'parcel_type_id.required' => 'Please select a parcel type',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$defaultShippingRateInternationally = DefaultShippingRateInternationally::findOrFail($id);

		$defaultShippingRateInternationally->shipping_date_id = $request->shipping_date_id;
		$defaultShippingRateInternationally->pickup_cost = $request->pickup_cost;
		$defaultShippingRateInternationally->supply_cost = $request->supply_cost;
		$defaultShippingRateInternationally->shipping_cost = $request->shipping_cost;
		$defaultShippingRateInternationally->return_shipment_cost = $request->return_shipment_cost;
		$defaultShippingRateInternationally->default_tax = $request->default_tax;
		$defaultShippingRateInternationally->default_insurance = $request->default_insurance;

		$defaultShippingRateInternationally->save();
		Session::flash('active-tab', 'tab2');
		return back()->with('success', 'Default rate internationally update successfully');
	}

	public function operatorCountryRate(Request $request, $type = null)
	{
		$operatorCountryShippingRateManagement = config('operatorCountryShippingRateManagement');
		$types = array_keys($operatorCountryShippingRateManagement);
		abort_if(!in_array($type, $types), 404);
		$data['title'] = $operatorCountryShippingRateManagement[$type]['title'];

		$data['shippingRateList'] = ShippingRateOperatorCountry::with('fromState', 'toState', 'parcelType')
			->when($type == 'state', function ($query) {
				$query->whereNull(['from_city_id', 'from_area_id']);
			})
			->when($type == 'city', function ($query) {
				$query->whereNotNull('from_city_id')->whereNull('from_area_id');
			})
			->when($type == 'area', function ($query) {
				$query->whereNotNull(['from_area_id']);
			})
			->groupBy('parcel_type_id')
			->paginate(config('basic.paginate'));
		return view($operatorCountryShippingRateManagement[$type]['shipping_rate_view'], $data);
	}

	public function operatorCountryShowRate(Request $request, $type = null, $id = null)
	{
		$search = $request->all();
		$operatorCountryShowShippingRateManagement = config('operatorCountryShowShippingRateManagement');
		$types = array_keys($operatorCountryShowShippingRateManagement);
		abort_if(!in_array($type, $types), 404);
		$data['title'] = $operatorCountryShowShippingRateManagement[$type]['title'];

		$data['allParcelTypes'] = ParcelType::where('status', 1)->get();

		$data['showShippingRateList'] = ShippingRateOperatorCountry::with('fromState', 'toState', 'fromCity', 'toCity', 'fromArea', 'toArea', 'parcelType')
			->when(isset($search['from_state']), function ($query) use ($search) {
				$query->whereHas('fromState', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['from_state']}[[:>:]]'");
				});
			})
			->when(isset($search['to_state']), function ($query) use ($search) {
				$query->whereHas('toState', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['to_state']}[[:>:]]'");
				});
			})
			->when(isset($search['from_city']), function ($query) use ($search) {
				$query->whereHas('fromCity', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['from_city']}[[:>:]]'");
				});
			})
			->when(isset($search['to_city']), function ($query) use ($search) {
				$query->whereHas('toCity', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['to_city']}[[:>:]]'");
				});
			})
			->when(isset($search['from_area']), function ($query) use ($search) {
				$query->whereHas('fromArea', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['from_area']}[[:>:]]'");
				});
			})
			->when(isset($search['to_area']), function ($query) use ($search) {
				$query->whereHas('toArea', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['to_area']}[[:>:]]'");
				});
			})
			->when($type == 'state-list', function ($query) {
				$query->whereNull(['from_city_id', 'from_area_id']);
			})
			->when($type == 'city-list', function ($query) {
				$query->whereNotNull('from_city_id')->whereNull('from_area_id');
			})
			->when($type == 'area-list', function ($query) {
				$query->whereNotNull('from_area_id');
			})
			->where('parcel_type_id', $id)
			->paginate(config('basic.paginate'));

		return view($operatorCountryShowShippingRateManagement[$type]['show_shipping_rate_view'], $data);
	}


	public function stateRateUpdate(Request $request, $id)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'from_state_id' => ['required', 'exists:states,id'],
			'to_state_id' => ['required', 'exists:states,id'],
			'parcel_type_id' => ['required', 'exists:parcel_types,id'],
			'shipping_cost' => ['nullable', 'numeric', 'min:0'],
			'return_shipment_cost' => ['nullable', 'numeric', 'min:0'],
			'tax' => ['nullable', 'numeric', 'min:0'],
			'insurance' => ['nullable', 'numeric', 'min:0'],
			'cash_on_delivery_cost' => ['nullable', 'numeric', 'min:0'],
		];

		$message = [
			'from_state_id.required' => 'Please select from state',
			'to_state_id.required' => 'Please select to state',
			'parcel_type_id.required' => 'Please select parcel type',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$operatorCountry = ShippingRateOperatorCountry::findOrFail($id);

		$operatorCountry->from_state_id = $request->from_state_id;
		$operatorCountry->to_state_id = $request->to_state_id;
		$operatorCountry->parcel_type_id = $request->parcel_type_id;
		$operatorCountry->shipping_cost = $request->shipping_cost == null ? 0 : $request->shipping_cost;
		$operatorCountry->return_shipment_cost = $request->return_shipment_cost == null ? 0 : $request->return_shipment_cost;
		$operatorCountry->tax = $request->tax == null ? 0 : $request->tax;
		$operatorCountry->insurance = $request->insurance == null ? 0 : $request->insurance;
		$operatorCountry->cash_on_delivery_cost = $request->cash_on_delivery_cost == null ? 0 : $request->cash_on_delivery_cost;

		$operatorCountry->save();

		return back()->with('success', 'Shipping rate Update successfully');
	}

	public function cityRateUpdate(Request $request, $id)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'from_state_id' => ['required', 'exists:states,id'],
			'to_state_id' => ['required', 'exists:states,id'],
			'from_city_id' => ['required', 'exists:cities,id'],
			'to_city_id' => ['required', 'exists:cities,id'],
			'parcel_type_id' => ['required', 'exists:parcel_types,id'],
			'shipping_cost' => ['nullable', 'numeric', 'min:0'],
			'return_shipment_cost' => ['nullable', 'numeric', 'min:0'],
			'tax' => ['nullable', 'numeric', 'min:0'],
			'insurance' => ['nullable', 'numeric', 'min:0'],
			'cash_on_delivery_cost' => ['nullable', 'numeric', 'min:0'],
		];

		$message = [
			'from_state_id.required' => 'Please select from state',
			'to_state_id.required' => 'Please select to state',
			'from_city_id.required' => 'Please select from city',
			'to_city_id.required' => 'Please select to city',
			'parcel_type_id.required' => 'Please select parcel type',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$operatorCountry = ShippingRateOperatorCountry::findOrFail($id);

		$operatorCountry->from_state_id = $request->from_state_id;
		$operatorCountry->to_state_id = $request->to_state_id;
		$operatorCountry->from_city_id = $request->from_city_id;
		$operatorCountry->to_city_id = $request->to_city_id;
		$operatorCountry->parcel_type_id = $request->parcel_type_id;
		$operatorCountry->shipping_cost = $request->shipping_cost == null ? 0 : $request->shipping_cost;
		$operatorCountry->return_shipment_cost = $request->return_shipment_cost == null ? 0 : $request->return_shipment_cost;
		$operatorCountry->tax = $request->tax == null ? 0 : $request->tax;
		$operatorCountry->insurance = $request->insurance == null ? 0 : $request->insurance;
		$operatorCountry->cash_on_delivery_cost = $request->cash_on_delivery_cost == null ? 0 : $request->cash_on_delivery_cost;

		$operatorCountry->save();

		return back()->with('success', 'Shipping rate Update successfully');
	}

	public function areaRateUpdate(Request $request, $id)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'from_state_id' => ['required', 'exists:states,id'],
			'to_state_id' => ['required', 'exists:states,id'],
			'from_city_id' => ['required', 'exists:cities,id'],
			'to_city_id' => ['required', 'exists:cities,id'],
			'from_area_id' => ['required', 'exists:areas,id'],
			'to_area_id' => ['required', 'exists:areas,id'],
			'parcel_type_id' => ['required', 'exists:parcel_types,id'],
			'shipping_cost' => ['nullable', 'numeric', 'min:0'],
			'return_shipment_cost' => ['nullable', 'numeric', 'min:0'],
			'tax' => ['nullable', 'numeric', 'min:0'],
			'insurance' => ['nullable', 'numeric', 'min:0'],
			'cash_on_delivery_cost' => ['nullable', 'numeric', 'min:0'],
		];

		$message = [
			'from_state_id.required' => 'Please select from state',
			'to_state_id.required' => 'Please select to state',
			'from_city_id.required' => 'Please select from city',
			'to_city_id.required' => 'Please select to city',
			'from_area_id.required' => 'Please select from area',
			'to_area_id.required' => 'Please select to area',
			'parcel_type_id.required' => 'Please select parcel type',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$operatorCountry = ShippingRateOperatorCountry::findOrFail($id);

		$operatorCountry->from_state_id = $request->from_state_id;
		$operatorCountry->to_state_id = $request->to_state_id;
		$operatorCountry->from_city_id = $request->from_city_id;
		$operatorCountry->to_city_id = $request->to_city_id;
		$operatorCountry->from_area_id = $request->from_area_id;
		$operatorCountry->to_area_id = $request->to_area_id;
		$operatorCountry->parcel_type_id = $request->parcel_type_id;
		$operatorCountry->shipping_cost = $request->shipping_cost == null ? 0 : $request->shipping_cost;
		$operatorCountry->return_shipment_cost = $request->return_shipment_cost == null ? 0 : $request->return_shipment_cost;
		$operatorCountry->tax = $request->tax == null ? 0 : $request->tax;
		$operatorCountry->insurance = $request->insurance == null ? 0 : $request->insurance;
		$operatorCountry->cash_on_delivery_cost = $request->cash_on_delivery_cost == null ? 0 : $request->cash_on_delivery_cost;

		$operatorCountry->save();

		return back()->with('success', 'Shipping rate Update successfully');
	}


	public function createShippingRateOperatorCountry()
	{
		$data['allCountries'] = Country::where('status', 1)->get();
		$data['basicControl'] = BasicControl::with('operatorCountry')->first();
		$data['allParcelTypes'] = ParcelType::where('status', 1)->get();
		return view('admin.shippingRate.operatorCountry.create', $data);
	}

	public function shippingRateOperatorCountryStore(Request $request, $type = null)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'operator_country_id' => ['required', 'exists:countries,id'],
			'from_state_id' => ['required', 'exists:states,id'],
			'to_state_id' => ['required', 'exists:states,id'],
			'parcel_type_id' => ['required', 'exists:parcel_types,id'],
			'shipping_cost' => ['nullable', 'numeric', 'min:0'],
			'return_shipment_cost' => ['nullable', 'numeric', 'min:0'],
			'tax' => ['nullable', 'numeric', 'min:0'],
			'insurance' => ['nullable', 'numeric', 'min:0'],
			'cash_on_delivery_cost' => ['nullable', 'numeric', 'min:0'],
		];

		$message = [
			'operator_country_id.required' => 'Select Operator Country',
			'from_state_id.required' => 'Please select from state',
			'to_state_id.required' => 'Please select to state',
			'parcel_type_id.required' => 'Please select parcel type',
		];

		if ($type == 'city-wise') {
			$rules['from_city_id'] = ['required', 'exists:cities,id'];
			$rules['to_city_id'] = ['required', 'exists:cities,id'];
			$message['from_city_id.required'] = 'please select from city';
			$message['to_city_id.required'] = 'please select to city';
		} elseif ($type == 'area-wise') {
			$rules['from_area_id'] = ['required', 'exists:areas,id'];
			$rules['to_area_id'] = ['required', 'exists:areas,id'];
			$message['from_area_id.required'] = 'please select from area';
			$message['to_area_id.required'] = 'please select to area';
		}

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$operatorCountry = new ShippingRateOperatorCountry();

		$operatorCountry->country_id = $request->operator_country_id;
		$operatorCountry->from_state_id = $request->from_state_id;
		$operatorCountry->to_state_id = $request->to_state_id;
		$operatorCountry->parcel_type_id = $request->parcel_type_id;
		$operatorCountry->shipping_cost = $request->shipping_cost == null ? 0 : $request->shipping_cost;
		$operatorCountry->return_shipment_cost = $request->return_shipment_cost == null ? 0 : $request->return_shipment_cost;
		$operatorCountry->tax = $request->tax == null ? 0 : $request->tax;
		$operatorCountry->insurance = $request->insurance == null ? 0 : $request->insurance;
		$operatorCountry->cash_on_delivery_cost = $request->cash_on_delivery_cost == null ? 0 : $request->cash_on_delivery_cost;

		if ($type == 'city-wise') {
			$operatorCountry->from_city_id = $request->from_city_id;
			$operatorCountry->to_city_id = $request->to_city_id;
		} elseif ($type == 'area-wise') {
			$operatorCountry->from_city_id = $request->from_city_id;
			$operatorCountry->to_city_id = $request->to_city_id;
			$operatorCountry->from_area_id = $request->from_area_id;
			$operatorCountry->to_area_id = $request->to_area_id;
		}

		$operatorCountry->save();

		return back()->with('success', 'Shipping rate created successfully');
	}


	public function internationallyRate(Request $request, $type = null)
	{
		$internationallyShippingRateManagement = config('internationallyShippingRateManagement');
		$types = array_keys($internationallyShippingRateManagement);
		abort_if(!in_array($type, $types), 404);
		$data['title'] = $internationallyShippingRateManagement[$type]['title'];

		$data['shippingRateList'] = ShippingRateInternationally::with('fromCountry', 'toCountry', 'parcelType')
			->when($type == 'country', function ($query) {
				$query->whereNull(['from_state_id', 'from_city_id']);
			})
			->when($type == 'state', function ($query) {
				$query->whereNotNull('from_state_id')->whereNull('from_city_id');
			})
			->when($type == 'city', function ($query) {
				$query->whereNotNull(['from_city_id']);
			})
			->groupBy('parcel_type_id')
			->paginate(config('basic.paginate'));
		return view($internationallyShippingRateManagement[$type]['shipping_rate_view'], $data);
	}


	public function createShippingRateInternationally()
	{
		$data['allCountries'] = Country::where('status', 1)->get();
		$data['allParcelTypes'] = ParcelType::where('status', 1)->get();
		return view('admin.shippingRate.internationally.create', $data);
	}

	public function shippingRateInternationallyStore(Request $request, $type = null)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'from_country_id' => ['required', 'exists:countries,id'],
			'to_country_id' => ['required', 'exists:countries,id'],
			'parcel_type_id' => ['required', 'exists:parcel_types,id'],
			'shipping_cost' => ['nullable', 'numeric', 'min:0'],
			'return_shipment_cost' => ['nullable', 'numeric', 'min:0'],
			'tax' => ['nullable', 'numeric', 'min:0'],
			'insurance' => ['nullable', 'numeric', 'min:0'],
		];

		$message = [
			'from_country_id.required' => 'Please select from country',
			'to_country_id.required' => 'Please select to country',
			'parcel_type_id.required' => 'Please select parcel type',
		];

		if ($type == 'state-wise') {
			$rules['from_state_id'] = ['required', 'exists:states,id'];
			$rules['to_state_id'] = ['required', 'exists:states,id'];
			$message['from_state_id.required'] = 'please select from state';
			$message['to_state_id.required'] = 'please select to state';
		} elseif ($type == 'city-wise') {
			$rules['from_city_id'] = ['required', 'exists:cities,id'];
			$rules['to_city_id'] = ['required', 'exists:cities,id'];
			$message['from_city_id.required'] = 'please select from city';
			$message['to_city_id.required'] = 'please select to city';
		}

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$internationallyRate = new ShippingRateInternationally();

		$internationallyRate->from_country_id = $request->from_country_id;
		$internationallyRate->to_country_id = $request->to_country_id;
		$internationallyRate->parcel_type_id = $request->parcel_type_id;
		$internationallyRate->shipping_cost = $request->shipping_cost == null ? 0 : $request->shipping_cost;
		$internationallyRate->return_shipment_cost = $request->return_shipment_cost == null ? 0 : $request->return_shipment_cost;
		$internationallyRate->tax = $request->tax == null ? 0 : $request->tax;
		$internationallyRate->insurance = $request->insurance == null ? 0 : $request->insurance;

		if ($type == 'state-wise') {
			$internationallyRate->from_state_id = $request->from_state_id;
			$internationallyRate->to_state_id = $request->to_state_id;
		} elseif ($type == 'city-wise') {
			$internationallyRate->from_state_id = $request->from_state_id;
			$internationallyRate->to_state_id = $request->to_state_id;
			$internationallyRate->from_city_id = $request->from_city_id;
			$internationallyRate->to_city_id = $request->to_city_id;
		}

		$internationallyRate->save();

		return back()->with('success', 'Shipping rate added successfully');
	}

	public function internationallyShowRate(Request $request, $type = null, $id = null)
	{
		$search = $request->all();
		$internationallyShowShippingRateManagement = config('internationallyShowShippingRateManagement');
		$types = array_keys($internationallyShowShippingRateManagement);
		abort_if(!in_array($type, $types), 404);
		$data['title'] = $internationallyShowShippingRateManagement[$type]['title'];

		$data['allCountries'] = Country::where('status', 1)->get();
		$data['allParcelTypes'] = ParcelType::where('status', 1)->get();

		$data['showShippingRateList'] = ShippingRateInternationally::with('fromCountry', 'toCountry', 'fromState', 'toState', 'fromCity', 'toCity', 'parcelType')
			->when(isset($search['from_country']), function ($query) use ($search) {
				$query->whereHas('fromCountry', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['from_country']}[[:>:]]'");
				});
			})
			->when(isset($search['to_country']), function ($query) use ($search) {
				$query->whereHas('toCountry', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['to_country']}[[:>:]]'");
				});
			})
			->when(isset($search['from_state']), function ($query) use ($search) {
				$query->whereHas('fromState', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['from_state']}[[:>:]]'");
				});
			})
			->when(isset($search['to_state']), function ($query) use ($search) {
				$query->whereHas('toState', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['to_state']}[[:>:]]'");
				});
			})
			->when(isset($search['from_city']), function ($query) use ($search) {
				$query->whereHas('fromCity', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['from_city']}[[:>:]]'");
				});
			})
			->when(isset($search['to_city']), function ($query) use ($search) {
				$query->whereHas('toCity', function ($q) use ($search) {
					return $q->whereRaw("name REGEXP '[[:<:]]{$search['to_city']}[[:>:]]'");
				});
			})
			->when($type == 'country-list', function ($query) {
				$query->whereNull(['from_state_id', 'from_city_id']);
			})
			->when($type == 'state-list', function ($query) {
				$query->whereNotNull('from_state_id')->whereNull('from_city_id');
			})
			->when($type == 'city-list', function ($query) {
				$query->whereNotNull('from_city_id');
			})
			->where('parcel_type_id', $id)
			->paginate(config('basic.paginate'));

		return view($internationallyShowShippingRateManagement[$type]['show_shipping_rate_view'], $data);
	}


	public function countryRateUpdateInternationally(Request $request, $id)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'from_country_id' => ['required', 'exists:countries,id'],
			'to_country_id' => ['required', 'exists:countries,id'],
			'parcel_type_id' => ['required', 'exists:parcel_types,id'],
			'shipping_cost' => ['nullable', 'numeric', 'min:0'],
			'return_shipment_cost' => ['nullable', 'numeric', 'min:0'],
			'tax' => ['nullable', 'numeric', 'min:0'],
			'insurance' => ['nullable', 'numeric', 'min:0'],
		];

		$message = [
			'from_country_id.required' => 'Please select from country',
			'to_country_id.required' => 'Please select to country',
			'parcel_type_id.required' => 'Please select parcel type',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$internationallyRate = ShippingRateInternationally::findOrFail($id);

		$internationallyRate->from_country_id = $request->from_country_id;
		$internationallyRate->to_country_id = $request->to_country_id;
		$internationallyRate->parcel_type_id = $request->parcel_type_id;
		$internationallyRate->shipping_cost = $request->shipping_cost == null ? 0 : $request->shipping_cost;
		$internationallyRate->return_shipment_cost = $request->return_shipment_cost == null ? 0 : $request->return_shipment_cost;
		$internationallyRate->tax = $request->tax == null ? 0 : $request->tax;
		$internationallyRate->insurance = $request->insurance == null ? 0 : $request->insurance;

		$internationallyRate->save();

		return back()->with('success', 'Shipping rate Update successfully');
	}

	public function stateRateUpdateInternationally(Request $request, $id)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));


		$rules = [
			'from_country_id' => ['required', 'exists:countries,id'],
			'to_country_id' => ['required', 'exists:countries,id'],
			'from_state_id' => ['required', 'exists:states,id'],
			'to_state_id' => ['required', 'exists:states,id'],
			'parcel_type_id' => ['required', 'exists:parcel_types,id'],
			'shipping_cost' => ['nullable', 'numeric', 'min:0'],
			'return_shipment_cost' => ['nullable', 'numeric', 'min:0'],
			'tax' => ['nullable', 'numeric', 'min:0'],
			'insurance' => ['nullable', 'numeric', 'min:0'],
		];

		$message = [
			'from_country_id.required' => 'Please select from country',
			'to_country_id.required' => 'Please select to country',
			'from_state_id.required' => 'Please select from state',
			'to_state_id.required' => 'Please select to state',
			'parcel_type_id.required' => 'Please select parcel type',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$internationallyRate = ShippingRateInternationally::findOrFail($id);

		$internationallyRate->from_country_id = $request->from_country_id;
		$internationallyRate->to_country_id = $request->to_country_id;
		$internationallyRate->from_state_id = $request->from_state_id;
		$internationallyRate->to_state_id = $request->to_state_id;
		$internationallyRate->parcel_type_id = $request->parcel_type_id;
		$internationallyRate->shipping_cost = $request->shipping_cost == null ? 0 : $request->shipping_cost;
		$internationallyRate->return_shipment_cost = $request->return_shipment_cost == null ? 0 : $request->return_shipment_cost;
		$internationallyRate->tax = $request->tax == null ? 0 : $request->tax;
		$internationallyRate->insurance = $request->insurance == null ? 0 : $request->insurance;

		$internationallyRate->save();

		return back()->with('success', 'Shipping rate Update successfully');
	}


	public function cityRateUpdateInternationally(Request $request, $id)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));


		$rules = [
			'from_country_id' => ['required', 'exists:countries,id'],
			'to_country_id' => ['required', 'exists:countries,id'],
			'from_state_id' => ['required', 'exists:states,id'],
			'to_state_id' => ['required', 'exists:states,id'],
			'from_city_id' => ['required', 'exists:cities,id'],
			'to_city_id' => ['required', 'exists:cities,id'],
			'parcel_type_id' => ['required', 'exists:parcel_types,id'],
			'shipping_cost' => ['nullable', 'numeric', 'min:0'],
			'return_shipment_cost' => ['nullable', 'numeric', 'min:0'],
			'tax' => ['nullable', 'numeric', 'min:0'],
			'insurance' => ['nullable', 'numeric', 'min:0'],
		];

		$message = [
			'from_country_id.required' => 'Please select from country',
			'to_country_id.required' => 'Please select to country',
			'from_state_id.required' => 'Please select from state',
			'to_state_id.required' => 'Please select to state',
			'from_city_id.required' => 'Please select from city',
			'to_city_id.required' => 'Please select to city',
			'parcel_type_id.required' => 'Please select parcel type',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		$internationallyRate = ShippingRateInternationally::findOrFail($id);

		$internationallyRate->from_country_id = $request->from_country_id;
		$internationallyRate->to_country_id = $request->to_country_id;
		$internationallyRate->from_state_id = $request->from_state_id;
		$internationallyRate->to_state_id = $request->to_state_id;
		$internationallyRate->from_city_id = $request->from_city_id;
		$internationallyRate->to_city_id = $request->to_city_id;
		$internationallyRate->parcel_type_id = $request->parcel_type_id;
		$internationallyRate->shipping_cost = $request->shipping_cost == null ? 0 : $request->shipping_cost;
		$internationallyRate->return_shipment_cost = $request->return_shipment_cost == null ? 0 : $request->return_shipment_cost;
		$internationallyRate->tax = $request->tax == null ? 0 : $request->tax;
		$internationallyRate->insurance = $request->insurance == null ? 0 : $request->insurance;

		$internationallyRate->save();

		return back()->with('success', 'Shipping rate Update successfully');
	}


	public function shippingDateStore(Request $request)
	{
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'shipping_days' => ['required', 'numeric', 'min:0'],
		];

		$message = [
			'shipping_days.required' => 'Shipping date is required',
		];

		$validate = Validator::make($purifiedData, $rules, $message);

		if ($validate->fails()) {
			return back()->withInput()->withErrors($validate);
		}

		if ($request->shipping_days == null) {
			return back()->with('error', 'Shipping date is required');
		}

		$shippingDate = new ShippingDate();
		$shippingDate->shipping_days = $request->shipping_days;
		$shippingDate->status = $request->status;
		$shippingDate->save();

		return back()->with('success', 'Shipping Date Created Successfully!');
	}


	public function OCGetSelectedLocationShipRate(Request $request)
	{
		$operatorCountryId = BasicControl::first('operator_country');
		$parcelTypeId = $request->parcelTypeId;
		if ($request->fromStateId != null && $request->toStateId != null && $request->fromCityId == null && $request->fromAreaId == null) {
			$shippingRate = ShippingRateOperatorCountry::where('country_id', $operatorCountryId->operator_country)
				->when($parcelTypeId != '', function ($query) use ($parcelTypeId) {
					$query->where('parcel_type_id', $parcelTypeId);
				})
				->where('from_state_id', $request->fromStateId)
				->where('to_state_id', $request->toStateId)
				->first();
			return response($shippingRate);
		} elseif ($request->fromStateId != null && $request->toStateId != null && $request->fromCityId != null && $request->toCityId != null && $request->fromAreaId == null && $request->toAreaId == null) {
			$shippingRate = ShippingRateOperatorCountry::where('country_id', $operatorCountryId->operator_country)
				->when($parcelTypeId != '', function ($query) use ($parcelTypeId) {
					$query->where('parcel_type_id', $parcelTypeId);
				})
				->where('from_state_id', $request->fromStateId)
				->where('to_state_id', $request->toStateId)
				->where('from_city_id', $request->fromCityId)
				->where('to_city_id', $request->toCityId)
				->first();
			return response($shippingRate);
		} elseif ($request->fromStateId != null && $request->toStateId != null && $request->fromCityId != null && $request->toCityId != null && $request->fromAreaId != null && $request->toAreaId != null) {
			$shippingRate = ShippingRateOperatorCountry::where('country_id', $operatorCountryId->operator_country)
				->when($parcelTypeId != '', function ($query) use ($parcelTypeId) {
					$query->where('parcel_type_id', $parcelTypeId);
				})
				->where('from_state_id', $request->fromStateId)
				->where('to_state_id', $request->toStateId)
				->where('from_city_id', $request->fromCityId)
				->where('to_city_id', $request->toCityId)
				->where('from_area_id', $request->fromAreaId)
				->where('to_area_id', $request->toAreaId)
				->first();
			return response($shippingRate);
		}
	}
}
