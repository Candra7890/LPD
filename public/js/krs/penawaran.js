var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span> sedang memproses...';
var TB_LOADER = '<tr><td colspan="8"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';
var DIV_LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p>';
var TABLE_ID = '#table';
var VAR_ID_PENGAMPU = 0;
var VAR_IDMKTAWAR_PENGAMPU = 0;
var ID_MKTAWAR_KELAS = 0;
var arrHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
var gedung_option = '';
var KEY_CHECKBOX = 0;

$(document).ready(function() {
	$('#table').DataTable();
	$('#modal-set-kelas .modal-body table').DataTable({
		paging: false
	});
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
});

$('#btn-tampilkan').click(function() {
	get_current_selected();
	// alert('tervalidasi');
});

function get_current_selected() {
	var btn = '#btn-tampilkan';

	var prodi = $('#prodi_id').val();
	var program = $('#program_id').val();
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var is_mbkm = $('#is_mbkm').val();
	var is_cross_study = $('#is_cross_study').val();
	// var angkatan = $('#angkatan').val();
	// var ganjil = $('#ganjil').is(":checked");
	// var genap = $('#genap').is(":checked");
	// var paket = $('#paket').is(":checked");

	if (prodi == '') {
		swal({
			title: 'Warning!',
			text: 'Kolom Program Studi tidak boleh kosong!',
			type: 'warning'
		});
	}
	// else if (program == '') {
	//   swal({
	//     title: "Warning!",
	//     text: "Kolom Program tidak boleh kosong!",
	//     type: "warning"
	//   });
	// }
	else if (thn_ajaran == '') {
		swal({
			title: 'Warning!',
			text: 'Kolom Tahun Ajaran tidak boleh kosong!',
			type: 'warning'
		});
	} else if (semester == '') {
		swal({
			title: 'Warning!',
			text: 'Kolom Semester tidak boleh kosong!',
			type: 'warning'
		});
		//  } else if (angkatan == '') {
		//   swal({
		//     title: "Warning!",
		//     text: "Kolom angkatan tidak boleh kosong!",
		//     type: "warning"
		//   });
		// }else if(ganjil == false && genap == false && paket == false){
		//   swal({
		//       title: "Warning!",
		//       text: "Pilih salah satu atau kedua semester MK tersebut",
		//       type: "warning"
		//   });
	} else {
		var temp = $(btn).html();
		$(btn).html(BTN_LOADER);
		$(btn).attr('disabled', '');
		var url = $('#form-penawaran').attr('action');
		var token = $('input[name=_token]').val();
		$(TABLE_ID + ' tbody').html(TB_LOADER);
		$.post({
			url: url,
			data: {
				_token: token,
				prodi_id: prodi,
				program_id: program,
				tahun_ajaran: thn_ajaran,
				semester: semester,
				is_mbkm: is_mbkm,
				is_cross_study: is_cross_study
				// angkatan: angkatan
				// ganjil: ganjil,
				// genap:genap,
				// paket:paket
			},
			success: function(data) {
				// console.log(data);
				$('#table')
					.DataTable()
					.destroy();
				$('#penawaran-all').html(data);
				$('#table').DataTable({
					autoWidth: false
				});
				document.getElementById('penawaran-mk-view').scrollIntoView();
			},
			error: function(data) {
				data = data.responseJSON;

				if (data.hasOwnProperty('status')) {
					if (data.type == 'warning') {
						swal(
							{
								title: 'PERHATIAN!',
								text: data.msg,
								type: data.type,
								showCancelButton: true,
								confirmButtonColor: '#DD6B55',
								confirmButtonText: 'Ya, Buatkan Penawaran!',
								closeOnConfirm: true
							},
							function(isConfirm) {
								if (isConfirm) {
									var nama_prodi = $('#prodi_id option[value=' + prodi + ']').html();
									var nama_program = $('#program_id option[value=' + program + ']').html();
									var tahunajaran = $('#tahun_ajaran option[value=' + thn_ajaran + ']').html();
									var nama_semester = $('#semester option[value=' + semester + ']').html();

									$('#form-set-penawaran input[name=prodi]').val(nama_prodi);
									$('#form-set-penawaran input[name=prodi_id]').val(prodi);
									$('#form-set-penawaran input[name=program]').val(nama_program);
									$('#form-set-penawaran input[name=program_id]').val(program);
									$('#form-set-penawaran input[name=tahunajaran]').val(tahunajaran);
									$('#form-set-penawaran input[name=tahunajaran_id]').val(thn_ajaran);
									$('#form-set-penawaran input[name=semester]').val(nama_semester);
									$('#form-set-penawaran input[name=semester_id]').val(semester);
									// $('#form-set-penawaran input[name=angkatan]').val(angkatan);
									$('#modal-set-penawaran').modal('show');
								}
							}
						);
					} else {
						swal('Error', data.msg, 'error');
					}
					$('#table')
						.DataTable()
						.destroy();
					$('#penawaran-all').html('');
					$('#table').DataTable({
						autoWidth: false
					});
				} else {
					swal('Error', 'Terjadi kesalahan sistem. Silakan hubungi pihak terkait', 'error');
				}
			},
			complete: function() {
				$(btn).html(temp);
				$(btn).removeAttr('disabled');
			}
		});
	}
}

