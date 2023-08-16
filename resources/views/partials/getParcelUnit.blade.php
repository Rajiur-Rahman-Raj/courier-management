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
					selectedParcelUnitClass = `.selectedParcelUnit${dynamicId}`
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

</script>
