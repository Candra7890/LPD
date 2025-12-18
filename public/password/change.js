
$('#btn-change').click(function(){
	var form = new FormData($('#form-change')[0]);
	var link = $('#form-change').attr('action');
	var btn = this;
	var temp = $(btn).html();
	$(btn).html('Sedang memproses...');
	$(btn).attr('disabled', '');
// 
	$.post({
		url:link,
		data:form,
		contentType:false,
		processData:false,
		success:function(data){
			if (data.status == true) {
				swal('SUKSES!', data.msg, 'success');
				window.location.href = '/';
			}else{
				swal('ERROR!', 'Response sistem tidak diketahui. Silakan ulangi beberapa saat lagi.', 'error');
			}
		}, error:function(data){
			data  = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			}else{
				swal('ERROR!', 'Terjadi kesalahan server. Silakan ulangi beberapa saat lagi.', 'error');
			}
		}, complete:function(){
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
})