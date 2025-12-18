var loader = '<span class="btn-label"><i class="fa fa-spinner fa-spin"></i></span> ...';
var tableLoader = ' <tr><td colspan="4"><p style="text-align: center;"><span class="fa fa-spinner fa-spin"></span> Sedang mengambil data...</p></td></tr>';
var tableError = ' <tr><td colspan="4"><p style="text-align: center;" class="text-danger">terjadi error saat mengambil data.</p></td></tr>';
var temp = '';
var tableBody = '#tipeuser_broker';
var table = '#table-tipeuser';
var tempButtonId = '';
var msgErrorNoBrokerRole = '<small class="text-danger"><span class="ti-face-sad"></span> tidak ada data role</small>';
var msgErrorConnection = '<small class="text-danger"><span class="ti-face-sad"></span> terjadi error koneksi database. jika error ini terus terjadi silakan hubungi pihak berwajib.</small>'
var msgLoaderGetBrokerRole = '<span class="fa fa-spinner fa-spin"></span> sedang mengambil data role broker...';
var brokerRoleDIV = '#broker_role';
var requestError = 'Terjadi error saat menyimpan. Jika error ini terus terjadi silakan hubungi pihak berwajib';
var LAST_PAKETMENU = 0;
var LAST_NAMAPAKETMENU = '';
var PAKET_ROW = 0;


$(document).ready(function(){
	// getCurrentFilter();
	getPaketMenu();
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

})

function getPaketMenu(){
	var id = $('#tipeuser').val();
	var tempButtonId = '#btn-filter-paketmenu';
	var temp = $(tempButtonId).html();
	$(tempButtonId).html(loader);
	$(tempButtonId).attr('disabled', '');
	$(tableBody).html(tableLoader);

	$.get({
		url:'/api/pembagianApp/' + id + '/paketmenu',
		success:function(data){
			if (data.status == true) {
				var button;
				var row;
				$.each(data.msg, function(i, val){
					button = '';
					button += '<button class="btn btn-info btn-edit-paketmenu ml-1 mb-1" data-id="'+ val['paketmenu_id'] +'" data-toggle="tooltip" title="Edit Aplikasi pada Paket ini"><i class="ti-pencil-alt"></i></button>';
					button += '<button class="btn btn-danger btn-delete-paketmenu ml-1 mb-1" data-id="'+ val['paketmenu_id'] +'" data-toggle="tooltip" title="Hapus Paket Menu ini"><i class="ti-trash"></i></button>';
					row += '<tr>' +
		                    '<td>'+ (i+1) +'</td>' +
		                    '<td>'+ val['nama_paketmenu'] +'</td>' + 
		                    '<td>'+ button +'</td>' +
		                  '</tr>';
				});
				$(tableBody).html('');
				$(table).DataTable().destroy();
				$(tableBody).html(row);
				$(table).DataTable();
			}else{
				swal("ERROR!", 'Gagal mengambil data paket menu jenis pengguna ini. Response tidak diketahui', 'error');
			}
		},
		error:function(data){
			alert('terjadi kesalahan server');
		},
		complete:function(){
				$(tempButtonId).html(temp);
				$(tempButtonId).removeAttr('disabled');
			}
	})
}


$(document).on('click', '.btn-edit-paketmenu', function(){
	var id = $(this).data('id');
	PAKET_ROW = $(this).closest('tr').find('td'); 
	var nama = PAKET_ROW[1].innerHTML;
	
	LAST_NAMAPAKETMENU = nama;
	LAST_PAKETMENU = id;

	getPaketMenuBroker(id, nama);
})

$(document).on('click', '#btn-back-paketmenubroker', function(){
	getPaketMenuBroker(LAST_PAKETMENU, LAST_NAMAPAKETMENU);
});

