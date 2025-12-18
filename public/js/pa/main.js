var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span>sedang memproses..'
var TB_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';
var TABLE = '#tb-mhs';
let LAST_PRODI_ID = 0;

var row;

$(document).ready(function () {
	$(TABLE).DataTable();
	$('select[name=prodi]').select2()

	getDosen()
})

function show() {
	var form = new FormData($('#form-pa')[0]);
	var link = $('#form-pa').attr('action');
	var btn = '#btn-tampilkan';
	var temp;
	$.post({
		url: link,
		data: form,
		contentType: false,
		processData: false,
		beforeSend: function () {
			temp = $(btn).html();
			$(btn).html(BTN_LOADER);
			$(btn).attr('disabled', '');
			$(TABLE + ' tbody').html(TB_LOADER);
		},
		success: function (data) {
			$(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({
				"autoWidth": false
			});
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
}

$('#btn-tampilkan').click(function () {
	show();
})

$(document).on('click', '.btn-set', function () {
	var m = $(this).data('mid');
	var p = $(this).data('pid');
	let pr = $(this).data('ppid');

	row = $(this).closest('tr').find('td');
	var nim = row[1].innerHTML;
	var nama = row[2].innerHTML;

	$('#form-set-pa select[name=prodi]').prop('selectedIndex', 0);
	$('#form-set-pa select[name=prodi] option[value=' + pr + ']').prop('selected', true);
	$('#form-set-pa select[name=prodi]').select2();

	$('#form-set-pa input[name=nim]').val(nim);
	$('#form-set-pa input[name=nama]').val(nama);
	$('#form-set-pa input[name=mahasiswa_id]').val(m);

	$('#form-set-pa select[name=dosen]').prop('selectedIndex', 0);
	$('#form-set-pa select[name=dosen] option[value=' + p + ']').prop('selected', true);
	$('#form-set-pa select[name=dosen]').select2();

	$('#modal-set-pa').modal('show');
	LAST_PRODI_ID = pr;
})

function getDosen(prodi = 0) {
	var url = '/api/prodi/' + prodi + '/dosen';
	var option;
	$.get({
		url: url,
		beforeSend: function () {
			option += '<option>mohon tunggu..</option>';
			$('#form-set-pa select[name=dosen]').html(option);
		},
		success: function (data) {
			if (data.status == true) {
				option = '<option><< pilih dosen >></option>';
				$.each(data.msg, function (i, val) {
					option += '<option value="' + val.dosen_id + '">' + val.nip + ' - ' + val.nama + '</option>';
				})
				$('#form-set-pa select[name=dosen]').html(option);
			} else {
				$('#form-set-pa select[name=dosen]').html('<option>error saat mengambil data dosen.</option>');
			}
		},
		error: function () {
			$('#form-set-pa select[name=dosen]').html('<option>error saat mengambil data dosen.</option>');
		}
	})
}

// $('select[name=prodi]').change(function () {
// 	getDosen();
// })

$('#btn-simpan-pa').click(function () {
	var form = new FormData($('#form-set-pa')[0]);
	var link = $("#form-set-pa").attr('action');

	var btn = this;
	var temp;
	$.post({
		url: link,
		data: form,
		contentType: false,
		processData: false,
		beforeSend: function () {
			temp = $(btn).html();
			$(btn).html('sedang memproses...');
			$(btn).attr('disabled', '');
		},
		success: function (data) {
			if (data.status == true) {
				row[3].innerHTML = data.nip;
				row[4].innerHTML = data.nama;

				$('#modal-set-pa').modal('toggle');
				swal('SUKSES!', data.msg, 'success');
			} else {
				swal('ERROR!', 'Response sistem tidak diketahui.', 'error');
			}
		},
		error: function (data) {
			data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			} else {
				swal('ERROR!', 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.', 'error');
			}
		},
		complete: function () {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
})