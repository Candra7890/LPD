$('#level').change(function(){
	var level = $(this).val();

	console.log(level);
	if(level == ''){
		return;
	}

	if(level == 1){
		$('#prodi').hide();
		$('#program').hide();
		$('#fakultas').hide();
	}
	else if (level == 2) {
		$('#prodi').hide();
		$('#program').hide();
		$('#fakultas').show();
	}else if(level == 3){
		$('#prodi').show();
		$('#program').hide();
		$('#fakultas').hide();
	}else if(level == 4){
		$('#prodi').show();
		$('#program').show();
		$('#fakultas').hide();
	}
});