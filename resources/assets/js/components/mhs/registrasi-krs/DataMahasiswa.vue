<template>
	<div>
		<div class="row">
			<div class="col-sm-12 col-md-9">
				<div class="card card-outline-danger">
					<div class="card-header">
						<h4 class="m-b-0 text-white">Informasi Mahasiswa</h4>
					</div>
					<div class="card-body">
						<form class="" action="" method="post">
							<div class="row mt-1">
								<div class="col-md-3">
									<label>NIM</label>
								</div>
								<div class="col-md-4">
									<input type="text" name="" class="form-control" readonly="" :value="mahasiswa['nim']" />
								</div>
							</div>

							<div class="row mt-1">
								<div class="col-md-3">
									<label>Nama</label>
								</div>
								<div class="col-md-4">
									<input type="text" name="" class="form-control" readonly="" :value="mahasiswa['nama_tercetak']" />
								</div>
							</div>

							<div class="row mt-1">
								<div class="col-md-3">
									<label>Fakultas</label>
								</div>
								<div class="col-md-4">
									<input type="text" name="fakultas_id" class="form-control" readonly="" :value="mahasiswa['fakultas']['nama_fakultas']" />
								</div>
							</div>
							<div class="row mt-1">
								<div class="col-md-3">
									<label>Program Studi</label>
								</div>
								<div class="col-md-4">
									<input type="text" name="prodi_id" class="form-control" readonly="" :value="mahasiswa['prodi']['nama_prodi']" />
								</div>
							</div>
							<div class="row mt-1">
								<div class="col-md-3">
									<label>Tahun Ajaran</label>
								</div>
								<div class="col-md-4">
									<input
										type="text"
										id="thn_ajaran"
										name="thn_ajaran"
										class="form-control"
										readonly=""
										:value="krs_global['tahun_ajaran'] + '/' + (krs_global['tahun_ajaran'] + 1) + ' Semester ' + krs_global['semester']['nama_semester']"
									/>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-3">
				<div class="card card-outline-danger" style="height: 135px !important;">
					<div class="card-header">
						<h4 class="m-b-0 text-white">IPK</h4>
					</div>
					<div class="card-body">
						<div class="d-flex">
							<div class="display-5 text-info m-auto">
								<span>
									<span class="fa fa-refresh fa-spin" v-if="is_loading"></span>
									{{ !is_loading ? local_ip['ipk'] : '' }}
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="card card-outline-danger" style="height: 135px !important;">
					<div class="card-header">
						<h4 class="m-b-0 text-white">IP Terakhir</h4>
					</div>
					<div class="card-body">
						<div class="d-flex">
							<div class="display-5 text-info m-auto">
								<span>
									<span class="fa fa-refresh fa-spin" v-if="is_loading"></span>
									{{ !is_loading ? local_ip['ips'] : '' }}
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['mahasiswa', 'krs_global'],
		data() {
			return {
				is_loading: true,
				local_ip: null
			};
		},
		methods: {
			getIP() {
				axios
					.get('/registrasi-krs/hitung-nilai', {
						params: {
							mahasiswa_id: this.mahasiswa['mahasiswa_id'],
							thn_ajaran: this.krs_global['tahun_ajaran'] + '/' + (this.krs_global['tahun_ajaran'] + 1),
							semester: this.krs_global['semester_id']
						}
					})
					.then(({ data }) => {
						this.local_ip = data;
						this.$emit('send-ip', data);
						this.is_loading = false;
					});
			}
		},
		created() {
			this.getIP();
		}
	};
</script>

<style lang="scss" scoped></style>
