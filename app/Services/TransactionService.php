<?php

namespace App\Services;
use App\Models\Shipment;
use App\Traits\Notify;
use App\Traits\Upload;
use Carbon\Carbon;


class TransactionService
{
    use Upload, Notify;

	public function requestedShipmentAccept($shipment, $transaction, $trans = null, $payment_by = null){
		$transaction->shipment_id = $shipment->id;
		$transaction->branch_id = $shipment->sender_branch;
		$transaction->user_id = $payment_by;
		$transaction->amount = round($shipment->total_pay, 2);
		$transaction->charge = 0;
		$transaction->trx_type = '+';
		$transaction->trx_id = $trans;
		$transaction->remarks = 'Accept shipment request & Payment complete for this shipment. ' . 'Shipment Id: '. '('.$shipment->shipment_id.')'. " Now this shipment currently in queue";
		$transaction->transactional_type = Shipment::class;
		$shipment->transactional()->save($transaction);
	}
}
