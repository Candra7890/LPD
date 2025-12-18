var TABLE = '#tb-mhs';
var TABLE_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memproses..</p></td></tr>';
var IDM = 0;
var row;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$('.btn-switch').click(function () {
	$('#form-filter').toggle();
	$('#form-search').toggle();
})

$("#btn-global").on('click', function() {
	let prodi_id = $("#prodi_f").val()
	$.ajax({
        method: "POST",
        url: '/status-mhs/global/detail',
        data: {
            prodi_id: prodi_id
        },
        success: function(data){

			Swal.fire({
				title: "Nonaktifkan Seluruh Mahasiswa " + $("#prodi_f option:selected" ).text() + "?",
                text: "Terdapat "+data+" Mahasiswa dengan status Aktif",
				showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Nonaktifkan!",
                closeOnConfirm: true,
				showLoaderOnConfirm: true,
				preConfirm: (login) => {
					return new Promise(function (resolve) {
						$.ajax({
						  type: "POST",
						  data: { prodi_id: prodi_id },
						  url: "/status-mhs/global/nonaktif",
						})
						.done(function (res) {
							Swal.fire(
							  "Berhasil!",
							  data+" Mahasiswa berhasil dinonaktifkan",
							  "success"
							);
						})
						.fail(function (erordata) {
							console.log(erordata);
							Swal.fire('Gagal!', 'Mahasiswa gagal dinonaktifkan', 'error');
						})
				  
					})
				},
				allowOutsideClick: () => !Swal.isLoading()
			})
        }
    });
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
})

function initTooltip() {
	$('.tooltip').tooltip();
}

$(document).on('click', '.btn-edit', function () {
	let idM = $(this).data('id');
	IDM = $(this).data('mhs');
	row = $(this).closest('tr').find('td');

	$('#modal').modal('show')
	$('#modal .modal-title').html("Edit Status aktif")
	$('#form-status select[name=statusaktif]').val(idM);
})

$(document).on('click', '#btn-save', function () {
	let btn = this;

	$(this).html('<span class="fa fa-refresh fa-spin"></span> menyimpan...');
	$(this).attr('disabled', '')
	let form = new FormData($('#form-status')[0])
	form.append('mahasiswa_id', IDM);
	$.post({
		url: $('#form-status').attr('action'),
		data: form,
		contentType: false,
		processData: false,
		success: function (data) {
			if (data.status == true) {
				$('#modal').modal('toggle');
				Swal.fire("SUKSES!", data.msg, 'success');
				row[6].innerHTML = $('#form-status select[name=statusaktif] option:selected').text()
			}
		},
		error: function () {
			Swal.fire("ERROR", 'Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.', 'error');
		},
		complete: function () {
			$(btn).html('<span class="ti-save"></span> Simpan');
			$(btn).removeAttr('disabled')
		}
	})
})

$(document).keypress(function (e) {
	if (e.which == 13) {
		e.preventDefault()
	}
});