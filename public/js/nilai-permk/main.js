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

function get(){
	$(TABLE).DataTable().destroy();
	let btn = '#btn-filter';
	let temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');
	$(TABLE + ' tbody').html(TB_LOADER);

	var form = $('#form-filter').serialize();
	var url = $('#form-filter').attr('action') + '?' + form;

	$.get({
		url:url,
		success:function(data){
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

	var form = $('#form-search').serialize();
	let url = $('#form-search').attr('action') + '?' + form;
	$.get({
		url : url,
		success:function(data){
			// $(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable({'autoWidth':false});
		}, 
		error:function(data){
			$(TABLE + ' tbody').html('');
			$(TABLE).DataTable({'autoWidth':false});
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