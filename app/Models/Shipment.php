<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

	protected $guarded = ['id'];
	protected $table = 'shipments';
	protected $fillable = [
		'shipment_identifier',
		'shipment_type',
		'shipment_id',
		'receive_amount',
		'shipment_date',
		'delivery_date',
		'sender_branch',
		'receiver_branch',
		'sender_id',
		'receiver_id',
		'from_country_id',
		'from_state_id',
		'from_city_id',
		'from_area_id',
		'to_country_id',
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
		'first_fiv',
		'last_fiv',
		'total_pay',
		'status'
	];

	protected $casts = [
		'packing_services' => 'array',
		'parcel_information' => 'array',
	];

	public function senderBranch(){
		return $this->belongsTo(Branch::class, 'sender_branch', 'id');
	}

	public function receiverBranch(){
		return $this->belongsTo(Branch::class, 'receiver_branch', 'id');
	}

	public function sender(){
		return $this->belongsTo(User::class, 'sender_id', 'id');
	}

	public function receiver(){
		return $this->belongsTo(User::class, 'receiver_id', 'id');
	}

	public function fromCountry(){
		return $this->belongsTo(Country::class, 'from_country_id', 'id');
	}

	public function fromState(){
		return $this->belongsTo(State::class, 'from_state_id', 'id');
	}

	public function fromCity(){
		return $this->belongsTo(City::class, 'from_city_id', 'id');
	}

	public function fromArea(){
		return $this->belongsTo(Area::class, 'from_area_id', 'id');
	}

	public function toCountry(){
		return $this->belongsTo(Country::class, 'to_country_id', 'id');
	}

	public function toState(){
		return $this->belongsTo(State::class, 'to_state_id', 'id');
	}

	public function toCity(){
		return $this->belongsTo(City::class, 'to_city_id', 'id');
	}

	public function toArea(){
		return $this->belongsTo(Area::class, 'to_area_id', 'id');
	}
}
