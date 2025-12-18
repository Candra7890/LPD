var LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p>';
var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span> memproses...';
var TABLE = '#tb-permohonan';
var TABLE_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';

$(document).ready(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(TABLE).DataTable();
	getPermohonan();
})

$('#btn-tambah-permohonan').click(function(){
	$('#modal-tambah .modal-body').html(LOADER);
	$('#modal-tambah .modal-title').html('tambah permohonan');
	$('#modal-tambah').modal('show');

	$.get({
		url:'/pindahprogram/tambah',
		success:function(data){
			$('#modal-tambah .modal-body').html(data);
		}, error:function(data){
			data = data.responseJSON;
			if (data.status == false) {
				$('#modal-tambah .modal-body').html('<p class="text-center text-danger">'+ data.msg +'</p>');
			}else{
				$('#modal-tambah .modal-body').html('<p class="text-center text-danger">Terjadi kesalahan sistem. Jika error ini terus terjadi silakan hubungi pihak terkait.</p>');
			}
		}
	})
})

$(document).on('click', '#btn-submit-permohonan', function(){
	var form = new FormData($('#form-permohonan')[0]);
	var url = $('#form-permohonan').attr('action');

	var btn = this;
	var temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');

	$.post({
		url:url,
		contentType:false,
		processData:false,
		data:form,
		success:function(data){
			if (data.status == true) {
				swal("SUKSES!", data.msg, 'success');
				$('#modal-tambah').modal('toggle');
				getPermohonan();
			}else{
				swal("ERROR!", 'Response tidak diketahui.', 'error');
			}
		}, error:function(data){
			data = data.responseJSON;
			if (data.status == false) {
				swal("ERROR!", data.msg, 'error');
			}else{
				swal("ERROR!", 'Terjadi kesalahan sistem. Silakan hubungi pihak terkait.', 'error');
			}
		},
		complete:function(){
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
})

function getPermohonan(){
	$(TABLE + ' tbody').html(TABLE_LOADER);

	$.get({
		url:'/pindahprogram/get',
		success:function(data){
			$(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable();
		}, error:function(){
			$(TABLE + ' tbody').html('<tr><td colspan="10"><p class="text-center text-danger">Unable to load data due to system error</p></td></tr>');
		}
	})
}

$(document).on('click', '.btn-edit', function(){
	$('#modal-tambah .modal-body').html(LOADER);
	$('#modal-tambah .modal-title').html('edit permohonan');
	$('#modal-tambah').modal('show');

	var id = $(this).data('id');
	url = '/pindahprogram/show/' + id;
	$.get({
		url:url,
		success:function(data){
			$('#modal-tambah .modal-body').html(data);
		}, error:function(data){
			data = data.responseJSON;
			if (data.status == false) {
				$('#modal-tambah .modal-body').html('<p class="text-center text-danger">'+ data.msg +'</p>');
			}else{
				$('#modal-tambah .modal-body').html('<p class="text-center text-danger">Terjadi kesalahan sistem. Jika error ini terus terjadi silakan hubungi pihak terkait.</p>');
			}
		}
	})
})

$(document).on('click', '.btn-delete', function(){
	
	var id = $(this).data('id');
	swal({   
      title: "PERHATIAN!",   
      text: "Apakah anda yakin ingin menghapus permohonan ini?",   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, Hapus!",   
      closeOnConfirm: false,
      showLoaderOnConfirm:true
  }, function(){   
      url = '/pindahprogram/delete/';
			$.post({
				url:url,
				data:{
					id:id
				},
				success:function(data){
					if (data.status == true) {
						swal("SUKSES!", data.msg, 'success');
						getPermohonan();
					}else{
						swal("ERROR!", 'Response tidak diketahui.', 'error');
					}
				}, error:function(data){
					data = data.responseJSON;
					if (data.status == false) {
						swal("ERROR!", data.msg, 'error');
					}else{
						swal("ERROR!", 'Terjadi kesalahan sistem.', 'error');
					}
				}
			})
  });
	
})