function getPaketMenuBroker(id, nama){
	$('#modal-paketmenu .modal-body').html(tableLoader);
	$('#modal-paketmenu').modal('show');
	$('#nama_paketmenu').html(nama);
	$.get({
		url:'/api/pembagianApp/' + id + '/paketmenu/broker',
		success: function(data){
			$('#modal-paketmenu .modal-body').html(data);
			$('#tb-paketmenubroker').DataTable();
		},
		error:function(data){
			eText = data.responseText;
			data = data.responseJSON;
			if (data.status == false) {
				$('#modal-paketmenu .modal-body').html(data.msg);
			}else{
				$('#modal-paketmenu .modal-body').html(eText);
			}
		}
	})
}

function getCurrentFilter(callback = null){
	$(tableBody).html(tableLoader);
	var tipeuser = $("#tipeuser").val();
	var paketmenu = $('select[name=nama_menu]').val();

	var row  = '';
	var role = '';
	var button = '';
	$.get({
		url:'/api/tipeuser/broker',
		data:{
			tipeuser: tipeuser,
			paketmenu:paketmenu
		},
		success: function(data){
			row = '';

			$.each(data, function(i, val){
				role = '';
				button = '';
				button += '<button class="btn btn-info btn-edit ml-1 mb-1" data-id="'+ val['paketmenu_broker_id'] +'" data-toggle="tooltip" title="Edit Hak Akses Broker ini"><i class="ti-pencil-alt"></i></button>';
				button += '<button class="btn btn-danger btn-delete ml-1 mb-1" data-id="'+ val['paketmenu_broker_id'] +'" data-toggle="tooltip" title="Hapus Broker dari tipe pengguna ini"><i class="ti-trash"></i></button>';

				row += '<tr>' +
		                    '<td>'+ (i+1) +'</td>' +
		                    '<td>'+ val['broker']['nama_broker'] +'</td>';

		                    $.each(val['paketmenudetail'], function(key, value){
		                    	role += value['nama_role'] + '<br>';
		                    })

		        row +=	    '<td>'+ role +'</td>' +
		                    '<td>'+ button +'</td>' +
		                  '</tr>';
			});
			$(tableBody).html('');
			$(table).DataTable().destroy();
			$(tableBody).html(row);
			$(table).DataTable();
			if (callback!=null) {
				callback();
			}
		},
		error:function(){
			alert('gagal');
		}
	})

}

function getMenu(){

	var jeniuser = $('#tipeuser').val();

	$.get({
		url:'/api/menu/' + jeniuser,
		beforeSend:function(){
			$('select[name=nama_menu]').html('<option>mohon tunggu...</option>');
		},

		success:function(data){
			if (data.status == true) {
				var opt = '';
				$.each(data.msg, function(i, val){
					opt += '<option value="'+ val.paketmenu_id +'">'+ val.nama_paketmenu +'</option>'
				})

				$('select[name=nama_menu]').html(opt);
			}
		}, error:function(){
			$('select[name=nama_menu]').html('<option>terjadi error server</option>');
		}
	})
}


$('#btn-filter-paketmenu').click(function(){
	getPaketMenu();
})

// Toggle view 
$('.btn-toggle').click(function(){
	var url = window.location.href;
	var id = url.lastIndexOf('#');
	var content = url.substr(id+1, url.length);
	var tipeuserLihat = $('#tipeuser').val();
	var tipeuserTambah = $('#tipeuser_tambah').val();

	console.log('lihat '+tipeuserLihat);
	console.log('tambah '+tipeuserTambah);
	if (content == 'config') {
		$('#tipeuser option[value="' + tipeuserTambah +'"]').prop("selected", true);
		getCurrentFilter();
	}else if(content == 'lihat'){
		$('#tipeuser_tambah option[value="' + tipeuserLihat +'"]').prop("selected", true);
	}

	$('#atur').toggle();
	$('#view').toggle();
})
// 

