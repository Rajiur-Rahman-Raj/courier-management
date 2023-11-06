<?php

namespace App\Http\Controllers;

use App\Helpers\UserSystemInfo;
use App\Models\Branch;
use App\Models\Deposit;
use App\Models\Payout;
use App\Models\Shipment;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

	public function percentGrowthCalculation($currentRecords, $previousRecords = 0){
		if (0 < $previousRecords) {
			$percentGrowth = (($currentRecords - $previousRecords) / $previousRecords) * 100;
		} else {
			$percentGrowth = 0;
		}


		if ($percentGrowth > 0) {
			$class = "text-success";
			$arrowIcon = "fas fa-arrow-up";
		} elseif ($percentGrowth < 0) {
			$class = "text-danger";
			$arrowIcon = "fas fa-arrow-down";
		} else {
			$class =  "text-secondary";
			$arrowIcon = null;
		}

		return [
			'class' => $class,
			'arrowIcon' => $arrowIcon,
			'percentage' => round($percentGrowth, 2)
		];
	}


	public function getAdminDashboardData(){
		$basic = config('basic');
		$last30 = date('Y-m-d', strtotime('-30 days'));

		$users = User::selectRaw('COUNT(id) AS totalUser')
			->selectRaw('COUNT((CASE WHEN status = 1  THEN id END)) AS activeUser')
			->selectRaw("COUNT((CASE WHEN MONTH(created_at) = MONTH(CURDATE()) THEN id END)) AS thisMonthUsers")
			->selectRaw("COUNT((CASE WHEN MONTH(created_at) = MONTH(CURDATE()) - 1 THEN id END)) AS lastMonthUsers")
			->selectRaw("COUNT((CASE WHEN MONTH(created_at) = MONTH(CURDATE()) - 2 THEN id END)) AS monthBeforeLastMonthUsers")
			->selectRaw("COUNT((CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN id END)) AS thisYearUsers")
			->selectRaw("COUNT((CASE WHEN YEAR(created_at) = YEAR(CURDATE()) - 1 THEN id END)) AS lastYearUsers")
			->selectRaw("COUNT((CASE WHEN created_at >= $last30 THEN id END)) AS last_30_days_join")
			->selectRaw('SUM(balance) AS totalUserBalance')
			->selectRaw('COUNT((CASE WHEN email_verified_at IS NOT NULL  THEN id END)) AS verifiedUser')
			->get()->makeHidden(['mobile', 'profile'])->toArray();

		$data['userRecord'] = collect($users)->collapse();

		$currentMonthGrowthCalculation = $this->percentGrowthCalculation($data['userRecord']['thisMonthUsers'], $data['userRecord']['lastMonthUsers']);
		$currentYearGrowthCalculation = $this->percentGrowthCalculation($data['userRecord']['thisYearUsers'], $data['userRecord']['lastYearUsers']);

		$data['userRecord']->put('currentMonthClass', $currentMonthGrowthCalculation['class']);
		$data['userRecord']->put('currentMonthArrowIcon', $currentMonthGrowthCalculation['arrowIcon']);
		$data['userRecord']->put('currentMonthPercentage', $currentMonthGrowthCalculation['percentage']);

		$data['userRecord']->put('currentYearClass', $currentYearGrowthCalculation['class']);
		$data['userRecord']->put('currentYearArrowIcon', $currentYearGrowthCalculation['arrowIcon']);
		$data['userRecord']->put('currentYearPercentage', $currentYearGrowthCalculation['percentage']);


		$tickets = Ticket::selectRaw('COUNT((CASE WHEN status = 0  THEN id END)) AS pendingTickets')
			->selectRaw('COUNT((CASE WHEN status = 1 THEN id END)) AS answeredTickets')
			->selectRaw('COUNT((CASE WHEN status = 2 THEN id END)) AS repliedTickets')
			->selectRaw('COUNT((CASE WHEN status = 2 THEN id END)) AS closedTickets')
			->get()->toArray();

		$data['ticketRecord'] = collect($tickets)->collapse();



		return response()->json(['data' => $data, 'basic' => $basic]);
	}

	public function index()
	{
		$admin = Auth::guard('admin')->user();
		$basicControl = basicControl();
		$last30 = date('Y-m-d', strtotime('-30 days'));
		$last7 = date('Y-m-d', strtotime('-7 days'));
		$today = today();
		$currentDate = date('Y-m-d');

		$dayCount = date('t', strtotime($today));

		$data['yearLabels'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

		$users = User::selectRaw('COUNT(id) AS totalUser')
			->selectRaw('COUNT((CASE WHEN status = 1  THEN id END)) AS activeUser')
			->selectRaw("COUNT((CASE WHEN MONTH(created_at) = MONTH(CURDATE()) THEN id END)) AS thisMonthUsers")
			->selectRaw("COUNT((CASE WHEN MONTH(created_at) = MONTH(CURDATE()) - 1 THEN id END)) AS lastMonthUsers")
			->selectRaw("COUNT((CASE WHEN MONTH(created_at) = MONTH(CURDATE()) - 2 THEN id END)) AS monthBeforeLastMonthUsers")
			->selectRaw("COUNT((CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN id END)) AS thisYearUsers")
			->selectRaw("COUNT((CASE WHEN YEAR(created_at) = YEAR(CURDATE()) - 1 THEN id END)) AS lastYearUsers")
			->selectRaw("COUNT((CASE WHEN created_at >= $last30 THEN id END)) AS last_30_days_join")
			->selectRaw('SUM(balance) AS totalUserBalance')
			->selectRaw('COUNT((CASE WHEN email_verified_at IS NOT NULL  THEN id END)) AS verifiedUser')
			->get()->makeHidden(['mobile', 'profile'])->toArray();

		$data['userRecord'] = collect($users)->collapse();

		$currentMonthGrowthCalculation = $this->percentGrowthCalculation($data['userRecord']['thisMonthUsers'], $data['userRecord']['lastMonthUsers']);
		$currentYearGrowthCalculation = $this->percentGrowthCalculation($data['userRecord']['thisYearUsers'], $data['userRecord']['lastYearUsers']);

		$data['userRecord']->put('currentMonthClass', $currentMonthGrowthCalculation['class']);
		$data['userRecord']->put('currentMonthArrowIcon', $currentMonthGrowthCalculation['arrowIcon']);
		$data['userRecord']->put('currentMonthPercentage', $currentMonthGrowthCalculation['percentage']);

		$data['userRecord']->put('currentYearClass', $currentYearGrowthCalculation['class']);
		$data['userRecord']->put('currentYearArrowIcon', $currentYearGrowthCalculation['arrowIcon']);
		$data['userRecord']->put('currentYearPercentage', $currentYearGrowthCalculation['percentage']);


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
			->selectRaw('COUNT(CASE WHEN shipments.status = 10 THEN shipments.id END) AS totalReturnDeliveryInQueueShipments')
			->selectRaw('COUNT(CASE WHEN shipments.status = 11 THEN shipments.id END) AS totalReturnInDelivered')
			->get()
			->toArray();

		$data['shipmentRecord'] = collect($shipments)->collapse();

		$shipmentTransactions = Transaction::selectRaw('SUM(CASE WHEN shipment_id IS NOT NULL THEN amount ELSE 0 END) AS totalShipmentTransactions')
			->selectRaw('SUM(CASE WHEN shipment_identifier IS NOT NULL AND shipment_identifier = 1 THEN amount ELSE 0 END) AS totalOperatorCountryTransactions')
			->selectRaw('SUM(CASE WHEN shipment_identifier IS NOT NULL AND shipment_identifier = 2 THEN amount ELSE 0 END) AS totalInternationallyTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type IS NOT NULL AND shipment_type = "drop_off" THEN amount ELSE 0 END) AS totalDropOffTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type IS NOT NULL AND shipment_type = "pickup" THEN amount ELSE 0 END) AS totalPickupTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type IS NOT NULL AND shipment_type = "condition" THEN amount ELSE 0 END) AS totalConditionTransactions')
			->selectRaw('SUM(CASE WHEN shipment_id IS NOT NULL AND created_at >= CURDATE() THEN amount ELSE 0 END) AS todayTotalTransactions')
			->get()
			->toArray();

		$data['transactionRecord'] = collect($shipmentTransactions)->collapse();


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



		$monthlyShipmentTransactions = Transaction::select('created_at')
			->whereYear('created_at', $today)
			->groupBy([DB::raw("DATE_FORMAT(created_at, '%m')")])
			->selectRaw('SUM(CASE WHEN shipment_id IS NOT NULL THEN amount ELSE 0 END) AS totalShipmentTransactions')
			->selectRaw('SUM(CASE WHEN shipment_identifier IS NOT NULL AND shipment_identifier = 1 THEN amount ELSE 0 END) AS totalOperatorCountryTransactions')
			->selectRaw('SUM(CASE WHEN shipment_identifier IS NOT NULL AND shipment_identifier = 2 THEN amount ELSE 0 END) AS totalInternationallyTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type IS NOT NULL AND shipment_type = "drop_off" THEN amount ELSE 0 END) AS totalDropOffTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type IS NOT NULL AND shipment_type = "pickup" THEN amount ELSE 0 END) AS totalPickupTransactions')
			->selectRaw('SUM(CASE WHEN shipment_type IS NOT NULL AND shipment_type = "condition" THEN amount ELSE 0 END) AS totalConditionTransactions')
			->get()
			->groupBy([function ($query) {
				return $query->created_at->format('F');
			}]);


		$yearTotalShipmentTransactions = [];
		$yearTotalOperatorCountryTransactions = [];
		$yearTotalInternationallyTransactions = [];
		$yearTotalDropOffTransactions = [];
		$yearTotalPickupTransactions = [];
		$yearTotalConditionTransactions = [];

		foreach ($data['yearLabels'] as $yearLabel) {
			$currentTotalShipmentTransactions = 0;
			$currentTotalOperatorCountryTransactions = 0;
			$currentTotalInternationallyTransactions = 0;
			$currentTotalDropOffTransactions = 0;
			$currentTotalPickupTransactions = 0;
			$currentTotalConditionTransactions = 0;

			if (isset($monthlyShipmentTransactions[$yearLabel])) {
				foreach ($monthlyShipmentTransactions[$yearLabel] as $key => $shipment) {
					$currentTotalShipmentTransactions += $shipment->totalShipmentTransactions;
					$currentTotalOperatorCountryTransactions += $shipment->totalOperatorCountryTransactions;
					$currentTotalInternationallyTransactions += $shipment->totalInternationallyTransactions;
					$currentTotalDropOffTransactions += $shipment->totalDropOffTransactions;
					$currentTotalPickupTransactions += $shipment->totalPickupTransactions;
					$currentTotalConditionTransactions += $shipment->totalConditionTransactions;
				}
			}

			$yearTotalShipmentTransactions[] = $currentTotalShipmentTransactions;
			$yearTotalOperatorCountryTransactions[] = $currentTotalOperatorCountryTransactions;
			$yearTotalInternationallyTransactions[] = $currentTotalInternationallyTransactions;
			$yearTotalDropOffTransactions[] = $currentTotalDropOffTransactions;
			$yearTotalPickupTransactions[] = $currentTotalPickupTransactions;
			$yearTotalConditionTransactions[] = $currentTotalConditionTransactions;
		}


		$data['yearTotalShipmentTransactions'] = $yearTotalShipmentTransactions;
		$data['yearTotalOperatorCountryTransactions'] = $yearTotalOperatorCountryTransactions;
		$data['yearTotalInternationallyTransactions'] = $yearTotalInternationallyTransactions;
		$data['yearTotalDropOffTransactions'] = $yearTotalDropOffTransactions;
		$data['yearTotalPickupTransactions'] = $yearTotalPickupTransactions;
		$data['yearTotalConditionTransactions'] = $yearTotalConditionTransactions;


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


	public function forbidden()
	{
		return view('admin.errors.403');
	}


	public function getDailyShipmentAnalytics(Request $request)
	{
		$start = Carbon::createFromFormat('d/m/Y', $request->start);
		$end = Carbon::createFromFormat('d/m/Y', $request->end);

		$dailyShipments = DB::table('shipments')
			->selectRaw('DATE(created_at) as date, COUNT(CASE WHEN shipments.status = 0 THEN shipments.id END) AS totalPendingShipments')
			->selectRaw('DATE(created_at) as date, COUNT(CASE WHEN shipments.status = 1 THEN shipments.id END) AS totalInQueueShipments')
			->selectRaw('DATE(created_at) as date, COUNT(CASE WHEN shipments.status = 2 THEN shipments.id END) AS totalDispatchShipments')
			->selectRaw('DATE(created_at) as date, COUNT(CASE WHEN shipments.status = 3 THEN shipments.id END) AS totalReceivedShipments')
			->selectRaw('DATE(created_at) as date, COUNT(CASE WHEN shipments.status = 4 THEN shipments.id END) AS totalDeliveredShipments')
			->selectRaw('DATE(created_at) as date, COUNT(CASE WHEN shipments.status = 8 THEN shipments.id END) AS totalReturnInQueueShipments')
			->selectRaw('DATE(created_at) as date, COUNT(CASE WHEN shipments.status = 9 THEN shipments.id END) AS totalReturnDispatchShipments')
			->selectRaw('DATE(created_at) as date, COUNT(CASE WHEN shipments.status = 10 THEN shipments.id END) AS totalReturnReceivedShipments')
			->selectRaw('DATE(created_at) as date, COUNT(CASE WHEN shipments.status = 11 THEN shipments.id END) AS totalReturnDeliveredShipments')
			->whereBetween('created_at', [$start, $end])
			->groupBy('date')
			->get();

		$start = new \DateTime($start);
		$end = new \DateTime($end);
		$data = [];

		for ($day = $start; $day <= $end; $day->modify('+1 day')) {
			$date = $day->format('Y-m-d');
			$data['labels'][] = $day->format('jS M');
			$data['dataPendingShipment'][] = $dailyShipments->where('date', $date)->first()->totalPendingShipments ?? 0;
			$data['dataInQueueShipment'][] = $dailyShipments->where('date', $date)->first()->totalInQueueShipments ?? 0;
			$data['dataDispatchShipment'][] = $dailyShipments->where('date', $date)->first()->totalDispatchShipments ?? 0;
			$data['dataReceivedShipment'][] = $dailyShipments->where('date', $date)->first()->totalReceivedShipments ?? 0;
			$data['dataDeliveredShipment'][] = $dailyShipments->where('date', $date)->first()->totalDeliveredShipments ?? 0;
			$data['dataReturnInQueueShipment'][] = $dailyShipments->where('date', $date)->first()->totalReturnInQueueShipments ?? 0;
			$data['dataReturnDispatchShipment'][] = $dailyShipments->where('date', $date)->first()->totalReturnDispatchShipments ?? 0;
			$data['dataReturnReceivedShipment'][] = $dailyShipments->where('date', $date)->first()->totalReturnReceivedShipments ?? 0;
			$data['dataReturnDeliveredShipment'][] = $dailyShipments->where('date', $date)->first()->totalReturnDeliveredShipments ?? 0;
		}

		return response()->json($data);
	}


	public function getDailyShipmentTransactionsAnalytics(Request $request){
		$start = Carbon::createFromFormat('d/m/Y', $request->start);
		$end = Carbon::createFromFormat('d/m/Y', $request->end);


		$dailyShipmentTransactions = DB::table('transactions')

			->selectRaw('DATE(created_at) as date, SUM(CASE WHEN shipment_id IS NOT NULL THEN amount ELSE 0 END) AS totalShipmentTransactions')
			->selectRaw('DATE(created_at) as date, SUM(CASE WHEN shipment_identifier IS NOT NULL AND shipment_identifier = 1 THEN amount ELSE 0 END) AS totalOperatorCountryTransactions')
			->selectRaw('DATE(created_at) as date, SUM(CASE WHEN shipment_identifier IS NOT NULL AND shipment_identifier = 2 THEN amount ELSE 0 END) AS totalInternationallyTransactions')
			->selectRaw('DATE(created_at) as date, SUM(CASE WHEN shipment_type IS NOT NULL AND shipment_type = "drop_off" THEN amount ELSE 0 END) AS totalDropOffTransactions')
			->selectRaw('DATE(created_at) as date, SUM(CASE WHEN shipment_type IS NOT NULL AND shipment_type = "pickup" THEN amount ELSE 0 END) AS totalPickupTransactions')
			->selectRaw('DATE(created_at) as date, SUM(CASE WHEN shipment_type IS NOT NULL AND shipment_type = "condition" THEN amount ELSE 0 END) AS totalConditionTransactions')
			->whereBetween('created_at', [$start, $end])
			->groupBy('date')
			->get();

		$start = new \DateTime($start);
		$end = new \DateTime($end);
		$data = [];

		for ($day = $start; $day <= $end; $day->modify('+1 day')) {
			$date = $day->format('Y-m-d');
			$data['labels'][] = $day->format('jS M');
			$data['dataTotalShipmentTransactions'][] = $dailyShipmentTransactions->where('date', $date)->first()->totalShipmentTransactions ?? 0;
			$data['dataTotalOperatorCountryTransactions'][] = $dailyShipmentTransactions->where('date', $date)->first()->totalOperatorCountryTransactions ?? 0;
			$data['dataTotalInternationallyTransactions'][] = $dailyShipmentTransactions->where('date', $date)->first()->totalInternationallyTransactions ?? 0;
			$data['dataDropOffTransactions'][] = $dailyShipmentTransactions->where('date', $date)->first()->totalDropOffTransactions ?? 0;
			$data['dataPickupTransactions'][] = $dailyShipmentTransactions->where('date', $date)->first()->totalPickupTransactions ?? 0;
			$data['dataConditionTransactions'][] = $dailyShipmentTransactions->where('date', $date)->first()->totalConditionTransactions ?? 0;
		}

		return response()->json($data);
	}


	public function getDailyBrowserHistoryAnalytics(Request $request){
		$start = Carbon::createFromFormat('d/m/Y', $request->start);
		$end = Carbon::createFromFormat('d/m/Y', $request->end);

		$userCreationData = DB::table('users')
			->whereBetween('created_at', [$start, $end])
			->select('browser_history')
			->get();

		$data['userCreationBrowserData'] = $userCreationData->groupBy('browser_history')->map->count();

		return response()->json(['userCreationBrowserData' => $data['userCreationBrowserData']]);
	}

	public function getDailyOperatingSystemHistoryAnalytics(Request $request){
		$start = Carbon::createFromFormat('d/m/Y', $request->start);
		$end = Carbon::createFromFormat('d/m/Y', $request->end);

		$userCreationData = DB::table('users')
			->whereBetween('created_at', [$start, $end])
			->select('os_history')
			->get();

		$data['userCreationOSData'] = $userCreationData->groupBy('os_history')->map->count();

		return response()->json(['userCreationOSData' => $data['userCreationOSData']]);
	}

	public function getDailyDeviceHistoryAnalytics(Request $request){
		$start = Carbon::createFromFormat('d/m/Y', $request->start);
		$end = Carbon::createFromFormat('d/m/Y', $request->end);

		$userCreationData = DB::table('users')
			->whereBetween('created_at', [$start, $end])
			->select('device_history')
			->get();

		$data['userCreationDeviceData'] = $userCreationData->groupBy('device_history')->map->count();

		return response()->json(['userCreationDeviceData' => $data['userCreationDeviceData']]);
	}

}