$('#btn-simpan-set-penawaran').click(function() {
	var form = new FormData($('#form-set-penawaran')[0]);
	var url = $('#form-set-penawaran').attr('action');

	var btn = this;
	var temp;
	$.post({
		url: url,
		data: form,
		contentType: false,
		processData: false,
		beforeSend: function() {
			temp = $(btn).html();
			$(btn).html('sedang memproses..');
			$(btn).attr('disabled', '');
		},
		success: function(data) {
			if (data.status == true) {
				$('#modal-set-penawaran').modal('toggle');
				$('#form-set-penawaran')[0].reset();
				swal('SUKSES!', data.msg, 'success');
				get_current_selected();
			} else {
				swal('ERROR!', 'Response sistem tidak diketahui.', 'error');
			}
		},
		error: function(data) {
			data = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			} else {
				swal('ERROR!', 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi. Jika error ini terus terjadi, silakan hubungi pihak berwajib.', 'error');
			}
		},
		complete: function() {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	});
});

function get_kelas(id_mktawar) {
	ID_MKTAWAR_KELAS = id_mktawar;
	$('#modal-set-kelas .modal-body tbody').html(TB_LOADER);
	var url = '/penawaran/set-kelas/info';
	var token = $('input[name=_token]').val();

	$('#mktawar_id').val(id_mktawar);
	$.post({
		url: url,
		data: {
			_token: token,
			mktawar: id_mktawar
		},
		success: function(data) {
			// console.log(data);
			var kelas_content = '';
			$.each(data['mk'], function(key, value) {
				gedung_option = '<select class="form-control select2 custom-select" name="ruangan[]" style="width:100%;" required>';
				gedung_option += '<option value="">--pilih ruangan--</option>';

				var ruang;
				$.each(data['gedung'], function(key, val) {
					ruang = value['ruangan_id'] == val['ruangan_id'] ? 'selected' : '';
					gedung_option += '<option value="' + val['ruangan_id'] + '" ' + ruang + '> Gedung ' + val['nama_gedung'] + ' - Ruang ' + val['nama_ruangan'] + '</option>';
				});

				let hari = '<select class="form-control select2 custom-select" name="hari[]" style="width:100%;">';
				hari += '<option value="">-</option>';
				$.each(arrHari, function(key, val) {
					let isHariSelected = val == value['hari'] ? 'selected' : '';
					hari += '<option value="' + val + '" ' + isHariSelected + '>' + val + '</option>';
				});
				// $.each(data['ruangan'], function(key, val){
				//   ruang = (value['ruangan_id'] == val['ruangan_id']) ? 'selected': '';
				//   ruangan_option += '<option value="'+ val['ruangan_id'] +'" '+ ruang +'>'+ val['nama_ruangan'] +'</option>';
				// })
				gedung_option += '</select>';
				hari += '</select>';

				let jam_mulai = value['jam_mulai'] == '' || value['jam_mulai'] == null ? '' : value['jam_mulai'];
				let jam_berakhir = value['jam_berakhir'] == '' || value['jam_berakhir'] == null ? '' : value['jam_berakhir'];

				let mode_kuliah = `<select class="form-control select2 custom-select" name="mode_kuliah[]" style="width:100%;">
					<option value="">--pilih--</option>
					<option value="online" ${value['mode_kuliah'] == 'online' ? 'selected' : ''} >Daring / Online</option>
					<option value="offline" ${value['mode_kuliah'] == 'offline' ? 'selected' : ''} >Luring / Offline</option>
				</select>`;

				let lingkup_kelas = `<select class="form-control select2 custom-select" name="lingkup_kelas[]" style="width:100%;">
					<option value="">--pilih--</option>
					<option value="internal" ${value['lingkup_kelas'] == 'internal' ? 'selected' : ''}>Internal</option>
					<option value="external" ${value['lingkup_kelas'] == 'external' ? 'selected' : ''}>External</option>
					<option value="campuran" ${value['lingkup_kelas'] == 'campuran' ? 'selected' : ''}>Campuran</option>
				</select>`;

				kelas_content +=
					'<tr>' +
					'<input type="hidden" name="mktawar[]" value="' +
					value['mktawar_id'] +
					'" required>' +
					'<td><input type="text" name="kelas[]" class="form-control" value="' +
					value['kelas'] +
					'" required></td>' +
					'<td>' +
					gedung_option +
					'</td>' +
					'<td><input type="number" name="kapasitas[]" class="form-control" value="' +
					value['kapasitas'] +
					'" placeholder="jumlah mahasiswa ditampung" required></td>' +
					'<td>' +
					hari +
					'</td>' +
					'<td><input type="text" data-autoclose="true" name="jam_mulai[]" class="form-control clockpicker" value="' +
					jam_mulai +
					'" ></td>' +
					'<td><input type="text" name="jam_berakhir[]" data-autoclose="true" class="form-control clockpicker" value="' +
					jam_berakhir +
					'" ></td>' +
					'<td>' +
					mode_kuliah +
					'</td>' +
					'<td>' +
					lingkup_kelas +
					'</td>' +
					'<td class="text-center"><input type="checkbox" name="is_cross_study[' +
					key +
					']" id="is_cross_study[' +
					key +
					']" class="filled-in chk-col-red" ' +
					(value['is_cross_study'] == 1 ? 'checked' : '') +
					' ><label for="is_cross_study[' +
					key +
					']"></label></td>' +
					'</tr>';

				KEY_CHECKBOX = key;

				if (value['is_cross_study'] == 1) {
					console.log('checked', '#is_cross_study[' + KEY_CHECKBOX + ']');
					$('#is_cross_study[' + KEY_CHECKBOX + ']').prop('checked', true);
				}
			});
			// $('#modal-set-kelas .modal-body table')
			// 	.DataTable()
			// 	.destroy();
			$('#mk-kelas').html(kelas_content);
			// $('#modal-set-kelas .modal-body table').DataTable({
			// 	paging: false,
			// 	autoWidth: false
			// });
			$('.select2').select2();
			$('.clockpicker').clockpicker();
		}
	});

	$('#modal-set-kelas').modal('show');
}

$(document).on('click', '.btn-set-kelas', function() {
	var kode_mk = $(this)
		.closest('tr')
		.find('td')[2].innerHTML;
	var id_mktawar = $(this).data('twr');

	$('#set-kelas-title').html('Set Kelas ' + kode_mk);

	get_kelas(id_mktawar);
});

$(document).on('click', '#btn-simpan-set-kelas', function() {
	var form = new FormData($('#form-set-kelas')[0]);

	var btn = this;
	var temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');

	$.post({
		url: '/penawaran/set-kelas/save',
		data: form,
		contentType: false,
		processData: false,
		success: function(data) {
			get_kelas(ID_MKTAWAR_KELAS);
			get_current_selected();
		},
		error: function(data) {
			data = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			} else {
				swal('ERROR!', 'Gagal menyimpan data kelas', 'error');
			}
		},
		complete: function() {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	});
});

$('#btn-add-kelas').click(function() {
	var tambah = '';
	let hari = '<select class="form-control select2 custom-select" name="hari[]" style="width:100%;">';
	hari += '<option value="">-</option>';
	$.each(arrHari, function(key, val) {
		hari += '<option value="' + val + '">' + val + '</option>';
	});

	let mode_kuliah = `<select class="form-control select2 custom-select" name="mode_kuliah[]" style="width:100%;">
					<option value="">--pilih--</option>
					<option value="online" >Daring / Online</option>
					<option value="offline" >Luring / Offline</option>
				</select>`;

	let lingkup_kelas = `<select class="form-control select2 custom-select" name="lingkup_kelas[]" style="width:100%;">
					<option value="">--pilih--</option>
					<option value="internal" >Internal</option>
					<option value="external" >External</option>
					<option value="campuran" >Campuran</option>
				</select>`;

	tambah +=
		'<tr>' +
		'<input type="hidden" name="mktawar[]" value="0">' +
		'<td><input type="text" name="kelas[]" class="form-control" value="" required></td>' +
		'<td>' +
		gedung_option +
		'</td>' +
		'<td><input type="number" name="kapasitas[]" class="form-control" value="" placeholder="jumlah mahasiswa ditampung" required></td>' +
		'<td>' +
		hari +
		'</td>' +
		'<td><input type="text" data-autoclose="true" name="jam_mulai[]" class="form-control clockpicker" value="" ></td>' +
		'<td><input type="text" name="jam_berakhir[]" data-autoclose="true" class="form-control clockpicker" value="" ></td>' +
		'<td>' +
		mode_kuliah +
		'</td>' +
		'<td>' +
		lingkup_kelas +
		'</td>' +
		'<td class="text-center"><input type="checkbox" name="is_cross_study[' +
		(KEY_CHECKBOX + 1) +
		']" id="is_cross_study[' +
		(KEY_CHECKBOX + 1) +
		']" class="filled-in chk-col-red"><label for="is_cross_study[' +
		(KEY_CHECKBOX + 1) +
		']"></label></td>' +
		'</tr>';
	$('#mk-kelas').append(tambah);

	$('.select2').select2();
	$('.clockpicker').clockpicker();
});

function set_pengampu(id, id_mktawar) {
	var kode_mk = $('#table tr')
		.eq(id)
		.find('td')
		.eq(2)
		.html();
	var nama_mk = $('#table tr')
		.eq(id)
		.find('td')
		.eq(3)
		.html();
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
		success: function(data) {
			// alert(data);
			$('#mk-pengampu').html(data);
		}
	});
	$('#pengampu_mktawar_id').val(id_mktawar);
	$('#modal-set-pengampu').modal('show');
}

