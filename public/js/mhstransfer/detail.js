var LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p>';
var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span> memproses...';
var TABLE = '#tb-permohonan';
var TABLE_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';

$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('.select2').select2();
	$(TABLE).DataTable();
});

$('#btn-tambah').click(function() {
	$('#modal').modal('show');
});

$('#semester-input').change(function() {
	changeMk();
});

$('#tahunajaran-input').change(function() {
	changeMk();
});

$(document).on('change', '.checklistmk', function() {
	let mode = $(this).data('mode');
	let checklistStatus = $(this).is(':checked');
	let krsId = $(this).data('krsid');
	let checklist = this;

	if (mode == 1) modeTitle = 'terbaik';
	else if (mode == 2) modeTitle = 'terakhir';
	else modeTitle = 'terpakai';

	$.post({
		url: '/mhs-transfer/update',
		data: {
			type: 'triplet',
			mode: mode,
			krsId: krsId,
			checklistStatus: checklistStatus
		},
		beforeSend: function() {
			$(checklist).hide();
			$('label[for=' + modeTitle + krsId + ']').hide();

			$('#loader' + modeTitle + krsId).show();
		},
		success: function(data) {
			$(checklist).show();
			$('label[for=' + modeTitle + krsId + ']').show();

			$('#loader' + modeTitle + krsId).hide();
		},
		error: function(data) {
			$(checklist).show();
			$('label[for=' + modeTitle + krsId + ']').show();

			$('#loader' + modeTitle + krsId).hide();

			if (checklistStatus) {
				$(checklist).prop('checked', false);
			} else {
				$(checklist).prop('checked', true);
			}
		}
	});
});

function changeMk() {
	var tahunajaran = $('select[name=tahunajaran]').val();
	var semester = $('select[name=semester]').val();
	var program = $('input[name=program]').val();
	var prodi = $('input[name=prodi]').val();
	let angkatan = $('input[name=angkatan]').val();

	if (tahunajaran == '') {
		$('select[name=matakuliah]').html('<option value=""><< pilih tahun ajaran terlebih dahulu >></option>');
		return;
	} else if (semester == '') {
		$('select[name=matakuliah]').html('<option value=""><< pilih semester terlebih dahulu >></option>');
		return;
	}

	$('select[name=matakuliah]').html('<option value="">mohon tunggu...</option>');
	$.get({
		url: '/mhs-transfer/getMatakuliah',
		data: {
			tahunajaran: tahunajaran,
			program: program,
			semester: semester,
			prodi: prodi,
			angkatan: angkatan
		},
		success: function(data) {
			if (data.status == true) {
				var option = '<option value=""><< pilih matakuliah >></option>';
				$.each(data.msg, function(i, val) {
					option += '<option value="' + val.mktawar_id + '">' + val.mkangkatan.kode_matakuliah + ' ' + val.mkangkatan.nama_matakuliah + ' (' + val.kelas + ')' + '</option>';
				});
				$('select[name=matakuliah]').html(option);
				$('.select2').select2();
			} else {
				$('select[name=matakuliah]').html('<option value="">terjadi kesalahan server</option>');
			}
		},
		error: function() {
			swal('ERROR!', 'Terjadi kegagalan sistem', 'error');
		}
	});
}

$(document).on('click', '#btn-simpan', function() {
	var form = new FormData($('#form-tambah')[0]);
	var temp = $(this).html();
	var btn = this;
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');
	$.post({
		url: '/mhs-transfer/store',
		data: form,
		contentType: false,
		processData: false,
		success: function(data) {
			location.reload();
		},
		error: function(data) {
			data = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			} else {
				swal('ERROR!', 'Terjadi kesalahan sistem.', 'error');
			}
		},
		complete: function() {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	});
});

$(document).on('click', '.btn-edit', function() {
	$('#modal-edit').modal('show');
	$('#modal-edit .modal-body').html(LOADER);

	var id = $(this).data('id');

	$.get({
		url: '/mhs-transfer/edit/' + id,
		success: function(data) {
			$('#modal-edit .modal-body').html(data);
		},
		error: function() {
			$('#modal-edit .modal-body').html('<p class="text-danger text-center">Terjadi kesalahan sistem.</p>');
		}
	});
});

$(document).on('click', '#btn-simpan-edit', function() {
	var form = new FormData($('#form-edit')[0]);
	var url = $('#form-edit').attr('action');

	var temp = $(this).html();
	var btn = this;
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');

	$.post({
		url: url,
		contentType: false,
		processData: false,
		data: form,
		success: function(data) {
			location.reload();
		},
		error: function(data) {
			data = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			} else {
				swal('ERROR!', 'Terjadi kesalahan sistem.', 'error');
			}
		},
		complete: function() {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	});
});

$(document).on('click', '.btn-delete', function() {
	var id = $(this).data('id');
	let ampulen = $(this).data('ampulen');
	swal(
		{
			title: 'PERHATIAN!',
			text: 'Apakan anda yakin ingin menghapus matakuliah ini?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Hapus!',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.post({
				url: '/mhs-transfer/delete',
				data: {
					id: id,
					ampulen: ampulen
				},
				success: function(data) {
					location.reload();
				},
				error: function(data) {
					data = data.responseJSON;
					if (data.status == false) {
						swal('ERROR!', data.msg, 'error');
					} else {
						swal('ERROR!', 'Terjadi kesalahan sistem.', 'error');
					}
				}
			});
		}
	);
});

$('#btn-tambah-ampulen').click(function() {
	$('#modal-ampulen').modal('show');
	$('#modal-ampulen .modal-title').html('Tambah Matakuliah Pindahan/Ampulen');
	$('#modal-ampulen .modal-body').html(TABLE_LOADER);
	let id = $(this).data('id');
	$.get({
		url: '/mhs-transfer/ampulen',
		data: {
			mhs_id: id
		},
		success: function(data) {
			$('#modal-ampulen .modal-body').html(data);
			$('select[name=new_mk]').select2();
		},
		error: function(data) {
			$('#modal-ampulen .modal-body').html('ERROR! Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.');
		}
	});
});

$(document).on('click', '#btn-simpan-ampulen', function() {
	var form = new FormData($('#form-tambah-ampulen')[0]);
	var temp = $(this).html();
	var btn = this;
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');
	$.post({
		url: '/mhs-transfer/store',
		data: form,
		contentType: false,
		processData: false,
		success: function(data) {
			$('#modal-ampulen').modal('toggle');
			swal('SUKSES!', data.msg, 'success');
		},
		error: function(data) {
			data = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			} else {
				swal('ERROR!', 'Terjadi kesalahan sistem.', 'error');
			}
		},
		complete: function() {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	});
});

$(document).on('click', '#btn-show-ampulen', function(e) {
	e.preventDefault();
	$('#modal-ampulen').modal('show');
	$('#modal-ampulen .modal-title').html('Matakuliah pindahan/ampulen');
	$('#modal-ampulen .modal-body').html(TABLE_LOADER);

	let url = $(this).data('url');
	$.get({
		url: url,
		data: {
			service: 'ampulen'
		},
		success: function(data) {
			$('#modal-ampulen .modal-body').html(data);
		},
		error: function(data) {
			alert('error');
		}
	});
});
