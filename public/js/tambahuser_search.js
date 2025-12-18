var btn_loader = '<span class="btn-label"><i class="fa fa-spinner fa-spin"></i></span> sedang memuat..';
var btn_temp = '';
var btn = '';
var tempUser = {};

function cleanSearchResult(){
	$('#identifier-result').html('-');
	$('#ktp-result').html('-');
	$('#name-result').html('-');
	$('#dob-result').html('-');
	$('#email-result').html('-');
}

$('#btn-modal-close').click(function(){
	cleanSearchResult();
	$('#modal-select-user').modal('toggle');
});

$('#txtSearchProdAssign').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    $('input[name = butAssignProd]').click();
    return false;  
  }
});

$('#btn-save-user').click(function(){
	$("#selected-identifier").val(tempUser.identifier);
	$("#selected-name").val(tempUser.name);
	$("#selected-email").val(tempUser.email);
	$("#selected_prodi_id").val(tempUser.prodi_id);
	$("#selected_fakultas_id").val(tempUser.fakultas_id);

	$('#modal-select-user').modal('toggle');
});

$('#btn-searchuser').click(function(){
	cleanSearchResult();
	$('#modal-select-user').modal('show');
	getPaketMenu();
});


function getPaketMenu(){
	var id = $('#jenisuser').val();
	$('#paketmenu').html('<option>mohon tunggu</option>');
	$.get({
		url:'/api/pembagianApp/' + id + '/paketmenu',
		success:function(data){
			if (data.status == true) {
				var option = '<option><< pilih paket menu >></option>';
				$.each(data.msg, function(i, val){
						option += '<option value="'+ val.paketmenu_id +'">'+ val.nama_paketmenu +'</option>'
				});

				$('#paketmenu').html(option);
			}else{
				$('#paketmenu').html('<option>response tidak diketahui</option>');
			}
		},
		error:function(data){
			$('#paketmenu').html('<option>terjadi kesalahan saat mengambil paket menu</option>');
		}
	})
}


$('#btn-search').click(function(){
	cleanSearchResult();

	$('#input-identifier').attr('class', 'form-group');
	$("#err-identifier").html('');
	btn = this;
	btn_temp = $(this).html();
	$(this).html(btn_loader);
	$(this).attr('disabled', '');
	var identifier = $('#identifier').val();
	var jenisuser = $('#jenisuser').val();

	if (identifier == '') {
		return;
	}

	$.get({
		url: '/admin/akun/tambah/api/getUser',
		data:{
			identifier: identifier,
			jenisuser:jenisuser
		},
		success:function(data){
			if (data['code'] == 200) {
				console.log(data);
				$('#identifier-result').html(data['result']['identifier']);
				$('#ktp-result').html(data['result']['no_ktp']);
				$('#name-result').html(data['result']['nama']);
				$('#dob-result').html(data['result']['tanggal_lahir']);
				$('#email-result').html(data['result']['email']);
				$('#selected_prodi_id').val(data['result']['prodi_id']);
				$('#selected_fakultas_id').val(data['result']['fakultas_id']);

				tempUser.identifier = data['result']['identifier'];
				tempUser.ktp = data['result']['no_ktp'];
				tempUser.name = data['result']['nama'];
				tempUser.dob = data['result']['tanggal_lahir'];
				tempUser.email = data['result']['email'];
				tempUser.prodi_id = data['result']['prodi_id'],
				tempUser.fakultas_id = data['result']['fakultas_id']
				}
			$(btn).html(btn_temp);
			$(btn).removeAttr('disabled');
		},
		error:function(data){
			data = data.responseJSON;
			if (data['code'] == 500) {
				$("#err-identifier").html(data['msg']);
				$('#input-identifier').attr('class', $('#input-identifier').attr('class') + ' has-danger');
			}
			$(btn).html(btn_temp);
			$(btn).removeAttr('disabled');
		}
	});
});