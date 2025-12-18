var loader = '<span class="btn-label"><i class="fa fa-spinner fa-spin"></i></span> mohon tunggu...';

$(document).ready(function(){
	activatedSelectedView();
})

// Toggle view 
$('.btn-toggle').click(function(){
    $('#insert').toggle();
    $('#view').toggle();
})
// 

function toTop(){
    $(window).scrollTop(0);
}

function activatedSelectedView(){
    var url = window.location.href;
    var id = url.lastIndexOf('#');
    var content = url.substr(id+1, url.length);
    
    if (content == 'tambah') {
        $('#insert').show();
    }else if(content == 'lihat'){
        $('#view').show();
    }else{
        $('#insert').show();
    }
}

function deleteThis(e){
	swal({   
    title: "Apakah Anda Yakin?",   
    text: "Data ini akan terhapus secara permanent. Lanjutkan?",   
    type: "warning",   
    showCancelButton: true, 
    cancelButtonText: 'Batal',
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Ya, Hapus!",   
    showLoaderOnConfirm: true,
    closeOnConfirm: false
	},function(){
		$('#bdel').val($(e).data('bid'));
		$('#formdel').submit();
	});
}

function updateThis(e){
	var id = $(e).data('bid');
	var spf = '';
	var gdbkExp = '';
	$('#edit-loader').show();
	$('#edit-content').hide();
	$.get({
		url: '/api/broker/'+id,
		success:function(data){
			console.log(data);
			if (data['code'] == 200) {
				spf = '';
				gdbkExp = '';

				spf = (data['broker']['pengguna_spesifik'] == '-') ? '' : data['broker']['pengguna_spesifik'];
				gdbkExp = (data['broker']['penjelasan_guidebook'] == null || data['broker']['penjelasan_guidebook'] == '') ? '' : data['broker']['penjelasan_guidebook'];
				$('#edit-loader').toggle();
				$('#edit-content').toggle();
				$("#bedit").val(data['broker']['broker_id']);


				$("#nama_broker_edit").val(data['broker']['nama_broker']);
				$("#kode_broker_edit").val(data['broker']['kode_broker']);
				$('#url_broker_edit').val(data['broker']['url']);
				$('#penjelasan_singkat_edit').html(data['broker']['penjelasan_singkat']);
				$('#icon_preview_edit').attr('src', data['brokerIconDir']+'/'+data['broker']['broker_icon']);
				$('#guidebook_exp_edit').html(gdbkExp);
				if (data['broker']['guidebook_broker'] == null || data['broker']['guidebook_broker'] == '') {
					$('#guideLabel').html('<p class="label label-danger">Belum</p>');
				}else{
					$('#guideLabel').html('<p class="label label-success">Sudah</p>');
				}
			}else{
				alert('not responding');
			}
		},
		error:function(){
			alert('gagal');
		}
	})


	var row = $(e).closest('tr').find('td');

	var nama = row[1].innerHTML;
	var URL = row[2].innerHTML;
	var logo = $(e).data('icon');
	var penjelasan = row[3].innerHTML;

	

	$('#modal-edit').modal('show');
}

$("#btn-close-edit").click(function(){
	closeModalEdit();
})

function closeModalEdit(){
	$('#modal-edit').modal('toggle');
	$("#nama_broker_edit").val('');
	$('#url_broker_edit').val('');
	$('#penjelasan_singkat_edit').html('');
	$('#icon_preview_edit').attr('src', '#');
	$('#btn-simpan-edit').html('Simpan');
	$('#btn-simpan-edit').removeAttr('disabled');
}

$('#btn-simpan-edit').click(function(){
	$(this).html('<span class="fa fa-spinner fa-spin"></span> Menyimpan...');
	$(this).attr('disabled', '');
	$('#form-edit').submit();
})

function readURL(input, preview) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $(preview).attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#icon").change(function() {
  readURL(this, '#preview');
});

$('#icon_broker_edit').change(function(){
	readURL(this, '#icon_preview_edit');
})

