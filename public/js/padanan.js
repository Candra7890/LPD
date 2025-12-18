var mkdipilih = [];
var mkpilihan = []; //temporary storage

$('#btn-pilihmk').click(function(){
	$('#modal-padanan').modal('show');
})

$(document).ready(function(){
	$('.select2').select2({ dropdownParent: $("#modal-padanan") });
	get_mk_padanan_list();
})

function get_mk_padanan_list(){
	var tahunajaran = $('#tahunajaran').val();
	var semester = $('#semester').val();
	var prodi = $('#prodi').val();
	var angkatan = $('#angkatan').val();
	var program = $('#program').val();
	var token = $('input[name=_token]').val();

	$.post({
		url: '/padanan/get_matakuliah_padanan',
		data:{
			_token:token,
			tahunajaran:tahunajaran,
			semester:semester,
			prodi:prodi,
			angkatan:angkatan,
			program:program
		},
		success:function(data){
			var row = '';
			var mk = {};
			$.each(data, function(i,val){
				mk = {};
				mk.mktawarId = val['mktawar_id'];
				mk.mkId = val['matakuliah_id']
				mk.kode = val['kode_matakuliah'];
				mk.nama = val['nama_matakuliah'];
				mk.kls = val['kelas'];
				mk.sks = val['sks'];
				mk.smt = val['smtMk'];
				mk.angkatan = angkatan;
				mk.program = val['nama_program'];

				mkpilihan[mkpilihan.length] = mk;
				row += '<tr style="cursor:pointer;">'+
		            		'<td>'+ (i+1) +'</td>'+
		            		'<td>'+ val['kode_matakuliah'] +'</td>'+
		            		'<td>'+ val['nama_matakuliah'] +'('+ val['kelas'] +')</td>'+
		            		'<td>'+ val['sks'] +'</td>'+
		            		'<td>'+ val['smtMk'] +'</td>'+
		            		'<td>'+ angkatan +'</td>'+
		            	'</tr>';
		            	'</tr>';
			});
			$("#table-padanan").DataTable().destroy();
			$('#mk-padanan').html(row);
			$("#table-padanan").DataTable();
			console.log(mkpilihan);
		},
		error:function(){

		}
	})
}

$('#btn-caripadanan').click(function(){
	get_mk_padanan_list();
})

$('#table-padanan tbody').on( 'click', 'tr', function () {
	var row = $(this).closest('tr');
	var ada = 0;
	$.each(mkdipilih, function(i, v){
		if (v.mktawarId == mkpilihan[row[0].rowIndex-1].mktawarId) {
			ada = 1;
			return false;
		}
	})
	if (ada == 0) {	
		mkdipilih[mkdipilih.length] = mkpilihan[row[0].rowIndex-1];
	}
	$('#modal-padanan').modal('toggle');
	// console.log(mkdipilih);
	update_pilihan();
})

function update_pilihan(){
	var row = '';
	var del = '';
	if (mkdipilih.length == 0) {
		row = '<tr><td colspan="9">Belum ada matakuliah yang dipilih</td></tr>';
		$('#mkdipilih').html(row);
		return true;
	}

	$.each(mkdipilih, function(i,val){
		del = '<button class="btn btn-danger btn-sm" onclick="del('+i+')"><span class="mdi mdi-delete"></span></button>'
		row += '<tr style="cursor:pointer;">'+
	        		'<td>'+ (i+1) +'</td>'+
	        		'<td>'+ val['kode'] +'</td>'+
	        		'<td>'+ val['nama'] +'('+ val['kls'] +')</td>'+
	        		'<td>'+ val['sks'] +'</td>'+
	        		'<td>'+ val['smt'] +'</td>'+
	        		'<td>'+ val['angkatan'] +'</td>'+
	        		'<td>'+ val['program'] +'</td>'+
	        		'<td>'+ del +'</td>'+
	        	'</tr>';
	});
	$('#mkdipilih').html(row);
}

function del(index){
	mkdipilih.splice(index, 1);
	update_pilihan();
}

$('#btn-simpanPadanan').click(function(){
	var nama_padanan = $('#nama_padanan').val();
	var token = $('input[name=_token]').val();

	if (nama_padanan == '') {
		alert('kosong');
		return false;
	}

	if(mkdipilih.length == 0){
		alert('dipilih kosong');
		return false;
	}

	if(mkdipilih.length == 1){
		alert('dipilih minimal 2');
		return false;
	}

	$.post({
		url: '/padanan/store',
		data:{
			_token:token,
			nama:nama_padanan,
			kelas:mkdipilih
		},
		success:function(data){
			if (data == 'success') {
				swal({   
			        title: "Sukses!",   
			        text: "Sukses menambah kelas padanan baru",   
			        type: "success"
			    });
				window.location.href = "/padanan";
			}
		},
		error:function(){
			alert('error');
		}
	})
})