$('#fakultas_pengampu').change(function() {
	var fakultas = $('#fakultas_pengampu').val();
	var url = '/master/prodi_in/' + fakultas;
	var prodi = '<option value="">--pilih prodi--</option>';
	$.get({
		url: url,
		success: function(data) {
			$.each(data, function(key, val) {
				prodi += '<option value="' + val['prodi_id'] + '">' + val['jenjangprodi']['jenjang'] + ' ' + val['nama_prodi'] + '</option>';
			});
			$('#prodi_pengampu').html(prodi);
			$('#prodi_pengampu').removeAttr('disabled');
		}
	});
});

$('#prodi_pengampu').change(function() {
	var prodi = $('#prodi_pengampu').val();
	var url = '/master/dosen/prodi/' + prodi;

	if (prodi === 'semua') {
		url = '/master/dosen/allprodi/0';
	}

	$('#pengampu').html('<option value="">mohon tunggu</option>');
	var pengampu = '<option value="">--pilih pengampu--</option>';
	$.get({
		url: url,
		success: function(data) {
			// console.log(data);
			$.each(data, function(key, val) {
				pengampu += '<option value="' + val['dosen_id'] + '" data-nip="' + val['nip'] + '" data-nama="' + val['nama'] + '">' + val['nip'] + ' - ' + val['nama'] + '</option>';
			});

			$('#pengampu').html(pengampu);
			$('#pengampu').removeAttr('disabled');
		}
	});
});

