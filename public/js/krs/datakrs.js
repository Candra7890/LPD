function get_datakrs_by_filter(){
	var thn_ajaran = $('#tahun_ajaran').val();
	var semester = $('#semester').val();
	var token = $('input[name=_token]').val();

	$.post({
		url: '/datakrs',
		data:{
			thn_ajaran:thn_ajaran,
			semester:semester,
			_token:token
		},
		beforeSend: function(res){
			$("#mktawar-row").html(
				'<td colspan="8" class="text-center">' +
				'<i class="fa fa-spin fa-refresh"></i>  ' +
				'Sedang Memproses...' +
				'</td>'
			)
		},
		success:function(data){
			var row = '';
			var ttl_sks = 0;

			if(data.length === 0){
				$("#mktawar-row").html(
					'<td colspan="8" class="text-center">' +
					'Tidak ada data' +
					'</td>'
				)

				return false;
			}

			$.each(data, function(i, val){
				ttl_sks += val['sks'];
				row += '<tr>'+
		                  '<td>'+ (i+1) +'</td>'+
		                  '<td>'+ val['kode_matakuliah'] +'</td>'+
		                  '<td>'+ val['nama_matakuliah'] + ' ('+val['kelas']+')' +'</td>'+
		                  '<td>'+ val['sks'] +'</td>'+
		                '</tr>';
			})
			row += '<tr>'+
								'<td colspan="3"><b>Total</b></td>'+
								'<td><b>'+ ttl_sks +'</b></td>'+
							'</tr>';
			$('#mktawar-row').html(row);
		},
		error:function(){
			alert('error');
		}
	})
}

$(document).ready(function(){
	get_datakrs_by_filter();
})

$('#btn-search-datakrs').click(function(){
	let button = $(this)
	button.html('<span class="btn-label"><i class="fa fa-spin fa-circle-o-notch"></i></span> Memproses')

	get_datakrs_by_filter();

	button.html('<span class="btn-label"><i class="fa fa-search"></i></span> Tampilkan')
})