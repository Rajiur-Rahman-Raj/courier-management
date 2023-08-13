<script>
	'use strict'



	$(document).on('change', '.selectedParcelType', function () {
		let selectedValue = $(this).val();
		getSelectedParcelTypeUnit(selectedValue);
	})

	function getSelectedParcelTypeUnit(value, unitId=null) {
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
				let responseData = response;
				$('.selectedParcelUnit').empty();
				responseData.forEach(res => {
					$('.selectedParcelUnit').append(`<option value="${res.id}">${res.unit}</option>`)
				})
				$('.selectedParcelUnit').prepend(`<option value="" selected disabled>@lang('Select Unit')</option>`)
				$('#unitId').val(unitId);
				$('.cost-per-unit').text(`(${responseData[0].unit})`)
			},
			error: function (xhr, status, error) {
				console.log(error)
			}
		});
	}

</script>
