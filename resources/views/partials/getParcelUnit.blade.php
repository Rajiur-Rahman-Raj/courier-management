<script>
	'use strict'
	$(document).on('change', '.selectedParcelType', function () {
		let selectedValue = $(this).val();
		getSelectedParcelTypeUnit(selectedValue);
	})

	function getSelectedParcelTypeUnit(value) {
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
				$('.cost-per-unit').text(`(${responseData[0].unit})`)
			},
			error: function (xhr, status, error) {
				console.log(error)
			}
		});
	}

	//	2nd part
	// If your required parcel type area are not found
	$('.select2ParcelType').select2({
		width: '100%'
	}).on('select2:open', () => {
		$(".select2-results:not(:has(a))").append(`<li style='list-style: none; padding: 10px;'><a style="width: 100%" href="{{ route('parcelServiceList') }}"
                    class="btn btn-outline-primary" target="_blank">+ Create New Parcel </a>
                    </li>`);
	});
</script>
