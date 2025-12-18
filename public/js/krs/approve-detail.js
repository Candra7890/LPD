var krs_semua = [];
var krs_regis = [];
var jml_sks = 0;
var batas_sks = 0;
var mk_tawaran = [];
let IS_PAKET = 0;

function get_mk_ditawarkan() {
	var url = '/registrasi-krs-mbkm/penawaran';
	$.get({
		url: url,
		data: {
			nim: $('#nim').val()
		},
		success: function(data) {
			// console.log(data);
			mk_tawaran = [];
			var row = '';
			var mk = {};
			var selected = '';
			$.each(data['penawaran'], function(key, val) {
				mk = {};
				mk.kode = val['kode_matakuliah'];
				mk.nama = val['nama_matakuliah'];
				mk.sks = val['sks'];
				mk.smt = val['semester'];
				mk.kelas = val['kelas'];
				mk.is_dipilih = 0;
				mk.is_mbkm = val['is_mbkm'];
				mk.is_cross_study = val['is_cross_study'];
				mk_tawaran[mk_tawaran.length] = mk;
			});
			mapping_dipilih_ditawarkan();
		},
		error: function() {
			swal({
				title: 'Error!',
				text: 'Terjadi kesalahan sistem saat mengambil data matakuliah!',
				type: 'error'
			});
		}
	});
}

function get_ips_mhs(mhs_id) {
	$.get({
		url: '/approve-krs/grafik-nilai',
		data: {
			mahasiswa_id: mhs_id
		},
		success: function(data) {
			// console.log(data);
			if (data['nilai'] != 'tdk_ada') {
				new Chartist.Line(
					'.ct-sm-line-chart',
					{
						labels: data['tahun'],
						series: [data['nilai']]
						// labels: ['smt 1', 'smt 2', 'smt 3'],
						// series: [
						//   [2.9, 3.0, 4.0]
						// ]
					},
					{
						high: 4,
						plugins: [Chartist.plugins.tooltip()],
						showArea: true
					}
				);
			}
		},
		error: function() {
			alert('error');
		}
	});
}

function get_ipk_ips(mhs_id) {
	$.get({
		url: '/registrasi-krs/hitung-nilai',
		data: {
			mahasiswa_id: mhs_id
		},
		success: function(data) {
			console.log(data);
			batas_sks = data['maks_sks'];
			$('#maks-sks').html(batas_sks);

			if (data['ipk'] == 0) {
				$('#ipk').html('0');
			} else {
				$('#ipk').html(data['ipk']);
			}

			if (data['ips'] == 0) {
				$('#ips').html('0');
			} else {
				$('#ips').html(data['ips']);
			}
			// $('#ips').html('4.0');

			if (data['khusus'] != null) {
				var sks = data['khusus']['jml_sks'] == null || data['khusus']['jml_sks'] == 0 ? '<span class="badge badge-danger">standar</span><br>' : '<span><b>' + data['khusus']['jml_sks'] + '</b></span><br>';
				var syarat_mk = data['khusus']['syarat_mk'] == 0 ? '<span class="badge badge-danger">Tidak</span><br>' : '<span class="badge badge-success">Ya</span><br>';
				var syarat_sks = data['khusus']['prasyarat_sks'] == 0 ? '<span class="badge badge-danger">Tidak</span><br>' : '<span class="badge badge-success">Ya</span><br>';
				var pengabaian =
					'<div class="alert alert-info">' +
					'<h5>Mahasiswa Ini mendapat perlakuan khusus.</h5>' +
					'Pengambilan SKS   : ' +
					sks +
					'Pengabaian Syarat MK terhadap MK lain  : ' +
					syarat_mk +
					'Pengabaian Syarat SKS MK  : ' +
					syarat_sks +
					'</div>';
				$('#pengabaian').html(pengabaian);
			}
		},
		error: function() {
			alert('error');
		}
	});
}

function get_transkrip_nilai(mhs_id) {
	$.get({
		url: '/approve-krs/transkrip',
		data: {
			mahasiswa_id: mhs_id
		},
		success: function(data) {
			$.each(data['krs'], function(i, val) {
				var krs = {};
				if (data['tahun_ajaran_sekarang']['tahun_ajaran'] == val['tahunajaran'] && data['tahun_ajaran_sekarang']['semester_id'] == val['semester']) {
					return;
				}
				krs.matakuliah_id = val['matakuliah_id'];
				krs.mktawar_id = val['mktawar_id'];

				krs_semua[krs_semua.length] = krs;
			});
			console.log(krs_semua);
		},
		error: function() {
			alert('error');
		}
	});
}