$('#broker').change(function(){
	var broker = $('#broker').val();
	var role = '';
	$(brokerRoleDIV).html(msgLoaderGetBrokerRole);

	$.get({
		url: '/api/broker/'+broker+'/role',
		success:function(data){
			if (data == '') {
				$(brokerRoleDIV).html(msgErrorNoBrokerRole);
				return;
			}

			$.each(data, function(i, val){
				program = (val['program_id'] == null) ? '-' : val['program_id'];
				prodi = (val['prodi_id'] == null) ? '-' : val['prodi_id'];
				fakultas = (val['fakultas_id'] == null) ? '-' : val['fakultas_id'];

				var value = val['role_id'] +'|'+ val['role_name'] + '|' + program + '|' + prodi + '|' + fakultas;
				role += '<input type="checkbox" name="role[]" value ="'+ value +'" id="role'+ i +'" class="filled-in chk-col-light-blue">';
				role += '<label for="role'+ i +'">'+ val['role_name'] +'</label><br>';
			});

			$(brokerRoleDIV).html(role);
		},
		error:function(){
			$(brokerRoleDIV).html(msgErrorConnection);
		}
	})
})

function postAturanPembagianAplikasi(tipeuser, broker, role, token, ignore = 0){
	$.post({
		url: '/admin/pembagianApp',
		data:{
			tipeuser: tipeuser,
			broker:broker,
			role:role,
			_token:token,
			ignore:ignore
		},
		success:function(data){
		if (data['code'] == 201) {
			swal({   
          title: "Oops..",   
          text: data['message'] + ". Lanjutkan?",   
          type: "warning",   
          showCancelButton: true,   
          confirmButtonColor: "#DD6B55",   
          confirmButtonText: "Ya, lanjutkan",
          showLoaderOnConfirm: true,
          closeOnConfirm: false 
      }, function(){   
          postAturanPembagianAplikasi(tipeuser, broker, role, token, 1);
      	});
			}else if (data['code'] == 200) {
				 swal("Yes!", data['message'], "success");
				 // window.location = "/admin/pembagianApp";
			}else{
				swal("Oops", "Sistem tidak merespon", "warning");
			}
			$(tempButtonId).html(temp);
			$(tempButtonId).removeAttr('disabled');
		},
		error:function(data){
			swal("Nooo", requestError, "error");
			$(tempButtonId).html(temp);
			$(tempButtonId).removeAttr('disabled');
		}
	})
	
}


$('#btn-store').click(function(){

	var tipeuser = $("#tipeuser_tambah").val();
	var broker = $('#broker').val();
	var role =  $("#broker_role input:checkbox:checked").map(function(){
      return $(this).val();
    }).get();

  var token = $("input[name=_token]").val();

  if (tipeuser == '' || broker == '' || role == '') {
  	swal("Oops..", 
  		"Belum semua kolom terisi. Periksa kembali kolom yg anda masukkan dan pastikan semua terisi.", 
  		"warning");
 	}else{
		// loader
		temp = $(this).html();
		tempButtonId = this;
		var button = this;
		$(tempButtonId).html(loader);
		$(tempButtonId).attr('disabled', '');
		// 
 		postAturanPembagianAplikasi(tipeuser, broker, role, token);
 	}
})

// delete the rule
$(document).on('click', ".btn-delete-paketmenubroker", function() {
	var id = $(this).data('id');
	var token = $("input[name=_token]").val();

	swal({   
      title: "PERHATIAN?",   
      text: "Apakah anda yakin ingin menghapus aplikasi ini dari paket menu ini?",   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, hapus",
      showLoaderOnConfirm: true,
      closeOnConfirm: false 
  }, function(){   
      $.post({
      	url: '/api/pembagianApp/delete',
      	data:{
      		id:id,
      		_token:token
      	},
      	success:function(data){
      		if (data['code'] == 200) {
      			swal('Yess!', data['message'], 'success');
						getPaketMenuBroker(LAST_PAKETMENU, LAST_NAMAPAKETMENU);
      		}else{
						swal("ERROR!", 'Response server tidak diketahui', 'error');
					}
      	},
      	error:function(){
      		swal('Noo!', requestError, 'error');
      	}
      })
  });
});
// 

