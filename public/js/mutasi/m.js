var MDL_LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memproses...</p>'
var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span> sedang memproses...'
var TABLE_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';
var TABLE = '#tb-permohonan';
var MUTASI = 0;


$(document).ready(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(TABLE).DataTable({
		'autoWidth': false
	});
	view();
})

$(document).on('change', '#form-permohonan select[name=tipe_mutasi]', function () {
	let mutasiTipe = $(this).val();
	if (mutasiTipe == 3) {
		$('#cuti').css('display', 'block');
		$('#pindah_prodi').css('display', 'none');
	} else if (mutasiTipe == 8) {
		$('#pindah_prodi').css('display', 'block');
		$('#cuti').css('display', 'none');
	} else {
		$('#pindah_prodi').css('display', 'none');
		$('#cuti').css('display', 'none');
	}

})

$('#btn-tambah-mutasi').click(function () {
	$('#modal-tambah').modal('show');
	$('#modal-tambah .modal-body').html(MDL_LOADER);
	$('#modal-tambah .modal-title').html('tambah permohonan mutasi');
	var url = '/mutasi/tambah';

	$.get({
		url: url,
		success: function (data) {
			$('#modal-tambah .modal-body').html(data);
			$('.select2').select2()
		},
		error: function (data) {
			data = data.responseJSON;
			if (data.status == false) {
				var msg = '<p class="text-center text-danger">' + data.msg + '</p>'
				$('#modal-tambah .modal-body').html(msg);
			} else {
				var msg = '<p class="text-center text-danger">Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.</p>'
				$('#modal-tambah .modal-body').html();
			}
		}
	})
})

$(document).on('click', '#btn-submit-permohonan', function () {
	var form = new FormData($('#form-permohonan')[0]);
	var url = $('#form-permohonan').attr('action');

	let btn = this;
	let temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');

	$.post({
		url: url,
		data: form,
		contentType: false,
		processData: false,
		success: function (data) {
			if (data.status == true) {
				swal('SUKSES!', data.msg, 'success');
				$('#modal-tambah').modal('toggle');
				view();
			} else {
				swal('ERROR!', 'Response sistem tidak diketahui.', 'error');
			}
		},
		error: function (data) {
			data = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			} else {
				swal('ERROR!', 'Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.', 'error');
			}
		},
		complete: function () {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
})

function view() {
	$(TABLE + ' tbody').html(TABLE_LOADER);
	let url = '/mutasi/view';

	$.get({
		url: url,
		success: function (data) {
			$(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({
				'autoWidth': false
			});
		},
		error: function (data) {
			data = responseJSON;
			let msg;
			if (data.status == false) {
				msg = data.msg
			} else {
				msg = 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.'
			}

			$(TABLE + 'tbody').html('<tr><td colspan="8"><p class="text-center">' + msg + '</p></td></tr>')
		}
	})
}

$(document).on('click', '.btn-edit', function () {
	$('#modal-tambah').modal('show');
	$('#modal-tambah .modal-body').html(MDL_LOADER);
	$('#modal-tambah .modal-title').html('edit permohonan mutasi');

	let id = $(this).data('id');
	let url = '/mutasi/' + id + '/edit';

	$.get({
		url: url,
		success: function (data) {
			$('#modal-tambah .modal-body').html(data);
		},
		error: function (data) {
			data = data.responseJSON;
			if (data.status == false) {
				var msg = '<p class="text-center text-danger">' + data.msg + '</p>'
				$('#modal-tambah .modal-body').html(msg);
			} else {
				var msg = '<p class="text-center text-danger">Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.</p>'
				$('#modal-tambah .modal-body').html();
			}
		}
	})
})

$(document).on('click', '.btn-delete', function () {
	let btn = this;
	swal({
		title: "PERHATIAN!",
		text: "Apakah anda yakin ingin menghapus permohonan mutasi ini?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Ya, Hapus Permohonan!",
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}, function () {
		let id = $(btn).data('id');
		let url = '/mutasi/delete';

		$.post({
			url: url,
			data: {
				id: id
			},
			success: function (data) {
				if (data.status == true) {
					swal('SUKSES!', data.msg, 'success');
					view();
				} else {
					swal('ERROR!', 'Response sistem tidak diketahui.', 'error');
				}
			},
			error: function (data) {
				data = data.responseJSON;
				if (data.status == false) {
					swal('ERROR!', data.msg, 'error');
				} else {
					swal('ERROR!', 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.', 'error');
				}
			}
		})

	});
})

$(document).on('click', '.btn-sh-revisi', function () {
	var id = $(this).data('id');
	MUTASI = id;

	$('#modal-tambah').modal('show');
	$('#modal-tambah .modal-body').html(MDL_LOADER);
	$('#modal-tambah .modal-title').html('Revisi');

	$.get({
		url: '/mutasi/' + id + '/revisi',
		success: function (data) {
			$('#modal-tambah .modal-body').html(data);
			$('#tb-revisi').DataTable();
		},
		error: function (data) {
			data = data.responseJSON;
			if (data.status == false) {
				var msg = '<p class="text-center text-danger">' + data.msg + '</p>'
				$('#modal-tambah .modal-body').html(msg);
			} else {
				var msg = '<p class="text-center text-danger">Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.</p>'
				$('#modal-tambah .modal-body').html(msg);
			}
		}
	})
})

$(document).on('click', '#btn-revisi-mutasi', function () {
	$('#modal-tambah').modal('show');
	$('#modal-tambah .modal-body').html(MDL_LOADER);
	$('#modal-tambah .modal-title').html('edit permohonan mutasi');

	let url = '/mutasi/' + MUTASI + '/revisiedit';

	$.get({
		url: url,
		success: function (data) {
			$('#modal-tambah .modal-body').html(data);
		},
		error: function (data) {
			data = data.responseJSON;
			if (data.status == false) {
				var msg = '<p class="text-center text-danger">' + data.msg + '</p>'
				$('#modal-tambah .modal-body').html(msg);
			} else {
				var msg = '<p class="text-center text-danger">Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.</p>'
				$('#modal-tambah .modal-body').html();
			}
		}
	})
})