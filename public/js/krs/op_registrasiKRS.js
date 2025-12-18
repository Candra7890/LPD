$(document).ready(function() {
	$('#container-loader').hide();
});

function get_current_selected_option() {
	$('#table-reg').hide();
	$('#container-loader').show();
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var prodi_id = $('#prodi').val();
	var angkatan = $('#angkatan').val();
	var program = $('#program').val();
	var status = $('#status_krs').val();

	$.get({
		url: '/registrasi-krs-mhs/get_krs_mhs_all',
		data: {
			thn_ajaran: thn_ajaran,
			semester: semester,
			prodi_id: prodi_id,
			angkatan: angkatan,
			program: program,
			status: status
		},
		success: function(data) {
			console.log(data);
			var row = '';
			var status_regis = '';
			var button = '';

			$('#belum_regis').html(data['total']['belum_regis']);
			$('#belum_approve').html(data['total']['belum_approve']);
			$('#sudah_approve').html(data['total']['sudah_approve']);
			$('#total').html(data['total']['belum_regis'] + data['total']['belum_approve'] + data['total']['sudah_approve']);

			$.each(data['mhs'], function(i, val) {
				// status_regis = val['is_krs'] == 0 ? '<span class="badge badge-danger">Belum</span>' : '<span class="badge badge-success">Sudah</span>';
				// button = '<a href="/registrasi-krs-mbkm?nim=' + val['nim'] + '" class="btn btn-info btn-sm">Registrasi</a>';
				status_regis =
					val['is_krs'] == 0
						? '<span class="badge badge-danger">Belum Registrasi</span>'
						: val['is_krs'] == 1
						? val['jumlah_krs'] != val['jumlah_approve']
							? '<span class="badge badge-warning">Terapprove Sebagian</span>'
							: '<span class="badge badge-success">Terapprove Semua</span>'
						: '<span class="badge badge-warning">Belum Approve</span>';
				button = '<a href="/registrasi-krs-mbkm?nim=' + val['nim'] + '" class="btn btn-info btn-sm">Registrasi</a>';

				row +=
					'<tr>' +
					'<td>' +
					(i + 1) +
					'</td>' +
					'<td>' +
					val['nim'] +
					'</td>' +
					'<td>' +
					val['nama'] +
					'</td>' +
					'<td>' +
					val['tahun'] +
					'</td>' +
					'<td>' +
					val['nama_program'] +
					'</td>' +
					'<td>' +
					val['status'] +
					'</td>' +
					'<td class="text-center">' +
					status_regis +
					'</td>' +
					'<td class="text-center">' +
					button +
					'</td>' +
					'</tr>';
			});
			$('#container-loader').hide();
			$('#table-registrasi')
				.DataTable()
				.destroy();
			$('#krs-mhs').html(row);
			$('#table-registrasi').DataTable();
			$('#table-reg').show();
		},
		error: function() {
			alert('error');
		}
	});
}

$('#btn-search-mhs').click(function() {
	get_current_selected_option();
});

$('#btn-cetak-excel').click(function() {
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var prodi_id = $('#prodi').val();
	var angkatan = $('#angkatan').val();
	var program = $('#program').val();
	var status = $('#status_krs').val();

	if(angkatan == null || angkatan == [] || angkatan == ''){
		alert('Pilih Angkatan');
	}else{
		// angkatan array
		var paramAngkatan = '';
		if (angkatan != null) {
			$.each(angkatan, function(i, val) {
				paramAngkatan += '&angkatan[]=' + val;
			});
		}
		window.location.href = '/registrasi-krs-mhs/export?thn_ajaran=' + thn_ajaran + '&semester=' + semester + '&prodi_id=' + prodi_id + paramAngkatan + '&program=' + program + '&status=' + status;
	}

});

function approve_all(nim) {
	var tahun_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var token = $('input[name=_token]').val();
	// alert(token);
	swal(
		{
			title: 'Approve Semua Matakuliah?',
			text: 'Anda dapat unapprove dengan menuju ke halaman detail KRS',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Approve!',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.post({
				url: '/approve-krs/approve_all',
				data: {
					_token: token,
					tahun_ajaran: tahun_ajaran,
					semester: semester,
					nim: nim,
					isNewItem: true
				},
				success: function(data) {
					if (data.success) {
						swal('Sukses!', data.msg, 'success');
					} else {
						let errorMsg = data.msg == null ? 'Response Tidak Diketahui' : data.msg;
						swal('Error!', data.msg, 'error');
					}
				}
			});
		}
	);
}