$(document).on('click', '.btn-edit-paketmenubroker', function(){
	var id = $(this).data('id');
	$('#modal-paketmenu .modal-body').html(tableLoader);

	$.get({
			url: '/api/pembagianApp/'+id,
			success: function(data){
				$('#modal-paketmenu .modal-body').html(data);
			},
			error:function(){
				$('#modal-paketmenu .modal-body').html('Terjadi kesalahan server');
			}
	})
})

// get information about the rule
$(document).on('click', ".btn-edit", function() {
	$('#modal-edit #modal-loader').html('<p style="text-align: center;"><span class="fa fa-spinner fa-spin"></span> Sedang mengambil data...</p>');
	$('#modal-loader').show();
	$('#edit-body').hide();
	$('#modal-edit-title').html('');

	var id = $(this).data('id');
	$('#edit-id').val(id);
	var checkbox = '';
	var checked = '';
	$("#modal-edit").modal('show');
	$.get({
			url: '/api/pembagianApp/'+id,
			success: function(data){
				checkbox = '';
				if (data['code'] == 200) {
					
					$('#modal-edit-title').html(data['broker']['broker']['nama_broker']);
					$('#edit-broker').val(data['broker']['broker']['nama_broker']);
					$.each(data['brokerRole'], function(i, val){
						checked = '';
						$.each(data['broker']['paketmenudetail'], function(key, value){
							if (value['brokerrole_id'] == val['role_id']) {
								checked = 'checked=""';
								return false;
							}
						})
						
						program = (val['program_id'] == null) ? '-' : val['program_id'];
						prodi = (val['prodi_id'] == null) ? '-' : val['prodi_id'];
						fakultas = (val['fakultas_id'] == null) ? '-' : val['fakultas_id'];

						var value = val['role_id'] +'|'+ val['role_name'] + '|' + program + '|' + prodi + '|' + fakultas;

						checkbox += '<input type="checkbox" name="edit_role[]" value ="'+ value +'" id="role'+ i +'" class="filled-in chk-col-light-blue" '+ checked +'>';
						checkbox += '<label for="role'+ i +'">'+ val['role_name'] +'</label><br>';
					});
					$('#edit-broker-role').html(checkbox);
					$('#modal-loader').toggle();
					$('#edit-body').toggle();

				}
			},
			error:function(){
				$('#modal-edit #modal-loader').html('<p style="text-align: center;" class="text-danger">tidak dapat mengambil data priviledge ini.</p>');
			}
	})
});
// 

$(document).on('click', '#btn-store-edit', function(){
	var id = $('#edit-id').val();
	var role = $("#edit-broker-role input:checkbox:checked").map(function(){
      return $(this).val();
    }).get();
	var token = $("input[name=_token]").val();

	temp = $(this).html();
	tempButtonId = this;
	$(tempButtonId).html(loader);
	$(tempButtonId).attr('disabled', '');

	$.post({
		url:'/api/pembagianApp/edit',
		data:{
			_token:token,
			id:id,
			role:role,
			paketmenu: $('select[name=nama_menu]').val()
		},
		success:function(data){
			if (data['code'] == 200) {
				$(tempButtonId).html(temp);
				$(tempButtonId).removeAttr('disabled');

				swal('Yess..', data['message'], 'success');
				getPaketMenuBroker(LAST_PAKETMENU, LAST_NAMAPAKETMENU);
			}
		},
		error:function(){
			$(tempButtonId).html(temp);
			$(tempButtonId).removeAttr('disabled');
			swal('Noo..', 'Terjadi kesalahan input atau server', 'error');
		}
	})
})


$(document).on('click', '#btn-paketmenubroker-add', function(){
	var paketmenu = $('select[name=nama_menu]').val();
	$('#modal-paketmenu .modal-body').html('<p style="text-align: center;"><span class="fa fa-spinner fa-spin"></span> Sedang mengambil data...</p>');

	$.get({
		url:'/api/pembagianApp/tambah/' + LAST_PAKETMENU,
		success:function(data){
			$('#modal-paketmenu .modal-body').html(data);
			$('select[id=broker_add]').select2();
		},
		error:function(){
			$('#modal-paketmenu .modal-body').html(tableError);
		}
	})
})


