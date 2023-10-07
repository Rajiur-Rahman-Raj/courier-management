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

	public function getSenderBranchManager($shipment){
		return optional(optional($shipment->senderBranch)->branchManager)->admin;
	}

	public function getReceiverBranchManager($shipment){
		return optional(optional($shipment->receiverBranch)->branchManager)->admin;
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

		$this->adminPushNotification($this->getSenderBranchManager($shipment),'ADMIN_NOTIFY_SHIPMENT_REQUEST_ACCEPT', $params, $adminAction, $superAdmin = 1);
		$this->adminMail($this->getSenderBranchManager($shipment), 'ADMIN_MAIL_SHIPMENT_REQUEST_ACCEPT', $params, $subject = null, $requestMessage = null, $superAdmin = 1);

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

			$this->adminPushNotification($this->getSenderBranchManager($shipment),'ADMIN_NOTIFY_SHIPMENT_REQUEST_CANCEL_WITH_REFUND', $params, $adminAction, $superAdmin = 1);
			$this->adminMail($this->getSenderBranchManager($shipment), 'ADMIN_MAIL_SHIPMENT_REQUEST_CANCEL_WITH_REFUND', $params, $subject = null, $requestMessage = null, $superAdmin = 1);
		}else{
			$params = [
				'sender' => optional($shipment->sender)->name,
				'shipmentId' => $shipment->shipment_id,
			];
			$this->userPushNotification($shipment->sender, 'USER_NOTIFY_SHIPMENT_REQUEST_CANCEL', $params, $userAction);
			$this->sendMailSms($shipment->sender, 'USER_MAIL_SHIPMENT_REQUEST_CANCEL', $params);

			$this->adminPushNotification($this->getSenderBranchManager($shipment),'ADMIN_NOTIFY_SHIPMENT_REQUEST_CANCEL', $params, $adminAction, $superAdmin = 1);
			$this->adminMail($this->getSenderBranchManager($shipment), 'ADMIN_MAIL_SHIPMENT_REQUEST_CANCEL', $params, $subject = null, $requestMessage = null, $superAdmin = 1);
		}
	}

	public function cancelShipmentRequestRefundMoney($shipment, $user, $refundAmount){
		$params = [
			'user' => $user->name,
			'shipmentId' => $shipment->shipment_id,
			'refundAmount' => getAmount($refundAmount),
			'currency' => config('basic.currency_symbol'),
		];

		$adminAction = [
			"link" => route('shipmentList', ['shipment_status' => 'requested', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fas fa-truck text-white"
		];

		$this->adminPushNotification($this->getSenderBranchManager($shipment),'ADMIN_NOTIFY_SHIPMENT_REQUEST_CANCEL_REFUND_MONEY', $params, $adminAction, $superAdmin = 1);
		$this->adminMail($this->getSenderBranchManager($shipment), 'ADMIN_MAIL_SHIPMENT_REQUEST_CANCEL_REFUND_MONEY', $params, $subject = null, $requestMessage = null, $superAdmin = 1);


		$userAction = [
			"link" => route('user.shipmentList', ['shipment_status' => 'requested', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fal fa-truck text-white"
		];

		$this->userPushNotification($shipment->sender, 'USER_NOTIFY_SHIPMENT_REQUEST_CANCEL_REFUND_MONEY', $params, $userAction);
		$this->sendMailSms($shipment->sender, 'USER_MAIL_SHIPMENT_REQUEST_CANCEL_REFUND_MONEY', $params);
	}

	public function dispatchShipmentRequest($shipment){
		$senderParams = [
			'sender' => optional($shipment->sender)->name,
			'shipmentId' => $shipment->shipment_id,
			'dispatchTime' => $shipment->dispatch_time,
		];

		$receiverParams = [
			'receiver' => optional($shipment->receiver)->name,
			'shipmentId' => $shipment->shipment_id,
			'dispatchTime' => $shipment->dispatch_time,
		];

		$adminAction = [
			"link" => route('shipmentList', ['shipment_status' => 'dispatch', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fas fa-truck text-white"
		];

		$this->adminPushNotification($this->getSenderBranchManager($shipment),'ADMIN_NOTIFY_SHIPMENT_DISPATCH', $senderParams, $adminAction, $superAdmin = 1);
		$this->adminMail($this->getSenderBranchManager($shipment), 'ADMIN_MAIL_SHIPMENT_DISPATCH', $senderParams, $subject = null, $requestMessage = null, $superAdmin = 1);


		$userAction = [
			"link" => route('user.shipmentList', ['shipment_status' => 'dispatch', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fal fa-truck text-white"
		];

		$this->userPushNotification($shipment->sender, 'SENDER_NOTIFY_SHIPMENT_DISPATCH', $senderParams, $userAction);
		$this->sendMailSms($shipment->sender, 'SENDER_MAIL_SHIPMENT_DISPATCH', $senderParams);

		$this->userPushNotification($shipment->receiver, 'RECEIVER_NOTIFY_SHIPMENT_DISPATCH', $receiverParams);
		$this->sendMailSms($shipment->receiver, 'RECEIVER_MAIL_SHIPMENT_DISPATCH', $receiverParams);
	}

	public function receiveShipmentRequest($shipment){

		$senderParams = [
			'sender' => optional($shipment->sender)->name,
			'senderBranch' => optional($shipment->senderBranch)->branch_name,
			'receiverBranch' => optional($shipment->receiverBranch)->branch_name,
			'shipmentId' => $shipment->shipment_id,
			'receiveTime' => $shipment->receive_time,
		];

		$receiverParams = [
			'receiver' => optional($shipment->receiver)->name,
			'senderBranch' => optional($shipment->senderBranch)->branch_name,
			'receiverBranch' => optional($shipment->receiverBranch)->branch_name,
			'shipmentId' => $shipment->shipment_id,
			'receiveTime' => $shipment->dispatch_time,
		];

		$adminAction = [
			"link" => route('shipmentList', ['shipment_status' => 'received', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fas fa-truck text-white"
		];

		$this->adminPushNotification($this->getSenderBranchManager($shipment),'ADMIN_NOTIFY_SHIPMENT_RECEIVED', $senderParams, $adminAction, $superAdmin = 1);
		$this->adminMail($this->getSenderBranchManager($shipment), 'ADMIN_MAIL_SHIPMENT_RECEIVED', $senderParams, $subject = null, $requestMessage = null, $superAdmin = 1);

		$userAction = [
			"link" => route('user.shipmentList', ['shipment_status' => 'received', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fal fa-truck text-white"
		];

		$this->userPushNotification($shipment->sender, 'SENDER_NOTIFY_SHIPMENT_RECEIVED', $senderParams, $userAction);
		$this->sendMailSms($shipment->sender, 'SENDER_MAIL_SHIPMENT_RECEIVED', $senderParams);
//
		$this->userPushNotification($shipment->receiver, 'RECEIVER_NOTIFY_SHIPMENT_RECEIVED', $receiverParams);
		$this->sendMailSms($shipment->receiver, 'RECEIVER_MAIL_SHIPMENT_RECEIVED', $receiverParams);
	}

	public function deliveredShipmentRequest($shipment){

		$senderParams = [
			'sender' => optional($shipment->sender)->name,
			'receiver' => optional($shipment->receiver)->name,
			'senderBranch' => optional($shipment->senderBranch)->branch_name,
			'receiverBranch' => optional($shipment->receiverBranch)->branch_name,
			'shipmentId' => $shipment->shipment_id,
			'deliveredTime' => $shipment->receive_time,
		];

		$receiverParams = [
			'sender' => optional($shipment->sender)->name,
			'receiver' => optional($shipment->receiver)->name,
			'senderBranch' => optional($shipment->senderBranch)->branch_name,
			'receiverBranch' => optional($shipment->receiverBranch)->branch_name,
			'shipmentId' => $shipment->shipment_id,
			'deliveredTime' => $shipment->receive_time,
		];

		$adminAction = [
			"link" => route('shipmentList', ['shipment_status' => 'delivered', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fas fa-truck text-white"
		];

		$this->adminPushNotification($this->getSenderBranchManager($shipment),'ADMIN_NOTIFY_SHIPMENT_DELIVERED', $senderParams, $adminAction, $superAdmin = 1);
		$this->adminMail($this->getSenderBranchManager($shipment), 'ADMIN_MAIL_SHIPMENT_DELIVERED', $senderParams, $subject = null, $requestMessage = null, $superAdmin = 1);

		$userAction = [
			"link" => route('user.shipmentList', ['shipment_status' => 'delivered', 'shipment_type' => $this->getShipmentType($shipment)]),
			"icon" => "fal fa-truck text-white"
		];

		$this->userPushNotification($shipment->sender, 'SENDER_NOTIFY_SHIPMENT_DELIVERED', $senderParams, $userAction);
		$this->sendMailSms($shipment->sender, 'SENDER_MAIL_SHIPMENT_DELIVERED', $senderParams);
//
		$this->userPushNotification($shipment->receiver, 'RECEIVER_NOTIFY_SHIPMENT_DELIVERED', $receiverParams);
		$this->sendMailSms($shipment->receiver, 'RECEIVER_MAIL_SHIPMENT_DELIVERED', $receiverParams);
	}

}
