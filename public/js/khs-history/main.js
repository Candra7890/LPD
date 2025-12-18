var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span>memproses..';
var TB_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memproses...</p></td></tr>';
var TABLE = '#table';


$(document).ready(function(){
	$('.select2').select2();
	$(TABLE).DataTable();
	get();
})

$('.btn-switch').click(function(){
	$('#form-filter').toggle();
	$('#form-search').toggle();
})

function get(formId = '#form-filter'){
	$(TABLE).DataTable().destroy();
	let btn = '#btn-filter';
	let temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');
	$(TABLE + ' tbody').html(TB_LOADER);

	var form = new FormData($(formId)[0]);
	$.post({
		url : $(formId).attr('action'),
		data:form,
		contentType:false,
		processData:false,
		success:function(data){
			// $(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({'autoWidth':false});
		}, 
		error:function(data){
			data = data.responseJSON;
			let msg = '';
			if (data.status != '' && data.status == false) {
				msg = data.msg;
			}else{
				msg = 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.'
			}

			$(TABLE + ' tbody').html('<tr><td colspan="10"><p class="text-center">'+msg+'</p></td></tr>');
		},
		complete:function(){
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
}

$('#btn-filter').click(function(){
	get();
})

$('#btn-search').click(function(){
	$(TABLE).DataTable().destroy();
	let btn = this;
	let temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');
	$(TABLE + ' tbody').html(TB_LOADER);

	let formId = '#form-search';
	var form = new FormData($(formId)[0]);
	$.post({
		url : $(formId).attr('action'),
		data:form,
		contentType:false,
		processData:false,
		success:function(data){
			// $(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({'autoWidth':false});
		}, 
		error:function(data){
			data = data.responseJSON;
			let msg = '';
			if (data.status != '' && data.status == false) {
				msg = data.msg;
			}else{
				msg = 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.'
			}

			$(TABLE + ' tbody').html('<tr><td colspan="10"><p class="text-center">'+msg+'</p></td></tr>');
		},
		complete:function(){
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
})

$(document).on('click', '.btn-khs', function(e){
	e.preventDefault();
	let id = $(this).data('id');
	let row = $(this).closest('tr').find('td');

	$("#modal .modal-title").html('permintaan khs ' + row[1].innerHTML);
	$('#modal').modal('show');
	$('#modal .modal-body').html(TB_LOADER);

	$.get({
		url: window.location.pathname,
		data:{
			service:1,
			mid:id
		},
		success:function(data){
			$('#modal .modal-body').html(data);
		},
		error:function(data){
			$('#modal .modal-body').html('Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.');
		}
	})
})