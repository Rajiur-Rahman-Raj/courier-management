<script>
	'use strict'

	$(document).on('change', '.selectedParcelType', function () {
		let selectedValue = $(this).val();
		getSelectedParcelTypeUnit(selectedValue);
	})

	function selectedParcelTypeHandel(id = null){
		let selectedValue = $(`.selectedParcelType_${id}`).val();
		getSelectedParcelTypeUnit(selectedValue, null, id);
	}

	function getSelectedParcelTypeUnit(value, unitId=null, dynamicId = null) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: "{{ route('getSelectedParcelTypeUnit') }}",
			method: 'POST',
			data: {
				id: value,
			},
			success: function (response) {
				let selectedParcelUnitClass = '.selectedParcelUnit';
				if (dynamicId){
					selectedParcelUnitClass = `.selectedParcelUnit_${dynamicId}`
				}
				let responseData = response;
				$(selectedParcelUnitClass).empty();
				responseData.forEach(res => {
					$(selectedParcelUnitClass).append(`<option value="${res.id}">${res.unit}</option>`)
				})
				$(selectedParcelUnitClass).prepend(`<option value="" selected disabled>@lang('Select Unit')</option>`)
				$('#unitId').val(unitId);
				$('.cost-per-unit').text(`(${responseData[0].unit})`)
			},
			error: function (xhr, status, error) {
				console.log(error)
			}
		});
	}



	$(document).on('change', '.selectedParcelUnit', function () {
		let selectedParcelType = $('.selectedParcelType').val();
		let selectedParcelUnit = $(this).val();
		getSelectedParcelService(selectedParcelType, selectedParcelUnit);
	})


	function selectedParcelServiceHandel(id = null) {
		let selectedParcelTypeValue = $(`.selectedParcelType`).val();
		let selectedParcelUnitValue = $(`.selectedParcelUnit`).val();
		if (id) {
			selectedParcelTypeValue = $(`.selectedParcelType_${id}`).val();
			selectedParcelUnitValue = $(`.selectedParcelUnit_${id}`).val();
		}

		getSelectedParcelService(selectedParcelTypeValue, selectedParcelUnitValue, id);
	}


	function getSelectedParcelService(selectedParcelTypeValue, selectedParcelUnitValue, id = null) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: "{{ route('getSelectedParcelUnitService') }}",
			method: 'POST',
			data: {
				parcelTypeId: selectedParcelTypeValue,
				parcelUnitId: selectedParcelUnitValue,
			},
			success: function (response) {
				let responseData = response;
				let unitPriceClass = ".unitPrice";
				if (id) {
					unitPriceClass = `.unitPrice_${id}`;
				}
				if (responseData.length == 0){
					$(unitPriceClass).val(0);
				}else{
					$(unitPriceClass).val(responseData[0].cost);
				}
				window.calculateParcelTotalPrice();
			},
			error: function (xhr, status, error) {
				console.log(error)
			}
		});

	}

</script>
