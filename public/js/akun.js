var tableLoader = ' <tr><td colspan="6"><p class="text-center"><span class="fa fa-spinner fa-spin"></span> sedang memuat...</p></td></tr>';
var emailUserId = 0;
var btnLoader = '<span class="btn-label"><i class="fa fa-spinner fa-spin"></i></span> Simpan';
var oldEmail = '';
var passUserId = 0;
var moreLoader = '<p class="text-center"><span class="fa fa-spinner fa-spin" style="font-size: 40px;"></span></p>';

$(document).ready(function(){
    activatedSelectedView();
    filter();

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
});

$(document).keypress(function(e) {
    if(e.which == 13) {
        e.preventDefault();
    }
});
// 
$('.btn-switch').click(function(){
  $('#form-filter').toggle();
  $('#form-search').toggle();
})

$("#btn-search").click(function(){
  let form = $('#form-search').serialize();
  let url = $('#form-search').attr('action') + '?' + form;

  $('#user-table').html(tableLoader);
  $('#btn-search').attr('disabled', '');
  $('#btn-search span i').attr('class', 'fa fa-spinner fa-spin');

  $.get({
    url:url,
    success:function(data){
      $('#table-tipeuser').DataTable().destroy();
      $('#user-table').html(data);
      $('#table-tipeuser').DataTable({'autoWidth': false});
      $('#btn-search span i').attr('class', 'ti-search');
      $('#btn-search').removeAttr('disabled');
    },
    error:function(data){
      data = data.responseJSON;
      swal('Noo..', data['msg'], 'error');
      $('#btn-filter span i').attr('class', 'ti-filter');
      $('#btn-filter').removeAttr('disabled');
    }
  })
})

$("#btn-tambahakun").click(function(){
  
})

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

function filter(){
  var tipeuser = $('#tipeuser').val();
  var prodi = $('#prodi').val();

  $('#user-table').html(tableLoader);
  $('#btn-filter').attr('disabled', '');
  $('#btn-filter span i').attr('class', 'fa fa-spinner fa-spin');

  $.get({
    url: '/admin/akun/view/user_table',
    data:{
      tipeuser:tipeuser,
      prodi:prodi
    },
    success:function(data){
      $('#table-tipeuser').DataTable().destroy();
      $('#user-table').html(data);
      $('#table-tipeuser').DataTable({
        'autoWidth': false
      });
      $('#btn-filter span i').attr('class', 'ti-filter');
      $('#btn-filter').removeAttr('disabled');
    },
    error:function(data){
      console.log(data);
      data = data.responseJSON;
      swal('Noo..', data['msg'], 'error');
      $('#btn-filter span i').attr('class', 'ti-filter');
      $('#btn-filter').removeAttr('disabled');
    }
  });
}

$(document).on('click', '.btn-paketmenu', function(){
  var jenisuser = $(this).data('jenis');
  var paketmenu = $(this).data('pkt');
  var id = $(this).data('id');
  $('#modal-paketmenu').modal('show');
  $('#modal-paketmenu .modal-body').html(tableLoader);

  $.get({
    url: '/admin/akun/view/user_table/paketmenu',
    data:{
      jenisuser:jenisuser,
      paketmenu:paketmenu,
      id:id
    }, success:function(data){
      $('#modal-paketmenu .modal-body').html(data);
      $("#editpaketmenu").select2();
    }, error:function(){
      $('#modal-paketmenu .modal-body').html('<span class="text-danger">terjadi error saat mengambil data. silakan coba lagi.</span>');
    }
  })
});

$(document).on('click', '#btn-simpan-paketmenu', function(){
  var btn = this;
  var temp = $(btn).html();
  $(btn).html(btnLoader);
  $(btn).attr('disabled', '');
  var form = new FormData($('#form-paketmenu')[0]);
  var url = $('#form-paketmenu').attr('action');

  $.post({
    url:url,
    data:form,
    contentType:false,
    processData:false,
    success:function(data){
      if (data.status == true) {
        swal("SUKSES!", data.msg, 'success');
      }
    },
    error:function(data){
      data = data.responseJSON;
      if (data.status == false) {
        swal("ERROR!", data.msg, 'error');
      }else{
        swal("ERROR!", 'terjadi error saat menyimpan data.', 'error');
      }
    },
    complete:function(){
      $(btn).html(temp);
      $(btn).removeAttr('disabled');
      $('#modal-paketmenu').modal('toggle');
    }
  })
})

// Toggle view 
$('.btn-toggle').click(function(){
    $('#insert').toggle();
    $('#view').toggle();
})
// 

