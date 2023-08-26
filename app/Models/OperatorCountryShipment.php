<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorCountryShipment extends Model
{
    use HasFactory;

	protected $guarded = ['id'];
	protected $table = 'operator_country_shipments';
	protected $fillable = [
		'shipment_type',
		'shipment_id',
		'receive_amount',
		'shipment_date',
		'delivery_date',
		'sender_branch',
		'receiver_branch',
		'sender_id',
		'receiver_id',
		'from_state_id',
		'from_city_id',
		'from_area_id',
		'to_state_id',
		'to_city_id',
		'to_area_id',
		'payment_by',
		'payment_type',
		'payment_status',
		'packing_services',
		'parcel_information',
		'parcel_details',
		'discount',
		'discount_amount',
		'sub_total',
		'shipping_cost',
		'tax',
		'insurance',
		'pickup_cost',
		'supply_cost',
		'total_pay',
		'status'
	];

	protected $casts = [
		'packing_services' => 'array',
		'parcel_information' => 'array',
	];

}
