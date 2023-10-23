<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Deposit;
use App\Models\Payout;
use App\Models\Shipment;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
	public function index()
	{
		$admin = Auth::guard('admin')->user();
		$basicControl = basicControl();
		$last30 = date('Y-m-d', strtotime('-30 days'));
		$last7 = date('Y-m-d', strtotime('-7 days'));
		$today = today();

		$dayCount = date('t', strtotime($today));
		$data['yearLabels'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

		$users = User::selectRaw('COUNT(id) AS totalUser')
			->selectRaw('COUNT((CASE WHEN status = 1  THEN id END)) AS activeUser')
			->selectRaw("COUNT((CASE WHEN created_at >= $last30 THEN id END)) AS last_30_days_join")
			->selectRaw('SUM(balance) AS totalUserBalance')
			->selectRaw('COUNT((CASE WHEN email_verified_at IS NOT NULL  THEN id END)) AS verifiedUser')
			->get()->makeHidden(['mobile', 'profile'])->toArray();

		$data['userRecord'] = collect($users)->collapse();

		$tickets = Ticket::selectRaw('COUNT((CASE WHEN status = 0  THEN id END)) AS pendingTickets')
			->selectRaw('COUNT((CASE WHEN status = 1 THEN id END)) AS answeredTickets')
			->selectRaw('COUNT((CASE WHEN status = 2 THEN id END)) AS repliedTickets')
			->selectRaw('COUNT((CASE WHEN status = 2 THEN id END)) AS closedTickets')
			->get()->toArray();

		$data['ticketRecord'] = collect($tickets)->collapse();

		$branches = Branch::selectRaw('COUNT(branches.id) AS totalBranches')
			->selectRaw('COUNT(CASE WHEN branches.status = 1 THEN branches.id END) AS totalActiveBranches')
			->selectRaw('COUNT(CASE WHEN branches.status = 0 THEN branches.id END) AS totalInactiveBranches')
			->selectRaw('COUNT(branch_managers.id) AS totalBranchManagers')
			->selectRaw('COUNT(branch_drivers.id) AS totalBranchDrivers')
			->selectRaw('COUNT(branch_employees.id) AS totalBranchEmployees')
			->leftJoin('branch_managers', 'branches.id', '=', 'branch_managers.branch_id')
			->leftJoin('branch_drivers', 'branches.id', '=', 'branch_drivers.branch_id')
			->leftJoin('branch_employees', 'branches.id', '=', 'branch_employees.branch_id')
			->get()
			->toArray();

		$data['branchRecord'] = collect($branches)->collapse();

		$shipments = Shipment::selectRaw('COUNT(shipments.id) AS totalShipments')
			->selectRaw('COUNT(CASE WHEN shipments.shipment_identifier = 1 THEN shipments.id END) AS totalOperatorCountryShipments')
			->selectRaw('COUNT(CASE WHEN shipments.shipment_identifier = 2 THEN shipments.id END) AS totalInternationallyShipments')
			->selectRaw('COUNT((CASE WHEN created_at >= CURDATE() THEN id END)) AS totalTodayShipments')
			->selectRaw('COUNT(CASE WHEN shipments.shipment_type = "drop_off" THEN shipments.id END) AS totalDropOffShipments')
			->selectRaw('COUNT(CASE WHEN shipments.shipment_type = "pickup" THEN shipments.id END) AS totalPickupShipments')
			->selectRaw('COUNT(CASE WHEN shipments.shipment_type = "condition" THEN shipments.id END) AS totalConditionShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 0 THEN shipments.id END) AS totalPendingShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 1 THEN shipments.id END) AS totalInQueueShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 2 THEN shipments.id END) AS totalDispatchShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 3 THEN shipments.id END) AS totalDeliveryInQueueShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 4 THEN shipments.id END) AS totalDeliveredShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 8 THEN shipments.id END) AS totalReturnInQueueShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 9 THEN shipments.id END) AS totalReturnInDispatchShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 9 THEN shipments.id END) AS totalReturnInDispatchShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 10 THEN shipments.id END) AS totalReturnDeliveryInQueueShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 11 THEN shipments.id END) AS totalReturnInDelivered')
			->get()
			->toArray();

		$data['shipmentRecord'] = collect($shipments)->collapse();

		$shipmentTransactions = Transaction::selectRaw('SUM(CASE WHEN shipment_id IS NOT NULL THEN amount ELSE 0 END) AS totalShipmentTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type = "drop_off" THEN amount ELSE 0 END) AS totalDropOffTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type = "pickup" THEN amount ELSE 0 END) AS totalPickupTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type = "condition" THEN amount ELSE 0 END) AS totalConditionTransactions')
			->selectRaw('SUM(CASE WHEN shipment_id IS NOT NULL AND created_at >= CURDATE() THEN amount ELSE 0 END) AS todayTotalTransactions')
			->get()
			->toArray();

		$data['transactionRecord'] = collect($shipmentTransactions)->collapse();


		$dailyShipments = Shipment::select('created_at')
			->whereMonth('created_at', $today)
			->selectRaw('COUNT(CASE WHEN shipments.status = 0 THEN shipments.id END) AS totalPendingShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 1 THEN shipments.id END) AS totalInQueueShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 2 THEN shipments.id END) AS totalDispatchShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 3 THEN shipments.id END) AS totalReceivedShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 4 THEN shipments.id END) AS totalDeliveredShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 8 THEN shipments.id END) AS totalReturnInQueueShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 9 THEN shipments.id END) AS totalReturnDispatchShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 10 THEN shipments.id END) AS totalReturnReceivedShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 11 THEN shipments.id END) AS totalReturnDeliveredShipments')
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%j')")])
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('j');
			}]);


		$shipmentDayLabels = [];
		$dataPendingShipment = [];
		$dataInQueueShipment = [];
		$dataDispatchShipment = [];
		$dataReceivedShipment = [];
		$dataDeliveredShipment = [];
		$dataReturnInQueueShipment = [];
		$dataReturnDispatchShipment = [];
		$dataReturnReceivedShipment = [];
		$dataReturnDeliveredShipment = [];

		for ($i = 1; $i <= $dayCount; $i++) {
			$shipmentDayLabels[] = date('jS M', strtotime(date('Y/m/') . $i));

			$currentPendingShipment = 0;
			$currentInQueueShipment = 0;
			$currentDispatchShipment = 0;
			$currentReceivedShipment = 0;
			$currentDeliveredShipment = 0;
			$currentReturnInQueueShipment = 0;
			$currentReturnDispatchShipment = 0;
			$currentReturnReceivedShipment = 0;
			$currentReturnDeliveredShipment = 0;

			if (isset($dailyShipments[$i])) {
				foreach ($dailyShipments[$i] as $key => $shipment) {
					$currentPendingShipment += $shipment->totalPendingShipments;
					$currentInQueueShipment += $shipment->totalInQueueShipments;
					$currentDispatchShipment += $shipment->totalDispatchShipments;
					$currentReceivedShipment += $shipment->totalReceivedShipments;
					$currentDeliveredShipment += $shipment->totalDeliveredShipments;
					$currentReturnInQueueShipment += $shipment->totalReturnInQueueShipments;
					$currentReturnDispatchShipment += $shipment->totalReturnDispatchShipments;
					$currentReturnReceivedShipment += $shipment->totalReturnReceivedShipments;
					$currentReturnDeliveredShipment += $shipment->totalReturnDeliveredShipments;
				}
			}

			$dataPendingShipment[] = $currentPendingShipment;
			$dataInQueueShipment[] = $currentInQueueShipment;
			$dataDispatchShipment[] = $currentDispatchShipment;
			$dataReceivedShipment[] = $currentReceivedShipment;
			$dataDeliveredShipment[] = $currentDeliveredShipment;
			$dataReturnInQueueShipment[] = $currentReturnInQueueShipment;
			$dataReturnDispatchShipment[] = $currentReturnDispatchShipment;
			$dataReturnReceivedShipment[] = $currentReturnReceivedShipment;
			$dataReturnDeliveredShipment[] = $currentReturnDeliveredShipment;
		}

		$data['shipmentDayLabels'] = $shipmentDayLabels;
		$data['dataPendingShipment'] = $dataPendingShipment;
		$data['dataInQueueShipment'] = $dataInQueueShipment;
		$data['dataDispatchShipment'] = $dataDispatchShipment;
		$data['dataReceivedShipment'] = $dataReceivedShipment;
		$data['dataDeliveredShipment'] = $dataDeliveredShipment;
		$data['dataReturnInQueueShipment'] = $dataReturnInQueueShipment;
		$data['dataReturnDispatchShipment'] = $dataReturnDispatchShipment;
		$data['dataReturnReceivedShipment'] = $dataReturnReceivedShipment;
		$data['dataReturnDeliveredShipment'] = $dataReturnDeliveredShipment;


		$monthlyShipments = Shipment::select('created_at')
			->whereYear('created_at', $today)
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
			->selectRaw('COUNT(shipments.id) AS totalShipments')
			->selectRaw('COUNT(CASE WHEN shipments.shipment_identifier = 1 THEN shipments.id END) AS totalOperatorCountryShipments')
			->selectRaw('COUNT(CASE WHEN shipments.shipment_identifier = 2 THEN shipments.id END) AS totalInternationallyShipments')
			->selectRaw('COUNT(CASE WHEN shipments.shipment_type = "drop_off" THEN shipments.id END) AS totalDropOffShipments')
			->selectRaw('COUNT(CASE WHEN shipments.shipment_type = "pickup" THEN shipments.id END) AS totalPickupShipments')
			->selectRaw('COUNT(CASE WHEN shipments.shipment_type = "condition" THEN shipments.id END) AS totalConditionShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 0 THEN shipments.id END) AS totalPendingShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 4 THEN shipments.id END) AS totalDeliveredShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 11 THEN shipments.id END) AS totalReturnInDelivered')
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('F');
			}]);


		$data['shipmentYearLabels'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

		$yearTotalShipments = [];
		$yearOperatorCountryShipments = [];
		$yearInternationallyShipments = [];
		$yearDropOffShipments = [];
		$yearPickupShipments = [];
		$yearConditionShipments = [];
		$yearRequestShipments = [];
		$yearDeliveredShipments = [];
		$yearReturnShipments = [];


		foreach ($data['shipmentYearLabels'] as $yearLabel) {
			$currentTotalShipments = 0;
			$currentOperatorCountryShipments = 0;
			$currentInternationallyShipments = 0;
			$currentDropOffShipments = 0;
			$currentPickupShipments = 0;
			$currentConditionShipments = 0;
			$currentRequestShipments = 0;
			$currentDeliveredShipments = 0;
			$currentReturnShipments = 0;

			if (isset($monthlyShipments[$yearLabel])) {
				foreach ($monthlyShipments[$yearLabel] as $key => $shipment) {
					$currentTotalShipments += $shipment->totalShipments;
					$currentOperatorCountryShipments += $shipment->totalOperatorCountryShipments;
					$currentInternationallyShipments += $shipment->totalInternationallyShipments;
					$currentDropOffShipments += $shipment->totalDropOffShipments;
					$currentPickupShipments += $shipment->totalPickupShipments;
					$currentConditionShipments += $shipment->totalConditionShipments;
					$currentRequestShipments += $shipment->totalPendingShipments;
					$currentDeliveredShipments += $shipment->totalDeliveredShipments;
					$currentReturnShipments += $shipment->totalReturnInDelivered;
				}
			}

			$yearTotalShipments[] = $currentTotalShipments;
			$yearOperatorCountryShipments[] = $currentOperatorCountryShipments;
			$yearInternationallyShipments[] = $currentInternationallyShipments;
			$yearDropOffShipments[] = $currentDropOffShipments;
			$yearPickupShipments[] = $currentPickupShipments;
			$yearConditionShipments[] = $currentConditionShipments;
			$yearRequestShipments[] = $currentRequestShipments;
			$yearDeliveredShipments[] = $currentDeliveredShipments;
			$yearReturnShipments[] = $currentReturnShipments;
		}

		$data['yearTotalShipments'] = $yearTotalShipments;
		$data['yearOperatorCountryShipments'] = $yearOperatorCountryShipments;
		$data['yearInternationallyShipments'] = $yearInternationallyShipments;
		$data['yearDropOffShipments'] = $yearDropOffShipments;
		$data['yearPickupShipments'] = $yearPickupShipments;
		$data['yearConditionShipments'] = $yearConditionShipments;
		$data['yearRequestShipments'] = $yearRequestShipments;
		$data['yearDeliveredShipments'] = $yearDeliveredShipments;
		$data['yearReturnShipments'] = $yearReturnShipments;


		$dailyShipmentTransactions = Transaction::select('created_at')
			->whereMonth('created_at', $today)
			->selectRaw('SUM(CASE WHEN shipment_type = "drop_off" THEN amount ELSE 0 END) AS totalDropOffTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type = "pickup" THEN amount ELSE 0 END) AS totalPickupTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type = "condition" THEN amount ELSE 0 END) AS totalConditionTransactions')
			->selectRaw('SUM(CASE WHEN shipment_id IS NOT NULL AND created_at >= CURDATE() THEN amount ELSE 0 END) AS todayTotalTransactions')
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%j')")])
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('j');
			}]);

		$shipmentTransactionsDayLabels = [];
		$dataDropOffTransactions = [];
		$dataPickupTransactions = [];
		$dataConditionTransactions = [];

		for ($i = 1; $i <= $dayCount; $i++) {
			$shipmentTransactionsDayLabels[] = date('jS M', strtotime(date('Y/m/') . $i));

			$currentDataDropOffTransactions = 0;
			$currentDataPickupTransactions = 0;
			$currentConditionTransactions = 0;

			if (isset($dailyShipmentTransactions[$i])) {
				foreach ($dailyShipmentTransactions[$i] as $key => $shipment) {
					$currentDataDropOffTransactions += $shipment->totalDropOffTransactions;
					$currentDataPickupTransactions += $shipment->totalPickupTransactions;
					$currentConditionTransactions += $shipment->totalConditionTransactions;
				}
			}

			$dataDropOffTransactions[] = $currentDataDropOffTransactions;
			$dataPickupTransactions[] = $currentDataPickupTransactions;
			$dataConditionTransactions[] = $currentConditionTransactions;
		}

		$data['shipmentTransactionsDayLabels'] = $shipmentTransactionsDayLabels;
		$data['dataDropOffTransactions'] = $dataDropOffTransactions;
		$data['dataPickupTransactions'] = $dataPickupTransactions;
		$data['dataConditionTransactions'] = $dataConditionTransactions;


		$monthlyShipmentTransactions = Transaction::select('created_at')
			->whereYear('created_at', $today)
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
			->selectRaw('SUM(CASE WHEN shipment_id IS NOT NULL THEN amount ELSE 0 END) AS totalShipmentTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type = "drop_off" THEN amount ELSE 0 END) AS totalDropOffTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type = "pickup" THEN amount ELSE 0 END) AS totalPickupTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type = "condition" THEN amount ELSE 0 END) AS totalConditionTransactions')
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('F');
			}]);


		$yeartotalShipmentTransactions = [];
		$yeartotalDropOffTransactions = [];
		$yeartotalPickupTransactions = [];
		$yeartotalConditionTransactions = [];

		foreach ($data['yearLabels'] as $yearLabel) {
			$currenttotalShipmentTransactions = 0;
			$currenttotalDropOffTransactions = 0;
			$currenttotalPickupTransactions = 0;
			$currenttotalConditionTransactions = 0;

			if (isset($monthlyShipmentTransactions[$yearLabel])) {
				foreach ($monthlyShipmentTransactions[$yearLabel] as $key => $shipment) {
					$currenttotalShipmentTransactions += $shipment->totalShipmentTransactions;
					$currenttotalDropOffTransactions += $shipment->totalDropOffTransactions;
					$currenttotalPickupTransactions += $shipment->totalPickupTransactions;
					$currenttotalConditionTransactions += $shipment->totalConditionTransactions;
				}
			}

			$yeartotalShipmentTransactions[] = $currenttotalShipmentTransactions;
			$yeartotalDropOffTransactions[] = $currenttotalDropOffTransactions;
			$yeartotalPickupTransactions[] = $currenttotalPickupTransactions;
			$yeartotalConditionTransactions[] = $currenttotalConditionTransactions;
		}


		$data['yeartotalShipmentTransactions'] = $yeartotalShipmentTransactions;
		$data['yeartotalDropOffTransactions'] = $yeartotalDropOffTransactions;
		$data['yeartotalPickupTransactions'] = $yeartotalPickupTransactions;
		$data['yeartotalConditionTransactions'] = $yeartotalConditionTransactions;


		$transactions = Transaction::select('created_at')
			->whereMonth('created_at', $today)
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%j')")])
			->selectRaw("SUM(CASE WHEN transactional_type like '%Deposit' THEN amount ELSE 0 END) as Deposit")
			->selectRaw("SUM(CASE WHEN transactional_type like '%Fund' THEN amount ELSE 0 END) as Fund")
			->selectRaw("SUM(CASE WHEN transactional_type like '%Payout' THEN amount ELSE 0 END) as Payout")
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('j');
			}]);


		$labels = [];
		$dataDeposit = [];
		$dataFund = [];
		$dataPayout = [];
		for ($i = 1; $i <= $dayCount; $i++) {
			$labels[] = date('jS M', strtotime(date('Y/m/') . $i));

			$currentDeposit = 0;
			$currentFund = 0;
			$currentPayout = 0;
			if (isset($transactions[$i])) {
				foreach ($transactions[$i] as $key => $transaction) {
					$currentDeposit += $transaction->Deposit;
					$currentFund += $transaction->Fund;
					$currentPayout += $transaction->Payout;
				}
			}
			$dataDeposit[] = round($currentDeposit, $basicControl->fraction_number);
			$dataFund[] = round($currentFund, $basicControl->fraction_number);

			$dataPayout[] = round($currentPayout, $basicControl->fraction_number);
		}

		$data['labels'] = $labels;
		$data['dataDeposit'] = $dataDeposit;
		$data['dataFund'] = $dataFund;

		$data['dataPayout'] = $dataPayout;


		$deposits = Deposit::select('created_at')
			->where('status', 1)
			->whereYear('created_at', $today)
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
			->selectRaw("SUM(amount) as Deposit")
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('F');
			}]);

		$payouts = Payout::select('created_at')
			->whereYear('created_at', $today)
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
			->selectRaw("SUM(amount) as Payout")
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('F');
			}]);

		$yearDeposit = [];
		$yearPayout = [];

		foreach ($data['yearLabels'] as $yearLabel) {
			$currentYearDeposit = 0;
			$currentYearPayout = 0;

			if (isset($deposits[$yearLabel])) {
				foreach ($deposits[$yearLabel] as $key => $deposit) {
					$currentYearDeposit += $deposit->Deposit;
				}
			}
			if (isset($payouts[$yearLabel])) {
				foreach ($payouts[$yearLabel] as $key => $payout) {
					$currentYearPayout += $payout->Payout;
				}
			}

			$yearDeposit[] = round($currentYearDeposit, $basicControl->fraction_number);
			$yearPayout[] = round($currentYearPayout, $basicControl->fraction_number);
		}

		$data['yearDeposit'] = $yearDeposit;
		$data['yearPayout'] = $yearPayout;

		$paymentMethods = Deposit::with('gateway:id,name')
			->whereYear('created_at', $today)
			->where('status', 1)
			->groupBy(['payment_method_id'])
			->selectRaw("SUM(amount) as totalAmount, payment_method_id")
			->get()
			->groupBy(['payment_method_id']);

		$paymentMethodeLabel = [];
		$paymentMethodeData = [];

		$paymentMethods = collect($paymentMethods)->collapse();
		foreach ($paymentMethods as $paymentMethode) {
			$currentPaymentMethodeLabel = 0;
			$currentPaymentMethodeData = 0;
			$currentPaymentMethodeLabel = optional($paymentMethode->gateway)->name ?? 'N/A';
			$currentPaymentMethodeData += $paymentMethode->totalAmount;

			$paymentMethodeLabel[] = $currentPaymentMethodeLabel;
			$paymentMethodeData[] = round($currentPaymentMethodeData, $basicControl->fraction_number);
		}

		$data['paymentMethodeLabel'] = $paymentMethodeLabel;
		$data['paymentMethodeData'] = $paymentMethodeData;
		$data['basicControl'] = $basicControl;

		return view('admin.home', $data);
	}

	public function changePassword(Request $request)
	{
		if ($request->isMethod('get')) {
			return view('admin.auth.passwords.change');
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'current_password' => 'required|min:5',
				'password' => 'required|min:5|confirmed',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$user = Auth::user();
			$purifiedData = (object)$purifiedData;

			if (!Hash::check($purifiedData->current_password, $user->password)) {
				return back()->withInput()->withErrors(['current_password' => 'current password did not match']);
			}

			$user->password = bcrypt($purifiedData->password);
			$user->save();
			return back()->with('success', 'Password changed successfully');
		}
	}

//
	public function forbidden()
	{
		return view('admin.errors.403');
	}
}