$('#btn-add-pengampu').click(function() {
	var fakultas = $('#fakultas_pengampu').val();
	var prodi = $('#prodi_pengampu').val();
	var pengampu = $('#pengampu').val();
	var status = $('#status_pengampu').val();
	var new_pengampu = '';

	if (fakultas == '') {
		swal({
			title: 'Warning!',
			text: 'Pilih Fakultas terlebih dahulu',
			type: 'warning'
		});
	} else if (prodi == '') {
		swal({
			title: 'Warning!',
			text: 'Pilih Program Studi terlebih dahulu',
			type: 'warning'
		});
	} else if (pengampu == '') {
		swal({
			title: 'Warning!',
			text: 'Pilih Dosen Pengampu terlebih dahulu',
			type: 'warning'
		});
	} else {
		var nip_pengampu = $('#pengampu')
			.find(':selected')
			.data('nip');
		var nama_pengampu = $('#pengampu')
			.find(':selected')
			.data('nama');
		new_pengampu =
			'<tr id="pengampu">' +
			'<input type="hidden" name="status[]" value="' +
			status +
			'">' +
			'<input type="hidden" name="new_dosen_id[]" value="0">' +
			'<input type="hidden" name="dosen_id[]" value="' +
			pengampu +
			'">' +
			'<td>' +
			nip_pengampu +
			'</td>' +
			'<td>' +
			nama_pengampu +
			'</td>' +
			'<td>' +
			status +
			'</td>' +
			'<td>' +
			'<button class="btn btn-danger btn-sm ml-1" type="button" data-toggle="tooltip" title="Hapus/Reset" onclick="hapus_pengampu("pengampu")"><i class="mdi mdi-delete"></i></button>' +
			'</td>' +
			'</tr>';

		$('#mk-pengampu').append(new_pengampu);
		store_pengampu(this);
	}
});

