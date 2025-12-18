function setKelas(e, pid){
	$('#set-kelas-title').html("Set Kelas "+ $(e).data('nm'));
	$('#pid').val(pid);
	var rid = $(e).data('r');

	$('[name=rid] option').filter(function() { 
	    return ($(this).val() == rid);
	}).prop('selected', true);

	$("#modal-set-kelas").modal('show');
}