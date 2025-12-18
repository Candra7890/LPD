$(document).ready(function() {
	get_mktawar_by_filter();
});

function get_mktawar_by_filter() {
	$('#table-mktawar').hide();
	$('#container-loader').show();
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var prodi_id = $('#prodi').val();
	// var angkatan = $('#angkatan').val();
	var program = $('#program').val();

	$.get({
		url: '/api/inputnilai/get_mktawar_by_filter',
		data: {
			thn_ajaran: thn_ajaran,
			semester: semester,
			// angkatan: angkatan,
			program: program
		},
		success: function(data) {
			$('#container-loader').hide();
			$('#table-mktawar').show();
			// console.log(data);
			var row = '';
			var status = 0;
			var button = '';
			let progress = '';

			let start, end, now;

			$('#table-mktawar')
				.DataTable()
				.destroy();

			$.each(data.mktawar, function(i, val) {
				start = new Date(data.aktivasi.tgl_mulai_input_nilai);
				end = new Date(data.aktivasi.tgl_berakhir_input_nilai);

				now = new Date();
				now.setHours(0, 0, 0, 0);

				// console.log(now, data.aktivasi.tgl_mulai_input_nilai, end);
				// console.log(now <= end)

				button = '';
				button =
					'<a target="_blank" href="/penawaran/' + val['mktawar_id'] + '/peminat" class="btn btn-primary btn-sm mt-1 mr-1" data-toggle="tooltip" data-placement="top" title="Daftar Mahasiswa"> <i class="mdi mdi-account-multiple"></i> </a>';
				
				// Dropdown cetak nilai
				button += '<div class="btn-group">' +
					'<button type="button" class="btn btn-sm btn-danger dropdown-toggle mt-1 mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Cetak Nilai">' +
					'<span class="ti-printer"></span> <span class="caret"></span>' +
					'</button>' +
					'<div class="dropdown-menu">' +
					'<a class="dropdown-item" href="#" onclick="cetakNilaiStandar(' + val['mktawar_id'] + ')">' +
					'<i class="ti-printer"></i> Cetak Nilai Standar' +
					'</a>' +
					'<a class="dropdown-item" href="#" onclick="cetakNilaiDetail(' + val['mktawar_id'] + ')">' +
					'<i class="ti-printer"></i> Cetak Nilai Detail' +
					'</a>' +
					'</div>' +
					'</div>';
				button +=
						now >= start && now <= end
						// val.semester === 1 && val.tahunajaran === 2024
						? '<br> <a target="_blank" href="/inputnilai/input?mkt=' + val['hash'] + '" class="btn btn-info btn-sm mt-1 mr-1" data-toggle="tooltip" data-placement="top" title="Input Nilai"> <i class="mdi mdi-pencil"></i> </a>'
						: '';
				// button = '<a target="_blank" href="/inputnilai/input?mkt=' + val['hash'] + '" class="btn btn-info btn-sm">Input Nilai</a>';

				if (val.krs_count > 0) status = Math.ceil((val.krs_has_nilai_count / val.krs_count) * 100);
				else status = 0;

				statusClass = status == 100 ? 'label-success' : 'label-danger';
				progress = "<span class='label " + statusClass + "'>" + status + '%</span>';
				row +=
					'<tr>' +
					'<td>' +
					(i + 1) +
					'</td>' +
					'<td>' +
					val.mkangkatan.kode_matakuliah +
					'</td>' +
					'<td>' +
					val.mkangkatan.nama_matakuliah +
					' (' +
					val['kelas'] +
					'/' +
					val.program.nama_program +
					')' +
					'</td>' +
					'<td>' +
					val.prodi.nama_prodi +
					'/' +
					val.fakultas.nama_fakultas +
					'</td>' +
					'<td class="text-center">' +
					val.mkangkatan.semester +
					'</td>' +
					'<td class="text-center">' +
					val.mkangkatan.sks +
					'</td>' +
					'<td class="text-center">' +
					progress +
					'</td>' +
					'<td class="text-center">' +
					button +
					'</td>' +
					'</tr>';
			});
			$('#mktawar-row').html(row);
			$('#table-mktawar').DataTable();
		},
		error: function() {
			$('#container-loader').hide();
			$('#table-mktawar').hide();
			console.log('belum dapat mengakses halaman ini');
		}
	});
}

$('#btn-search-mktawar').click(function() {
	get_mktawar_by_filter();
});

// Fungsi untuk cetak nilai standar
function cetakNilaiStandar(mktawar_id) {
	var form = $('<form>', {
		'method': 'POST',
		'action': '/report/cetak-matkul-tawar-nilai',
		'target': '_blank'
	});
	
	form.append($('<input>', {
		'type': 'hidden',
		'name': '_token',
		'value': $('meta[name="csrf-token"]').attr('content')
	}));
	
	form.append($('<input>', {
		'type': 'hidden',
		'name': 'mktawar_id',
		'value': mktawar_id
	}));
	
	$('body').append(form);
	form.submit();
	form.remove();
}

// Fungsi untuk cetak nilai detail
function cetakNilaiDetail(mktawar_id) {
	var form = $('<form>', {
		'method': 'POST',
		'action': '/report/cetak-matkul-tawar-nilai-detail',
		'target': '_blank'
	});
	
	form.append($('<input>', {
		'type': 'hidden',
		'name': '_token',
		'value': $('meta[name="csrf-token"]').attr('content')
	}));
	
	form.append($('<input>', {
		'type': 'hidden',
		'name': 'mktawar_id',
		'value': mktawar_id
	}));
	
	$('body').append(form);
	form.submit();
	form.remove();
}
