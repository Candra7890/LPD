var MODAL_LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memproses..</p>';
var TABLE = '#tb-syarat';
var IDTF;

$(document).ready(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
})

$(document).on('click', '.btn-prasyarat', function () {
	IDTF = $(this).data('id');
	let row = $(this).closest('tr').find('td');

	let nama = row[2].innerHTML;

	$('#modal-none').modal('show');
	$('#modal-none .modal-title').html('Prasyarat Matakuliah ' + nama);

	syarat(IDTF);

})

function syarat(id) {
	$('#modal-none .modal-body').html(MODAL_LOADER);
	url = '/master/matakuliah/' + id + '/syarat';
	$.get({
		url: url,
		success: function (data) {
			$('#modal-none .modal-body').html(data);
			$(TABLE).DataTable({
				'autoWidth': false,
				'ordering': false,
				'paging': false
			});
		},
		error: function (data) {
			$('#modal-none .modal-body').html('! Terjadi kesalahan sistem, silakan ulangi beberapa saat lagi.');
		}
	})
}

$(document).on('click', '#btn-add-syarat', function () {
	let id = $(this).data('id');
	$('#modal-none .modal-body').html(MODAL_LOADER);

	$.get({
		url: '/master/matakuliah/' + id + '/syarat/tambah',
		success: function (data) {
			$('#modal-none .modal-body').html(data);
			$('select[name=mksyarat]').select2();
		},
		error: function () {
			$('#modal-none .modal-body').html('! Terjadi kesalahan sistem, silakan ulangi beberapa saat lagi.');
		}
	})
})

$(document).on('click', '#btn-back', function () {
	syarat(IDTF);
})

$(document).on('click', '#btn-simpan-syarat', function () {
	let form = new FormData($('#form-add-syarat')[0]);
	let btn = this;

	$(btn).attr('disabled', '');
	$(btn).html('<span class="fa fa-refresh fa-spin mr-3"></span> meyimpan...')
	$.post({
		url: $('#form-add-syarat').attr('action'),
		data: form,
		contentType: false,
		processData: false,
		success: function (data) {
			syarat(IDTF);
		},
		error: function () {
			swal('ERROR!', 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.', 'error');
		},
		complete: function () {
			$(btn).removeAttr('disabled');
			$(btn).html('<span class="ti-save mr-3"></span> Simpan')
		}
	})
})

$(document).on('click', '.btn-del-syarat', function () {
	let id = $(this).data('id');

	swal({
		title: "PERHATIAN",
		text: "Apakah anda yakin ingin menghapus syarat matakuliah ini?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Ya, hapus!",
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}, function () {
		$.post({
			url: '/master/matakuliah/syarat/delete',
			data: {
				id: id
			},
			success: function (data) {
				if (data.status == true) {
					swal("SUKSES", data.msg, 'success');
					syarat(IDTF);
				} else {
					swal("PERHATIAN", "Response tidak diketahui", 'warning');
				}
			},
			error: function () {
				swal("ERROR!", 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.', 'error');
			}
		});
	});
})