<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicControl;
use App\Models\Branch;
use App\Models\Country;
use App\Models\DefaultShippingRateInternationally;
use App\Models\DefaultShippingRateOperatorCountry;
use App\Models\ParcelType;
use App\Models\ShippingDate;
use App\Models\ShippingRateOperatorCountry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class ShipmentController extends Controller
{

	public function shipmentList(){
		return view('admin.shipments.index');
	}

	public function createShipment(){
		$data['allBranches'] = Branch::where('status', 1);
		return view('admin.shipments.create', $data);
	}


	public function defaultRate(){
		$data['basicControl'] = BasicControl::with('operatorCountry')->first();
		$data['allShippingDates'] = ShippingDate::where('status', 1)->get();
		$data['allParcelTypes'] = ParcelType::where('status', 1)->get();
		$data['defaultShippingRateOperatorCountry'] = DefaultShippingRateOperatorCountry::first();
		$data['defaultShippingRateInternationally'] = DefaultShippingRateInternationally::first();
		return view('admin.shippingRate.defaultRate', $data);
	}

	public function defaultShippingRateOperatorCountryUpdate(Request $request, $id){

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
			'parcel_type_id' => ['exists:parcel_types,id'],
			'shipping_cost_first_unit' => ['numeric', 'min:0'],
			'return_shipping_cost_first_unit' => ['numeric', 'min:0'],
			'default_tax_first_unit' => ['numeric', 'min:0'],
			'default_insurance_first_unit' => ['numeric', 'min:0'],
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
		$defaultShippingRateOperatorCountry->parcel_type_id = $request->parcel_type_id;
		$defaultShippingRateOperatorCountry->shipping_cost_first_unit = $request->shipping_cost_first_unit;
		$defaultShippingRateOperatorCountry->return_shipment_cost_first_unit = $request->return_shipment_cost_first_unit;
		$defaultShippingRateOperatorCountry->default_tax_first_unit = $request->default_tax_first_unit;
		$defaultShippingRateOperatorCountry->default_insurance_first_unit = $request->default_insurance_first_unit;

		$defaultShippingRateOperatorCountry->save();

		return back()->with('success', 'Default rate update successfully');
	}

	public function defaultShippingRateInternationallyUpdate(Request $request, $id){

		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'shipping_date_id' => ['required', 'exists:shipping_dates,id'],
			'pickup_cost' => ['numeric', 'min:0'],
			'supply_cost' => ['numeric', 'min:0'],
			'shipping_cost' => ['numeric', 'min:0'],
			'return_shipment_cost' => ['numeric', 'min:0'],
			'default_tax' => ['numeric', 'min:0'],
			'default_insurance' => ['numeric', 'min:0'],
			'parcel_type_id' => ['exists:parcel_types,id'],
			'shipping_cost_first_unit' => ['numeric', 'min:0'],
			'return_shipping_cost_first_unit' => ['numeric', 'min:0'],
			'default_tax_first_unit' => ['numeric', 'min:0'],
			'default_insurance_first_unit' => ['numeric', 'min:0'],
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
		$defaultShippingRateInternationally->parcel_type_id = $request->parcel_type_id;
		$defaultShippingRateInternationally->shipping_cost_first_unit = $request->shipping_cost_first_unit;
		$defaultShippingRateInternationally->return_shipment_cost_first_unit = $request->return_shipment_cost_first_unit;
		$defaultShippingRateInternationally->default_tax_first_unit = $request->default_tax_first_unit;
		$defaultShippingRateInternationally->default_insurance_first_unit = $request->default_insurance_first_unit;

		$defaultShippingRateInternationally->save();
		Session::flash('active-tab', 'tab2');
		return back()->with('success', 'Default rate internationally update successfully');
	}


	public function operatorCountryRate(Request $request, $type=null){
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

	public function operatorCountryShowRate(Request $request, $type=null, $id=null){
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
			->when($type == 'state-list', function ($query){
				$query->whereNull(['from_city_id', 'from_area_id']);
			})
			->when($type == 'city-list', function ($query){
				$query->whereNotNull('from_city_id')->whereNull('from_area_id');
			})
			->when($type == 'area-list', function ($query){
				$query->whereNotNull('from_area_id');
			})
			->where('parcel_type_id', $id)
			->paginate(config('basic.paginate'));

		return view($operatorCountryShowShippingRateManagement[$type]['show_shipping_rate_view'], $data);
	}


	public function stateRateUpdate(Request $request, $id){
		$purifiedData = Purify::clean($request->except('_token', '_method'));

		$rules = [
			'from_state_id' => ['required', 'exists:states,id'],
			'to_state_id' => ['required', 'exists:states,id'],
			'parcel_type_id' => ['required', 'exists:parcel_types,id'],
			'shipping_cost' => ['nullable', 'numeric', 'min:0'],
			'return_shipment_cost' => ['nullable', 'numeric', 'min:0'],
			'tax' => ['nullable', 'numeric', 'min:0'],
			'insurance' => ['nullable', 'numeric', 'min:0'],
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

		$operatorCountry->save();

		return back()->with('success', 'Shipping rate Update successfully');
	}

	public function cityRateUpdate(Request $request, $id){
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

		$operatorCountry->save();

		return back()->with('success', 'Shipping rate Update successfully');
	}

	public function areaRateUpdate(Request $request, $id){
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

		$operatorCountry->save();

		return back()->with('success', 'Shipping rate Update successfully');
	}



	public function createShippingRateOperatorCountry(){
		$data['allCountries'] = Country::where('status', 1)->get();
		$data['basicControl'] = BasicControl::with('operatorCountry')->first();
		$data['allParcelTypes'] = ParcelType::where('status', 1)->get();
		return view('admin.shippingRate.operatorCountry.create', $data);
	}

	public function shippingRateOperatorCountryStore(Request $request, $type=null){
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
		];

		$message = [
			'operator_country_id.required' => 'Select Operator Country',
			'from_state_id.required' => 'Please select from state',
			'to_state_id.required' => 'Please select to state',
			'parcel_type_id.required' => 'Please select parcel type',
		];

		if ($type == 'city-wise'){
			$rules['from_city_id'] = ['required', 'exists:cities,id'];
			$rules['to_city_id'] = ['required', 'exists:cities,id'];
			$message['from_city_id.required'] = 'please select from city';
			$message['to_city_id.required'] = 'please select to city';
		}elseif ($type == 'area-wise'){
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

		if ($type == 'city-wise'){
			$operatorCountry->from_city_id = $request->from_city_id;
			$operatorCountry->to_city_id = $request->to_city_id;
		}elseif ($type == 'area-wise'){
			$operatorCountry->from_city_id = $request->from_city_id;
			$operatorCountry->to_city_id = $request->to_city_id;
			$operatorCountry->from_area_id = $request->from_area_id;
			$operatorCountry->to_area_id = $request->to_area_id;
		}

		$operatorCountry->save();

		return back()->with('success', 'Shipping rate created successfully');
	}













	public function internationallyRate(){
		dd('this is internationally rate list');
	}

	public function shippingDateStore(Request $request){
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
}