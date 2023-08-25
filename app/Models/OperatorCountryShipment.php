<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorCountryShipment extends Model
{
    use HasFactory;

	protected $guarded = ['id'];

	protected $casts = [
		'packing_service' => 'array',
		'parcel_information' => 'array',
	];

}
