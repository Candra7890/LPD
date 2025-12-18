var DATATABLE = $(TABLE).DataTable({
	autoWidth: false
});

var TABLE = '#tb-insentif';

$(document).ready(function() {
	// filter();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
});

$('#btn-filter').click(function() {
	filter();
});

$('#btn-count').click(function() {
	let form = new FormData();

	let btn = this;
	$(btn).html('<i class="fa fa-refresh fa-spin"></i>');
	$(btn).attr('disabled', '');

	form.append('tahun_ajaran', $('select[name=tahun_ajaran]').val());
	form.append('semester', $('select[name=semester]').val());

	$.post({
		url: '/insentif/count',
		data: form,
		contentType: false,
		processData: false,
		success: function(data) {
			filter();
		},
		error: function(data) {
			if (data.status != null && data.status == false) {
				data = data.responseJSON;
				swal('ERROR!', 'Tidak dapat men-generate insentif karena alasan berikut: \n' + data.msg, 'error');
			} else {
				swal('Berhasil!', 'Generate Insentif berhasil.', 'success');
			}
		},
		complete: function() {
			$(btn).html('<i class="mdi mdi-book-plus mr-2"></i> Hitung');
			$(btn).removeAttr('disabled');
		}
	});
});

$('#btn-cetak').click(function() {
	let form = $('#form-filter').serialize();
	let url = '/insentif/cetak?' + form;

	window.open(url);
});

$(document).on('click', '.btn-detail', function(e) {
	e.preventDefault();
	let dosen_id = $(this).data('id');

	let form = new FormData();

	let btn = this;
	$(btn).html('<i class="fa fa-refresh fa-spin"></i>');
	$(btn).attr('disabled', '');

	form.append('tahun_ajaran', $('select[name=tahun_ajaran]').val());
	form.append('semester', $('select[name=semester]').val());
	form.append('dosen_id', dosen_id);

	$('#modal').modal('show');
	showLoader($('#modal .modal-body'));

	$.post({
		url: '/insentif/detail',
		data: form,
		contentType: false,
		processData: false,
		success: function(data) {
			$('#modal .modal-body').html(data);
		},
		error: function(data) {
			error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.';
			$('#modal .modal-body').html(error);
		},
		complete: function() {
			$(btn).html('<i class="fa fa-eye"></i>');
			$(btn).removeAttr('disabled');
		}
	});

	// $.post({
	// 	url: '/set-rubrik/' + LAST_MKTAWARID + '/hadir/' + LAST_RUBRIKID,
	// 	success: function(data) {
	// 		$('#modal .modal-body').html(data);
	// 		$('.select2').select2();
	// 	},
	// 	error: function() {
	// 		error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.';
	// 		$('#modal .modal-body').html(error);
	// 	}
	// });
});

function showLoader(element) {
	let LOADER = '<td colspan="20" style="width:100%"><p class="text-center"><i class="fa fa-refresh fa-spin mr-3"></i> memproses...</p></td>';
	element.html(LOADER);
}

function filter() {
	let form = $('#form-filter').serialize();
	let url = '?' + form;

	showLoader($(TABLE + ' tbody'));

	$.get({
		url: url,
		success: function(data) {
			$(TABLE)
				.DataTable()
				.destroy();

			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({
				autoWidth: false
			});
		}
	});
}
