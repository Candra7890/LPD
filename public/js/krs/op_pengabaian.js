var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span> sedang memproses...';

$(document).ready(function(){
	get_current_selected_option();
})

$('#btn-search-mhs').click(function(){
	get_current_selected_option();
})
function get_current_selected_option(){
	$('#table-reg').hide();
	$('#container-loader').show();
	var tahunajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var prodi_id = $('#prodi').val();
	var angkatan = $('#angkatan').val();
	var program = $('#program').val();
	var token = $('input[name=_token]').val();


	$.post({
		url: '/pengabaiansyarat/get',
		data:{
			prodi:prodi_id,
			angkatan:angkatan,
			program:program,
			_token:token,
			tahunajaran:tahunajaran,
			semester:semester
		},
		success:function(data){
			// console.log(data);
			var row = '';
			var jml_sks = '';
			var syarat_mk = '';
			var prasyarat_sks = '';
			var button = '';

			$.each(data, function(i, val){
				jml_sks = (val['jml_sks'] == null) ? '<span class="badge badge-danger">Sesuai Standar</span>' : '<span class="badge badge-success">'+ val['jml_sks'] +'</span>';
				syarat_mk = (val['syarat_mk'] == 0 || val['syarat_mk'] == null) ? '<span class="badge badge-danger">Tidak</span>' : '<span class="badge badge-success">Ya</span>';
				prasyarat_sks = (val['prasyarat_sks'] == 0 || val['prasyarat_sks'] == null) ? '<span class="badge badge-danger">Tidak</span>' : '<span class="badge badge-success">Ya</span>';
				button = '<button class="btn btn-info btn-sm waves-effect waves-light mr-1" data-toggle="tooltip" title="Tambah Pengabaian" onclick="exception('+ (i+1) +', '+ val['mahasiswa_id'] +','+ val['pengabaian_id'] +')"><span class="mdi mdi-bookmark-plus"></span></button>';
				if (val['pengabaian_id'] != null) {
					button = '<button type="button" class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="tooltip" title="Hilangkan Pengabaian" onclick="disable('+ val['pengabaian_id'] +')"><span class="mdi mdi-delete"></span></button>'
				}
				row += '<tr>' +
                  '<td>'+ 
                  	(i+1) +
                  '</td>' +
                  '<td>'+ val['nim'] + '</td>' +
                  '<td>'+ val['nama'] +'</td>'+
                  '<td>'+ jml_sks +'</td>'+
                  '<td>'+ syarat_mk +'</td>'+
                  '<td>'+ prasyarat_sks +'</td>'+
                  '<td>'+ button +'</td>'+
                '</tr>';
			});
			$('#container-loader').hide();
			$('#table-registrasi').DataTable().destroy();
			$('#krs-mhs').html(row);
			$('#table-registrasi').DataTable();
			$('#table-reg').show();
		},
		error:function(){
			alert('error');
		}
	})
}

function exception(index, mhs, pid){
	var nama = $('#table-registrasi tr').eq(index).find('td').eq(2).html();

	$('#nama_mhs').val(nama);
	$('#mid').val(mhs);
	$('#pid').val(pid);
	$('#modal-exception').modal('show');
}

function disable(pid){
	$('#pid-del').val(pid);
	var form = new FormData($('#pengabaian-del')[0]);
	var url = $('#pengabaian-del').attr('action');

	swal({   
      title: "PERHATIAN?",   
      text: "Apakah anda yakin ingin menghapus pengabaian syarat mahasiswa ini?",   
      type: "warning",   
      showCancelButton: true, 
      cancelButtonText: 'Batal',
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, hilangkan!",   
      closeOnConfirm: false,
      showLoaderOnConfirm: true,
  },function(){
      $.post({
        url:url,
        data: form,
        contentType:false,
        processData:false,

        success:function(data){
          if (data.status == true) {
            swal('SUKSES!', data.msg, 'success');
            get_current_selected_option();
          }else{
          	swal('ERROR!', "Sistem tidak merespon", 'error');
          }
        },
        error: function(data){
        	var text = data.responseText;
			  	data = data.responseJSON;

			  	if (data.status == false) {
		    		swal('ERROR!', data.msg, 'error');
		    	}else{
		    		swal('ERROR!', data.message, 'error');
		    	}
        }
      });
    }
  );
}

$('#btn-simpan-pengabaian').click(function(){
	var form = new FormData($('#form-pengabaian')[0]);

	var url = $('#form-pengabaian').attr('action');

	var btn = this;
	var temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');

	$.post({
		url:url,
		data:form,
		contentType: false,
    processData: false,
    success:function(data){
    	if (data.status == true) {
    		$('#modal-exception').modal('toggle');
    		swal('SUKSES!', data.msg, 'success');
    		get_current_selected_option();
    	}else{
    		swal('ERROR!', "Sistem tidak merespon", 'error');
    	}
    }, error:function(data){
    	var text = data.responseText;
    	data = data.responseJSON;

    	if (data.status == false) {
    		swal('ERROR!', data.msg, 'error');
    	}else{
    		swal('ERROR!', data.message, 'error');
    	}
    },
    complete:function(){
    	$(btn).html(temp);
			$(btn).removeAttr('disabled');
    }
	})
})