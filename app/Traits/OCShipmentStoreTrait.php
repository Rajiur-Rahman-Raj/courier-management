<?php

namespace App\Traits;

use App\Models\OCSAttatchment;
use Illuminate\Support\Facades\DB;

trait OCShipmentStoreTrait {
	public function storePackingService($request, $OperatorCountryShipment){
		if ($request->packing_service == 'yes'){
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
			$OperatorCountryShipment->packing_service = $packingService;
		}
	}

	public function storeParcelInformation($request, $OperatorCountryShipment){
		if ($request->shipment_type == 'drop_off' || $request->shipment_type == 'pickup'){
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
			$OperatorCountryShipment->parcel_information = $parcelInformation;

		}
	}


	public function storeShipmentAttatchments($request, $OperatorCountryShipment){
		if ($request->hasFile('shipment_image')){
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
					DB::rollBack();
					return back()->with('error', 'could not upload image');
				}
			}
		}
	}
}