$(document).on('click', '#btn-store-newbroker', function(){
	var form = new FormData($('#form-newbroker')[0]);
	var url = $('#form-newbroker').attr('action');

	$.post({
		url:url,
		contentType: false,
		processData: false,
		data:form,
		success:function(data){
			if (data.status == true) {
				swal("SUKSES!", data.msg, 'success');
				getPaketMenuBroker(LAST_PAKETMENU, LAST_NAMAPAKETMENU);
			}else{
				swal("ERROR!", 'Response server tidak diketahui', 'error');
			}
		},
		error:function(data){
			data = data.responseJSON;
			if (data.status == false) {
				swal("ERROR!", data.msg, 'error');
			}else{
				swal("ERROR!", 'Terjadi error pada server', 'error');
			}
		}
	})
})

$(document).on('click', '#btn-tambah-paketmenu', function(){
	$('#modal-tambah-paketmenu').modal('show');
	$('#modal-tambah-paketmenu .modal-body').html(tableLoader);
	var id = $('#tipeuser').val();

	$.get({
		url:'/api/pembagianApp/paketmenu/'+ id + '/tambah',
		success:function(data){
			$('#modal-tambah-paketmenu .modal-body').html(data);
			$('#paketmenu-add').select2();
		},
		error:function(){
			$('#modal-tambah-paketmenu .modal-body').html('<span class="text-danger">gagal mendapatkan data dari server</span>');
		}
	})
})

$(document).on('click', '#btn-store-paketmenu', function(){
	var form = new FormData($('#form-addpaketmenu')[0]);
	var url = $('#form-addpaketmenu').attr('action');
	var btn = this;
	var temp;
	$.post({
		url: url,
		data:form,
		contentType:false,
		processData:false,
		beforeSend:function(){
			temp = $(btn).html();
			$(btn).html(loader);
			$(btn).attr('disabled', '');
		},
		success:function(data){
			if (data.status == true) {
				swal('SUKSES!', data.msg , 'success');
				$('#modal-tambah-paketmenu').modal('toggle');
				getPaketMenu();
			}else{
				swal('ERROR!', 'Response tidak diketahui' , 'error');
			}
		}, error:function(data){
			data = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg , 'error');
			}else{
				swal('ERROR!', 'Terjadi kesalahan saat menyimpan pada server', 'error');
			}
		},complete:function(){
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
})

$(document).on('click', '.btn-delete-paketmenu', function(){
	var id = $(this).data('id');

	swal({   
      title: "PERHATIAN?",   
      text: "Apakah anda yakin ingin menghapus paket menu ini?",   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, hapus",
      showLoaderOnConfirm: true,
      closeOnConfirm: false 
  }, function(){   
      $.post({
      	url: '/api/pembagianApp/paketmenu/delete',
      	data:{
      		id:id,
      	},
      	success:function(data){
      		if (data.status == true) {
      			swal('SUKSES!', data.msg, 'success');
						getPaketMenu();
      		}else{
						swal("ERROR!", 'Response server tidak diketahui', 'error');
					}
      	},
      	error:function(data){
      		data.responseJSON;
      		if (data.status == true) {
      			swal('ERROR!', data.msg, 'error');
      		}else{
      			swal('ERROR!', 'Terjadi kesalahan sistem saat menghapus paket menu ini.', 'error');
      		}
      	}
      })
  });
})

$(document).on('click', '#btn-simpan-nama', function(){
	let form = new FormData($('#form-nama-paket')[0])

	let btn = this;
	$(btn).html('menyimpan...')
	$(btn).attr('disabled', '')

	$.post({
		url:'/api/pembagianApp/paketmenu/update',
		data:form,
		contentType:false,
		processData:false,
		success:function(data){
			if (data.status == true) {
				PAKET_ROW[1].innerHTML = form.get('nama_paket');
				$('#nama_paketmenu').html(form.get('nama_paket'));
			}
		},
		complete:function(){
			$(btn).html('Simpan')
			$(btn).removeAttr('disabled')
		}
	})
})