var loaderInTable = '<tr><td colspan="3"><p class="text-center"><span class="fa fa-spinner fa-spin"></span> sedang memuat...</p></td></tr>';

$('#tipeuser').change(function(){
	loadBrokerFromSelectedTipeUser();
});

// $(document).ready(function(){
// 	loadBrokerFromSelectedTipeUser();
// });

function loadBrokerFromSelectedTipeUser(){
	$('#broker-list').html(loaderInTable);
	var tipeuser = $('#tipeuser').val();
	var row = '';
	var brokerRoleList = '';

	if (tipeuser == '') {
		return;
	}

	$.get({
		url: '/api/tipeuser/broker',
		data:{
			tipeuser:tipeuser
		},
		success:function(data){
			row = '';
			$.each(data['paketmenu_with_detail'], function(i, val){
				brokerRoleList = '';

				$.each(val['paketmenudetail'], function(key, value){
					brokerRoleList += value['nama_role'] + '<br>';
				});

				row += '<tr>' +
	                  '<td>'+ (i+1) +'</td>' +
	                  '<td>'+ val['broker']['nama_broker'] +'</td>' +
	                  '<td>'+ brokerRoleList +'</td>' +
	              '</tr>';
			});

			$('#table-broker').DataTable().destroy();
			$('#broker-list').html(row);
			$("#table-broker").DataTable({
        'paging':false
    	});
		},
		error:function(){
			alert('gagal koneksi ke database');
		}
	});	
}