function hapus_pengampu(id) {
	// alert(id);
	var row = document.getElementById(id);
	row.parentNode.removeChild(row);
	store_pengampu('#btn-add-pengampu');
}

function hapus_penawaran(e, mktawar_id) {
	var row = $(e)
		.closest('tr')
		.find('td');
	var nama = row[2].innerHTML;
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();

	swal(
		{
			title: 'Hapus Penawaran Mata Kuliah ' + nama + '?',
			text: 'Data yang sudah dihapus tidak dapat dikembalikan lagi!',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Hapus!',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			var url = '/penawaran/delete';
			var token = $('input[name=_token]').val();

			$.post({
				url: url,
				data: {
					_token: token,
					mktawar_id: mktawar_id,
					thn_ajaran: thn_ajaran,
					semester: semester
				},
				success: function(data) {
					if (data == 'sukses') {
						swal('Sukses!', 'Penawaran ' + nama + ' berhasil dihapus', 'success');
						get_current_selected();
					} else if (data == 'ada_mhs') {
						swal('Error', 'Kelas ini tidak dapat dihapus karena terdapat mahasiswa didalamnya', 'error');
					}
				},
				error: function() {
					swal('Error', 'Terjadi kesalahan sistem. Silakan hubungi pihak terkait', 'error');
				}
			});
		}
	);
}

$('#btn-shw-penawaran').click(function() {
	var btn = this;

	var fakultas = $('#fakultas_id_penawaran').val();
	var prodi = $('#prodi_id').val();
	var program = $('#program-add-penawaran').val();
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var angkatan = $('#angkatan').val();
	var ganjil = $('#ganjil-add-penawaran').is(':checked');
	var genap = $('#genap-add-penawaran').is(':checked');
	var table = '';
	// alert(angkatan);

	if (prodi == '') {
		swal({
			title: 'Warning!',
			text: 'Kolom Program Studi tidak boleh kosong!',
			type: 'warning'
		});
	}
	// else if (program == '') {
	//   swal({
	//     title: "Warning!",
	//     text: "Kolom Program tidak boleh kosong!",
	//     type: "warning"
	//   });
	// }
	else if (thn_ajaran == '') {
		swal({
			title: 'Warning!',
			text: 'Kolom Tahun Ajaran tidak boleh kosong!',
			type: 'warning'
		});
	} else if (semester == '') {
		swal({
			title: 'Warning!',
			text: 'Kolom Semester tidak boleh kosong!',
			type: 'warning'
		});
	} else if (angkatan == '') {
		swal({
			title: 'Warning!',
			text: 'Isi kolom angkatan terlebih dahulu',
			type: 'warning'
		});
	} else if (ganjil == false && genap == false) {
		swal({
			title: 'Warning!',
			text: 'Centang salah satu semester MK',
			type: 'warning'
		});
	} else {
		var temp = $(btn).html();
		$(btn).html(BTN_LOADER);
		$(btn).attr('disabled', '');
		var url = '/penawaran/get_mk_angkatan';

		$.get({
			url: url,
			data: {
				prodi_id: prodi,
				program_id: program,
				thn_ajaran: thn_ajaran,
				semester: semester,
				angkatan: angkatan,
				ganjil: ganjil,
				genap: genap
			},
			success: function(data) {
				// console.log(data);
				if (data == '') {
					swal({
						title: 'Warning!',
						text: 'Semua matakuliah sudah ditawarkan',
						type: 'warning'
					});
				} else {
					$.each(data, function(key, val) {
						table +=
							'<tr data-id="' +
							val['matakuliah_id'] +
							'" style="cursor: pointer;" data-toggle="tooltip" title="klik untuk menambahkan MK ini ke panawaran">' +
							'<td>' +
							val['kode_matakuliah'] +
							'</td>' +
							'<td>' +
							val['nama_matakuliah'] +
							'</td>' +
							'<td>' +
							val['semester'] +
							'</td>' +
							'<td>' +
							val['sks'] +
							'</td>' +
							'</tr>';
					});
					$('#table-mk-penawaran-add')
						.DataTable()
						.destroy();
					$('#mk-penawaran-add').html(table);
					$('#table-mk-penawaran-add').DataTable();
				}
			},
			error: function(data) {
				if (data.responseJSON) {
					swal('ERROR!', data.responseJSON.msg, 'error');
				} else {
					swal('ERROR!', 'terjadi kesalahan server', 'error');
				}
			},
			complete: function() {
				$(btn).html(temp);
				$(btn).removeAttr('disabled');
			}
		});
	}
});