$('#btn-semua-mhs').click(function(e){
    e.preventDefault();
    var token = $("input[name=_token]").val();
    console.log(token);

    swal({   
      title: "Anda Yakin?",   
      text: "Apakan anda yakin ingin membuatkan semua mahasiswa akun SRUTI?",   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, buatkan",
      showLoaderOnConfirm: true,
      closeOnConfirm: false 
    }, function(){   
      $.post({
        url: '/admin/akun/tambah_semua_mhs',
        data:{
            _token:token
        },
        success:function(data){
            if (data['code'] == 200) {
                swal('Yess..', data['msg'], 'success');
            }else{
                swal('Noo..', 'Sistem tidak merespon', 'warning');
            }
        },
        error:function(){
            swal('Oops..', 'Gagal menambahkan semua mahasiswa ke SRUTI', 'error');
        }
      })
    });
})

$('#btn-semua-mhs-baru').click(function(e){
  e.preventDefault();
  var token = $("input[name=_token]").val();
  console.log(token);

  swal({   
    title: "Anda Yakin?",   
    text: "Apakan anda yakin ingin membuatkan semua mahasiswa baru akun SRUTI?",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Ya, buatkan",
    showLoaderOnConfirm: true,
    closeOnConfirm: false 
  }, function(){   
    $.post({
      url: '/admin/akun/tambah_semua_mhs_baru',
      data:{
          _token:token
      },
      success:function(data){
          if (data['code'] == 200) {
              swal('Yess..', data['msg'], 'success');
          }else{
              swal('Noo..', 'Sistem tidak merespon', 'warning');
          }
      },
      error:function(){
          swal('Oops..', 'Gagal menambahkan semua mahasiswa ke SRUTI', 'error');
      }
    })
  });
})

$('#btn-semua-dosen').click(function(e){
  e.preventDefault();
  var token = $("input[name=_token]").val();
  console.log(token);

  swal({   
    title: "Anda Yakin?",   
    text: "Apakan anda yakin ingin membuatkan semua dosen akun SRUTI?",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Ya, buatkan",
    showLoaderOnConfirm: true,
    closeOnConfirm: false 
  }, function(){   
    $.post({
      url: '/admin/akun/tambah_semua_dosen',
      data:{
          _token:token
      },
      success:function(data){
          if (data['code'] == 200) {
              swal('Yess..', data['msg'], 'success');
          }else{
              swal('Noo..', 'Sistem tidak merespon', 'warning');
          }
      },
      error:function(){
          swal('Oops..', 'Gagal menambahkan semua mahasiswa ke SRUTI', 'error');
      }
    })
  });
})

$('#btn-filter').click(function(){
  filter();
})

$(document).on('click', '.btn-new-email', function(){
  emailUserId = $(this).data('id');
  
  var column = $(this).closest('tr').find('td');
  var nama = column[3].innerHTML;
  oldEmail = column[4].innerHTML;


  $('#identifier-edit').html(nama);
  $('#modal-edit').modal('show');
})

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

$(document).on('click', '#btn-simpan-email', function(){
  var email = $('#email-baru-edit').val();
  var button = this;
  var token = $('input[name=_token]').val();
  var temp = '';

  if (validateEmail(email)) {
    $('#new-email-form').attr('class', 'form-group');
    $('#new-email-msg').html('');
    temp = $(button).html();
    $(button).html(btnLoader);
    $(button).attr('disabled', '');

    $.post({
      url:'/admin/akun/change_email',
      data:{
        _token:token,
        userId:emailUserId,
        newEmail:email
      },
      success:function(data){
        console.log(data);
        $(button).html(temp);
        $(button).removeAttr('disabled');
        $('#email-baru-edit').val('');

        var column = $(button).closest('tr').find('td');
        $("#table-tipeuser td:contains('"+ oldEmail +"')").html(email);
        $('#modal-edit').modal('toggle');
      },
      error:function(){
        swal('Noo..', 'Terjadi kesalahan sistem. Jika error ini terus terjadi silakan hubungi pihak berwajib', 'error');
        $(button).html(temp);
        $(button).removeAttr('disabled');
      }
    })
  }else{
    $('#new-email-form').attr('class', 'form-group has-danger');
    $('#new-email-msg').html('Format email salah');
  }

})

$(document).on('click', '.btn-new-pass', function(){
  passUserId = $(this).data('id');
  
  var column = $(this).closest('tr').find('td');
  var nama = column[3].innerHTML;

  $('#password-edit').html(nama);

  $('#modal-password').modal('show');
})

