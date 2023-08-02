<script>
	'use strict'
	$(document).ready(function () {
		$('.selectedCountry').on('change', function () {
			let selectedValue = $(this).val();
			getSelectedCountryState(selectedValue);
		})

		function getSelectedCountryState(value) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: "{{ route('getSeletedCountryState') }}",
				method: 'POST',
				data: {
					id: value,
				},
				success: function (response) {
					$('.selectedState').empty();
					let responseData = response;
					responseData.forEach(res => {
						$('.selectedState').append(`<option value="${res.id}">${res.name}</option>`)
					})

					$('.selectedState').prepend(`<option value="" selected disabled>@lang('Select State')</option>`)
				},
				error: function (xhr, status, error) {
					console.log(error)
				}
			});
		}


		$('.selectedState').on('change', function () {
			let selectedValue = $(this).val();
			getSelectedStateCity(selectedValue);
		})

		function getSelectedStateCity(value) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: "{{ route('getSeletedStateCity') }}",
				method: 'POST',
				data: {
					id: value,
				},
				success: function (response) {
					$('.selectedCity').empty();
					let responseData = response;
					responseData.forEach(res => {
						$('.selectedCity').append(`<option value="${res.id}">${res.name}</option>`)
					})

					$('.selectedCity').prepend(`<option value="" selected disabled>@lang('Select City')</option>`)
				},
				error: function (xhr, status, error) {
					console.log(error)
				}
			});
		}


		$('.selectedCity').on('change', function () {
			let selectedValue = $(this).val();
			getSelectedCityArea(selectedValue);
		})

		function getSelectedCityArea(value) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: "{{ route('getSeletedCityArea') }}",
				method: 'POST',
				data: {
					id: value,
				},
				success: function (response) {
					$('.selectedArea').empty();
					let responseData = response;
					responseData.forEach(res => {
						$('.selectedArea').append(`<option value="${res.id}">${res.name}</option>`)
					})

					$('.selectedArea').prepend(`<option value="" selected disabled>@lang('Select Area')</option>`)
				},
				error: function (xhr, status, error) {
					console.log(error)
				}
			});
		}





		// From state city area
		$('.selectedFromState').on('change', function () {
			let selectedValue = $(this).val();
			getSelectedFromStateCity(selectedValue);
		})

		window.getSelectedFromStateCity = function getSelectedFromStateCity(value, from_city_id = null, dataProperty = null) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: "{{ route('getSeletedStateCity') }}",
				method: 'POST',
				data: {
					id: value,
				},
				success: function (response) {
					$('.selectedFromCity').empty();
					let responseData = response;
					responseData.forEach(res => {
						$('.selectedFromCity').append(`<option value="${res.id}" ${res.id == from_city_id ? 'selected' : ''}>${res.name}</option>`)
					})

					window.getSelectedFromCityArea($('.selectedFromCity').val(), dataProperty.from_area_id);

					if (!from_city_id) {
						$('.selectedFromCity').prepend(`<option value="" selected disabled>@lang('Select City')</option>`)
					}
				},
				error: function (xhr, status, error) {
					console.log(error)
				}
			});
		}


		$('.selectedToState').on('change', function () {
			let selectedValue = $(this).val();
			getSelectedToStateCity(selectedValue);
		})

		window.getSelectedToStateCity = function getSelectedToStateCity(value, to_city_id = null, dataProperty = null) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: "{{ route('getSeletedStateCity') }}",
				method: 'POST',
				data: {
					id: value,
				},
				success: function (response) {
					$('.selectedToCity').empty();
					let responseData = response;
					responseData.forEach(res => {
						$('.selectedToCity').append(`<option value="${res.id}" ${res.id == to_city_id ? 'selected' : ''}>${res.name}</option>`)
					})

					window.getSelectedToCityArea($('.selectedToCity').val(), dataProperty.to_area_id);

					if (!to_city_id) {
						$('.selectedToCity').prepend(`<option value="" selected disabled>@lang('Select City')</option>`)
					}
				},
				error: function (xhr, status, error) {
					console.log(error)
				}
			});
		}


		$('.selectedFromCity').on('change', function () {
			let selectedValue = $(this).val();
			getSelectedFromCityArea(selectedValue);
		})

		window.getSelectedFromCityArea = function getSelectedFromCityArea(value, from_area_id = null) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: "{{ route('getSeletedCityArea') }}",
				method: 'POST',
				data: {
					id: value,
				},
				success: function (response) {
					$('.selectedFromArea').empty();
					let responseData = response;
					responseData.forEach(res => {
						$('.selectedFromArea').append(`<option value="${res.id}" ${res.id == from_area_id ? 'selected' : ''}>${res.name}</option>`)
					})

					if (!from_area_id) {
						$('.selectedFromArea').prepend(`<option value="" selected disabled>@lang('Select Area')</option>`)
					}
				},
				error: function (xhr, status, error) {
					console.log(error)
				}
			});
		}


		$('.selectedToCity').on('change', function () {
			let selectedValue = $(this).val();
			getSelectedToCityArea(selectedValue);
		})

		window.getSelectedToCityArea = function getSelectedToCityArea(value, to_area_id = null) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: "{{ route('getSeletedCityArea') }}",
				method: 'POST',
				data: {
					id: value,
				},
				success: function (response) {
					$('.selectedToArea').empty();
					let responseData = response;
					responseData.forEach(res => {
						$('.selectedToArea').append(`<option value="${res.id}" ${res.id == to_area_id ? 'selected' : ''}>${res.name}</option>`)
					})

					if (!to_area_id){
						$('.selectedToArea').prepend(`<option value="" selected disabled>@lang('Select Area')</option>`)
					}

				},
				error: function (xhr, status, error) {
					console.log(error)
				}
			});
		}

	});
</script>
