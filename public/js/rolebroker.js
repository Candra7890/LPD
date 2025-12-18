$(document).ready(function(){
    activatedSelectedView();
});

function activatedSelectedView(){
    var url = window.location.href;
    var id = url.lastIndexOf('#');
    var content = url.substr(id+1, url.length);
    
    if (content == 'tambah') {
        $('#insert').show();
    }else if(content == 'lihat'){
        $('#view').show();
    }else{
        $('#view').show();
    }
}

// Toggle view 
$('.btn-toggle').click(function(){
    $('#insert').toggle();
    $('#view').toggle();
})
// 

$('.delete').click(function(){
	$('#brokerdel').val($(this).data('broker'));
$('#roledel').val($(this).data('r'));

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
		$('#formdel').submit();
	});
});

$("select[name=unit]").change(function(){
    $('select[name=subunit]').html('<option>mohon tunggu...</option>')
    var id = $('select[name=unit]').val();
    $.get({

        url:'/api/fakultas/' + id + '/prodi',
        success:function(data){
            if (data['status'] == true) {
                var option = '<option value="">pilih subunit</option>';

                $.each(data.msg, function(i, val){
                    option += '<option value="'+ val.prodi_id +'">'+ val.nama_prodi +'</option>';
                })
                $('select[name=subunit]').html(option);
            }
        }, error:function(){
            $('select[name=subunit]').html('<option>:( terjadi error server</option>')
        }
    })
})