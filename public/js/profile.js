
// $('#btn-update').click(function(){
// 	var nama = $('#name').val();
// 	var email = $('#email').val();
// 	var token = $('[name=_token]').val();

// 	alert(token);
// })
var avatarStatus = 0;

$(document).ready(function(){
	activatedSelectedView();
})

function activatedSelectedView(){
    var url = window.location.href;
    var id = url.lastIndexOf('#');
    var content = url.substr(id+1, url.length);
    if (content == 'password') {
        $('#profile-tab a[href="#change-pass"]').tab('show');
    }else{
        $('#profile-tab a[href="#profile"]').tab('show');
    }
}


$('.btn-load').click(function(){
	$(this).html('<span class="btn-label"><i class="fa fa-spinner fa-spin"></i></span> mohon tunggu..');
});

$('#profile-view').click(function(){
	$('#modal-change-photo-profile').modal('show');
});

$('#new_profile').change(function(){
	var formData = new FormData($('#change-profile-form')[0]);
	var label = $('#label-up');
	var title = $('#up-title');
	var sideProfile = $('#side-profile');
	var topProfile = $('.top-profile');

	$.post({
		url: '/profile/postImage',
		data: formData,
		contentType: false,
		processData: false,
		beforeSend: function() {
   		label.html('<span class="fa fa-spinner fa-spin"></span> uploading...');
    },
		success:function(data){
			if (data['code'] == 200) {
				sideProfile.attr('src', data['new']);
				topProfile.attr('src', data['new']);
				$('#modal-change-photo-profile').modal('toggle');
			}
			label.html('Unggah Foto');
			$('#change-profile-form').trigger("reset");
		},error:function(data){
			var errors = data.responseJSON;
			var errorsParsed = '';

			$.each(errors[0]['photo'], function(i, val){
				errorsParsed += '# '+ val + '\n';
			})
			swal('Oops..', 'Terjadi error saat mengunggah foto, antara lain:\n '+ errorsParsed, 'error');
			label.html('Unggah Foto');
			$('#change-profile-form').trigger("reset");
		}

	});

});

$('.dis-click').click(function(e){
	e.preventDefault();
})

$('#btn-modal-back').click(function(){
	$('#modal-change-photo-profile').modal('toggle');
	$('#modal-avatar-profile').modal('toggle');
})

$('#btn-avatar').click(function(){
	if (avatarStatus == 0) {
		getAvatar();
	}

	$('#modal-change-photo-profile').modal('toggle');
	$('#modal-avatar-profile').modal('toggle');

});

function getAvatar(){
	var avatarList = '';
	var avatarBody = $('#avatar-body');
	var load = 
	$.get({
		url:'/api/profile/avatar',
		success:function(data){
			console.log(data);
			$.each(data, function(i, val){
				avatarList += '<div class="col-xs-12 col-lg-2 col-md-3 col-sm-6 mr-3" style="margin-bottom: 50px;">' + 
                      	'<div style="margin: 0 auto;">' + 
	                        '<input name="avatar" type="radio" value="'+val['avatar_id']+'" id="avatar'+ val['avatar_id'] +'" class="with-gap radio-col-blue">' + 
	                        '<label for="avatar'+ val['avatar_id'] +'">' + 
	                          '<img src="/users/'+ val['name'] +'" id="side-profile" class="img-circle mb-3" width="100">' + 
	                        '</label>' + 
	                      '</div>' + 
	                    '</div>';
			});
			avatarBody.html(avatarList);
			avatarStatus = 1;
		},
		error:function(){
			swal('Oops..', 'Gagal mengambil avatar', 'error');
		}
	})
}

$('#btn-save-avatar').click(function(){
	var avatar = '';
	var token  = $('input[name="_token"]').val();
	var temp = '';
	var button = $(this);
	var sideProfile = $('#side-profile');
	var topProfile = $('.top-profile');

	avatar = $('input[name="avatar"]:checked').val();
	
	if (avatar === undefined) {
		alert('pilih avatar terlebih dahulu');
	}else{
		$.post({
			url: '/profile/postImage',
			data: {
				_token:token,
				avatar_id:avatar
			},
			
			beforeSend: function() {
				button.html('<span class="fa fa-spinner fa-spin"></span> uploading...');
				button.attr('disabled', '');
	    },
			success:function(data){
				if (data['code'] == 200) {
					sideProfile.attr('src', data['new']);
					topProfile.attr('src', data['new']);
					$('#modal-avatar-profile').modal('toggle');
				}
				button.html('Simpan');
				button.removeAttr('disabled');
			},error:function(data){
				swal('Oops..', 'Gagal mengunggah avatar sebagai foto profil', 'error');
			}

		});
	}
})

$('#btn-delete-profile').click(function(){
	var token = $('input[name="_token"]').val();
	var sideProfile = $('#side-profile');
	var topProfile = $('.top-profile');
	var button = $(this);

	$.post({
		url: '/profile/postImage',
		data: {
			_token:token,
			default:'true'
		},
		beforeSend: function() {
			button.html('<span class="fa fa-spinner fa-spin"></span> deleting...');
			button.attr('disabled', '');
    },

		success:function(data){
			if (data['code'] == 200) {
				sideProfile.attr('src', data['new']);
				topProfile.attr('src', data['new']);
				$('#modal-change-photo-profile').modal('toggle');
			}
			button.html('Hapus Foto Saat Ini');
			button.removeAttr('disabled');
		},
		error:function(){
			swal('Oops..', 'Gagal menghapus foto profil', 'error');
		}
	})
})