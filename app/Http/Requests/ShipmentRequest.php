<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$rules = [
			'shipment_type' => ['required', Rule::in(['drop_off', 'pickup', 'condition'])],
			'shipment_date' => ['required'],
			'delivery_date' => ['required'],
			'sender_branch' => ['required', 'exists:branches,id'],
			'receiver_branch' => ['required', 'exists:branches,id'],
			'sender_id' => ['required', 'exists:users,id'],
			'receiver_id' => ['required', 'exists:users,id'],
			'from_state_id' => ['required', 'exists:states,id'],
			'from_city_id' => ['nullable'],
			'from_area_id' => ['nullable'],
			'to_state_id' => ['required', 'exists:states,id'],
			'to_city_id' => ['nullable'],
			'to_area_id' => ['nullable'],
			'payment_by' => ['required', Rule::in(['1', '2'])],
			'payment_type' => ['required', Rule::in(['wallet', 'cash'])],
			'payment_status' => ['required', Rule::in(['1', '2'])],
			'package_id' => ['required_if:packing_service, yes', 'exists:packages,id'],
			'variant_id' => ['required_if:packing_service, yes'],
			'variant_quantity' => ['required_if:packing_service, yes'],
		];

		if ($this->input('shipment_type') === 'drop_off' || $this->input('shipment_type') === 'pickup') {
			$rules['parcel_name'] = ['required'];
			$rules['parcel_quantity'] = ['required', 'min:1'];
			$rules['parcel_type_id'] = ['required', 'exists:parcel_types,id'];
			$rules['parcel_unit_id'] = ['required', 'exists:parcel_units,id'];
			$rules['total_unit'] = ['required'];
		}

		if ($this->input('shipment_type') === 'condition') {
			$rules['receive_amount'] = ['required', 'numeric', 'min:1'];
			$rules['parcel_details'] = ['required', 'max:5000'];
		}

        return $rules;
    }

	public function messages()
	{
		return [
			'sender_id.required' => 'The sender field is required.',
			'receiver_id.required' => 'The Receiver field is required.',
		];
	}
}
