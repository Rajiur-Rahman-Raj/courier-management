<?php

namespace App\Traits;

use App\Models\OCSAttatchment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

trait OCShipmentStoreTrait {
	public function storePackingService($request, $OperatorCountryShipment){
			$packingService = [];
			foreach($request->package_id as $key => $value){
				$packingService[] = [
					'package_id' => $request->package_id[$key],
					'variant_id' => $request->variant_id[$key],
					'variant_price' => $request->variant_price[$key],
					'variant_quantity' => $request->variant_quantity[$key],
					'package_cost' => $request->package_cost[$key],
				];
			}
		$OperatorCountryShipment['packing_services'] = $packingService;
	}

	public function storeParcelInformation($request, $OperatorCountryShipment){
			$parcelInformation = [];
			foreach ($request->parcel_name as $key => $value){
				$parcelInformation[] = [
					'parcel_name' => $request->parcel_name[$key],
					'parcel_quantity' => $request->parcel_quantity[$key],
					'parcel_type_id' => $request->parcel_type_id[$key],
					'parcel_unit_id' => $request->parcel_unit_id[$key],
					'cost_per_unit' => $request->cost_per_unit[$key],
					'total_unit' => $request->total_unit[$key],
					'parcel_total_cost' => $request->parcel_total_cost[$key],
					'parcel_length' => $request->parcel_length[$key],
					'parcel_width' => $request->parcel_width[$key],
					'parcel_height' => $request->parcel_height[$key],
				];
			}
		$OperatorCountryShipment['parcel_information'] = $parcelInformation;
	}


	public function storeShipmentAttatchments($request, $OperatorCountryShipment){
			foreach ($request->shipment_image as $key => $value){
				try {
					$OCSAttatchment = new OCSAttatchment();
					$OCSAttatchment->operator_country_shipment_id = $OperatorCountryShipment->id;
					$image = $this->fileUpload($request->shipment_image[$key], config('location.shipmentAttatchments.path'), $OCSAttatchment->driver, null);
					if ($image) {
						$OCSAttatchment->image = $image['path'];
						$OCSAttatchment->driver = $image['driver'];
					}
					$OCSAttatchment->save();
				} catch (\Exception $exp) {
					return [
						'status' => 'error',
						'message' => 'could not upload image',
					];
				}
			}

			return [
				'status' => 'success',
			];
	}


	public function walletPaymentCalculation($request, $shipmentId){
		$paymnetBy = $request->payment_by;
		if ($paymnetBy == 1){
			$paymentFrom = $request->sender_id;
		}else{
			$paymentFrom = $request->receiver_id;
		}

		$amount = $request->total_pay;
		$user = User::findOrFail($paymentFrom);
		$userBalance = $user->balance;
		if ($amount > $userBalance) {
			return back()->with('error', 'Insufficient Balance');
		}

		$new_balance = getAmount($userBalance - $amount);
		$user->balance = $new_balance;
		$user->save();
		$basic = basicControl();

		$msg = [
			'currency' => $basic->currency_symbol,
			'amount' => $amount,
			'shipment_id' => $shipmentId,
		];

		$action = [
			"link" => "#",
			"icon" => "fa fa-money-bill-alt text-white"
		];

		$this->userPushNotification($user, 'PAYMENT_FOR_COURIER_SHIPMENT', $msg, $action);

		$this->sendMailSms($user, $type = 'PAYMENT_FOR_COURIER_SHIPMENT', [
			'amount' => getAmount($amount),
			'currency' => $basic->currency_symbol,
			'shipment_id' => $shipmentId,
		]);

	}

}
