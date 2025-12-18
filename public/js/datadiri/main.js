var load = '<option value="" selected="" disabled="">mohon tunggu..</option>';

function loadKab() {
	var pid = $('select[name=provinsi]').val();

	var option = '<option value="" selected="" disabled=""><< pilih kabupaten >></option>';
	$('select[name=kabupaten]').html(load);
	$('select[name=kecamatan]').html('<option value="" selected="" disabled=""><< pilih kabupaten terlebih dahulu >></option>');

	$.get({
		url: '/api/kabupaten',
		data: {
			pid: pid
		},
		success: function(data) {
			if (data['status'] == true) {
				$.each(data['msg'], function(i, val) {
					option += '<option value="' + val.kabupaten_id + '">' + val.nama_kabupaten + '</option>';
				});

				$('select[name=kabupaten]').html(option);
				return;
			}

			$('select[name=kabupaten]').html('<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>');
		},
		error: function() {
			$('select[name=kabupaten]').html('<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>');
		}
	});
}

function loadKec() {
	var kbid = $('select[name=kabupaten]').val();
	var option = '<option value="" selected="" disabled=""><< pilih kecamatan >></option>';
	$('select[name=kecamatan]').html(load);
	$.get({
		url: '/api/kecamatan',
		data: {
			kbid: kbid
		},
		success: function(data) {
			if (data.status == true) {
				$.each(data['msg'], function(i, val) {
					option += '<option value="' + val.kecamatan_id + '">' + val.nama_kecamatan + '</option>';
				});

				$('select[name=kecamatan]').html(option);
				return;
			}

			$('select[name=kecamatan]').html('<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>');
		},
		error: function() {
			$('select[name=kecamatan]').html('<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>');
		}
	});
}

$('select[name=provinsi]').on('change', function() {
	var pid = $(this).val();

	var option = '<option value="" selected="" disabled=""><< pilih kabupaten >></option>';
	$('select[name=kabupaten]').html(load);
	$('select[name=kecamatan]').html('<option value="" selected="" disabled=""><< pilih kabupaten terlebih dahulu >></option>');

	$.get({
		url: '/api/kabupaten',
		data: {
			pid: pid
		},
		success: function(data) {
			if (data['status'] == true) {
				$.each(data['msg'], function(i, val) {
					option += '<option value="' + val.kabupaten_id + '">' + val.nama_kabupaten + '</option>';
				});

				$('select[name=kabupaten]').html(option);
				return;
			}

			$('select[name=kabupaten]').html('<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>');
		},
		error: function() {
			$('select[name=kabupaten]').html('<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>');
		}
	});
});

$('select[name=kabupaten]').on('change', function() {
	var kbid = $(this).val();
	var option = '<option value="" selected="" disabled=""><< pilih kecamatan >></option>';
	$('select[name=kecamatan]').html(load);
	$.get({
		url: '/api/kecamatan',
		data: {
			kbid: kbid
		},
		success: function(data) {
			if (data.status == true) {
				$.each(data['msg'], function(i, val) {
					option += '<option value="' + val.kecamatan_id + '">' + val.nama_kecamatan + '</option>';
				});

				$('select[name=kecamatan]').html(option);
				return;
			}

			$('select[name=kecamatan]').html('<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>');
		},
		error: function() {
			$('select[name=kecamatan]').html('<option value="" selected="" disabled="">!! gagal mengambil data kabupaten !!</option>');
		}
	});
});

$('select[name=kecamatan]').on('change', function() {
	var kcid = $(this).val();
	var option = '<option value="" selected="" disabled=""><< pilih kelurahan >></option>';
	$('select[name=kelurahan]').html(load);
	$.get({
		url: '/api/kelurahan',
		data: {
			kcid: kcid
		},
		success: function(data) {
			if (data.status == true) {
				$.each(data['msg'], function(i, val) {
					option += '<option value="' + val.kelurahan_id + '">' + val.nama_kelurahan + '</option>';
				});

				$('select[name=kelurahan]').html(option);
				return;
			}

			$('select[name=kelurahan]').html('<option value="" selected="" disabled="">!! gagal mengambil data kecamatan !!</option>');
		},
		error: function() {
			$('select[name=kelurahan]').html('<option value="" selected="" disabled="">!! gagal mengambil data kecamatan !!</option>');
		}
	});
});
