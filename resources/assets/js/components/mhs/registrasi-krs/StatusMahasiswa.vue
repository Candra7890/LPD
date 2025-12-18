<template>
	<div>
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Informasi Tambahan</h4>
				<h6 class="card-subtitle">Penjelasan tambahan mengenai Merdeka Belajar Kampus Merdeka.</h6>
				<hr />
				<ul class="list-icons" v-if="status['rule'] == 'regular_study'">
					<li><i class="fa fa-check text-info"></i> Anda dapat mengambil Matakuliah Reguler.</li>
				</ul>
				<ul class="list-icons" v-if="status['rule'] == 'cross_study'">
					<li><i class="fa fa-check text-info"></i> Anda dapat mengambil matakuliah <strong>Lintas Prodi</strong> yang telah ditawarkan.</li>
					<li><i class="fa fa-check text-info"></i> Matakuliah yang dapat anda ambil tidak terbatas hanya dalam satu prodi.</li>
					<li><i class="fa fa-check text-info"></i> Matakuliah lintas prodi yang dapat anda ambil maksimal {{ status['maks_sks'] }} SKS.</li>
					<li><i class="fa fa-check text-info"></i> Anda dapat mengambil matakuliah tambahan yang ada pada program studi anda sendiri ketika telah memenuhi batas maksimum SKS lintas prodi diambil.</li>
				</ul>
				<ul class="list-icons" v-if="status['rule'] == 'paket_mbkm' && mbkm_allowed['status'] == 1">
					<li><i class="fa fa-check text-info"></i> Anda dapat mengambil <strong>Paket MBKM</strong> yang telah ditawarkan.</li>
					<li><i class="fa fa-check text-info"></i> Matakuliah pada Paket MBKM yang dapat anda ambil adalah sebanyak {{ status['maks_sks'] }} SKS.</li>
					<li><i class="fa fa-check text-info"></i> Anda dapat mengambil matakuliah Tugas Akhir atau Skripsi jika sudah memenuhi syarat SKS.</li>
				</ul>
				<ul class="list-icons" v-if="status['rule'] == 'paket_mbkm' && mbkm_allowed['status'] == 0">
					<li><i class="fa fa-times text-warning"></i> Anda belum dapat mengambil <strong>Paket MBKM</strong> karena jumlah SKS yang anda tempuh tidak memenuhi syarat.</li>
					<li>
						<i class="fa fa-times text-warning"></i> Minimum nilai SKS untuk mengambil Paket MBKM adalah <strong>{{ mbkm_allowed['detail']['min_sks'] }} SKS</strong> (SKS saat ini adalah
						<strong>{{ mbkm_allowed['detail']['sks_lulus'] }} SKS</strong> )
					</li>
					<li><i class="fa fa-times text-warning"></i> Nilai SKS dihitung berdasarkan akumulasi matakuliah dengan nilai minimum <strong>C</strong>.</li>
					<li><i class="fa fa-times text-warning"></i> Saat ini anda dapat mengambil matakuliah reguler yang telah ditawarkan untuk memenuhi syarat SKS, dan dapat mulai mengambil Paket MBKM pada semester selanjutnya</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['status', 'mbkm_allowed', 'mhs']
	};
</script>

<style lang="scss" scoped></style>
