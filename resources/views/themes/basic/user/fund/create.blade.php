@extends($theme.'layouts.user')
@section('page_title',__('Add Fund'))

@section('content')
	<div class="main-content">
		<section class="section">
			<div class="section-header">
				<h1>@lang('Add Fund')</h1>
				<div class="section-header-breadcrumb">
					<div class="breadcrumb-item active">
						<a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
					</div>
					<div class="breadcrumb-item">@lang('Add Fund')</div>
				</div>
			</div>
			<!------ alert ------>
			<div class="row ">
				<div class="col-md-12">
					<div class="bd-callout bd-callout-primary mx-2">
						<i class="fa-3x fas fa-info-circle text-primary"></i> @lang(@$template->description->short_description)
					</div>
				</div>
			</div>
			<!------ main content ------>
			<div class="row justify-content-md-center">
				<div class="col-md-6">
					<div class="card mb-4 shadow card-primary">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Deposit')</h6>
						</div>
						<div class="card-body">
							<form action="{{ route('fund.initialize') }}" method="post">
								@csrf
								<div class="row">
									<div class="col-md-6 search-currency-dropdown">
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="amount">@lang('Amount')</label>
											<div class="input-group">
												<input type="text" id="amount" value="{{ old('amount') }}" name="amount"
													   placeholder="@lang('0.00')"
													   class="form-control @error('amount') is-invalid @enderror"
													   autocomplete="off">
												<div class="input-group-prepend">
													<span class="form-control">{{config('basic.base_currency')}}</span>
												</div>
											</div>
											<div class="invalid-feedback">
												@error('amount') @lang($message) @enderror
											</div>
											<div class="valid-feedback"></div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<label for="methodId">@lang('Select Payment Method')</label>
										<div class="form-group">
											<div class="row payment-method-input p-1">
												@foreach($methods as $key => $method)
													<div class="col-md-2 col-sm-3 col-6">
														<div class="form-check form-check-inline mr-0 mb-3">
															<input class="form-check-input methodId" type="radio"
																   name="methodId" id="{{$key}}"
																   value="{{ $method->id }}" {{ old('methodId') == $method->id || $key == 0 ? ' checked' : ''}}>
															<label class="form-check-label" for="{{$key}}">
																<img
																	src="{{ getFile($method->driver,$method->image ) }}">
															</label>
														</div>
													</div>
												@endforeach
											</div>
										</div>
									</div>
								</div>
								<button type="submit" id="submit" class="btn btn-primary btn-sm btn-block"
										disabled>@lang('Deposit')</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card mb-4 shadow card-primary">
						<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="m-0 font-weight-bold text-primary">@lang('Details')</h6>
						</div>
						<div class="card-body showCharge">
						</div>
					</div>
				</div>
			</div>

		</section>
	</div>
@endsection

@section('scripts')
	<script>
		'use strict'
		$(document).ready(function () {
			$('[data-toggle="tooltip"]').tooltip()
			let amountField = $('#amount');
			let amountStatus = false;

			function clearMessage(fieldId) {
				$(fieldId).removeClass('is-valid')
				$(fieldId).removeClass('is-invalid')
				$(fieldId).closest('div').find(".invalid-feedback").html('');
				$(fieldId).closest('div').find(".is-valid").html('');
			}

			$(document).on('change, input', "#amount, #charge_from, .methodId", function (e) {
				let amount = amountField.val();
				let currency_code = "{{config('basic.base_currency')}}";
				let methodId = $("input[type='radio'][name='methodId']:checked").val();
				if (!isNaN(amount) && amount > 0) {
					let fraction = amount.split('.')[1];
					let limit = "{{config('basic.fraction_number')}}";
					if (fraction && fraction.length > limit) {
						amount = (Math.floor(amount * Math.pow(10, limit)) / Math.pow(10, limit)).toFixed(limit);
						amountField.val(amount);
					}
					checkAmount(amount, methodId, currency_code)
				} else {
					clearMessage(amountField)
					$('.showCharge').html('')
				}
			});

			function checkAmount(amount, methodId, currency_code) {
				$.ajax({
					method: "GET",
					url: "{{ route('deposit.checkAmount') }}",
					dataType: "json",
					data: {
						'amount': amount,
						'methodId': methodId,
					}
				})
					.done(function (response) {
						let amountField = $('#amount');
						if (response.status) {
							clearMessage(amountField);
							$(amountField).addClass('is-valid');
							$(amountField).closest('div').find(".valid-feedback").html(response.message);
							amountStatus = true;
							submitButton();
							showCharge(response, currency_code);
						} else {
							amountStatus = false;
							submitButton();
							$('.showCharge').html('');
							clearMessage(amountField);
							$(amountField).addClass('is-invalid');
							$(amountField).closest('div').find(".invalid-feedback").html(response.message);
						}
					});
			}

			function submitButton() {
				if (amountStatus) {
					$("#submit").removeAttr("disabled");
				} else {
					$("#submit").attr("disabled", true);
				}
			}

			function showCharge(response, currency_code) {
				let txnDetails = `
					<ul class="list-group">
						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Available Balance') }}</span>
							<span class="text-success"> ${response.balance} ${currency_code}</span>
						</li>
						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Transfer Charge') }}</span>
							<span class="text-danger"> ${response.percentage_charge} + ${response.fixed_charge} = ${response.charge} ${currency_code}</span>
						</li>
						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Payable Amount') }}</span>
							<span class="text-info"> ${response.payable_amount} ${currency_code}</span>
						</li>
						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Received') }}</span>
							<span class="text-info"> ${response.amount} ${currency_code}</span>
						</li>
						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('New Balance') }}</span>
							<span class="text-primary"> ${response.new_balance} ${currency_code}</span>
						</li>
						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Min Deposit Limit') }}</span>
							<span>${parseFloat(response.min_limit).toFixed(response.currency_limit)} ${currency_code}</span>
						</li>
						<li class="list-group-item d-flex justify-content-between">
							<span>{{ __('Max Deposit Limit') }}</span>
							<span>${parseFloat(response.max_limit).toFixed(response.currency_limit)} ${currency_code}</span>
						</li>
					</ul>
					`;
				$('.showCharge').html(txnDetails)
			}
		});
	</script>
@endsection
