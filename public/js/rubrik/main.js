var TABLE = '#tb-penawaran';
var LAST_MKTAWARID = 0;
var LAST_RUBRIKID = 0;

var DATATABLE = $(TABLE).DataTable({
	autoWidth: false
});

$(document).ready(function() {
	filter();
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
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

$('#btn-filter').click(function() {
	filter();
});

function openRubrik() {
	showLoader($('#modal .modal-body'));
	$.get({
		url: '/set-rubrik/' + LAST_MKTAWARID,
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
			jQuery('#datepicker-autoclose').datepicker({
				autoclose: true
			});
		},
		error: function() {
			error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.';
			$('#modal .modal-body').html(error);
		}
	});
}

$(document).on('click', '.btn-set', function() {
	let id = $(this).data('id');
	LAST_MKTAWARID = id;

	let btn = $(this);
	let row = btn.closest('tr').find('td');

	let kode = row[2].innerHTML;
	let nama = row[3].innerHTML;

	$('#modal .modal-title').html(kode + ' ' + nama);
	$('#modal').modal('show');

	openRubrik();
});

$(document).on('click', '#btn-store-new-rubrik', function() {
	var form = new FormData($('#form-new-rubrik')[0]);

	$('#btn-store-new-rubrik i').attr('class', 'fa fa-refresh fa-spin');
	$('#btn-store-new-rubrik').attr('disabled', '');

	form.append('_token', $('input[name=_token]').val());
	form.append('mktawar', $('input[name=mktawar]').val());
	form.append('pengampu', $('select[name=pengampu]').val());
	form.append('mulai', $('input[name=mulai]').val());
	form.append('berakhir', $('input[name=berakhir]').val());
	form.append('materi', $('textarea[name=materi]').val());
	form.append('tanggal', $('input[name=tanggal]').val());
	form.append('ke', $('input[name=ke]').val());
	$.post({
		url: $('#form-new-rubrik').attr('action'),
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
			$('#btn-store-new-rubrik i').attr('class', 'ti-arrow-right');
			$('#btn-store-new-rubrik').removeAttr('disabled');
		}
	});
});

$(document).on('click', '.btn-edit', function(e) {
	e.preventDefault();

	let btn = this;

	let row = $(btn)
		.closest('tr')
		.find('td');

	console.log(row);

	let ke = row[0].innerHTML;
	let jamMulai = row[2].innerHTML;
	let jamBerakhir = row[3].innerHTML;
	let materiPertemuan = row[4].innerHTML;
	let id = $(btn).data('id');
	let dosenId = $(btn).data('peng');
	let tanggal = $(btn).data('date');

	let pengampuList = $('select[name=pengampu]').html();
	let selectPengampu = '<select class="select2 form-control custom-select" style="width: 100%" name="pengampu_edit" data-id="' + id + '" required="">' + pengampuList + '</select>';
	let inputJamMulai =
		'<div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true">' +
		'<input data-id="' +
		id +
		'" type="text" class="form-control" name="mulai_edit" placeholder="jj:mm" value="' +
		jamMulai +
		'">' +
		'</div>';

	let inputJamBerakhir =
		'<div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true">' +
		'<input data-id="' +
		id +
		'" type="text" class="form-control" name="berakhir_edit" placeholder="jj:mm" value="' +
		jamBerakhir +
		'">' +
		'</div>';

	let textareaMateriPertemuan = '<textarea data-id="' + id + '" name="materi_edit" id="" cols="30" rows="2" class="form-control">' + materiPertemuan + '</textarea>';
	let inputTanggal = '<div class="input-group">' + '<input data-id="' + id + '" type="text" name="tanggal_edit" class="form-control" id="datepicker-autoclose-edit" placeholder="hh/bb/tttt" value="' + tanggal + '">' + '</div>';

	let button =
		'<button type="button" title="Simpan Perubahan" class="mr-1 mb-1 btn btn-sm btn-info btn-store-edit" data-id="' +
		id +
		'"><i class="ti-arrow-right"></i></button>' +
		'<button type="button" title="Batal" class="btn btn-sm btn-danger btn-cancel-edit" data-id="' +
		id +
		'"><i class="ti-close"></i></button>';

	let keInput = '<input type="number" name="ke_edit" value="' + ke + '" class="form-control">';

	row[0].innerHTML = keInput;
	row[1].innerHTML = selectPengampu;
	row[2].innerHTML = inputJamMulai;
	row[3].innerHTML = inputJamBerakhir;
	row[4].innerHTML = textareaMateriPertemuan;
	row[5].innerHTML = inputTanggal;
	row[7].innerHTML = button;

	$('select[name=pengampu_edit][data-id=' + id + ']').val(dosenId);

	$('.clockpicker')
		.clockpicker({
			donetext: 'Done'
		})
		.find('input')
		.change(function() {
			console.log(this.value);
		});
	jQuery('#datepicker-autoclose-edit').datepicker({
		autoclose: true
	});
});

$(document).on('click', '.btn-cancel-edit', function() {
	openRubrik();
});