$('#toggle-edit-icon').click(function(){
	event.preventDefault();
	$('#input-icon').toggle();
});

$('#toggle-edit-guide').click(function(){
	event.preventDefault();
	$('#input-guide').toggle();
});

$('.btn-dbconnection').click(function(){
	var id = $(this).data('bid');
	$('#db_name').val('');
	$('#db_user').val('');
	$('#db_pass').val('');
	$('#db_pass_confirmation').val('');

	var row = $(this).closest('tr').find('td');
	var broker = row[1].innerHTML;

	var btnClass = 'btn btn-block btn-info';
	$('#btn-test-connection').attr('class', btnClass);
	$('#btn-test-connection').html('Tes Koneksi Database');
	$('#bdb').val(id);
	$('#db_nama_broker').html(broker);
	$('#modal-db').modal('show');
});


$('#btn-test-connection').click(function(){
	var ip = $('#db_host').val();
	var db = $('#db_name').val();
	var user = $('#db_user').val();
	var pass = $('#db_pass').val();
	var passConf = $('#db_pass_confirmation').val();
	var token = $('input[name=_token]').val();
	var button = this;

	if (ip == '' || db == '' || user == '' || pass == '' || passConf == '') {
		swal('Oops..', 'Pastikan semua kolom terisi sebelum melakukan testing koneksi', 'warning');
		return;
	}

	if (pass !== passConf) {
		swal('Oops..', 'Password konfirmasi salah', 'warning');
		return;
	}

	$(this).html('testing koneksi...');

	$.post({
		url:"/api/broker/testConnection",
		data:{
			_token:token,
			db_host:ip,
			db_name:db,
			db_user:user,
			db_pass:pass
		},
		success:function(data){
			if (data['code'] == 500) {
				var btnClass = 'btn btn-block btn-danger';
				var btnHtml = '<span class="ti-alert"></span> ' + data['message'] + '. Klik Untuk Tes Kembali';

				$(button).attr('class', btnClass);
				$(button).html(btnHtml);
			}
			else if(data['code'] == 200){
				var btnClass = 'btn btn-block btn-success';
				var btnHtml = '<span class="ti-check"></span> ' + data['message'] + '. Klik Untuk Tes Kembali';

				$(button).attr('class', btnClass);
				$(button).html(btnHtml);
			}
		},
		error:function(){
			swal('Oops..', 'Terjadi masalah server. Silakan hubungi pihak terkait', 'error');
			var btnClass = 'btn btn-block btn-danger';
			var btnHtml = 'terjadi kesalahan server';

			$(button).attr('class', btnClass);
			$(button).html(btnHtml);
		}
	})
})

$('#btn-simpan-db').click(function(){
	var id = $('#bdb').val();
	var ip = $('#db_host').val();
	var db = $('#db_name').val();
	var user = $('#db_user').val();
	var pass = $('#db_pass').val();
	var passConf = $('#db_pass_confirmation').val();
	var token = $('input[name=_token]').val();

	if (ip == '' || db == '' || user == '' || pass == '' || passConf == '') {
		swal('Oops..', 'Pastikan semua kolom terisi sebelum melakukan testing koneksi', 'warning');
		return;
	}

	if (pass !== passConf) {
		swal('Oops..', 'Password konfirmasi salah', 'warning');
		return;
	}

	var temp = $(this).html();
	$(this).html(loader);
	$(this).attr('disabled', '');
	var button = this;

	$.post({
		url: '/api/broker/changeConnection',
		data:{
			_token:token,
			id:id,
			db_host:ip,
			db_name:db,
			db_user:user,
			db_pass:pass
		}, success:function(data){
			console.log(data);
			if (data['code'] == 500) {
				swal('Oops..', data['message'], 'error');
			}else if(data['code'] == 200){
				$('#modal-db').modal('toggle');
				swal('Yess!', data['message'], 'success');
			}

			$(button).html(temp);
			$(button).removeAttr('disabled');
		}, error:function(){
			alert('gagal memasukkan data');
			$(button).html(temp);
			$(button).removeAttr('disabled');
		}
	})
	
})