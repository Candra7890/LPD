$(document).ready(function () {
	get_mktawar_selected_option();
})

function get_mktawar_selected_option() {
	$('#table-mktawar').hide();
	$('#container-loader').show();
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var prodi_id = $('#prodi').val();
	var angkatan = $('#angkatan').val();
	var program = $('#program').val();

	$.get({
		url: '/distribusi-kelas/mktawar',
		data: {
			thn_ajaran: thn_ajaran,
			semester: semester,
			prodi_id: prodi_id,
			angkatan: angkatan,
			program: program
		},
		success: function (data) {
			$('#container-loader').hide();
			$('#table-mktawar').show();
			var row = '';
			var button = '';
			console.log(data);
			$.each(data, function (i, val) {
				button = '<a href="/distribusi-kelas/atur?mkt=' + val['mktawar_id'] + '" class="btn btn-info btn-sm">Atur Kelas</a>'
				row += '<tr>' +
					'<td>' + (i + 1) + '</td>' +
					'<td>' + val['kode_matakuliah'] + '</td>' +
					'<td>' + val['nama_matakuliah'] + '</td>' +
					'<td>' + val['semester'] + '</td>' +
					'<td>' + val['sks'] + '</td>' +
					// '<td>' + val['nama_program'] + '</td>' +
					'<td>' + val['jml_kelas'] + '</td>' +
					'<td class="text-center">' + button + '</td>' +
					'</tr>';
			});
			$('#table-mktawar').DataTable().destroy();
			$('#mktawar-row').html(row);
			$('#table-mktawar').DataTable();
		},
		error: function () {
			alert('error');
		}
	})
}

$('#btn-search-mktawar').click(function () {
	get_mktawar_selected_option();
})