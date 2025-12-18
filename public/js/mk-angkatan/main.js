var TABLE = '#tb-mk';
var TABLE_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memproses..</p></td></tr>';
var MODAL_LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memproses..</p>';
let MODAL = $("#modal");
let MODAL_TITLE = $('#modal .modal-title')
let MODAL_BODY = $('#modal .modal-body')
let matakuliahList = null
let filteredMatakuliah = null
let searchMode = false;

function getAngkatan() {
	if (searchMode) return $('#form-search select[name=angkatan]').val()
	else return $('#form-filter select[name=angkatan]').val()
}

function refreshTable() {
	if (searchMode) {
		$('#btn-search').click()
	} else $('#btn-filter').click()
}

$(document).ready(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('.select2').select2()
	$(TABLE).DataTable({
		'autoWitdh': false,
		'ordering': false
	});
	$('#btn-filter').click();
})

$(document).on('click', '.btn-switch', function () {
	$('#form-filter').toggle();
	$('#form-search').toggle();
	searchMode = !searchMode;
})

$('#btn-filter').click(function () {
	let form = $('#form-filter');
	let url = form.attr('action');
	param = form.serialize();

	url = url + "?" + param;

	btn = this;
	$(btn).attr('disabled', '');
	$(TABLE + ' tbody').html(TABLE_LOADER);
	$.get({
		url: url,
		success: function (data) {
			$(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({
				'autoWitdh': false,
				'ordering': false
			})
			// initTooltip();
		},
		error: function () {
			$(TABLE + ' tbody').html('<tr><td colspan="10"><p class="text-center text-danger">Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.</p></td></tr>');
		},
		complete: function () {
			$(btn).removeAttr('disabled');
		}
	})

	loadKurikulum(getAngkatan());
})

$('#btn-search').click(function () {
	let form = $('#form-search');
	let url = form.attr('action');
	param = form.serialize();

	url = url + "?" + param;

	btn = this;
	$(btn).attr('disabled', '');
	$(TABLE + ' tbody').html(TABLE_LOADER);
	$.get({
		url: url,
		success: function (data) {
			$(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({
				'autoWitdh': false,
				'ordering': false
			})
			// initTooltip();
		},
		error: function () {
			$(TABLE + ' tbody').html('<tr><td colspan="10"><p class="text-center text-danger">Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.</p></td></tr>');
		},
		complete: function () {
			$(btn).removeAttr('disabled');
		}
	})

	loadKurikulum(getAngkatan())
})

$(document).on('click', '.btn-syarat', function (e) {
	e.preventDefault()
	ID = $(this).data('id');
	let row = $(this).closest('tr').find('td');

	let nama = row[3].innerHTML;

	$('#modal').modal('show');
	$('#modal .modal-title').html('Prasyarat Matakuliah ' + nama);

	syarat(ID);

})

function syarat(id) {
	$('#modal .modal-body').html(MODAL_LOADER);
	url = "/mk-angkatan/" + id;
	$.get({
		url: url,
		success: function (data) {
			$('#modal .modal-body').html(data);
			$('#tb-syarat').DataTable({
				'autoWidth': false,
				'ordering': false,
				'paging': false
			});
		},
		error: function (data) {
			$('#modal .modal-body').html('! Terjadi kesalahan sistem, silakan ulangi beberapa saat lagi.');
		}
	})
}

$(document).on('click', '#btn-cp-syarat', function () {
	let id = $(this).data('id');

	swal({
		title: "PERHATIAN",
		text: "Apakah anda yakin ingin menyalin matakuliah syarat dari induk matakuliah ini?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Ya, salin!",
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}, function () {
		$.post({
			url: '/mk-angkatan/' + id,
			data: {
				service: 'copy'
			},
			success: function (data) {
				if (data.status == true) {
					swal.close();
					syarat(ID);
				} else if (data.status == false) {
					swal("ERROR!", data.msg, 'error');
				} else {
					swal("ERROR!", 'Response tidak diketahui', 'error');
				}
			},
			error: function () {
				swal("ERROR!", 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.', 'error');
			}
		})
	});

})

$(document).on('click', '#btn-add-syarat', function () {
	let id = $(this).data('id');
	$('#modal .modal-body').html(MODAL_LOADER);

	$.get({
		url: '/mk-angkatan/' + id + '/tambah',
		success: function (data) {
			$('#modal .modal-body').html(data);
			$('select[name=mksyarat]').select2();
		},
		error: function () {
			$('#modal .modal-body').html('! Terjadi kesalahan sistem, silakan ulangi beberapa saat lagi.');
		}
	})
})

$(document).on('click', '#btn-back', function () {
	syarat(ID);
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
			syarat(ID);
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
			url: '/mk-angkatan/syarat/delete',
			data: {
				id: id
			},
			success: function (data) {
				if (data.status == true) {
					swal.close();
					syarat(ID);
				} else if (data.status == false) {
					swal("ERROR!", data.msg, 'error');
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

function loadKurikulum(angkatan) {
	let ul = $('#kurikulum-list');
	$.get({
		url: '/mk-angkatan/tahun/' + angkatan,
		success: function (data) {
			let list = '';
			$.each(data, function (i, val) {
				list += '<li>' + val.nama_kurikulum + ' (' + val.tahun + ')</li>'
			});
			ul.html(list)
		},
		error: function (data) {
			ul.html('<li class="text-danger">Error mengambil kurikulum</li>');
		},
		beforeSend: function () {
			ul.html('<li><span class="fa fa-spin fa-spinner"></span></li>');
		}
	})
}

function loadKurikulumTersedia(angkatan) {
	let url = '/master/kurikulum/prodi/111';

	$.get({
		url: url,
		success: function (data) {

			let title = 'Pilih Kurikulum'
			let options = '<option value=""><< pilih kurikulum >></option>';

			$.each(data, function (i, val) {
				options += '<option value="' + val.kurikulum_id + '">' + val.nama_kurikulum + ' (' + val.tahun + ')</option>'
			})

			let html = '<label>' + title + '</label>' +
				'<select class="select2 form-control custom-select" style="width: 100%" name="kurikulum">' +
				options +
				'</select>';

			let filter = '<div class="row col-md-6 sol-sm-12 m-t-40 mb-1">Cari: <input type="text" class="form-control" placeholder="nama atau kode" id="search-mk"></div>';

			let table = '<div id="tb-kur" class="table-responsive" style="max-height: 400px; overflow-y:scroll;">' +
				'<table id="tb-matakuliah-list" class="table table-bordered table-hover">' +
				'<tbody>' +
				'<tr>' +
				'<td>Matakuliah akan muncul disini jika anda telah memilih kurikulum</td>' +
				'</tr>' +
				'</tbody>' +
				'</table>' +
				'</div>';

			MODAL_BODY.html(html + filter + table)
			$('.select2').select2()
		},
		error: function (data) {
			console.log(data)
		},
		beforeSend: function () {
			openModal('daftar kurikulum')
		}
	})
}

$(document).on('click', '#btn-tambah-kurikulum', function () {
	loadKurikulumTersedia();
})

function loadMatakuliah(kurikulumId) {
	let url = '/master/kurikulum/idx/' + kurikulumId + '/matakuliah';
	$.get({
		url: url,
		success: function (data) {
			let list = '';
			matakuliahList = data.data
			filteredMatakuliah = data.data
			filterMatakuliahKurikulum()
		},
		error: function (data) {
			console.log(data)
		}
	})
}

function openModal(title) {
	MODAL_TITLE.html(title)
	MODAL_BODY.html(MODAL_LOADER)
	MODAL.modal('show')
}

$(document).on('change', 'select[name=kurikulum]', function () {
	$('#tb-matakuliah-list tbody').html(TABLE_LOADER)
	loadMatakuliah($(this).val());
})

function filterMatakuliahKurikulum(input = null) {

	if (matakuliahList) {
		matakuliahList = Array.from(matakuliahList);
		let filtered = []
		if (input) {
			filtered = matakuliahList.filter((val, i, arr) => {
				return val.nama_matakuliah.toLowerCase().includes(input) ||
					val.kode_matakuliah.toLowerCase().includes(input)
			})
		} else filtered = matakuliahList

		let list = ''
		$.each(filtered, function (i, val) {
			let pengampu = (val.pengampu) ? val.pengampu.nama_tercetak : ''
			list += '<tr style="cursor:pointer" data-id="' + val.matakuliah_id + '">' +
				'<td>' +
				'<div>' +
				'<h4>' + val.kode_matakuliah + ' - ' + val.nama_matakuliah + '</h4>' +
				'<small><span class="font-bold">PENGAMPU</span><span class="ml-1">' + pengampu + '</span></small><br>' +
				'<small class="text-uppercase">' +
				'<span class="font-bold">SKS</span><span class="ml-1 mr-2">' + val.sks + '</span>' +
				'<span class="font-bold">semester</span><span class="ml-1 mr-2">' + val.semester + '</span>' +
				'<span class="font-bold">prasyarat sks</span><span class="ml-1 mr-2">' + val.prasyarat_sks + '</span>' +
				'</small>' +
				'</div>' +
				'</td>' +
				'</tr>';
		})

		if (filtered.length > 0) {
			$('#tb-matakuliah-list tbody').html(list)
		} else $('#tb-matakuliah-list tbody').html('<tr><td colspan="10"><p class="text-center">matakuliah tidak tersedia</p></td></tr>')

	} else {
		$('#tb-matakuliah-list tbody').html('<tr><td colspan="10"><p class="text-center">matakuliah tidak tersedia</p></td></tr>')
	}
}

$(document).on('keyup', '#search-mk', function () {
	filterMatakuliahKurikulum($(this).val())
})

$(document).on('click', '#tb-matakuliah-list tr', function () {
	let id = $(this).data('id')
	let angkatan = getAngkatan()
	let url = '/mk-angkatan/tambah/baru'

	$.post({
		url: url,
		data: {
			id: id,
			angkatan: angkatan
		},
		success: function (data) {
			if (data.success) {
				swal("Sukses!", data.msg, "success")
				refreshTable()
			} else if (!data.success) {
				swal("Error!", data.msg, "error")
			} else {
				swal("Peringatan!", 'Respon tidak diketahui', "warning")
			}

			filterMatakuliahKurikulum($('#search-mk').val())
		},
		error: function (data) {
			swal("Error!", "Server error", "error")
		},
		beforeSend: function () {
			$('#tb-matakuliah-list tbody').html(TABLE_LOADER)
		}
	})
})

$(document).on('click', '.btn-delete-mk', function (e) {
	e.preventDefault()
	let id = $(this).data('id')
	swal({
		title: "PERHATIAN",
		text: "Apakah anda yakin ingin menghapus matakuliah angkatan ini?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Ya, hapus!",
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	}, function () {
		$.post({
			url: '/mk-angkatan/delete',
			data: {
				id: id
			},
			success: function (data) {
				if (data.success == true) {
					swal.close();
					refreshTable()
				} else if (data.success == false) {
					swal("ERROR!", data.msg, 'error');
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