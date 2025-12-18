var masternilai;

$(document).ready(function() {
	$('#table-nilai').DataTable({
		bAutoWidth: false,
		aoColumns: [{ sWidth: '5%' }, { sWidth: '10%' }, { sWidth: '40%' }, { sWidth: '5%' }, { sWidth: '35%' }],
		paging: false
	});
});

$('#btn-upload-nilai').click(function() {
	$('#upload-step').show();
	$('#iunderstand').show();
	$('#form-upload').hide();
	$('#modal-upload').modal('show');
});

$('#iunderstand').click(function() {
	$('#upload-step').hide();
	$('#iunderstand').hide();
	$('#form-upload').show();
});

// $(function() {
// 	$('input').keydown(function() {
// 		// Save old value.
// 		$(this).data('old', $(this).val());
// 	});
// 	$('input').keyup(function() {
// 		// Check correct, else revert back to old value.
// 		if (parseInt($(this).val()) <= 100 && parseInt($(this).val()) >= 0);
// 		else $(this).val($(this).data('old'));
// 	});
// });

function reconfigure(e) {
	var nilai_baru = $('input[name="nilai_huruf[' + $(e).data('key') + ']"]:checked').val();
	var key = $(e).data('key');
	var krs = $(e).data('k');

	$.each(masternilai, function(i, val) {
		if (val['nilai_huruf'] == nilai_baru) {
			$('#nbr' + krs + '' + $(e).data('key')).val(val['nilai_bawah']);
			return false;
		}
	});
}

function reconfigureTeori(e) {
	var key = $(e).data('key');
	var krs = $(e).data('k');

	let nilai_kehadiran = $('#nhadir' + krs + '' + $(e).data('key')).val();
	let nilai_tugas = $('#ntugas' + krs + '' + $(e).data('key')).val();
	let nilai_uts = $('#nuts' + krs + '' + $(e).data('key')).val();
	let nilai_uas = $('#nuas' + krs + '' + $(e).data('key')).val();

	if (nilai_kehadiran && nilai_tugas && nilai_uts && nilai_uas) {
		let nilai_kehadiran_final = 0;
		let nilai_tugas_final = 0;
		let nilai_uts_final = 0;
		let nilai_uas_final = 0;

		BOBOT_NILAI.forEach(bobot => {
			if (bobot['nama_bobot'] == 'kehadiran') {
				nilai_kehadiran_final = nilai_kehadiran * (bobot['value_bobot'] / 100);
			}
			if (bobot['nama_bobot'] == 'tugas') {
				nilai_tugas_final = nilai_tugas * (bobot['value_bobot'] / 100);
			}
			if (bobot['nama_bobot'] == 'uts') {
				nilai_uts_final = nilai_uts * (bobot['value_bobot'] / 100);
			}
			if (bobot['nama_bobot'] == 'uas') {
				nilai_uas_final = nilai_uas * (bobot['value_bobot'] / 100);
			}
		});

		let nilai_akhir = parseFloat(nilai_kehadiran_final) + parseFloat(nilai_tugas_final) + parseFloat(nilai_uts_final) + parseFloat(nilai_uas_final);

		$('#nbr' + krs + '' + $(e).data('key')).val(nilai_akhir);

		$.each(masternilai, function(i, val) {
			if (val['nilai_atas'] >= nilai_akhir && val['nilai_bawah'] <= nilai_akhir) {
				$('#radio' + krs + '' + val['masternilai_id']).prop('checked', true);
				return false;
			}
		});
	}
}

function recalculateGrade(e) {
    var key = $(e).data('key');
    var krs = $(e).data('k');

    let nilai_kehadiran = parseFloat($('#nhadir' + krs + key).val()) || 0;
    let nilai_partisipasi = parseFloat($('#npartisipasi' + krs + key).val()) || 0;
    let nilai_proyek = parseFloat($('#nproyek' + krs + key).val()) || 0;
    let nilai_kognitif = parseFloat($('#nkognitif' + krs + key).val()) || 0;

    // Calculate total aktivitas partisipatif (10% + 40%)
	// new formula: ((nilai_kehadiran * 0.1) + (nilai_partisipasi * 0.4) * 2) 11 feb 2025
    let total_partisipasi = ((nilai_kehadiran * 0.1) + (nilai_partisipasi * 0.4)) * 2 ;
    $('#total_partisipasi' + krs + key).val(total_partisipasi.toFixed(1));

    // Calculate final grade
    let nilai_akhir = (total_partisipasi * 0.5) + (nilai_proyek * 0.4) + (nilai_kognitif * 0.1);
    $('#nbr' + krs + key).val(nilai_akhir.toFixed(1));

    // Update grade letter based on final grade
    $.each(masternilai, function(i, val) {
        if (val['nilai_atas'] >= nilai_akhir && val['nilai_bawah'] <= nilai_akhir) {
            $('#radio' + krs + val['masternilai_id']).prop('checked', true);
            return false;
        }
    });
}

function reconfigureProject(e) {
	var key = $(e).data('key');
	var krs = $(e).data('k');

	let nilai_kehadiran = $('#nhadir' + krs + '' + $(e).data('key')).val();
	let nilai_partisipasi_mhs = $('#npartisipasi_mhs' + krs + '' + $(e).data('key')).val();
	let nilai_presentasi_akhir = $('#npresentasi_akhir' + krs + '' + $(e).data('key')).val();

	if (nilai_kehadiran && nilai_partisipasi_mhs && nilai_presentasi_akhir) {
		let nilai_kehadiran_final = 0;
		let nilai_partisipasi_mhs_final = 0;
		let nilai_presentasi_akhir_final = 0;

		BOBOT_NILAI.forEach(bobot => {
			if (bobot['nama_bobot'] == 'kehadiran') {
				nilai_kehadiran_final = nilai_kehadiran * (bobot['value_bobot'] / 100);
			}
			if (bobot['nama_bobot'] == 'partisipasi_mhs') {
				nilai_partisipasi_mhs_final = nilai_partisipasi_mhs * (bobot['value_bobot'] / 100);
			}
			if (bobot['nama_bobot'] == 'presentasi_akhir') {
				nilai_presentasi_akhir_final = nilai_presentasi_akhir * (bobot['value_bobot'] / 100);
			}
		});

		let nilai_akhir = parseFloat(nilai_kehadiran_final) + parseFloat(nilai_partisipasi_mhs_final) + parseFloat(nilai_presentasi_akhir_final);

		$('#nbr' + krs + '' + $(e).data('key')).val(nilai_akhir);

		$.each(masternilai, function(i, val) {
			if (val['nilai_atas'] >= nilai_akhir && val['nilai_bawah'] <= nilai_akhir) {
				$('#radio' + krs + '' + val['masternilai_id']).prop('checked', true);
				return false;
			}
		});
	}
}

function get_masternilai(fid, jpid) {
	$.get({
		url: '/inputnilai/masternilai/' + fid + '/' + jpid,
		success: function(data) {
			masternilai = data;
		},
		error: function() {
			alert('error');
		}
	});
}

function reconfigureAlpha(e) {
	var nilai_baru = $(e).val();
	var krs = $(e).data('k');

	$.each(masternilai, function(i, val) {
		if (val['nilai_atas'] >= nilai_baru && val['nilai_bawah'] <= nilai_baru) {
			$('#radio' + krs + '' + val['masternilai_id']).prop('checked', true);
			return false;
		}
	});
}
