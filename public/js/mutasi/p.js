var TABLE = '#tb-permohonan';
var MDL_LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memproses...</p>'
var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span> sedang memproses...'
var TABLE_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';
var MUTASI = 0;

$(document).ready(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(TABLE).DataTable({'autoWidth' : false});
	view();
})

function view(){
	let form = new FormData($('#filter')[0]);
	let url = $("#filter").attr('action');
	$(TABLE + ' tbody').html(TABLE_LOADER);

	$.post({
		url:url,
		data:form,
		contentType:false,
		processData:false,
		success:function(data){
			$(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({'autoWidth' : false});
		},
		error:function(data){
			data = data.responseJSON;
			let msg;
			if (data.status == false) {
				msg = data.msg
			}else{
				msg = 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.'
			}

			$(TABLE + ' tbody').html('<tr><td colspan="8"><p class="text-center">'+msg+'</p></td></tr>')
		
		}
	})
}

$('#btn-filter').click(function(){
	view();
})

$(document).on('click', '.btn-status', function(){
	MUTASI = $(this).data('id');
	let status = $(this).data('stts');

	$('select[name=status_update] option[value=' + status + ']').prop('selected', true);
	$('#modal-status').modal('show');
})

$('#btn-simpan-status').click(function(){
	var newStatus = $('select[name=status_update]').val();
	var btn = this;

	let temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');
	$.post({
		url: '/mutasi/updateStatus',
		data:{
			id:MUTASI,
			new:newStatus
		},
		success:function(data){
			if (data.status == true) {
				swal('SUKSES!', data.msg, 'success');
				$('#modal-status').modal('toggle');
				view();
			}else{
				swal('ERROR!', 'Response sistem tidak diketahui.', 'error');
			}
		},
		error:function(data){
			data = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			}else{
				swal('ERROR!', 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi', 'error');
			}
		},
		complete:function(){
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
})

$(document).on('click', '.btn-revisi', function(){
	MUTASI = $(this).data('id');
	$('#modal-revisi').modal('show');
})

$('#btn-simpan-revisi').click(function(){
	let revisi = $('textarea[name=revisi]').val();
	let btn = this;
	let temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');

	$.post({
		url: '/mutasi/storeRevisi',
		data:{
			id:MUTASI,
			revisi:revisi
		},
		success:function(data){
			if (data.status == true) {
				swal('SUKSES!', data.msg, 'success');
				$('#modal-revisi').modal('toggle');
				view();
			}else{
				swal('ERROR!', 'Response sistem tidak diketahui.', 'error');
			}
		}, error:function(data){
			data = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			}else{
				swal('ERROR!', 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi', 'error');
			}	
		},
		complete:function(){
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
})

$(document).on('click', '.btn-sh-revisi', function(e){
	e.preventDefault();
	let id = $(this).data('id');

	MUTASI = id;
	loadRevisi(id);
})

function loadRevisi(id){
	$('#modal').modal('show');
	$('#modal .modal-title').html('REVISI');
	$('#modal .modal-body').html(MDL_LOADER);


	$.get({
		url: '/mutasi/' + id + '/revisi',
		success:function(data){
			$('#modal .modal-body').html(data);	
			$('#tb-revisi').DataTable({'autoWidth':false});		
		},
		error:function(data){
			data = data.responseJSON;
			let msg = '';
			if (data.status == false) {
				msg = data.msg;
			}else{
				msg = 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.'
			}

			$('#modal .modal-body').html('<p class="text-center">'+ msg +'</p>');
		}
	})
}

$(document).on('click', '.btn-revisi-delete', function(){
	let id = $(this).data('id');
	
	swal({   
            title: "PERHATIAN!",   
            text: "Apakah anda yakin ingin menghapus revisi ini?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Ya, hapus revisi!",   
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function(){   
        	 $.post({
        	 	url: '/mutasi/deleteRevisi',
        	 	data:{
        	 		id:id
        	 	},
        	 	success:function(data){
        	 		if (data.status == true) {
        	 			swal('SUKSES!', data.msg, 'success');
        	 			loadRevisi(MUTASI);
        	 			view();
        	 		}else{
						swal('ERROR!', 'Response sistem tidak diketahui.', 'error');
					}
        	 	},
        	 	error:function(data){
        	 		data = data.responseJSON;
					if (data.status == false) {
						swal('ERROR!', data.msg, 'error');
					}else{
						swal('ERROR!', 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi', 'error');
					}	
        	 	}
        	 })
        });
})

