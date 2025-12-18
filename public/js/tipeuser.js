var accountListBodyID = '#account-body';
var tableAccountID = '#table-account';
var loaderAccountBody = '<tr>'+ 
                            '<td colspan="4">' + 
                              '<p style="text-align: center;"><span class="fa fa-spinner fa-spin"></span> Sedang mengambil data...</p>' + 
                            '</td>' + 
                          '</tr>';

var msgErrorConnection = '<small class="text-danger"><span class="ti-face-sad"></span> terjadi kesalahan padas server. jika error ini terus terjadi silakan hubungi pihak berwajib.</small>'
var tempUser = [];
var hostname = 'http://' + $(location).attr('host');
var userPhotoPath = hostname + '/users/';

$(document).ready(function(){
    activatedSelectedView();
});

// Toggle view 
$('.btn-toggle').click(function(){
    toTop();
    $('#insert').toggle();
    $('#view').toggle();
})
// 

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
		$('#form'+ $(e).data('action')).submit();
	});
}

function activatedSelectedView(){
    toTop();
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

$('.list-akun').click(function(){
    toTop();
    window.scrollTo(0, 0);
    var id = $(this).data('id');
    var tipe = $(this).data('tipe');
    var row = '';

    $('#tipeuser').html(tipe);
    $('#view').hide();
    $('#akun').show();

    $.get({
        url: '/api/tipeuser/'+id+'/users',
        success:function(data){
            row = '';
            var email = '';
            tempUser = data;
            $.each(data['users'], function(i, val){
                email = (val['email'] == null) ? 'belum diset' : val['email'];
                row += '<tr>' + 
                            '<td>'+ (i+1) +'</td>' + 
                            '<td><a href="#detailakun" data-id="'+ i +'" class="detail-akun" data-toggle="tooltip" title="Lihat Detail Akun">'+ val['name'] +'</a></td>' + 
                            '<td>'+ val['username'] +'</td>' + 
                            '<td>'+ email +'</td>' + 
                        '</tr>'; 
            })
            $(accountListBodyID).html('');
            $(tableAccountID).DataTable().destroy();
            $(accountListBodyID).html(row);
            $(tableAccountID).DataTable();
        },
        error:function(){
            var errorMsg = '<tr>'+
                            '<td colspan="4">'+
                              msgErrorConnection+
                            '</td>'+
                          '</tr>';
            $(accountListBodyID).html(errorMsg);
        }
    })

})

$('.account-back').click(function(){
    $('#view').toggle();
    $('#akun').toggle();
    $(accountListBodyID).html(loaderAccountBody);
    toTop();
})

$('.detail-back').click(function(){
    $('#akun').toggle();
    $('#detailakun').toggle();
    toTop();
})

$(document).on('click', '.detail-akun', function(){

    var index = $(this).data('id');
    var userData = tempUser['users'][index];

    console.log(userData);
    $('#detail-nama').html(userData['name']);
    $('#detail-img').attr('src', userPhotoPath + userData['profilepict']);
    $('.detail-tipe').html(userData['tipeuser']['nama_tipeuser']);
    $('#detail-username').html((userData['username'] == null || userData['username'] == '') ? 'belum di set' : userData['username']);
    $('#detail-identifier').html((userData['identifier'] == null || userData['identifier'] == '') ? 'belum di set' : userData['identifier']);
    $('#detail-email').html((userData['email'] == null || userData['email'] == '') ? 'belum di set' : userData['email']);
    $('#detail-created').html(userData['created_at']);
    $('#detail-updated').html(userData['updated_at']);

    $('#akun').toggle();
    $('#detailakun').toggle();
})

function toTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}