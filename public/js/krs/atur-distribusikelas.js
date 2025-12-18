$(document).ready(function() {
	$('#table-mhs').DataTable({
		paging: false
	});
});

$('#manual').click(function() {
	$('.manual').removeAttr('disabled');
});

$('#rata').click(function() {
	swal(
		{
			title: 'Perhatian!',
			text: 'Apakah anda yakin ingin mendistribusikan mahasiswa dengan metode Bagi Rata?',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Bagi Rata!',
			closeOnConfirm: false
		},
		function() {
			$('#form-rata').submit();
		}
	);
});

$('#kuota').click(function() {
	swal(
		{
			title: 'Perhatian!',
			text: 'Apakah anda yakin ingin mendistribusikan mahasiswa dengan metode Bagi Berdasarkan Kapasitas?',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Bagi Rata!',
			closeOnConfirm: false
		},
		function() {
			$('#form-kuota').submit();
		}
	);
});

$('#kategori').click(function() {
	swal(
		{
			title: 'Perhatian!',
			text: 'Apakah anda yakin ingin mendistribusikan mahasiswa?',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya!',
			closeOnConfirm: false
		},
		function() {
			$('#form-kategori').submit();
		}
	);
});

$('#manual').click(function() {
	swal(
		{
			title: 'Perhatian!',
			text: 'Apakah anda yakin ingin menyimpan perubahan manual yang anda lakukan?',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Batal',
			confirmButtonColor: '#DD6B55',
			confirmButtonText: 'Ya, Simpan Perubahan Manual!',
			closeOnConfirm: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$('#form-manual').submit();
			} else {
				location.reload();
			}
		}
	);
});