$('#table-mk-penawaran-add tbody').on('click', 'tr', function() {
	var row = $(this).closest('tr');
	var column = row.find('td');
	var program = $('#program-add-penawaran').val();
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var angkatan = $('#angkatan').val();
	var token = $('input[name=_token]').val();
	var url = '/penawaran/store_individual_mk_penawaran';

	var mk = [];
	mk['kode'] = column[0].innerHTML;
	mk['nama'] = column[1].innerHTML;
	mk['smt'] = column[2].innerHTML;
	mk['sks'] = column[3].innerHTML;

	swal(
		{
			title: 'Tambahkan MK ' + mk['nama'] + ' ke penawaran?',
			text: 'Anda dapat menghapus mk ini jika diperlukan!',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Tambahkan!',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.post({
				url: url,
				data: {
					_token: token,
					angkatan: angkatan,
					program_id: program,
					thn_ajaran: thn_ajaran,
					semester: semester,
					kode_mk: mk['kode'],
					mkid: row.data('id')
				},
				success: function(data) {
					if (data == 'not_active') {
						swal({
							title: 'Warning!',
							text: 'Aktivasi KRS tahun ajaran dan semester yang dipilih belum diaktifkan secara global!',
							type: 'warning'
						});
					} else if (data == 'sudah_ditawarkan') {
						swal({
							title: 'Warning!',
							text: 'Matakuliah ini sudah ditawarkan!',
							type: 'warning'
						});
					} else if (data == 'sukses') {
						swal('Sukses!', 'Berhasil menambah penawaran matakuliah baru!', 'success');
						// $('#btn-shw-penawaran').click()

						// $('#modal-add-penawaran').modal('toggle');
					} else if (data == 'gagal') {
						swal('Error', 'Gagal menyimpan data penawaran baru', 'error');
					}
				},
				error: function() {
					swal('Error', 'Terjadi kesalahan sistem. Silakan hubungi pihak terkait', 'error');
				}
			});
		}
	);
});

function store_pengampu(btn) {
	var formData = new FormData($('#form-pengampu')[0]);
	var url = $('#form-pengampu').attr('action');

	var temp = $(btn).html();
	$.post({
		url: url,
		data: formData,
		contentType: false,
		processData: false,
		beforeSend: function() {
			$(btn).html('<span class="fa fa-refresh fa-spin"></span> menyimpan...');
			$(btn).attr('disabled', '');
		},
		success: function(data) {
			if (data.status == true) {
				swal('SUKSES!', data.msg, 'success');
				get_current_selected();
				return;
			}
			swal('ERROR!', 'No Response', 'error');
		},
		error: function(data) {
			var err = data.responseText;
			data = data.responseJSON;

			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			} else {
				swal('ERROR!', data.message, 'error');
			}
			console.log(data);
		},
		complete: function() {
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
			set_pengampu(VAR_ID_PENGAMPU, VAR_IDMKTAWAR_PENGAMPU);
		}
	});
	// console.log(status);
}

$('.nonpaket').click(function() {
	$('#paket').prop('checked', false);
});

$('#paket').click(function() {
	$('.nonpaket').prop('checked', false);
});
