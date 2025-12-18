$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$("#fak_f").on('change', function(){
    
    $('#load-prodi_filter').show();
    $('#prod_f').empty();

    var url = '/master/prodi/fakultas/' + this.value;
    var prodi_list = '<option value="">Semua</option>';

    // alert(url);
    $.get({
        url: url,
        success: function(data) {
            // console.log(data);
            $.each(data, function(key, value) {
                prodi_list += '<option value="' + value['prodi_id'] + '" >' + value['nama_prodi'] + '</option>'
            })

            $('#prod_f').html(prodi_list);
            $('#prod_f').removeAttr('disabled');
            $('#load-prodi_filter').hide();
        }
    })
})

$("#btn-tampilkan").on('click', function(){
    let fakultas_id = $("#fak_f").val();
    let prodi_id = $("#prod_f").val();

    if(!fakultas_id){
        swal('Perhatian', 'Fakultas Harus dipilih', 'error');
        return false;
    }

    $.ajax({
        method: "POST",
        url: '/status-mhs/global/detail',
        data: {
            fakultas_id: fakultas_id,
            prodi_id: prodi_id
        },
        success: function(data){
            console.log(data)
        }
    });
})