$(document).on('click', '.btn-store-edit', function() {
	let btn = this;
	$(btn).html('<i class="fa fa-refresh fa-spin"></i>');
	$(btn).attr('disabled', '');

	let form = new FormData();
	let id = $(this).data('id');

	form.append('id', id);
	form.append('_token', $('input[name=_token]').val());
	form.append('ke', $('input[name=ke_edit]').val());
	form.append('mktawar', $('input[name=mktawar]').val());
	form.append('pengampu', $('select[name=pengampu_edit][data-id=' + id + ']').val());
	form.append('mulai', $('input[name=mulai_edit][data-id=' + id + ']').val());
	form.append('berakhir', $('input[name=berakhir_edit][data-id=' + id + ']').val());
	form.append('materi', $('textarea[name=materi_edit][data-id=' + id + ']').val());
	form.append('tanggal', $('input[name=tanggal_edit][data-id=' + id + ']').val());

	$.post({
		url: '/set-rubrik/update',
		data: form,
		contentType: false,
		processData: false,
		success: function(data) {
			openRubrik();
		},
		error: function(data) {
			if (data.status != null && data.status == false) {
				data = data.responseJSON;
				swal('ERROR!', 'Tidak dapat memasukkan rubrik karena alasan berikut: \n' + data.msg, 'error');
			} else {
				swal('ERROR!', 'Tidak dapat mengedit rubrik saat ini. Silakan ulangi beberapa saat lagi.', 'error');
			}
		},
		complete: function() {
			$(btn).html('<i class="ti-arrow-right"></i>');
			$(btn).removeAttr('disabled');
		}
	});
});

$(document).on('click', '.btn-mhs-absen', function(e) {
	e.preventDefault();
	LAST_RUBRIKID = $(this).data('id');
	openRubrikAbsen();
});

function openRubrikAbsen() {
	showLoader($('#modal .modal-body'));

	$.get({
		url: '/set-rubrik/' + LAST_MKTAWARID + '/absensi/' + LAST_RUBRIKID,
		success: function(data) {
			$('#modal .modal-body').html(data);
			$('.select2').select2();
		},
		error: function() {
			error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.';
			$('#modal .modal-body').html(error);
		}
	});
}

$(document).on('click', '.btn-mhs-hadir', function(e) {
	e.preventDefault();
	LAST_RUBRIKID = $(this).data('id');
	openRubrikHadir();
});
function openRubrikHadir() {
	showLoader($('#modal .modal-body'));

	$.get({
		url: '/set-rubrik/' + LAST_MKTAWARID + '/hadir/' + LAST_RUBRIKID,
		success: function(data) {
			$('#modal .modal-body').html(data);
			$('.select2').select2();
		},
		error: function() {
			error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.';
			$('#modal .modal-body').html(error);
		}
	});
}

$(document).on('click', '#btn-back-torubrik', function() {
	openRubrik();
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
			rid: LAST_RUBRIKID,
			mid: mhs,
			ket: ket
		},
		success: function(data) {
			if (data.success) {
				openRubrikAbsen();
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

$(document).on('click', '#btn-new-hadir', function() {
	let mhs = $('#hadir-mhs').val();

	let loader = '<i class="fa fa-refresh fa-spin"></i>';
	let btn = $(this);
	btn.html(loader);
	btn.attr('disabled', '');
	$.post({
		url: '/set-rubrik/set-hadir',
		data: {
			rid: LAST_RUBRIKID,
			mid: mhs
		},
		success: function(data) {
			if (data.success) {
				openRubrikHadir()();
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
						openRubrikAbsen();
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

$(document).on('click', '.btn-delete', function() {
	let btn = $(this);
	swal(
		{
			title: 'PERHATIAN!',
			text: 'Apakah anda yakin ingin menghapus rubrik ini?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Hapus',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.post({
				url: '/set-rubrik',
				data: {
					_method: 'DELETE',
					rid: btn.data('id')
				},
				success: function(data) {
					if (data.success) {
						swal('SUKSES!', data.msg, 'success');
						openRubrik();
					} else if (!data.success && data.need_action == '1') {
						swal(
							{
								title: 'PERHATIAN!',
								text: data.msg,
								type: 'warning',
								showCancelButton: true,
								confirmButtonColor: '#DD6B55',
								confirmButtonText: 'Ya, Hapus',
								closeOnConfirm: false,
								showLoaderOnConfirm: true
							},
							function() {
								$.post({
									url: '/set-rubrik',
									data: {
										_method: 'DELETE',
										rid: btn.data('id'),
										force: 1
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

// bukti mengajar

$(document).on('click', '.btn-bukti-mengajar', function(e) {
	e.preventDefault();
	LAST_RUBRIKID = $(this).data('id');
	openBuktiMengajar();
});

function openBuktiMengajar() {
	showLoader($('#modal .modal-body'));

	$.get({
		url: '/set-rubrik/bukti-mengajar/' + LAST_RUBRIKID,
		success: function(data) {
			$('#modal .modal-body').html(data);

			$('.dropify').dropify();
		},
		error: function() {
			error = 'Tidak dapat membuka rubrik. Silakan ulangi beberapa saat nanti.';
			$('#modal .modal-body').html(error);
		}
	});
}

$(document).on('click', '#btn-upload', function(e) {
	let form = new FormData($('#form-bukti')[0]);
	form.append('rubrik_id', LAST_RUBRIKID);

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

$(document).on('click', '.btn-ubah-tipe', function() {
	let id = $(this).data('id');

	swal(
		{
			title: 'PERHATIAN!',
			text: 'Anda akan mengubah tipe absensi rubrik, lanjutkan?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.get({
				url: '/set-rubrik/ubah-tipe/' + id,
				success: function(data) {
					if (data.success) {
						swal('SUKSES!', 'Tipe absensi sekarang: ' + data.msg, 'success');
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

$(document).on('click', '.btn-set-absensi', function() {
	let id = $(this).data('id');

	swal(
		{
			title: 'PERHATIAN!',
			text: 'Data Kehadiran Mahasiswa pada Rubrik ini akan digunakan sebagai basis kehadiran mahasiswa pada rubrik dosen lainnya pada pertemuan yang sama, lanjutkan?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.get({
				url: '/set-rubrik/set-basis-kehadiran/' + id,
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
