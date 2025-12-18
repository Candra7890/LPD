var TABLE_ID = '#table-approve';
var TABLE_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';

$(document).ready(function() {
	$('#table-approve').DataTable();
	get_selected_appr_krs();
	moment.locale('id');

	console.log(is_koprodi);
});

$('#btn-search-mhs').click(function() {
	get_selected_appr_krs();
});

function get_selected_appr_krs() {
	$('#start').html('-');
	$('#end').html('-');
	var angkatan = $('#angkatan').val();
	var program = $('#program').val();
	var tahun_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var row = '';
	// if (angkatan == '' || program == '') {
	// 	swal({
	// 		title: "Warning!",
	// 		text: "Kolom Angkatan atau Program tidak boleh kosong!",
	// 		type: "warning"
	// 	});
	// } else {
	$(TABLE_ID + ' tbody').html(TABLE_LOADER);
	$.get({
		url: '/approve-krs/get_krs_mhs_all',
		data: {
			angkatan: angkatan,
			program: program,
			tahun_ajaran: tahun_ajaran,
			semester: semester
		},
		success: function(data) {
			$('#start').html(data.start == '' ? '-' : moment(data.start).format('D MMMM YYYY'));
			$('#end').html(data.end == '' ? '-' : moment(data.end).format('D MMMM YYYY'));

			var link = '';
			var btn = '';
			var status = '';
			var disable = '';
			let start, end;
			let anyAktivasi = data.start == '' ? false : true;

			$.each(data.mhs, function(key, val) {
				if (!anyAktivasi) {
					return;
				}
				var nim = val.nim;
				link = '/approve-krs/lihat?nim=' + nim + '&tahun_ajaran=' + tahun_ajaran + '&semester=' + semester;

				// console.log("before :" + link)
				start = new Date(data.start);
				end = new Date(data.end);

				btn = '';
				if (val.has_krs_count > 0) {
					btn = '<a href="' + link + '" target="_blank" class="btn btn-info btn-sm m-1" data-toggle="tooltip" title="Lihat KRS"><span class="mdi mdi-eye"></span></a>';
					btn += '<button class="btn btn-success btn-sm m-1" onclick="approve_all(' + val['nim'] + ')" data-toggle="tooltip" title="Approve Semua Matakuliah"><span class="mdi mdi-check-circle"></span></button>';
				}

				let tahun = val.angkatan == null ? 'Tidak diketahui' : val.angkatan.tahun;
				let program = val.program == null ? 'Tidak diketahui' : val.program.nama_program;
				let statusApprove = '';
				if (val.krs_approve_count == 0) {
					statusApprove = '<span class="badge badge-danger">Belum Approve</span>';
				} else if (val.krs_approve_count > 0 && val.krs_approve_count < val.has_krs_count) {
					statusApprove = '<span class="badge badge-warning">Approve Sebagian</span>';
				} else if (val.krs_approve_count == val.has_krs_count) {
					statusApprove = '<span class="badge badge-success">Telah Diapprove</span>';
				}

				let statusApproveKoprodi = '';
				if (val.krs_approve_koprodi_count == 0) {
					statusApproveKoprodi = '<span class="badge badge-danger">Belum Approve</span>';
				} else if (val.krs_approve_koprodi_count > 0 && val.krs_approve_koprodi_count < val.has_krs_count) {
					statusApproveKoprodi = '<span class="badge badge-warning">Approve Sebagian</span>';
				} else if (val.krs_approve_koprodi_count == val.has_krs_count) {
					statusApproveKoprodi = '<span class="badge badge-success">Telah Diapprove</span>';
				}

				status = val.has_krs_count > 0 ? '<span class="badge badge-success">Sudah</span>' : '<span class="badge badge-danger">Belum</span>';
				row +=
					'<tr>' +
					'<td>' +
					(key + 1) +
					'</td>' +
					'<td>' +
					nim +
					'</td>' +
					'<td>' +
					val['nama'] +
					'</td>' +
					'<td>' +
					tahun +
					'</td>' +
					'<td>' +
					program +
					'</td>' +
					'<td>' +
					status +
					'</td>' +
					'<td>' +
					statusApprove +
					'</td>' +
					// '<td>' + statusApproveKoprodi + '</td>' +
					'<td>' +
					btn +
					'</td>' +
					'</tr>';
			});
			$('#table-approve')
				.DataTable()
				.destroy();
			$('#approve-krs-mhs').html(row);
			$('#table-approve').DataTable({
				// "columns": [
				// 	{
				// 		"width": "5%"
				// 	},
				// 	{
				// 		"width": "10%"
				// 	},
				// 	{
				// 		"width": "25%"
				// 	},
				// 	{
				// 		"width": "10%"
				// 	},
				// 	{
				// 		"width": "10%"
				// 	},
				// 	{
				// 		"width": "10%"
				// 	},
				// 	{
				// 		"width": "10%"
				// 	},
				// 	{
				// 		"width": "10%"
				// 	},
				// 	{
				// 		"width": "20%"
				// 	},
				// ]
			});
		}
	});
	// }
}

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
					nim: nim
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

function approve_all_koprodi(nim) {}
