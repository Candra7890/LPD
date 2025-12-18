// bukti mengajar
$(document).on('click', '.btn-bukti-mengajar', function(e) {
	e.preventDefault();
	RUBRIK_ID = $(this).data('id');

	$('#modal .modal-title').html('Bukti Mengajar');
	$('#modal').modal('show');

	openBuktiMengajar();
});

function openBuktiMengajar() {
	showLoader($('#modal .modal-body'));

	$.get({
		url: '/set-rubrik/bukti-mengajar/' + RUBRIK_ID,
		success: function(data) {
			$('#modal .modal-body').html(data);

			$('.dropify').dropify({
				messages: {
					default: 'Silahkan Klik Area Ini untuk Meng-upload Bukti Mengajar'
				}
			});
		},
		error: function() {
			error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.';
			$('#modal .modal-body').html(error);
		}
	});
}

$(document).on('click', '#btn-upload', function(e) {
	let form = new FormData($('#form-bukti')[0]);
	form.append('rubrik_id', RUBRIK_ID);

	$.post({
		url: '/set-rubrik/bukti-mengajar',
		data: form,
		contentType: false,
		processData: false,
		success: function(data) {
			openBuktiMengajar();
		},
		error: function() {
			let error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.';
			$('#modal .modal-body').html(error);
		}
	});
});

$(document).on('click', '#btn-back-torubrik', function() {
	$('#modal').modal('hide');
});
