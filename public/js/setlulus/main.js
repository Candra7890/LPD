var TABLE_ID = '#tb-mhs';
var TB_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';
var LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p>';
let TAMBAHAN_COUNT = 4;

$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	getMahasiswa();
});

$('#btn-filter').click(function() {
	getMahasiswa();
});

function initTooltip() {
	$('[data-toggle="tooltip"]').tooltip();
}

function getMahasiswa() {
	$(TABLE_ID + ' tbody').html(TB_LOADER);
	var angkatan = $('select[name=angkatan]').val();
	var program = $('select[name=program]').val();
	$.get({
		url: '/mahasiswa/get',
		data: {
			angkatan: angkatan,
			program: program
		},
		success: function(data) {
			if (data['status'] == true) {
				var row = '';
				var btn = '';
				$.each(data['msg'], function(i, val) {
					var btn = '<button class="btn btn-sm btn-info btn-set" data-toggle="tooltip" title="Set Lulus" data-id="' + val['mahasiswa_id'] + '"><span class="ti-check"></span></button>';
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
						val['fakultas']['nama_fakultas'] +
						'</td>' +
						'<td>' +
						val['prodi']['nama_prodi'] +
						'</td>' +
						'<td>' +
						val['angkatan']['tahun'] +
						'</td>' +
						'<td>' +
						val['program']['nama_program'] +
						'</td>' +
						'<td>' +
						val['statusaktif']['status'] +
						'</td>' +
						'<td>' +
						btn +
						'</td>' +
						'</tr>';
				});
				$(TABLE_ID)
					.DataTable()
					.destroy();
				$(TABLE_ID + ' tbody').html(row);
				$(TABLE_ID).DataTable();
				return;
			}
			swal('ERROR!', 'Sistem tidak merespon', 'error');
		},
		error: function(data) {
			data = data.responseJSON;
			if (data['status'] == false) {
				swal('ERROR!', data['msg'], 'error');
			}
			swal('ERROR!', 'Terjadi kesalahan sistem', 'error');
		},
		complete: function() {
			initTooltip();
		}
	});
}

$(document).on('click', '.btn-set', function() {
	var id = $(this).data('id');
	var row = $(this)
		.closest('tr')
		.find('td');
	var nama = row[2].innerHTML;
	$('#nama-set').html(nama);
	$('#modal-set').modal('show');
	$('#modal-set-body').html(LOADER);

	$.get({
		url: '/mahasiswa/getstatuslulus/' + id,
		success: function(data) {
			$('#modal-set-body').html(data);
			$('#tgllls').bootstrapMaterialDatePicker({
				weekStart: 0,
				time: false
			});
			$('#tgl_sk_lulus').bootstrapMaterialDatePicker({
				weekStart: 0,
				time: false
			});
			$('#tgl_sk_tugas').bootstrapMaterialDatePicker({
				weekStart: 0,
				time: false
			});
			$('.select2').select2({
				dropdownParent: $('#modal-set')
			});
			$('.textarea_editor').wysihtml5();

			$('.wysihtml5-toolbar')[0].childNodes[0].remove();
			$('.wysihtml5-toolbar')[0].childNodes[1].remove();
			$('.wysihtml5-toolbar')[0].childNodes[1].remove();
			$('.wysihtml5-toolbar')[0].childNodes[1].remove();

			getDosenList();
			getPengujiTambahan(id);
		},
		error: function() {
			swal('ERROR!', 'Terjadi kesalahan sistem', 'error');
		}
	});
});

function getDosenList() {
	$.get({
		url: '/mahasiswa/setlulus/dosen',
		success: function(data) {
			DOSEN = data;

			addOption();
		}
	});
}

function getPengujiTambahan(mid) {
	$.get({
		url: '/mahasiswa/setlulus/penguji-tambah/' + mid,
		success: function(data) {
			if (data.length > 0) TAMBAHAN_COUNT += data.length - 1;
			TAMBAHAN_COUNT = 4;
		}
	});
}

