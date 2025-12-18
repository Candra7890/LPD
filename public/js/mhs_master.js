$.ajax({
    type: 'get',
    url: url,
    success: function(data){
      // insert data pribadi
      $('#nim_view').val(data['nim']);
      $('#nama_lengkap_view').val(data['nama']);
      $('#tgl_lahir_view').val(data['tanggal_lahir']);
      $('#tmp_lahir_view').val(data['tempat_lahir']);
      $('#telepon_view').val(data['alamat_asal_telepon']);
      $('#email_view').val(data['email']);
      $('#agama_view').val(data['agama']['agama']);
      $('#jk_view').val(data['kelamin_id']);
      $('#darah_view').val(data['goldarah_id']);
      $('.loading').attr('style', 'display: none;')
      $('.data-mhs').attr('style', '');

      $('#tercetak_view').val(data['nama_tercetak']); 
      $('#angkatan_view').val(data['angkatan']['tahun']); 
      $('#prodi_view').val(data['prodi']['nama_prodi']); 
      $('#jenjang_view').val(data['jenjang']['jenjang']); 
      $('#program_view').val(data['program']['nama_program']); 
      $('#binat_view').val(data['binat']['nama_bidang']); 
      $('#fakultas_view').val(data['fakultas']['nama_fakultas']); 
      $('#pa_view').val(data['pa']['nama']); 
      $('#status_view').val(data['statusaktif']['status']); 

      $('#asal_view').val(data['alamat_asal']); 
      $('#kecamatan_view').val(data['kecamatan']['nama_kecamatan']);
      $('#kabupaten_view').val(data['kabupaten']['nama_kabupaten']);
      $('#provinsi_view').val(data['provinsi']['nama_provinsi']);
      $('#tinggal_view').val(data['alamat_tinggal']);

      $('#ayah_view').val(data['nama_ayah']); 
      $('#ibu_view').val(data['nama_ibu']);
      $('#telp_rmh_view').val(data['alamat_tinggal_telepon']);
    }

  })