function get_mk_registrasi_mhs(mhs_id, is_paket = 0) {
	IS_PAKET = is_paket;
	$('#approve-krs-mhs').html('<td colspan="10" class="text-center">' + '<i class="fa fa-spin fa-refresh"></i>  ' + 'Sedang Memproses...' + '</td>');

	$.get({
		url: '/approve-krs/mk',
		data: {
			mahasiswa_id: mhs_id
		},
		success: function(data) {
			// console.log(data);
			var row = '';
			var check = '';
			var btn_appr_class = '';
			var btn_appr_icon = '';
			var keterangan = '';
			var button = '';
			if (data.length == 0) {
				$('#no-krs').show();
			}
			var comment = '';
			$.each(data, function(i, val) {
				var mk = {};

				mk.krs = val['krs_id'];
				mk.kode = val['kode_matakuliah'];
				mk.nama = val['nama_matakuliah'];
				mk.sks = val['sks'];
				mk.smt = val['semester'];
				mk.kelas = val['kelas'];
				mk.jadwal = val['hari'] + ', ' + val['jam_mulai'] + '-' + val['jam_berakhir'];
				mk.keterangan = val['keterangan'] == null ? '' : val['keterangan'];
				mk.is_approve = val['is_approve'];
				mk.is_approve_koprodi = val['is_approve_koprodi'];
				mk.is_mbkm = val['is_mbkm'];

				mk.matakuliah_id = val['matakuliah_id'];
				mk.mktawar_id = val['mktawar_id'];

				jml_sks += val['sks'];

				mk.pengulangan = 1;
				$.each(krs_semua, function(key, value) {
					if (val['matakuliah_id'] == value['matakuliah_id']) {
						mk.pengulangan++;
					}
				});
				krs_regis[krs_regis.length] = mk;

				if (is_koprodi === 1) {
					btn_appr_icon = val['is_approve_koprodi'] == 1 ? 'fa fa-times' : 'fa fa-check';
					btn_appr_class = val['is_approve_koprodi'] == 1 ? 'btn-warning' : 'btn-success';

					check = val['is_approve_koprodi'] == 1 ? '<span class="badge badge-success">Sudah</span>' : '<span class="badge badge-danger">Belum</span>';

					button = '<button class="btn ' + btn_appr_class + ' btn-sm mr-1" type="button" onclick="approve_koprodi(' + val['krs_id'] + ')" title="Ubah Status Approve"><span class="' + btn_appr_icon + '"></span></button>';
				} else {
					btn_appr_icon = val['is_approve'] == 1 ? 'fa fa-times' : 'fa fa-check';
					btn_appr_class = val['is_approve'] == 1 ? 'btn-warning' : 'btn-success';

					check = val['is_approve'] == 1 ? '<span class="badge badge-success">Sudah</span>' : '<span class="badge badge-danger">Belum</span>';

					if (is_paket == 1 && val['is_mbkm'] == 1) {
						button =
							// '<button class="btn btn-danger btn-sm mr-1" type="button" onclick="delete_krs(' +
							// (i + 1) +
							// ', ' +
							// val['krs_id'] +
							// ')" title="Hapus Matakuliah"><span class="fa fa-trash"></span></button>' +
							// '<button class="btn ' +
							// btn_appr_class +
							// ' btn-sm mr-1" type="button" onclick="approve(' +
							// val['krs_id'] +
							// ')" title="Ubah Status Approve"><span class="' +
							// btn_appr_icon +
							// '"></span></button>' +
							'<button class="btn btn-info btn-sm" type="button" onclick="openMsg(this)" title="Isi Catatan" data-idx="' +
							i +
							'" data-msg="' +
							mk.keterangan +
							'" data-id="' +
							val['krs_id'] +
							'"><span class="mdi mdi-email"></span></button>';
					} else {
						button =
							'<button class="btn btn-danger btn-sm mr-1" type="button" onclick="delete_krs(' +
							(i + 1) +
							', ' +
							val['krs_id'] +
							')" title="Hapus Matakuliah"><span class="fa fa-trash"></span></button>' +
							'<button class="btn ' +
							btn_appr_class +
							' btn-sm mr-1" type="button" onclick="approve(' +
							val['krs_id'] +
							')" title="Ubah Status Approve"><span class="' +
							btn_appr_icon +
							'"></span></button>' +
							'<button class="btn btn-info btn-sm" type="button" onclick="openMsg(this)" title="Isi Catatan" data-idx="' +
							i +
							'" data-msg="' +
							mk.keterangan +
							'" data-id="' +
							val['krs_id'] +
							'"><span class="mdi mdi-email"></span></button>';
					}
				}

				row +=
					'<tr>' +
					'<td>' +
					(i + 1) +
					'<input type="hidden" name="krs[]" value="' +
					val['krs_id'] +
					'">' +
					'</td>' +
					'<td>' +
					val['kode_matakuliah'] +
					'</td>' +
					'<td>' +
					val['nama_matakuliah'] +
					' (' +
					val['kelas'] +
					')</td>' +
					'<td>' +
					val['semester'] +
					'</td>' +
					'<td>' +
					val['sks'] +
					'</td>' +
					'<td>' +
					mk.jadwal +
					'</td>' +
					'<td>' +
					mk.pengulangan +
					'</td>' +
					'<td>' +
					check +
					'</td>' +
					'<td>' +
					button +
					'</td>' +
					'</tr>';
			});
			// console.log(krs_regis);
			$('#approve-krs-mhs').html(row);
			get_mk_ditawarkan();
			$('#sks-sekarang').html(jml_sks);
		},
		error: function() {
			alert('error');
		}
	});
}

