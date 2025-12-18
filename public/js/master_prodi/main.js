var TB_LOADER = '<tr><td colspan="20"><p class="text-center"><i class="fa fa-refresh fa-spin"></i> sedang memuat...</p></td></tr>';

$(document).ready(function(){
    $('#tb-search-dosen').DataTable({'autoWidth':false, 'paging':false});
})

document.querySelector('#form-search-dosen').addEventListener('keypress', function (e) {
    var key = e.which || e.keyCode;
    if (key === 13) { // 13 is enter
        e.preventDefault()
        $("#btn-search-dosen").click();
    }
});

$('.search-ketua-prodi').click(function(e){
    e.preventDefault();

    $('#modal-find').modal('show');
})

$('#btn-search-dosen').click(function(){
    $('tb-search-dosen').DataTable().destroy();
    let form = "?" + $('#form-search-dosen').serialize();
    let btn = this;

    $('#tb-search-dosen tbody').html(TB_LOADER);
    $.get({
        url:form, 
        success:function(data){
            $('#tb-search-dosen tbody').html(data);
            $('tb-search-dosen').DataTable({'autoWidth':false, 'paging':false});
        },
        error:function(){
            $('#tb-search-dosen tbody').html('');
            $('tb-search-dosen').DataTable({'autoWidth':false, 'paging':false});
        }
    })
})

$(document).on('click', '.btn-set-koprodi', function(){
    let id = $(this).data('id');

    let row = $(this).closest('tr').find('td');
    let nip = row[1].innerHTML;
    let nama = row[2].innerHTML;

    $('input[name=ketua_prodi]').val(nip + ' - ' + nama);
    $('input[name=ketua_prodi_id]').val(id);

    $("#modal-find").modal('toggle');
})