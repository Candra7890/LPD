var LOADER = '<tr><td colspan="10"><p style="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';

function get_khs_by_filter() {
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var token = $('input[name=_token]').val();

	$('#mktawar-row').html(LOADER);
	$.post({
		url: '/datakrs',
		data: {
			thn_ajaran: thn_ajaran,
			semester: semester,
			_token: token
		},
		beforeSend: function(res) {
			$('#mktawar-row').html('<td colspan="8" class="text-center">' + '<i class="fa fa-spin fa-refresh"></i>  ' + 'Sedang Memproses...' + '</td>');
		},
		success: function(data) {
			if (data.length === 0) {
				$('#mktawar-row').html('<td colspan="8" class="text-center">' + 'Tidak ada data' + '</td>');

				return false;
			}

			var row = '';
			var nk = 0;
			var jml_sks = 0;
			var nk_permk;
			var nilai;
			var jml_sks_nk = 0;
			$.each(data, function(i, val) {
				jml_sks += val['sks'];
				nk += val['sks'] * val['nilai_angka_konversi'];
				nk_permk = val['sks'] * val['nilai_angka_konversi'] == 0 ? '-' : val['sks'] * val['nilai_angka_konversi'];
				jml_sks_nk += val['sks'] * val['nilai_angka_konversi'] == 0 ? 0 : val['sks'];

				nilai = val['nilai_huruf'] == null ? '-' : val['nilai_huruf'];
				row +=
					'<tr>' +
					'<td>' +
					(i + 1) +
					'</td>' +
					'<td>' +
					val['kode_matakuliah'] +
					'</td>' +
					'<td>' +
					val['nama_matakuliah'] +
					' (' +
					val['kelas'] +
					')' +
					'</td>' +
					'<td>' +
					val['sks'] +
					'</td>' +
					'<td>' +
					nilai +
					'</td>' +
					'<td>' +
					nk_permk +
					'</td>' +
					'</tr>';
			});
			var ips = nk == 0 && jml_sks_nk == 0 ? 0 : (nk / jml_sks_nk).toFixed(2);

			// ips = (ips == NaN) ? 0 : ips.toFixed(2)

			row += '<tr>' + '<td colspan="3"><b>Total</b></td>' + '<td><b>' + jml_sks + '</b></td>' + '<td></td>' + '<td><b>' + nk + '</b></td>' + '</tr>';

			$('#mktawar-row').html(row);
			$('#ips').html(ips);
			get_ipk_ips();
		},
		error: function() {
			alert('error');
		}
	});
}

function get_ipk_ips(mhs_id) {
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var token = $('input[name=token]').val();
	$.get({
		url: '/registrasi-krs/hitung-nilai',
		data: {
			mahasiswa_id: token,
			thn_ajaran: thn_ajaran,
			semester: semester,
			service: 'khs'
		},
		success: function(data) {
			console.log(data);
			$('#ipk').html(data['ipk']);
			$('#maxsks').html(data['maks_sks']);
		},
		error: function() {
			console.log('error mengambil data ipk dan ips');
		}
	});
}

$(document).ready(function() {
	get_khs_by_filter();
});

$('#btn-search-khs').click(function() {
	let button = $(this);
	button.html('<span class="btn-label"><i class="fa fa-spin fa-circle-o-notch"></i></span> Memproses');

	get_khs_by_filter();

	button.html('<span class="btn-label"><i class="fa fa-search"></i></span> Tampilkan');
});
