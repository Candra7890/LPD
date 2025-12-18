var LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p>';
var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span> memproses...';
var TABLE = '#tb-permohonan';
var TABLE_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';

$(document).ready(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(TABLE).DataTable();
	getMhs();
})

function getMhs(){
	$(TABLE + ' tbody').html(TABLE_LOADER);
	$('#btn-filter').attr('disabled', '');
	var prodi = $('select[name=prodi]').val();
	var angkatan = $('select[name=angkatan]').val();
	var program = $('select[name=program]').val();

	$.get({
		url:'/mhs-transfer/getMhs',
		data:{
			prodi:prodi,
			tahun:angkatan,
			program:program
		},
		success:function(data){
			$(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable();
		},
		error:function(data){
			$(TABLE + ' tbody').html('<tr><td colspan="10"><p class="text-center text-danger">Unable to load data due to system error</p></td></tr>');
		},
		complete:function(){
			$('#btn-filter').removeAttr('disabled');
		}
	})
}

$('#btn-filter').click(function(){
	getMhs();
})