function addOption(idOption) {
	if (!idOption) idOption = '#inputpenguji-0';
	let optionHtml = '<option value="" selected="" disabled=""> << pilih >> </option>';
	DOSEN.forEach(dos => {
		optionHtml += '<option value="' + dos.dosen_id + '">' + dos.nip + ' - ' + dos.nama + '</option>';
	});

	$(idOption).html(optionHtml);
}

$(document).on('click', '#btn-tambahDosen', function() {
	TAMBAHAN_COUNT += 1;

	var fieldHtml =
		'<div class="penguji_tambah">' +
		'<label for="tgllls">Dosen Penguji ' +
		TAMBAHAN_COUNT +
		'</label>' +
		'<div class="form-group row">' +
		'<div class="col-10">' +
		'<select class="select2 form-control custom-select" id="inputpenguji-' +
		TAMBAHAN_COUNT +
		'" style="width: 100%; height:36px;" name="dospeng_tambahan[]"></select>' +
		'</div>' +
		'<div class="col-2 my-auto">' +
		'<button type="button" class="btn btn-sm btn-danger waves-effect btn-deleteTambahDosen"><i class="ti-minus"></i></button>' +
		'</div>' +
		'</div>' +
		'</div>';

	$('.wrapper').append(fieldHtml);

	$('.select2').select2({dropdownParent: $('#modal-set')});
	addOption('#inputpenguji-' + TAMBAHAN_COUNT);
});

$(document).on('click', '.btn-deleteTambahDosen', function() {
	const id = $(this).data('id');
	if (id) {
		$.ajax({
			url: '/mahasiswa/setlulus/penguji-tambah/' + id,
			type: 'DELETE',
			success: function(result) {
				console.log(result);
			}
		});
	}
	var parent = $(this).closest('.penguji_tambah');
	parent.remove();
});

$(document).on('click', '#btn-simpan', function() {
	let btn = this;
	let dosbim1, dosbim2, dosbim3, dospeng1, dospeng2, dospeng3;

	dosbim1 = $('select[name=dosbim1]').val();
	dosbim2 = $('select[name=dosbim2]').val();
	dosbim3 = $('select[name=dosbim3]').val();
	dospeng1 = $('select[name=dospeng1]').val();
	dospeng2 = $('select[name=dospeng2]').val();
	dospeng3 = $('select[name=dospeng3]').val();

	// if (dosbim1 == null || dosbim2 == null) {
	// 	swal("Error!", "Dosen Pembimbing harus diisi.", 'error');
	// 	return
	// }

	var arr_penguji = $('select[name="dospeng_tambahan[]"]')
		.map(function() {
			return this.value; // $(this).val()
		})
		.get();

	$(btn).html('menyimpan...');
	$(btn).attr('disabled', '');
	$.post({
		url: '/mahasiswa/savestatuslulus',
		data: {
			mid: $('input[name=mid]').val(),
			tgl_lulus: $('#tgllls').val(),
			predikat: $('select[name=predikat]').val(),
			tgs_akhir: $('textarea[name=tgs_akhir]').val(),
			dosbim1: dosbim1,
			dosbim2: dosbim2,
			dosbim3: dosbim3,
			dospeng1: dospeng1,
			dospeng2: dospeng2,
			dospeng3: dospeng3,
			no_sk_lulus: $('input[name=no_sk_lulus]').val(),
			no_sk_tugas: $('input[name=no_sk_tugas]').val(),
			tgl_sk_lulus: $('#tgl_sk_lulus').val(),
			tgl_sk_tugas: $('#tgl_sk_tugas').val(),
			tahunajaran_sk_tugas: $('select[name=tahunajaran_sk_tugas]').val(),
			arr_penguji: arr_penguji
		},
		success: function(data) {
			if (data['status'] == true) {
				swal('SUKSES!', data['msg'], 'success');
				$('#modal-set').modal('toggle');
			}
		},
		error: function() {
			swal('ERROR!', 'Terjadi kesalahan sistem', 'error');
		},
		complete: function() {
			$(btn).html('Simpan');
			$(btn).removeAttr('disabled');
		}
	});
});