$(document).on('click', '#btn-simpan-pass', function(){
  $('#new-pass-form').attr('class', 'form-group');
  $('#new-pass-msg').html('');
  $('#new-pass-conf-form').attr('class', 'form-group');
  $('#new-pass-conf-msg').html('');

  var pass = $('#new-pass').val();
  var passConf = $('#new-pass-confirmation').val();
  var button = this;
  var token = $('input[name=_token]').val();
  var temp = '';

  if (pass == '') {
    $('#new-pass-form').attr('class', 'form-group has-danger');
    $('#new-pass-msg').html('Password tidak boleh kosong');
    return;
  }

  if (passConf == '') {
    $('#new-pass-conf-form').attr('class', 'form-group has-danger');
    $('#new-pass-conf-msg').html('Password konfirmasi tidak boleh kosong');
    return;
  }

  if (pass !== passConf) {
    $('#new-pass-form').attr('class', 'form-group has-danger');
    $('#new-pass-msg').html('Password konfirmasi tidak cocok');
    return;
  }

  temp = $(button).html();
  $(button).html(btnLoader);
  $(button).attr('disabled', '');

  $.post({
    url:'/admin/akun/change_pass',
    data:{
      _token:token,
      userId:passUserId,
      pass:pass,
      pass_confirmation:passConf
    },
    success:function(data){
      // console.log(data);
      if (data['code'] == 200) {
        swal('Yess..', data['msg'], 'success');
        $('#new-pass').val('');
        $('#new-pass-confirmation').val('');
      }
      else{
        swal('Oops..', 'Sistem tidak merespon. Jika peringatan ini terus terjadi silakan hubungi pihak berwajib.', 'warning');
      }

      $(button).html(temp);
      $(button).removeAttr('disabled');
    },
    error:function(data){
      data = data.responseJSON;
      if (data['code'] == 500) {
        $('#new-pass-form').attr('class', 'form-group has-danger');
        $('#new-pass-msg').html(data['msg'][0]);
      }else{
        swal('Noo..', 'Terjadi kesalahan sistem. Jika error ini terus terjadi silakan hubungi pihak berwajib', 'error');
      }
      
      $(button).html(temp);
      $(button).removeAttr('disabled');
    }
  })

})

$(document).on('click', '.btn-del', function(){
  var userId = $(this).data('id');
  var token = $('input[name=_token]').val();

  swal({   
    title: "Anda Yakin?",   
    text: "Apakan anda yakin ingin pengguna ini?",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#DD6B55",   
    confirmButtonText: "Ya, hapus!",
    showLoaderOnConfirm: true,
    closeOnConfirm: false 
  }, function(){   
    $.post({
      url: '/admin/akun/delete',
      data:{
          _token:token,
          userId:userId
      },
      success:function(data){
          if (data['code'] == 200) {
              swal('Yess..', data['msg'], 'success');
              filter();
          }else{
              swal('Noo..', 'Sistem tidak merespon', 'warning');
          }
      },
      error:function(){
          swal('Oops..', 'Terjadi masalah sistem. Jika error ini terus muncul, silakan hubungi pihak berwajib.', 'error');
      }
    })
  });
})

$(document).on('click', '.btn-more', function(){
  $('#user-more').html(moreLoader);
  var userId = $(this).data('id');

  $.get({
    url:'/admin/akun/' + userId,
    success:function(data){
      $('#user-more').html(data);
    },
    error:function(){
      swal('Oops..', 'Terjadi masalah sistem. Jika error ini terus muncul, silakan hubungi pihak berwajib.', 'error');
    }
  })
  $('#modal-more').modal('show');
})


$(document).on('click', '.btn-set-admin', function(){
  let id = $(this).data('id');
  let btn = this;
  swal({   
      title: "PERHATIAN",   
      text: "Apakah anda yakin ingin mengubah status admin user ini?",   
      type: "warning",   
      showCancelButton: true,   
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Ya, ubah!",   
      closeOnConfirm: false,
      showLoaderOnConfirm:true
  }, function(){   
    $.post({
      url: '/admin/akun/set-admin',
      data:{
        id:id
      },
      success:function(data){
        if (data.status == true) {
          swal("SUKSES!", data.msg, 'success');

          if (data.newAdminStatus == 1) {
            $(btn).attr('class', 'btn btn-sm btn-danger waves-effect mb-1 btn-set-admin')
            $(btn).attr('title', 'Hilangkan Status Admin')
          }else if(data.newAdminStatus == 0){
            $(btn).attr('class', 'btn btn-sm btn-info waves-effect mb-1 btn-set-admin')
            $(btn).attr('title', 'Set Status Sebagai Admin')
          }
        }else if(data.status == false){
          swal("ERROR!", data.msg, 'error');
        }else{
          swal("PERHATIAN!", 'Response tidak diketahui', 'warning');
        }
      },
      error:function(){
        swal("ERROR!", 'Terjadi kesalahan sistem. Silakan ulangi beberapa saat lagi.', 'error');
      }
    })    
  });

  
})