function openMsg(e) {
	$('#msg').val($(e).data('msg'));
	$('#btn-send-msg').attr('onclick', 'send(' + $(e).data('idx') + ',' + $(e).data('id') + ')');
	$('#modal-catatan').modal('show');
}

function send(index, krs) {
	$('#modal-catatan').modal('toggle');
	var token = $('input[name=_token]').val();
	var catatan = $('#msg').val();
	if (catatan != '') {
		$.post({
			url: '/approve-krs/send-comment',
			data: {
				krs: krs,
				catatan: catatan,
				_token: token
			},
			success: function(data) {
				if (data['message'] == 'notAllowed') {
					swal({
						title: 'Error!',
						text: 'Anda tidak dapat mengirim catatan karena matakuliah ini sudah anda approve.',
						type: 'error'
					});
				} else if (data['message'] == 'notResponding') {
					swal({
						title: 'Perhatian!',
						text: 'Sistem tidak melakukan respon!',
						type: 'warning'
					});
				} else if (data['message'] == 'success') {
					$('#msg').val('');
					krs_regis[index].keterangan = catatan;
					$.toast({
						heading: 'Sukses!',
						text: 'Sistem berhasil mengirim catatan.',
						position: 'bottom-center',
						icon: 'success',
						hideAfter: 3000,
						stack: 6
					});
				}
			},
			error: function() {
				swal({
					title: 'Error!',
					text: 'Terjadi kesalahan sistem.',
					type: 'error'
				});
			}
		});
	}
}

function approve(krs) {
	var token = $('input[name=_token]').val();

	swal(
		{
			title: 'Ubah Status Approve?',
			text: 'Anda dapat mengubah status kembali jika diperlukan',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Ubah!',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.post({
				url: '/approve-krs/accept',
				data: {
					_token: token,
					krs: krs
				},
				success: function(data) {
					if (data.success) {
						$.each(krs_regis, function(i, val) {
							if (val.krs == krs) {
								krs_regis[i]['is_approve'] = krs_regis[i]['is_approve'] == 1 ? 0 : 1;
								return false;
							}
						});

						update_table_row();
						swal('Sukses!', 'Berhasil mengubah status approval KRS', 'success');
					} else {
						let errorMsg = data.msg ? data.msg : 'Respon tidak diketahui';
						swal('Error!', errorMsg, 'error');
					}
				},
				error: function() {
					swal('Error!', 'Terjadi kegagalan sistem', 'error');
				}
			});
		}
	);
}

function approve_koprodi(krs) {
	var token = $('input[name=_token]').val();

	swal(
		{
			title: 'Ubah Status Approve?',
			text: 'Anda dapat mengubah status kembali jika diperlukan',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Ubah!',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.post({
				url: '/approve-krs-koprodi/accept',
				data: {
					_token: token,
					krs: krs
				},
				success: function(data) {
					if (data.success) {
						$.each(krs_regis, function(i, val) {
							if (val.krs == krs) {
								krs_regis[i]['is_approve_koprodi'] = krs_regis[i]['is_approve_koprodi'] == 1 ? 0 : 1;
								return false;
							}
						});

						update_table_row();
						swal('Sukses!', 'Berhasil mengubah status approval KRS', 'success');
					} else {
						let errorMsg = data.msg ? data.msg : 'Respon tidak diketahui';
						swal('Error!', errorMsg, 'error');
					}
				},
				error: function() {
					swal('Error!', 'Terjadi kegagalan sistem', 'error');
				}
			});
		}
	);
}

