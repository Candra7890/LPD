var LOADER = '<p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p>';
var BTN_LOADER = '<span class="btn-label"><i class="fa fa-refresh fa-spin"></i></span> memproses...';
var TABLE = '#tb-permohonan';
var TABLE_LOADER = '<tr><td colspan="10"><p class="text-center"><span class="fa fa-refresh fa-spin"></span> sedang memuat...</p></td></tr>';
var ID_PERMOHONAN = 0;
$(document).ready(function(){
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$(TABLE).DataTable();
	getPermohonan();
})

function getPermohonan(){
	var tahun = $('select[name=tahunajaran]').val();
	var semester = $('select[name=semester]').val();
	var status = $('select[name=status]').val();
	$(TABLE + ' tbody').html(TABLE_LOADER);

	$.get({
		url:'/operator-pindahprogram/get',
		data:{
			tahunajaran:tahun,
			semester:semester,
			status:status
		},
		success:function(data){
			$(TABLE).DataTable().destroy();
			$(TABLE + ' tbody').html(data);
			$(TABLE).DataTable();
			initTooltip();
		}, error:function(){
			$(TABLE + ' tbody').html('<tr><td colspan="10"><p class="text-center text-danger">Unable to load data due to system error</p></td></tr>');
		}
	})
}

function initTooltip(){
	$('[data-toggle="tooltip"]').tooltip();
}

$('#btn-filter').click(function(){
	getPermohonan();
})

$(document).on('click', '.btn-set', function(){
	ID_PERMOHONAN = $(this).data('id');
	$('#modal').modal('show');
})

$('#btn-simpan-status').click(function(){
	status = $('select[name=status_update]').val();
	var btn = this;

	var temp = $(btn).html();
	$(btn).html(BTN_LOADER);
	$(btn).attr('disabled', '');

	$.post({
		url:'/operator-pindahprogram/update',
		data:{
			id:ID_PERMOHONAN,
			status_update: status
		},
		success:function(data){
			if (data.status == true) {
				swal('SUKSES!', data.msg, 'success');
				$('select[name=status_update]').prop('selectedIndex',0);
				$('#modal').modal('toggle');
				getPermohonan();
			}else{
				swal('ERROR!', 'Response tidak diketahui', 'error');
			}
		}, error:function(data){
			data = data.responseJSON;
			if (data.status == false) {
				swal('ERROR!', data.msg, 'error');
			}else{
				swal('ERROR!', 'Terjadi kesalahan sistem.', 'error');
			}
		}, complete:function(){
			$(btn).html(temp);
			$(btn).removeAttr('disabled');
		}
	})
})