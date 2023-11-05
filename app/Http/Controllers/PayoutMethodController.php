<?php

namespace App\Http\Controllers;

use App\Models\PayoutMethod;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class PayoutMethodController extends Controller
{
	use Upload;

	public function addMethod(Request $request)
	{
		if ($request->isMethod('get')) {
			return view('admin.payoutMethod.create');
		} elseif ($request->isMethod('post')) {

			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'methodName' => 'required|min:3|max:50|unique:payout_methods',
				'description' => 'required|min:3|max:50',
				'min_limit' => 'required|numeric|not_in:0',
				'max_limit' => 'required|numeric|not_in:0',
				'percentage_charge' => 'required|numeric|not_in:0',
				'fixed_charge' => 'required|numeric|not_in:0',
				'fieldName.*' => 'required|string|min:3',
				'fieldType.*' => 'required|string|min:3',
				'fieldValidation.*' => 'required|string|min:3',
				'is_active' => 'nullable|integer|min:0|in:0,1',
			], [
				'min' => 'This field must be at least :min characters.',
				'string' => 'This field must be :string.',
				'required' => 'This field is required.',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;

			$inputForm = [];
			if (isset($purifiedData->fieldType)) {
				$inputs = [];
				for ($i = 0; $i < count($purifiedData->fieldType); $i++) {
					$inputs['name'] = strtolower(Str::snake($purifiedData->fieldName[$i]));
					$inputs['label'] = $purifiedData->fieldName[$i];
					$inputs['type'] = $purifiedData->fieldType[$i];
					$inputs['validation'] = $purifiedData->fieldValidation[$i];
					$inputForm[$inputs['name']] = $inputs;
				}
			}

			$payoutMethod = new PayoutMethod();
			$payoutMethod->methodName = $purifiedData->methodName;
			$payoutMethod->description = $purifiedData->description;
			$payoutMethod->min_limit = $purifiedData->min_limit;
			$payoutMethod->max_limit = $purifiedData->max_limit;
			$payoutMethod->percentage_charge = $purifiedData->percentage_charge;
			$payoutMethod->fixed_charge = $purifiedData->fixed_charge;
			$payoutMethod->is_active = $purifiedData->is_active;
			$payoutMethod->inputForm = (empty($inputForm)) ? null : json_encode($inputForm);

			if ($request->file('logo') && $request->file('logo')->isValid()) {
				$extension = $request->logo->extension();
				$logoName = strtolower($purifiedData->methodName . '.' . $extension);

				$image = $this->fileUpload($request->logo, config('location.methodLogo.path'), null, $logoName);
				if ($image) {
					$payoutMethod->logo = $image['path'];
					$payoutMethod->driver = $image['driver'];
				}
			}

			$payoutMethod->save();
			return redirect(route('payout.method.list'))->with('success', 'Method Successfully Saved');
		}
	}

	public function index()
	{
		$payoutMethods = PayoutMethod::latest()->paginate();

		return view('admin.payoutMethod.index', compact('payoutMethods'));
	}

	public function edit(Request $request, PayoutMethod $payoutMethod)
	{
		if ($request->isMethod('get')) {
			return view('admin.payoutMethod.edit', compact('payoutMethod'));
		} elseif ($request->isMethod('put')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'methodName' => 'required|min:3|max:50|unique:payout_methods,methodName,' . $payoutMethod->id,
				'description' => 'required|min:3|max:50',
				'min_limit' => 'required|numeric|not_in:0',
				'max_limit' => 'required|numeric|not_in:0',
				'percentage_charge' => 'required|numeric|not_in:0',
				'fixed_charge' => 'required|numeric|not_in:0',
				'fieldName.*' => 'required|string|min:3',
				'fieldType.*' => 'required|string|min:3',
				'fieldValidation.*' => 'required|string|min:3',
				'is_active' => 'nullable|integer|min:0|in:0,1',
			], [
				'min' => 'This field must be at least :min characters.',
				'string' => 'This field must be :string.',
				'required' => 'This field is required.',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;

			$inputForm = [];
			if (isset($purifiedData->fieldType)) {
				$inputs = [];
				for ($i = 0; $i < count($purifiedData->fieldType); $i++) {
					$inputs['name'] = strtolower(Str::snake($purifiedData->fieldName[$i]));
					$inputs['label'] = $purifiedData->fieldName[$i];
					$inputs['type'] = $purifiedData->fieldType[$i];
					$inputs['validation'] = $purifiedData->fieldValidation[$i];
					$inputForm[$inputs['name']] = $inputs;
				}
			}

			$payoutMethod->methodName = $purifiedData->methodName;
			$payoutMethod->description = $purifiedData->description;
			$payoutMethod->min_limit = $purifiedData->min_limit;
			$payoutMethod->max_limit = $purifiedData->max_limit;
			$payoutMethod->percentage_charge = $purifiedData->percentage_charge;
			$payoutMethod->fixed_charge = $purifiedData->fixed_charge;
			$payoutMethod->is_active = $purifiedData->is_active;
			$payoutMethod->inputForm = (empty($inputForm)) ? null : json_encode($inputForm);

			if ($request->file('logo') && $request->file('logo')->isValid()) {
				$extension = $request->logo->extension();
				$logoName = strtolower($purifiedData->methodName . '.' . $extension);
				$old = $payoutMethod->logo;
				$image = $this->fileUpload($request->logo, config('location.methodLogo.path'), $payoutMethod->driver, null, $old);
				if ($image) {
					$payoutMethod->logo = $image['path'];
					$payoutMethod->driver = $image['driver'];
				}
			}

			$payoutMethod->save();

			return redirect(route('payout.method.list'))->with('success', 'Method Successfully Saved');
		}
	}
}
