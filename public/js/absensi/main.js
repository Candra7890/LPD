var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span>memproses..';
var TB_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memproses...</p></td></tr>';
var TABLE = '#table';
var DIV_LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p>';
var TABLE_ID = '#table';
var VAR_ID_PENGAMPU = 0;
var VAR_IDMKTAWAR_PENGAMPU = 0;


$(document).ready(function () {
	$('.select2').select2();
	// $(TABLE).DataTable();
	get();
})

$('.btn-switch').click(function () {
	$('#form-filter').toggle();
	$('#form-search').toggle();
})

function get() {
	$(TABLE).DataTable().destroy();
	let btn = '#btn-filter';
	let temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');
	$(TABLE + ' tbody').html(TB_LOADER);

	var form = $('#form-filter').serialize();
	var url = $('#form-filter').attr('action') + '?' + form;

	$.get({
		url: url,
		success: function (data) {
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({
				'autoWidth': false
			});
		},
		error: function (data) {
			data = data.responseJSON;
			let msg = '';
			if (data.status != '' && data.status == false) {
				msg = data.msg;
			} else {
				msg = 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.'
			}

			$(TABLE + ' tbody').html('<tr><td colspan="10"><p class="text-center">' + msg + '</p></td></tr>');
		},
		complete: function () {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
}

$('#btn-filter').click(function () {
	get();
})

$('#btn-search').click(function () {
	$(TABLE).DataTable().destroy();
	let btn = this;
	let temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');
	$(TABLE + ' tbody').html(TB_LOADER);

	var form = $('#form-search').serialize();
	let url = $('#form-search').attr('action') + '?' + form;
	$.get({
		url: url,
		success: function (data) {
			// $(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({
				'autoWidth': false
			});
		},
		error: function (data) {
			$(TABLE + ' tbody').html('');
			$(TABLE).DataTable({
				'autoWidth': false
			});
			data = data.responseJSON;
			let msg = '';
			if (data.status != '' && data.status == false) {
				msg = data.msg;
			} else {
				msg = 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.'
			}

			$(TABLE + ' tbody').html('<tr><td colspan="10"><p class="text-center">' + msg + '</p></td></tr>');
		},
		complete: function () {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
})

function set_pengampu(id, id_mktawar) {
	var kode_mk = $('#table tr').eq(id).find('td').eq(2).html();
	var nama_mk = $('#table tr').eq(id).find('td').eq(3).html();
	var token = $('input[name=_token]').val();

	VAR_ID_PENGAMPU = id;
	VAR_IDMKTAWAR_PENGAMPU = id_mktawar;

	$('#set-pengampu-title').html('Set Pengampu Kelas ' + kode_mk + ' - ' + nama_mk);
	$('#modal-set-pengampu tbody').html(TB_LOADER);

	var url = '/penawaran/set-pengampu/info';
	$.post({
		url: url,
		data: {
			_token: token,
			mktawar_id: id_mktawar
		},
		success: function (data) {
			// alert(data);
			$('#mk-pengampu').html(data);
		}
	})
	$('#pengampu_mktawar_id').val(id_mktawar);
	$('#modal-set-pengampu').modal('show');
}

$('#fakultas_pengampu').change(function () {
	var fakultas = $('#fakultas_pengampu').val();
	var url = '/master/prodi_in/' + fakultas;
	var prodi = '<option value="">--pilih prodi--</option>';
	$.get({
		url: url,
		success: function (data) {
			$.each(data, function (key, val) {
				prodi += '<option value="' + val['prodi_id'] + '">' + val['jenjangprodi']['jenjang'] + ' ' + val['nama_prodi'] + '</option>';
			})
			$('#prodi_pengampu').html(prodi);
			$('#prodi_pengampu').removeAttr('disabled');
		}
	})
})

$('#prodi_pengampu').change(function () {
	var prodi = $('#prodi_pengampu').val();
	var url = '/master/dosen/prodi/' + prodi;
	$('#pengampu').html('<option value="">mohon tunggu</option>');
	var pengampu = '<option value="">--pilih pengampu--</option>';
	$.get({
		url: url,
		success: function (data) {
			// console.log(data);
			$.each(data, function (key, val) {
				pengampu += '<option value="' + val['dosen_id'] + '" data-nip="' + val['nip'] + '" data-nama="' + val['nama'] + '">' + val['nip'] + ' - ' + val['nama'] + '</option>';
			})

			$('#pengampu').html(pengampu);
			$('#pengampu').removeAttr('disabled');
		}
	})
})

$('#btn-add-pengampu').click(function () {
	var fakultas = $('#fakultas_pengampu').val();
	var prodi = $('#prodi_pengampu').val();
	var pengampu = $('#pengampu').val();
	var status = $('#status_pengampu').val();
	var new_pengampu = '';

	if (fakultas == '') {
		swal({
			title: "Warning!",
			text: "Pilih Fakultas terlebih dahulu",
			type: "warning"
		});
	} else if (prodi == '') {
		swal({
			title: "Warning!",
			text: "Pilih Program Studi terlebih dahulu",
			type: "warning"
		});
	} else if (pengampu == '') {
		swal({
			title: "Warning!",
			text: "Pilih Dosen Pengampu terlebih dahulu",
			type: "warning"
		});
	} else {
		var nip_pengampu = $('#pengampu').find(':selected').data('nip');
		var nama_pengampu = $('#pengampu').find(':selected').data('nama');
		new_pengampu = '<tr id="pengampu">' +
			'<input type="hidden" name="status[]" value="' + status + '">' +
			'<input type="hidden" name="new_dosen_id[]" value="0">' +
			'<input type="hidden" name="dosen_id[]" value="' + pengampu + '">' +
			'<td>' + nip_pengampu + '</td>' +
			'<td>' + nama_pengampu + '</td>' +
			'<td>' + status + '</td>' +
			'<td>' +
			'<button class="btn btn-danger btn-sm ml-1" type="button" data-toggle="tooltip" title="Hapus/Reset" onclick="hapus_pengampu("pengampu")"><i class="mdi mdi-delete"></i></button>' +
			'</td>' +
			'</tr>';

		$('#mk-pengampu').append(new_pengampu);
		store_pengampu(this);
	}
})

function hapus_pengampu(id) {
	// alert(id);
	var row = document.getElementById(id);
	row.parentNode.removeChild(row);
	store_pengampu('#btn-add-pengampu');
}

function store_pengampu(btn) {

	var formData = new FormData($('#form-pengampu')[0]);
	var url = $('#form-pengampu').attr('action');

	var temp = $(btn).html();
	$.post({
		url: url,
		data: formData,
		contentType: false,
		processData: false,
		beforeSend: function () {
			$(btn).html('<span class="fa fa-refresh fa-spin"></span> menyimpan...');
			$(btn).attr('disabled', '');
		},
		success: function (data) {
			if (data.status == true) {
				swal('SUKSES!', data.msg, 'success');
				// get_current_selected();
				get()
				return;
			}
			swal('ERROR!', 'No Response', 'error');
		},
		error: function (data) {
			var err = data.responseText;
			data = data.responseJSON;

			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			} else {
				swal('ERROR!', data.message, 'error');
			}
			console.log(data);
		},
		complete: function () {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
			set_pengampu(VAR_ID_PENGAMPU, VAR_IDMKTAWAR_PENGAMPU);
		}
	})
	// console.log(status);
}