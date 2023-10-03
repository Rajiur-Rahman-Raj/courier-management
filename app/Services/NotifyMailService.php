<?php

namespace App\Services;
use App\Traits\Notify;
use App\Traits\Upload;
use Carbon\Carbon;


class NotifyMailService
{
    use Upload, Notify;

	public function getShipmentType($shipment){
		if ($shipment->shipment_identifier == 1){
			$shipment_type = 'operator-country';
		}else{
			$shipment_type = 'internationally';
		}

		return $shipment_type;
	}

	public function acceptShipmentRequestNotify($shipment, $trans = null){


		$params = [
			'sender' => optional($shipment->sender)->name,
			'shipmentId' => $shipment->shipment_id,
			'amount' => getAmount($shipment->total_pay),
			'currency' => config('basic.currency_symbol'),
			'transaction' => $trans,
		];

		$adminAction = [
			"link" => route('shipmentList', ['shipment_status' => 'in_queue', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fas fa-truck text-white"
		];

		$branchManager = optional(optional($shipment->senderBranch)->branchManager)->admin;
		$this->adminPushNotification($branchManager,'ADMIN_NOTIFY_SHIPMENT_REQUEST_ACCEPT', $params, $adminAction, $superAdmin = 1);
		$this->adminMail($branchManager, 'ADMIN_MAIL_SHIPMENT_REQUEST_ACCEPT', $params, $subject = null, $requestMessage = null, $superAdmin = 1);


		$userAction = [
			"link" => route('user.shipmentList', ['shipment_status' => 'in_queue', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fal fa-truck text-white"
		];

		$this->userPushNotification($shipment->sender, 'USER_NOTIFY_SHIPMENT_REQUEST_ACCEPT', $params, $userAction);
		$this->sendMailSms($shipment->sender, 'USER_MAIL_SHIPMENT_REQUEST_ACCEPT', $params);
	}

	public function cancelShipmentRequestNotify($shipment, $refund_time, $refund_time_type){

		$userAction = [
			"link" => route('user.shipmentList', ['shipment_status' => 'requested', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fas fa-truck text-white"
		];

		$adminAction = [
			"link" => route('shipmentList', ['shipment_status' => 'requested', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fas fa-truck text-white"
		];

		$branchManager = optional(optional($shipment->senderBranch)->branchManager)->admin;

		if ($shipment->payment_type == 'wallet' && $shipment->payment_status == 1){
			$params = [
				'sender' => optional($shipment->sender)->name,
				'shipmentId' => $shipment->shipment_id,
				'amount' => getAmount($shipment->total_pay),
				'currency' => config('basic.currency_symbol'),
				'refund_time' => $refund_time,
				'refund_time_type' => $refund_time_type
			];
			$this->userPushNotification($shipment->sender, 'USER_NOTIFY_SHIPMENT_REQUEST_CANCEL_WITH_REFUND', $params, $userAction);
			$this->sendMailSms($shipment->sender, 'USER_MAIL_SHIPMENT_REQUEST_CANCEL_WITH_REFUND', $params);

			$this->adminPushNotification($branchManager,'ADMIN_NOTIFY_SHIPMENT_REQUEST_CANCEL_WITH_REFUND', $params, $adminAction, $superAdmin = 1);
			$this->adminMail($branchManager, 'ADMIN_MAIL_SHIPMENT_REQUEST_CANCEL_WITH_REFUND', $params, $subject = null, $requestMessage = null, $superAdmin = 1);
		}else{
			$params = [
				'sender' => optional($shipment->sender)->name,
				'shipmentId' => $shipment->shipment_id,
			];
			$this->userPushNotification($shipment->sender, 'USER_NOTIFY_SHIPMENT_REQUEST_CANCEL', $params, $userAction);
			$this->sendMailSms($shipment->sender, 'USER_MAIL_SHIPMENT_REQUEST_CANCEL', $params);

			$this->adminPushNotification($branchManager,'ADMIN_NOTIFY_SHIPMENT_REQUEST_CANCEL', $params, $adminAction, $superAdmin = 1);
			$this->adminMail($branchManager, 'ADMIN_MAIL_SHIPMENT_REQUEST_CANCEL', $params, $subject = null, $requestMessage = null, $superAdmin = 1);
		}
	}

}
