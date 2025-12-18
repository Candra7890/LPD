$("#prodi").change(function(){
	get_dosen();
})

function get_dosen(){
	var prodi = $('#prodi').val();

	$.get({
		url: '/master/dosen/prodi/'+prodi,
		success:function(data){
			var option = '';

			if (data == '') {
				option += '<option value="">Tidak ada data dosen...</option>'
			}else{	
				$.each(data, function(k, v){
					option += '<option value="'+ v['dosen_id'] +'">'+ v['nama'] +'</option>'
				});
			}

			$('#dosen').html(option);
		},
		error:function(){
			swal({   
        title: "Oopss..",   
        text: "Terjadi kesalahan sistem.",   
        type: "error"
	    });
		}
	})
}