function mapping_dipilih_ditawarkan() {
	// alert('test');
	// console.log(mk_tawaran);
	// console.log(mk_dipilih);
	$.each(krs_regis, function(key, dipilih) {
		$.each(mk_tawaran, function(keys, tawaran) {
			if (dipilih.kode == tawaran.kode && dipilih.kelas == tawaran.kelas) {
				mk_tawaran[keys].is_dipilih = 1;
				return false;
			}
		});
	});

	update_mktawar_table();
}

function update_mktawar_table() {
	if (mk_tawaran.length >= 0) {
		var row = '';
		var dipilih = '';
		$.each(mk_tawaran, function(key, val) {
			dipilih = val.is_dipilih == 1 ? 'bgcolor="#FFCCBC"' : '';
			row +=
				'<tr style="cursor:pointer;" ' +
				dipilih +
				'>' +
				'<td>' +
				(key + 1) +
				'</td>' +
				'<td>' +
				val.kode +
				'</td>' +
				'<td>' +
				val.nama +
				'</td>' +
				'<td>' +
				val.sks +
				'</td>' +
				'<td>' +
				val.smt +
				'</td>' +
				'<td>' +
				val.kelas +
				'</td>' +
				'</tr>';
		});
		$('#table-registrasi-krs')
			.DataTable()
			.destroy();
		$('#mk-ditawarkan').html(row);
		$('#table-registrasi-krs').DataTable();
	}
}

$('#btn-submit-appr').click(function() {
	$('#load').show();
	var krs = [];
	var keterangan = [];
	var approve = [];
	var token = $('input[name=_token]').val();

	$('input[name^="krs"]').each(function() {
		krs[krs.length] = $(this).val();
	});

	$('input[name^="keterangan"]').each(function() {
		keterangan[keterangan.length] = $(this).val();
	});

	$.post({
		url: '/approve-krs/store',
		data: {
			_token: token,
			krs: krs,
			keterangan: keterangan,
			approve: approve
		},
		success: function(data) {
			swal('Sukses!', 'Berhasil menyimpan persetujuan KRS', 'success');
			$('#load').hide();
		},
		error: function() {
			swal('Error!', 'Terjadi kesalahan sistem. Silakan hubungi pihak berwajib.', 'error');
			$('#load').hide();
		}
	});
});

function insert_new(mk, row) {
	var token = $('input[name=_token]').val();
	var url = '/registrasi-krs/insert';
	var thn_ajaran = $('#thn_ajaran').val();
	var semester = $('#semester').val();
	var abaikan = $('#abaikan_syarat').is(':checked');
	// alert(abaikan);

	if (jml_sks + parseInt(mk.sks) > batas_sks) {
		swal({
			title: 'Peringatan!',
			text: 'Anda tidak diijinkan untuk menambah matakuliah karena telah melewati batas jumlah SKS',
			type: 'warning'
		});
	} else {
		$.post({
			url: url,
			data: {
				_token: token,
				tahun_ajaran: thn_ajaran,
				semester: semester,
				mk: mk,
				nim: $('#nim').val(),
				abaikan: abaikan
			},
			success: function(data) {
				if (data[0] == 'sukses') {
					$('#no-krs').hide();
					mk.pengulangan = 1;
					mk.krs = data[1];
					krs_regis[krs_regis.length] = mk;
					row.attr('bgcolor', '#FFCCBC');
					jml_sks += parseInt(mk.sks);
					$('#sks-sekarang').html(jml_sks);
					$.each(mk_tawaran, function(key, tawaran) {
						if (tawaran.kode == mk.kode && tawaran.kelas == mk.kelas) {
							mk_tawaran[key].is_dipilih = 1;
						}
					});
					update_table_row();
					$('#sks-sekarang').html(jml_sks);
				} else if (data[0] == 'mk_dilarang') {
					var mk_blm_diambil = '';
					$.each(data[1], function(i, val) {
						mk_blm_diambil += '# ' + val['nama_matakuliah'] + '\n, ';
					});
					swal({
						title: 'Peringatan!',
						text: 'Anda tidak dapat menambah matakuliah ini karena anda belum mengambil matakuliah syarat berikut: \n' + mk_blm_diambil,
						type: 'warning'
					});
				} else if (data[0] == 'too_much') {
					swal({
						title: 'Peringatan!',
						text: 'Anda tidak dapat menambah matakuliah ini karena kelas sudah penuh',
						type: 'warning'
					});
				} else if (data[0] == 'jmlSksViolation') {
					swal({
						title: 'Peringatan!',
						text: 'Anda tidak dapat menambah matakuliah ini karena melewati jumlah sks yang ditetapkan.\nAnda hanya boleh mengambil ' + data[1] + ' SKS',
						type: 'warning'
					});
				} else if (data[0] == 'prasyaratSksViolation') {
					swal({
						title: 'Peringatan!',
						text: 'Anda tidak dapat menambah matakuliah ini karena jumlah SKS yang anda telah kumpulkan tidak sesuai dengan prasyarat SKS matakuliah ini.',
						type: 'warning'
					});
				} else {
					swal({
						title: 'Peringatan!',
						text: 'Sistem tidak merespon. Hubungi pihak berwajib!',
						type: 'warning'
					});
				}
			},
			error: function() {
				swal({
					title: 'Error!',
					text: 'Terjadi masalah pada sistem. Hubungi pihak berwajib!',
					type: 'error'
				});
			}
		});
	}
}

