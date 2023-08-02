<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Payout;
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
		$basicControl = basicControl();
		$last30 = date('Y-m-d', strtotime('-30 days'));
		$last7 = date('Y-m-d', strtotime('-7 days'));
		$today = today();
		$dayCount = date('t', strtotime($today));

		$users = User::selectRaw('COUNT(id) AS totalUser')
			->selectRaw('COUNT((CASE WHEN created_at >= CURDATE()  THEN id END)) AS todayJoin')
			->selectRaw('COUNT((CASE WHEN status = 1  THEN id END)) AS activeUser')
			->selectRaw('COUNT((CASE WHEN email_verified_at IS NOT NULL  THEN id END)) AS verifiedUser')
			->get()->makeHidden(['mobile', 'profile'])->toArray();

		$data['userRecord'] = collect($users)->collapse();


		$data['users'] = User::with('profile')->latest()->limit(5)->get();

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

		$data['yearLabels'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

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
}
