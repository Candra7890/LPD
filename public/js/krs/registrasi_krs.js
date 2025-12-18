var mk_dipilih = [];
var jml_sks = 0;
var batas_sks = 0;
var mk_tawaran = [];

$(document).ready(function() {
	// alert('pok');
	get_mk_ditawarkan();
	// get_krs_mhs();
});

function getUrlParameter(sParam) {
	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : sParameterName[1];
		}
	}
}

function get_ipk_ips(mhs_id) {
	var thn_ajaran = $('#thn_ajaran').val();
	var semester = $('#semester').val();

	$.get({
		url: '/registrasi-krs/hitung-nilai',
		data: {
			mahasiswa_id: mhs_id,
			thn_ajaran: thn_ajaran,
			semester: semester
		},
		success: function(data) {
			console.log(data);

			batas_sks = data['maks_sks'];

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

			$('#maks-sks').html(batas_sks == 99 || batas_sks == '99' ? 'Sistem Paket' : batas_sks);
		},
		error: function() {
			console.log('error mengambil data ipk dan ips');
		}
	});
}

function mapping_dipilih_ditawarkan() {
	// alert('test');
	// console.log(mk_tawaran);
	// console.log(mk_dipilih);
	$.each(mk_dipilih, function(key, dipilih) {
		$.each(mk_tawaran, function(keys, tawaran) {
			if (dipilih.kode == tawaran.kode && dipilih.kelas == tawaran.kelas) {
				mk_tawaran[keys].is_dipilih = 1;
				return false;
			}
		});
	});

	update_mktawar_table();
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
		mk.jadwal = column[6].innerHTML;
		mk.keterangan = null;
		mk.is_approve = 0;
		mk.is_approve_koprodi = 0;

		if (mk_dipilih.length == 0) {
			// jika masih kosong
			insert_new(mk, row);
		} else {
			var sama = 0;
			var mk_old = {};
			var old_index;
			// && val.kelas == mk.kelas
			$.each(mk_dipilih, function(key, val) {
				if (val.kode == mk.kode) {
					// alert(val.kode);
					// jika sama kelas akan diganti

					$.each(mk_tawaran, function(i, val) {
						if (val.kode == mk.kode && val.is_dipilih == 1) {
							mk_old = val;
							old_index = i;
							console.log(mk_old);
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
							showLoaderOnConfirm: true,
							closeOnConfirm: false
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

function insert_new(mk, row) {
	var token = $('input[name=_token]').val();
	var url = '/registrasi-krs/insert';
	var thn_ajaran = $('#thn_ajaran').val();
	var semester = $('#semester').val();
	// alert(abaikan);

	if (jml_sks + parseInt(mk.sks) > batas_sks) {
		swal({
			title: 'Peringatan!',
			text: 'Anda tidak diijinkan untuk menambah matakuliah karena telah melewati batas jumlah SKS',
			type: 'warning'
		});
	} else {
		$('#mktawar-content').hide();
		$('#loader').show();
		$.post({
			url: url,
			data: {
				_token: token,
				tahun_ajaran: thn_ajaran,
				semester: semester,
				mk: mk,
				nim: getUrlParameter('nim')
			},
			success: function(data) {
				$('#loader').hide();
				$('#mktawar-content').show();
				console.log(data);
				if (data[0] == 'sukses') {
					mk_dipilih[mk_dipilih.length] = mk;
					row.attr('bgcolor', '#FFCCBC');
					jml_sks += parseInt(mk.sks);
					$('#sks-sekarang').html(jml_sks);
					$.each(mk_tawaran, function(key, tawaran) {
						if (tawaran.kode == mk.kode && tawaran.kelas == mk.kelas) {
							mk_tawaran[key].is_dipilih = 1;
						}
					});
					update_table_row();
				} else if (data[0] == 'mk_dilarang') {
					var mk_blm_diambil = '';
					$.each(data[1], function(i, val) {
						mk_blm_diambil += '# ' + val['nama_matakuliah'] + '\n, ';
					});
					swal({
						title: 'Peringatan!',
						text: 'Anda tidak dapat menambahkan matakuliah ini karena anda belum mengambil matakuliah syarat berikut: \n' + mk_blm_diambil,
						type: 'warning'
					});
				} else if (data[0] == 'too_much') {
					swal({
						title: 'Peringatan!',
						text: 'Anda tidak dapat menambahkan matakuliah ini karena kelas sudah penuh',
						type: 'warning'
					});
				} else if (data[0] == 'jmlSksViolation') {
					swal({
						title: 'Peringatan!',
						text: 'Anda tidak dapat menambahkan matakuliah ini karena melawati batas sks yang ditentukan',
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
			nim: getUrlParameter('nim')
		},
		success: function(data) {
			if (data == 'sukses') {
				mk_tawaran[old_index].is_dipilih = 0;
				$.each(mk_tawaran, function(key, tawaran) {
					if (tawaran.kode == mk_new.kode && tawaran.kelas == mk_new.kelas) {
						mk_tawaran[key].is_dipilih = 1;
					}
				});
				mk_dipilih[key].kelas = kelas;
				mk_dipilih[key].keterangan = null;
				mk_dipilih[key].is_approve = 0;
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
			swal.close();
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
				'<td>' +
				val.jadwal +
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

function update_table_row() {
	if (mk_dipilih.length >= 0) {
		var row = '';
		var appr = '';
		var apprKo = '';
		var keterangan = '';
		var btn = '<button type="button" data-toggle="tooltip" title="Hapus MK" class="btn btn-danger btn-sm"><span class="mdi mdi-delete"></span></button>';
		$.each(mk_dipilih, function(key, val) {
			appr = val.is_approve == 0 ? '<span class="badge badge-danger">Belum</span>' : '<span class="badge badge-success">Sudah</span>';
			apprKo = val.is_approve_koprodi == 1 ? '<span class="badge badge-success">Sudah</span>' : '<span class="badge badge-danger">Belum</span>';
			keterangan = val.keterangan == null ? 'tidak ada' : val.keterangan;

			row +=
				'<tr style="cursor:pointer;" >' +
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
				'<td>' +
				val.jadwal +
				'</td>' +
				'<td>' +
				keterangan +
				'</td>' +
				'<td>' +
				appr +
				'</td>' +
				'<td>' +
				apprKo +
				'</td>' +
				'<td>' +
				btn +
				'</td>' +
				'</tr>';
		});

		$('#no-krs').remove();
		$('#mk-registrasi').html(row);
		$('#info-del').show();
	}
	// console.log(mk_dipilih);
}

function get_mk_ditawarkan() {
	var url = '/registrasi-krs/get_penawaran_mk';
	$.get({
		url: url,
		data: {
			nim: getUrlParameter('nim')
			// jml_sks: jml_sks
		},
		success: function(data) {
			// console.log(data);
			var row = '';
			var mk = {};
			var selected = '';
			$.each(data, function(key, val) {
				mk = {};
				mk.kode = val['kode_matakuliah'];
				mk.nama = val['nama_matakuliah'] + ' (' + val['program']['nama_program'] + ')';
				mk.sks = val['sks'];
				mk.smt = val['semester'];
				mk.kelas = val['kelas'];
				mk.jadwal = val['hari'] + ', ' + val['jam_mulai'] + '-' + val['jam_berakhir'];
				mk.program = val['program']['nama_program'];
				mk.program_id = val['program_id'];
				mk.is_dipilih = 0;
				mk_tawaran[mk_tawaran.length] = mk;
			});
			get_krs_mhs();

			// $('#modal-set-mk').modal('show');
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

function get_krs_mhs() {
	// alert('jalan');
	var url = '/registrasi-krs/get_krs_mhs';

	$.get({
		url: url,
		data: {
			nim: getUrlParameter('nim')
		},
		success: function(data) {
			// console.log(data);
			if (data == '') {
				$('#no-krs').show();
				$('#mk-registrasi').html('<td colspan="10" class="text-center">' + 'Tidak ada data KRS' + '</td>');
			} else {
				$('#no-krs').remove();
				$('#info-del').show();
				var row = '';
				var appr = '';
				let apprKo = '';
				mk_dipilih = [];
				jml_mk = 0;
				var cttn = '';
				var btn = '<button type="button" data-toggle="tooltip" title="Hapus MK" class="btn btn-danger btn-sm"><span class="mdi mdi-delete"></span></button>';
				$.each(data, function(key, val) {
					var mk = {};

					mk.kode = val['kode_matakuliah'];
					mk.nama = val['nama_matakuliah'];
					mk.sks = val['sks'];
					mk.smt = val['semester'];
					mk.kelas = val['kelas'];
					mk.jadwal = val['hari'] + ', ' + val['jam_mulai'] + '-' + val['jam_berakhir'];
					mk.keterangan = val['keterangan'];
					mk.is_approve = val['is_approve'];
					mk.is_approve_koprodi = val['is_approve_koprodi'];

					jml_sks += val['sks'];

					mk_dipilih[jml_mk] = mk;
					jml_mk++;
					cttn = val['keterangan'] == null ? 'tidak ada' : val['keterangan'];
					appr = val['is_approve'] == 0 ? '<span class="badge badge-danger">Belum</span>' : '<span class="badge badge-success">Sudah</span>';
					apprKo = val['is_approve_koprodi'] == 0 ? '<span class="badge badge-danger">Belum</span>' : '<span class="badge badge-success">Sudah</span>';
					row +=
						'<tr style="cursor: pointer;">' +
						'<td>' +
						(key + 1) +
						'</td>' +
						'<td>' +
						val['kode_matakuliah'] +
						'</td>' +
						'<td>' +
						val['nama_matakuliah'] +
						'</td>' +
						'<td>' +
						val['sks'] +
						'</td>' +
						'<td>' +
						val['semester'] +
						'</td>' +
						'<td>' +
						val['kelas'] +
						'</td>' +
						'<td>' +
						val['hari'] +
						', ' +
						val['jam_mulai'] +
						'-' +
						val['jam_berakhir'] +
						'</td>' +
						'<td>' +
						cttn +
						'</td>' +
						'<td>' +
						appr +
						'</td>' +
						'<td>' +
						apprKo +
						'</td>' +
						'<td>' +
						btn +
						'</td>' +
						'</tr>';
				});
				$('#mk-registrasi').html(row);
				$('#sks-sekarang').html(jml_sks);
			}
			mapping_dipilih_ditawarkan();
		},
		error: function() {
			swal({
				title: 'Error!',
				text: 'Terjadi kesalahan sistem saat mengambil data krs anda!',
				type: 'error'
			});
		}
	});
}

function store_registrasi_krs() {
	var token = $('input[name=_token]').val();
	var url = '/registrasi-krs/save';
	var thn_ajaran = $('#thn_ajaran').val();
	var semester = $('#semester').val();

	$.post({
		url: url,
		data: {
			tahun_ajaran: thn_ajaran,
			semester: semester,
			mk: mk_dipilih,
			_token: token,
			nim: getUrlParameter('nim')
		},
		success: function(data) {
			console.log(data);
			get_krs_mhs();
		}
	});
}

$('#btn-save-reg').click(function() {
	if (mk_dipilih.length == 0) {
		swal({
			title: 'Warning!',
			text: 'Tambahkan matakuliah terlebih dahulu!',
			type: 'warning'
		});
	} else {
		store_registrasi_krs();
	}
});

$('#table-krs tbody').on('click', 'tr', function() {
	var token = $('input[name=_token]').val();
	var url = '/registrasi-krs/delete';
	var thn_ajaran = $('#thn_ajaran').val();
	var semester = $('#semester').val();

	var row = $(this).closest('tr');
	var column = row.find('td');
	var kode = column[1].innerHTML;
	var nama = column[2].innerHTML;
	var kelas = column[5].innerHTML;
	var dilarang = 0;
	var hps_index = '';
	swal(
		{
			title: 'Hapus Mata Kuliah ' + nama + '(' + kelas + ')?',
			text: 'Data akan terhapus secara permanen namun anda dapat kembali memilih matakuliah ini',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Hapus!',
			showLoaderOnConfirm: true,
			closeOnConfirm: false
		},
		function() {
			$.each(mk_dipilih, function(key, val) {
				if (val.kode == kode) {
					hps_index = key;
					return false;
				}
			});

			// console.log(mk_dipilih[hps_index].is_approve);
			// if (mk_dipilih[hps_index].is_approve == 1) {
			//   swal({
			//     title: "Error!",
			//     text: "Anda tidak dapat menghapus matakuliah ini karena telah di-approve oleh Dosen PA anda. Silakan hubungi Dosen PA anda untuk melakukan unapprove!",
			//     type: "error"
			//   });
			// }else{
			$.post({
				url: url,
				data: {
					_token: token,
					tahun_ajaran: thn_ajaran,
					semester: semester,
					kode: kode,
					kelas: kelas,
					nim: $('#nim').val()
				},
				success: function(data) {
					if (data == 'dilarang_koprodi') {
						swal({
							title: 'Error!',
							text: 'Anda tidak dapat menghapus matakuliah ini karena telah di-approve oleh Koordinator Program Studi anda. Silakan hubungi Koordinator Program Studi anda untuk melakukan unapprove!',
							type: 'error'
						});
					} else if (data == 'dilarang') {
						swal({
							title: 'Error!',
							text: 'Anda tidak dapat menghapus matakuliah ini karena telah di-approve oleh Dosen PA anda. Silakan hubungi Dosen PA anda untuk melakukan unapprove!',
							type: 'error'
						});
					} else if (data == 'sukses') {
						jml_sks -= parseInt(mk_dipilih[hps_index].sks);
						$.each(mk_tawaran, function(i, val) {
							if (val['kelas'] == kelas && val['kode'] == kode) {
								mk_tawaran[i].is_dipilih = 0;
								return false;
							}
						});
						mk_dipilih.splice(hps_index, 1);
						$('#sks-sekarang').html(jml_sks);
						update_table_row();
						update_mktawar_table();
						swal({
							title: 'Sukses!',
							text: 'Sukses menghapus matakuliah dari daftar registrasi anda!',
							type: 'success'
						});
					} else {
						swal({
							title: 'Peringatan!',
							text: 'Sistem tidak merespon, silakan hubungi Operator Astamanik',
							type: 'warning'
						});
					}
				},
				error: function() {
					alert('error');
				}
			});
		}
	);
});
