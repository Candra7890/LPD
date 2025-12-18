let MKTAWAR_ID = null;
let RUBRIK_ID = null;

$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
});

$(document).on('click', '.btn-absen', function() {
	MKTAWAR_ID = $(this).data('id');
	$('#modal .modal-title').html('Absensi Mengajar');
	$('#modal').modal('show');

	openRubrik();
});

function showLoader(element) {
	let LOADER = '<td colspan="20" style="width:100%"><p class="text-center"><i class="fa fa-refresh fa-spin mr-3"></i> memproses...</p></td>';
	element.html(LOADER);
}

function openRubrik() {
	showLoader($('#modal .modal-body'));
	$.get({
		url: '/absensi-mengajar/' + MKTAWAR_ID,
		success: function(data) {
			$('#modal .modal-body').html(data);
			$('.clockpicker')
				.clockpicker({
					donetext: 'Done'
				})
				.find('input')
				.change(function() {
					console.log(this.value);
				});

			openDaftarHadir();
			openDaftarAbsen();
		},
		error: function() {
			error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.';
			$('#modal .modal-body').html(error);
		}
	});
}

function openDaftarHadir() {
	let table = '#table-riwayat';
	RUBRIK_ID = $('#rubrik_id').val(); //get last rubrik_id

	showLoader($(table + ' tbody'));

	if (RUBRIK_ID) {
		$.get({
			url: '/absensi-mengajar/kehadiran/' + RUBRIK_ID,
			success: function(data) {
				$(table)
					.DataTable()
					.destroy();
				$(table + ' tbody').html(data);
				$(table).DataTable({
					autoWidth: false
				});
			}
		});
	}
}

function openDaftarAbsen() {
	RUBRIK_ID = $('#rubrik_id').val(); //get last rubrik_id
	$.get({
		url: '/absensi-mengajar/' + MKTAWAR_ID + '/absensi/' + RUBRIK_ID,
		success: function(data) {
			$('#daftar-absen').html(data);
			$('.select2').select2();
		},
		error: function() {
			error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.';
			$('#daftar-absen').html(error);
		}
	});
}

// click button
$(document).on('click', '#btn-absensi', function(e) {
	$('.nav-tabs a[href="#absen"]').tab('show');
});

$(document).on('click', '#btn-simgenAbsen', function() {
	var form = new FormData($('#form-mengajar')[0]);
	form.append('mktawar_id', MKTAWAR_ID);

	$('#btn-simgenAbsen').text('Memproses...');
	$('#btn-simgenAbsen').append('<i class="fa fa-refresh fa-spin"></i>');
	$('#btn-simgenAbsen').attr('disabled', '');

	// form.append("_token", $("input[name=_token]").val())
	// form.append('materi_pertemuan', $('textarea[name=materi]').val())
	// form.append('jam_mulai', $("input[name=mulai]").val())
	// form.append('jam_berakhir', $('input[name=berakhir]').val())
	// form.append('batas_absensi', $('input[name=batas_absensi]').val())
	// form.append('rubrik_id', $("input[name=rubrik_id]").val())

	$.post({
		url: $('#form-mengajar').attr('action'),
		contentType: false,
		processData: false,
		data: form,
		success: function(data) {
			console.log(data);
			openRubrik();
		},
		error: function(data) {
			data = data.responseJSON;
			swal('ERROR!', 'Tidak dapat memasukkan rubrik karena alasan berikut: \n' + data.msg, 'error');
		},
		complete: function() {
			$('#btn-simgenAbsen').text('Generate & Simpan Absensi');
			$('#btn-simgenAbsen').empty();
			$('#btn-simgenAbsen').removeAttr('disabled');
		}
	});
});

$(document).on('click', '#btn-perpanjang', function() {
	let btn = $(this);
	swal(
		{
			title: 'PERHATIAN!',
			text: 'Apakah anda yakin ingin memperpanjang Waktu Absensi?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Perpanjang',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.post({
				url: '/absensi-mengajar/perpanjang/' + btn.data('id'),
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					rid: btn.data('id')
				},
				success: function(data) {
					if (data.success) {
						swal('SUKSES!', data.msg, 'success');
						openRubrik();
					} else {
						swal('ERROR!', 'Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.', 'error');
					}
				},
				error: function() {
					swal('ERROR!', 'Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.', 'error');
				}
			});
		}
	);
});

$(document).on('click', '#btn-new-absensi', function() {
	let mhs = $('#absensi-mhs').val();
	let ket = $('input[name=ket]:checked').val();

	let loader = '<i class="fa fa-refresh fa-spin"></i>';
	let btn = $(this);
	btn.html(loader);
	btn.attr('disabled', '');
	$.post({
		url: '/set-rubrik/set-absensi',
		data: {
			rid: RUBRIK_ID,
			mid: mhs,
			ket: ket
		},
		success: function(data) {
			if (data.success) {
				openDaftarAbsen();
			} else if (!data.success) {
				swal('ERROR!', data.msg, 'error');
			} else {
				swal('ERROR!', 'Tidak dapat mengabsen mahasiswa', 'error');
			}
		},
		error: function() {
			swal('ERROR!', 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.', 'error');
		},
		complete: function() {
			btn.html('<i class="ti-plus"></i>');
			btn.removeAttr('disabled');
		}
	});
});

$(document).on('click', '.btn-del-absensi', function() {
	let btn = $(this);
	swal(
		{
			title: 'PERHATIAN!',
			text: 'Apakah anda yakin ingin menghapus mahasiswa ini?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Hapus',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.post({
				url: '/set-rubrik/del-absensi',
				data: {
					raid: btn.data('id')
				},
				success: function(data) {
					if (data.success) {
						swal('SUKSES!', data.msg, 'success');
						openDaftarAbsen();
					} else if (!data.success) {
						swal('ERROR!', data.msg, 'error');
					} else {
						swal('ERROR!', 'Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.', 'error');
					}
				},
				error: function() {
					swal('ERROR!', 'Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.', 'error');
				}
			});
		}
	);
});

// // bukti mengajar
// $(document).on('click', '.btn-bukti-mengajar', function (e) {
//     e.preventDefault()
//     RUBRIK_ID = $(this).data('id');

//     $('#modal .modal-title').html('Bukti Mengajar')
//     $('#modal').modal('show')

//     openBuktiMengajar()
// })

// function openBuktiMengajar() {
//     showLoader($('#modal .modal-body'))

//     $.get({
//         url: '/set-rubrik/bukti-mengajar/' + RUBRIK_ID,
//         success: function (data) {
//             $('#modal .modal-body').html(data)

//             $('.dropify').dropify();
//         },
//         error: function () {
//             error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.'
//             $('#modal .modal-body').html(error)
//         }
//     })
// }

// $(document).on('click', '#btn-upload', function(e) {
//     let form = new FormData($("#form-bukti")[0])
//     form.append('rubrik_id', RUBRIK_ID)

//     $.post({
//         url: "/set-rubrik/bukti-mengajar",
//         data: form,
//         contentType: false,
//         processData: false,
//         success: function (data) {
//             openBuktiMengajar()
//         },
//         error: function () {
//             let error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.'
//             $('#modal .modal-body').html(error)
//         }
//     })
// })

// $(document).on('click', '#btn-back-torubrik', function () {
//     $('#modal').modal('hide')
// })