$(document).on('click', '#approve-all', function() {
	var tahun_ajaran = $('#thn_ajaran').val();
	var semester = $('#semester').val();
	var token = $('input[name=_token]').val();
	var nim = $('#nim').val();
	// alert(token);
	swal(
		{
			title: 'Approve Semua Matakuliah?',
			text: 'Anda dapat unapprove kembali matakuliah',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Approve!',
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function() {
			$.post({
				url: '/approve-krs/approve_all',
				data: {
					_token: token,
					tahun_ajaran: tahun_ajaran,
					semester: semester,
					nim: nim
				},
				success: function(data) {
					if (data.success) {
						swal('Sukses!', data.msg, 'success');

						$.each(krs_regis, function(i, val) {
							krs_regis[i]['is_approve'] = 1;
						});

						update_table_row();
					} else {
						let errorMsg = data.msg == null ? 'Response Tidak Diketahui' : data.msg;
						swal('Error!', data.msg, 'error');
					}
				}
			});
		}
	);
});

// function to update row in student lecture list
function update_table_row() {
	$('#approve-krs-mhs').html('<td colspan="10" class="text-center">' + '<i class="fa fa-spin fa-refresh"></i>  ' + 'Sedang Memproses...' + '</td>');

	if (krs_regis.length >= 0) {
		var check;
		var keterangan;
		var row = '';
		var button = '';
		var btn_appr_icon = '';
		var btn_appr_class = '';
		var catatan = '';
		console.log(krs_regis);

		$.each(krs_regis, function(i, val) {
			if (is_koprodi === 1) {
				btn_appr_icon = val['is_approve_koprodi'] == 1 ? 'fa fa-times' : 'fa fa-check';
				btn_appr_class = val['is_approve_koprodi'] == 1 ? 'btn-warning' : 'btn-success';

				check = val['is_approve_koprodi'] == 1 ? '<span class="badge badge-success">Sudah</span>' : '<span class="badge badge-danger">Belum</span>';

				button = '<button class="btn ' + btn_appr_class + ' btn-sm mr-1" type="button" onclick="approve_koprodi(' + val['krs'] + ')"><span class="' + btn_appr_icon + '"></span></button>';
			} else {
				btn_appr_icon = val['is_approve'] == 1 ? 'fa fa-times' : 'fa fa-check';
				btn_appr_class = val['is_approve'] == 1 ? 'btn-warning' : 'btn-success';

				check = val['is_approve'] == 1 ? '<span class="badge badge-success">Sudah</span>' : '<span class="badge badge-danger">Belum</span>';

				if (IS_PAKET == 1 && val['is_mbkm'] == 1) {
					button =
						// '<button class="btn btn-danger btn-sm mr-1" type="button" onclick="delete_krs(' +
						// (i + 1) +
						// ', ' +
						// val['krs'] +
						// ')"><span class="fa fa-trash"></span></button>' +
						// '<button class="btn ' +
						// btn_appr_class +
						// ' btn-sm mr-1" type="button" onclick="approve(' +
						// val['krs'] +
						// ')"><span class="' +
						// btn_appr_icon +
						// '"></span></button>' +
						'<button class="btn btn-info btn-sm" onclick="openMsg(this)" type="button" title="" data-toggle="modal" data-target="#modal-catatan" data-idx="' +
						i +
						'" data-msg="' +
						keterangan +
						'" data-id="' +
						val['krs'] +
						'"><span class="mdi mdi-email"></span></button>';
				} else {
					button =
						'<button class="btn btn-danger btn-sm mr-1" type="button" onclick="delete_krs(' +
						(i + 1) +
						', ' +
						val['krs'] +
						')"><span class="fa fa-trash"></span></button>' +
						'<button class="btn ' +
						btn_appr_class +
						' btn-sm mr-1" type="button" onclick="approve(' +
						val['krs'] +
						')"><span class="' +
						btn_appr_icon +
						'"></span></button>' +
						'<button class="btn btn-info btn-sm" onclick="openMsg(this)" type="button" title="" data-toggle="modal" data-target="#modal-catatan" data-idx="' +
						i +
						'" data-msg="' +
						keterangan +
						'" data-id="' +
						val['krs'] +
						'"><span class="mdi mdi-email"></span></button>';
				}
			}

			var pengulangan = 1;
			$.each(krs_semua, function(key, value) {
				if (val['matakuliah_id'] == value['matakuliah_id']) {
					pengulangan++;
				}
			});
			keterangan = val['keterangan'] != null ? val['keterangan'] : '';

			row +=
				'<tr>' +
				'<td>' +
				(i + 1) +
				'<input type="hidden" name="krs[]" value="' +
				val['krs_id'] +
				'">' +
				'</td>' +
				'<td>' +
				val['kode'] +
				'</td>' +
				'<td>' +
				val['nama'] +
				' (' +
				val['kelas'] +
				')</td>' +
				'<td>' +
				val['smt'] +
				'</td>' +
				'<td>' +
				val['sks'] +
				'</td>' +
				'<td>' +
				val['jadwal'] +
				'</td>' +
				'<td>' +
				pengulangan +
				'</td>' +
				'<td>' +
				check +
				'</td>' +
				'<td>' +
				button +
				'</td>' +
				'</tr>';
		});
		// console.log(krs_regis);
		$('#approve-krs-mhs').html(row);
	}
}

$('#table-registrasi-krs tbody').on('click', 'tr', function() {
	// alert(mk_dipilih.length);
	var row = $(this).closest('tr');
	var attr = row.attr('bgcolor');
	var column = row.find('td');

	if (attr == null) {
		var mk = {};

		mk.kode = column[1].innerHTML;
		mk.nama = column[2].innerHTML;
		mk.sks = column[3].innerHTML;
		mk.smt = column[4].innerHTML;
		mk.kelas = column[5].innerHTML;
		mk.keterangan = null;
		mk.is_approve = 0;

		if (krs_regis.length == 0) {
			// jika masih kosong
			insert_new(mk, row);
		} else {
			var sama = 0;
			var mk_old = {};
			var old_index;
			// && val.kelas == mk.kelas
			$.each(krs_regis, function(key, val) {
				if (val.kode == mk.kode) {
					// alert(val.kode);
					// jika sama kelas akan diganti

					$.each(mk_tawaran, function(i, val) {
						if (val.kode == mk.kode && val.is_dipilih == 1) {
							mk_old = val;
							old_index = i;
							// console.log(mk_old);
							return false;
						}
					});
					sama = 1;
					swal(
						{
							title: 'Pindah Kelas?',
							text: 'Sistem mendeteksi anda mencoba menambahkan kelas lain matakuliah yang sama seperti yang anda tambahkan sebelumnya. Apakah anda ingin pindah dari kelas ' + mk_old.kelas + ' ke kelas ' + mk.kelas + '?',
							type: 'warning',
							showCancelButton: true,
							cancelButtonText: 'Batal',
							confirmButtonColor: '#DD6B55',
							confirmButtonText: 'Ya, Pindah!',
							closeOnConfirm: true
						},
						function() {
							update_reg(mk_old, mk, row, old_index, key, mk.kelas);
							update_mktawar_table();
							update_table_row();
						}
					);
				}
			});

			if (sama == 0) {
				insert_new(mk, row);
			}
		}
	}
});

function update_reg(mk_old, mk_new, row, old_index, key, kelas) {
	var token = $('input[name=_token]').val();
	var url = '/registrasi-krs/update';
	var thn_ajaran = $('#thn_ajaran').val();
	var semester = $('#semester').val();

	$.post({
		url: url,
		data: {
			_token: token,
			tahun_ajaran: thn_ajaran,
			semester: semester,
			mk_old: mk_old,
			mk_new: mk_new,
			nim: $('#nim').val()
		},
		success: function(data) {
			if (data == 'sukses') {
				mk_tawaran[old_index].is_dipilih = 0;
				$.each(mk_tawaran, function(key, tawaran) {
					if (tawaran.kode == mk_new.kode && tawaran.kelas == mk_new.kelas) {
						mk_tawaran[key].is_dipilih = 1;
					}
				});
				krs_regis[key].kelas = kelas;
				krs_regis[key].keterangan = null;
				krs_regis[key].is_approve = 0;
				update_mktawar_table();
				update_table_row();
			} else if (data == 'too_much') {
				swal({
					title: 'Peringatan!',
					text: 'Anda tidak dapat menambah matakuliah ini karena kelas sudah penuh',
					type: 'warning'
				});
			} else {
				swal({
					title: 'Peringatan!',
					text: 'Sistem tidak merespon. Hubungi pihak berwajib!',
					type: 'warning'
				});
			}
		},
		error: function() {
			swal({
				title: 'Error!',
				text: 'Terjadi masalah pada sistem. Hubungi pihak berwajib!',
				type: 'error'
			});
		}
	});
}

function delete_krs(row_index, krs) {
	var token = $('input[name=_token]').val();
	var url = '/registrasi-krs/delete';
	var thn_ajaran = $('#thn_ajaran').val();
	var semester = $('#semester').val();

	var row = $(this).closest('tr');
	var column = row.find('td');
	var kode = $('#table-approve tr')
		.eq(row_index)
		.find('td')
		.eq(1)
		.html();
	var nama = $('#table-approve tr')
		.eq(row_index)
		.find('td')
		.eq(2)
		.html();
	var dilarang = 0;
	var hps_index = '';
	var nama;
	var kelas;

	swal(
		{
			title: 'Hapus Mata Kuliah ' + nama + '?',
			text: 'Data akan terhapus secara permanen namun anda dapat kembali memilih matakuliah ini',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Hapus!',
			closeOnConfirm: false
		},
		function() {
			$.each(krs_regis, function(key, val) {
				if (val.kode == kode) {
					hps_index = key;
					kelas = val.kelas;
					return false;
				}
			});

			// console.log(krs_regis[hps_index].is_approve);
			if (krs_regis[hps_index].is_approve == 1) {
				swal({
					title: 'Error!',
					text: 'Anda tidak dapat menghapus matakuliah ini karena telah di-approve oleh Dosen PA anda. Silakan hubungi Dosen PA anda untuk melakukan unapprove!',
					type: 'error'
				});
			} else {
				$.post({
					url: url,
					data: {
						_token: token,
						krs: krs
					},
					success: function(data) {
						if (data == 'dilarang') {
							swal({
								title: 'Error!',
								text: 'Anda tidak dapat menghapus matakuliah ini karena telah di-approve oleh Dosen PA anda. Silakan hubungi Dosen PA anda untuk melakukan unapprove!',
								type: 'error'
							});
						} else if (data == 'sukses') {
							console.log(mk_tawaran);

							jml_sks -= parseInt(krs_regis[hps_index].sks);
							$.each(mk_tawaran, function(i, val) {
								if (val['kelas'] == kelas && val['kode'] == kode) {
									mk_tawaran[i].is_dipilih = 0;
									return false;
								}
							});
							krs_regis.splice(hps_index, 1);
							$('#sks-sekarang').html(jml_sks);
							update_table_row();
							update_mktawar_table();
							console.log(mk_tawaran);
							swal({
								title: 'Sukses!',
								text: 'Sukses menghapus matakuliah dari daftar registrasi anda!',
								type: 'success'
							});
						} else {
							swal({
								title: 'Peringatan!',
								text: 'Sistem tidak merespon, silakan hubungi pihak berwajib',
								type: 'warning'
							});
						}
					},
					error: function() {
						alert('error');
					}
				});
			}
		}
	);
}
