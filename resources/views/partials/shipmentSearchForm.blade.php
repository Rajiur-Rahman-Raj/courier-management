<form action="" method="get">
	<div class="row">
		<div class="col-md-2">
			<div class="form-group">
				<label for="shipment_id" class="custom-text">@lang('Shipment id')</label>
				<input placeholder="@lang('shipment id')" name="shipment_id"
					   value="{{ old('name',request()->shipment_id) }}" type="text"
					   class="form-control form-control-sm">
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group search-currency-dropdown">
				<label for="shipment_type" class="custom-text">@lang('Shipment Type')</label>
				<select name="shipment_type" class="form-control form-control-sm">
					<option value="">@lang('All Shipments')</option>
					<option
						value="drop_off" {{  request()->shipment_type == 'drop_off' ? 'selected' : '' }}>@lang('Drop Off')</option>
					<option
						value="pickup" {{  request()->status == 'pickup' ? 'selected' : '' }}>@lang('Pickup')</option>
					@if($type == 'operator-country')
						<option value="condition" {{  request()->status == 'condition' ? 'selected' : '' }}>@lang('Condition')</option>
					@endif

				</select>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="sender_branch" class="custom-text">@lang('Sender Branch')</label>
				<input placeholder="@lang('sender branch')" name="sender_branch"
					   value="{{ old('sender_branch',request()->sender_branch) }}"
					   type="text" class="form-control form-control-sm">
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group">
				<label for="receiver_branch" class="custom-text">@lang('Receiver Branch')</label>
				<input placeholder="@lang('receiver branch')" name="receiver_branch"
					   value="{{ old('receiver_branch',request()->receiver_branch) }}"
					   type="text" class="form-control form-control-sm">
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group">
				<label for="receiver_branch" class="custom-text">@lang('Sender')</label>
				<input placeholder="@lang('sender')" name="sender"
					   value="{{ old('sender',request()->sender) }}"
					   type="text" class="form-control form-control-sm">
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group">
				<label for="receiver_branch" class="custom-text">@lang('Receiver')</label>
				<input placeholder="@lang('receiver')" name="receiver"
					   value="{{ old('receiver',request()->receiver) }}"
					   type="text" class="form-control form-control-sm">
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group">
				<label for="address" class="custom-text">@lang('Location')</label>
				<input placeholder="@lang('search address')" name="address"
					   value="{{ old('address',request()->address) }}"
					   type="text" class="form-control form-control-sm">
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group">
				<label for="shipment_date" class="custom-text">@lang('Shipment Date')</label>
				<input placeholder="@lang('shipment date')" name="shipment_date"
					   value="{{ old('shipment_date', request()->shipment_date) }}" type="date"
					   class="form-control form-control-sm" autocomplete="off">
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group">
				<label for="delivery_date" class="custom-text">@lang('Delivery Date')</label>
				<input placeholder="@lang('delivery date')" name="delivery_date"
					   value="{{ old('delivery_date', request()->delivery_date) }}" type="date"
					   class="form-control form-control-sm" autocomplete="off">
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group">
				<label for="shipment_type" class="custom-text">@lang('From Date')</label>
				<input placeholder="@lang('from date')" name="from_date"
					   value="{{ old('from_date', request()->from_date) }}" type="date"
					   class="form-control form-control-sm" autocomplete="off">
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group">
				<label for="shipment_type" class="custom-text">@lang('To Date')</label>
				<input placeholder="@lang('to date')" name="to_date"
					   value="{{ old('to_date',request()->to_date) }}"
					   type="date" class="form-control form-control-sm">
			</div>
		</div>


		<div class="col-md-2">
			<div class="form-group search-currency-dropdown">
				<label for="status" class="custom-text">@lang('Status')</label>
				<select name="status" class="form-control form-control-sm">
					<option value="">@lang('All Status')</option>
					<option
						value="active" {{  request()->status == 'active' ? 'selected' : '' }}>@lang('Active')</option>
					<option
						value="deactive" {{  request()->status == 'deactive' ? 'selected' : '' }}>@lang('Deactive')</option>
				</select>
			</div>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<button type="submit"
						class="btn btn-primary btn-sm btn-block"><i
						class="fas fa-search"></i> @lang('Search')</button>
			</div>
		</div>
	</div>

</form>
