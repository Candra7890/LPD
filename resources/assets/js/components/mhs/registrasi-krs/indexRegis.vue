<template>
	<div>
		<data-mahasiswa :mahasiswa="mahasiswa" :krs_global="krs_global" @send-ip="getIPFromChild" />

		<notif-periode :errors="error" v-if="error.length > 0" />

		<div class="mb-10" v-if="error.length > 0 && mahasiswa['setting']['rule'] == 'paket_mbkm' && paket_mbkm['paket_diambil'] != null">
			<div class="card card-body">
				<h4 class="m-l-5">Informasi Paket Merdeka Belajar Kampus Merdeka Diambil :</h4>
				<div class="row">
					<div class="col-md-12">
						<div class="pull-left">
							<address>
								<h3>
									&nbsp;<b class="text-danger">{{ paket_mbkm['paket_diambil']['paket']['nama_paket'] }}</b>
								</h3>
								<h4 class="m-l-5">Semester {{ paket_mbkm['paket_diambil']['paket']['semester_diambil'] }}</h4>
								<h4 class="m-l-5">Program Studi {{ paket_mbkm['paket_diambil']['paket']['prodi']['nama_prodi'] }}</h4>
							</address>
						</div>
						<div class="pull-right text-right">
							<address>
								<h4 v-if="paket_mbkm['paket_diambil']['mitra_id'] != null">
									Mitra : <b>{{ paket_mbkm['paket_diambil']['mitra']['nama_mitra'] }}</b>
								</h4>
								<h4 v-if="paket_mbkm['paket_diambil']['dosen_id'] != null">
									Pembimbing 1 : <b>{{ paket_mbkm['paket_diambil']['dosen']['nama_tercetak'] }}</b>
								</h4>
								<h4 v-if="paket_mbkm['paket_diambil']['dosen_id_2'] != null">
									Pembimbing 2 : <b>{{ paket_mbkm['paket_diambil']['dosen_dua']['nama_tercetak'] }}</b>
								</h4>
							</address>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div>
			<status-mahasiswa :status="mahasiswa['setting']" :mbkm_allowed="mbkm_allowed" v-if="mahasiswa['setting']['rule'] != 'regular_study' && error.length <= 0" />

			<div class="card">
				<div class="" v-if="isLoading">
					<v-loader color="#1976d2" :size="150"></v-loader>
				</div>
				<div class="card-body" v-else>
					<div v-if="error.length <= 0">
						<div class="d-flex flex-wrap" v-if="mahasiswa['setting']['rule'] != 'paket_mbkm' || mbkm_allowed['status'] == 0">
							<div>
								<h4 class="card-title">Matakuliah Diambil</h4>
								<h6 class="card-subtitle">Daftar Matakuliah yang akan diambil pada Tahun Ajaran {{ krs_global['tahun_ajaran'] + '/' + (krs_global['tahun_ajaran'] + 1) }} Semester {{ krs_global['semester']['nama_semester'] }}</h6>
							</div>
							<div class="ml-auto align-self-center">
								<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="openMktawar">
									<span class="btn-label"><i class="mdi mdi-plus"></i></span> Tambah Matakuliah
								</button>
							</div>
						</div>
						<div class="d-flex flex-wrap" v-else>
							<div>
								<h4 class="card-title">Paket Merdeka Belajar Kampus Merdeka</h4>
								<h6 class="card-subtitle">Tahun Ajaran {{ krs_global['tahun_ajaran'] + '/' + (krs_global['tahun_ajaran'] + 1) }} Semester {{ krs_global['semester']['nama_semester'] }}</h6>
							</div>
							<div class="ml-auto align-self-center">
								<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="openPaketTawar">
									<span class="btn-label"><i class="mdi mdi-plus"></i></span>
									{{ paket_mbkm['paket_diambil'] == null ? 'Tambah Paket MBKM' : 'Ubah Paket MBKM' }}
								</button>
								<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="openMktawar">
									<span class="btn-label"><i class="mdi mdi-plus"></i></span> Tambah Matakuliah
								</button>
							</div>
						</div>
						<hr />

						<div class="text-center" v-if="mahasiswa['setting']['rule'] == 'paket_mbkm' && mbkm_allowed['status'] == 1 && paket_mbkm['paket_diambil'] == null">
							<h3 class="mt-30">Anda Belum Memilih Paket Merdeka Belajar Kampus Merdeka</h3>
							<p class="mb-10">
								Silahkan masukan pilih Paket MBKM menggunakan tombol diatas.
							</p>
						</div>

						<div class="mb-10" v-if="mahasiswa['setting']['rule'] == 'paket_mbkm' && mbkm_allowed['status'] == 1 && paket_mbkm['paket_diambil'] != null">
							<div class="card card-body">
								<h4 class="m-l-5">Informasi Paket Merdeka Belajar Kampus Merdeka Diambil :</h4>
								<div class="row">
									<div class="col-md-12">
										<div class="pull-left">
											<address>
												<h3>
													&nbsp;<b class="text-danger">{{ paket_mbkm['paket_diambil']['paket']['nama_paket'] }}</b>
												</h3>
												<h4 class="m-l-5">Semester {{ paket_mbkm['paket_diambil']['paket']['semester_diambil'] }}</h4>
												<h4 class="m-l-5">Program Studi {{ paket_mbkm['paket_diambil']['paket']['prodi']['nama_prodi'] }}</h4>
											</address>
										</div>
										<div class="pull-right text-right">
											<address>
												<button class="btn btn-warning waves-effect waves-light" type="button" v-on:click="deletePaketDiambil" v-if="paket_mbkm['paket_diambil']['mitra_id'] == null">
													<span class="btn-label"><i class="mdi mdi-delete"></i></span> Hapus Paket MBKM
												</button>
												<h4 v-if="paket_mbkm['paket_diambil']['mitra_id'] != null">
													Mitra : <b>{{ paket_mbkm['paket_diambil']['mitra']['nama_mitra'] }}</b>
												</h4>
												<h4 v-if="paket_mbkm['paket_diambil']['dosen_id'] != null">
													Pembimbing 1 : <b>{{ paket_mbkm['paket_diambil']['dosen']['nama_tercetak'] }}</b>
												</h4>
												<h4 v-if="paket_mbkm['paket_diambil']['dosen_id_2'] != null">
													Pembimbing 2 : <b>{{ paket_mbkm['paket_diambil']['dosen_dua']['nama_tercetak'] }}</b>
												</h4>
											</address>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="p-1">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th>Matakuliah</th>
										<th class="text-center">Jumlah SKS</th>
										<th>Info</th>
										<th>Kelas</th>
										<th>Jadwal</th>
										<th>Status Approve</th>
										<th>Catatan</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr v-if="krs_mhs.length == 0 && !is_busy">
										<td colspan="10" class="text-center font-weight-bold font-weight-italic">Tidak Ada Data KRS</td>
									</tr>
									<tr v-if="is_busy">
										<td class="text-center" colspan="10"><i class="fa fa-spinner fa-spin"></i> Memproses...</td>
									</tr>
									<tr v-else v-for="(krs, index) in krs_mhs" :key="index">
										<td class="text-center">{{ index + 1 }}</td>
										<td>
											{{ krs['kode_matakuliah'] }} - {{ krs['nama_matakuliah'] }} <br />
											Semester {{ krs['semester'] }}
										</td>
										<td class="text-center">{{ krs['sks'] }}</td>
										<td>
											{{
												krs['is_cross_study'] == 1 && krs['fakultas_id'] == mahasiswa['fakultas_id']
													? 'MBKM Lintas Prodi'
													: krs['is_cross_study'] == 1 && krs['fakultas_id'] != mahasiswa['fakultas_id']
													? 'MBKM Lintas Fakultas'
													: krs['is_mbkm'] == 1
													? 'Paket MBKM'
													: 'Matakuliah Reguler'
											}}
										</td>
										<td>{{ krs['kelas'] }}</td>
										<td>{{ krs['hari'] + ', ' + krs['jam_mulai'] + ' - ' + krs['jam_berakhir'] }}</td>
										<td>
											<span class="label label-info" v-if="krs['is_approve'] == 1">Sudah Di-Approve</span>
											<span class="label label-warning" v-else>Belum Di-Approve</span>
										</td>
										<td>{{ krs['keterangan'] }}</td>
										<td v-if="error.length <= 0">
											<button data-toggle="tooltip" title="Ubah Status Approve" v-if="role['jenisuser_sso'] == 3" type="button" class="btn btn-warning btn-sm" v-on:click="unapproveKrs(krs['krs_id'])">
												<i class="fa fa-times" v-if="krs['is_approve'] == 1"></i>
												<i class="fa fa-check" v-if="krs['is_approve'] == 0"></i>
											</button>
											<button
												data-toggle="tooltip"
												title="Hapus Matakuliah"
												v-if="(krs['is_mbkm'] == 0 || krs['is_cross_study'] == 1) && krs['is_approve'] == 0"
												type="button"
												class="btn btn-danger btn-sm"
												v-on:click="deleteMatkul(krs['krs_id'], krs['nama_matakuliah'])"
											>
												<i class="fa fa-trash-o"></i>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<hr />

						<div>
							<div class="pull-left">
								<address>
									<div>
										Jumlah SKS Sekarang: <span style="font-weight: bold;">{{ jumlah_sks }}</span>
										<br />
										Maksimal Jumlah SKS Diambil: <span style="font-weight: bold;">{{ ip_mahasiswa ? ip_mahasiswa['maks_sks'] : '' }}</span>
									</div>
								</address>
							</div>
							<div class="pull-right text-right">
								<address>
									<button class="btn btn-danger waves-effect waves-light" type="button" v-if="type == 'admin'" v-on:click="approveAll">
										<span class="btn-label"><i class="mdi mdi-check-all"></i></span> Approve Semua
									</button>
									<a :href="'/registrasi-krs/cetak?nim=' + mahasiswa['nim'] + '&tahun_ajaran=' + krs_global['tahun_ajaran'] + '&semester=' + krs_global['semester_id']" class="btn btn-danger waves-effect waves-light" type="button">
										<span class="btn-label"><i class="fa fa-file-pdf-o"></i></span>Cetak KRS
									</a>
								</address>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- modal mktawar -->
		<modal-mktawar :is_open="is_mktawar_open" :setting="mahasiswa['setting']" :mktawar="mktawar" :jumlah_sks="jumlah_sks" :status_krs="status_krs" @modal-closed="openMktawar" @add-matkul="tambahMatakuliah" />
		<!-- modal paket tawar -->
		<modal-paket :is_open="is_paket_tawar_open" :mahasiswa="mahasiswa" :paket_tawar="paket_mbkm['paket_tawar']" @modal-closed="openPaketTawar" @pilihpaket-succeed="getPaketTawar" />
	</div>
</template>

<script>
	import DataMahasiswa from './DataMahasiswa.vue';
	import NotifPeriode from './NotifPeriodeKRS.vue';
	const ModalPaket = () => System.import(/* webpackChunkName: "modal-paket-mbkm" */ './mbkm/ModalPaket.vue');
	const ModalMktawar = () => System.import(/* webpackChunkName: "modal-mktawar" */ './ModalMktawar.vue');
	import StatusMahasiswa from './StatusMahasiswa.vue';
	export default {
		components: { DataMahasiswa, StatusMahasiswa, ModalMktawar, ModalPaket, NotifPeriode },
		data() {
			return {
				mahasiswa: USER,
				error: ERROR,
				krs_global: KRS_GLOBAL,
				mbkm_allowed: MBKM_ALLOWED,
				type: TYPE,

				role: null,

				ip_mahasiswa: null,
				jumlah_sks: 0,
				is_busy: false,

				krs_mhs: [],

				is_mktawar_open: false,
				mktawar: [],
				status_krs: null,

				paket_mbkm: {
					paket_diambil: null,
					paket_tawar: []
				},
				is_paket_tawar_open: false,

				isLoading: true,
				sks_fakultas: 0
			};
		},
		methods: {
			getIPFromChild(IP) {
				this.ip_mahasiswa = IP;
			},
			countSKSFakultas() {
				this.sks_fakultas = 0;
				this.krs_mhs.forEach(element => {
					if (element.is_cross_study == 1 && element.fakultas_id == this.mahasiswa.fakultas_id) {
						this.sks_fakultas += element.sks;
					}
				});
			},
			getKRSMhs() {
				this.is_busy = true;
				axios
					.get('/registrasi-krs/get_krs_mhs', {
						params: {
							nim: this.mahasiswa['nim']
						}
					})
					.then(({ data }) => {
						this.krs_mhs = data;
						this.jumlah_sks = 0;
						this.countSKSFakultas();

						this.is_busy = false;
						this.isLoading = false;
					});
			},
			openMktawar() {
				this.is_mktawar_open = !this.is_mktawar_open;
				if (this.is_mktawar_open) {
					this.getPenawaran();
				}
			},
			getPenawaran() {
				let params;
				if (this.mbkm_allowed['status'] == 0 && this.mahasiswa['setting']['rule'] == 'paket_mbkm') {
					params = { status: 'sks_kurang', nim: this.mahasiswa['nim'] };
				} else {
					params = { nim: this.mahasiswa['nim'] };
				}
				axios
					.get('/registrasi-krs-mbkm/penawaran', {
						params: params
					})
					.then(({ data }) => {
						this.mktawar = data['penawaran'];
						this.status_krs = data['status'];
					});
			},
			tambahMatakuliah(mktawar) {
				if (mktawar['fakultas_id'] == this.mahasiswa['fakultas_id'] && this.status_krs['status'] == 'cross_study') {
					if (this.sks_fakultas + mktawar['sks'] > 10 && mktawar['is_cross_study'] == 1) {
						this.$swal('', 'Batas pengambilan SKS Fakultas melebihi 10', 'error');
						return false;
					}
				}

				axios
					.post('/registrasi-krs-mbkm', {
						tahun_ajaran: this.krs_global['tahun_ajaran'],
						semester: this.krs_global['semester_id'],
						nim: this.mahasiswa['nim'],
						mktawar_id: mktawar['mktawar_id']
					})
					.then(({ data }) => {
						this.$swal('', data['msg'], 'success');
						this.getKRSMhs();
					})
					.catch(error => {
						let data = error['response']['data'];
						this.$swal('', data['msg'], 'error');
					});
			},
			deleteMatkul(krs_id, matkul) {
				this.$swal
					.fire({
						title: 'Hapus Matakuliah?',
						text: 'Anda akan menghapus matakuliah ' + matkul,
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						cancelButtonText: 'Batal',
						confirmButtonText: 'Ya, Hapus!'
					})
					.then(result => {
						if (result.isConfirmed) {
							axios
								.delete('/registrasi-krs-mbkm/' + krs_id)
								.then(({ data }) => {
									this.$swal('', data['msg'], 'success');
									this.getKRSMhs();
								})
								.catch(error => {
									let data = error['response']['data'];
									this.$swal('', data['msg'], 'error');
								});
						}
					})
					.finally(() => {});
			},
			approveAll() {
				this.$swal
					.fire({
						title: 'Approve Semua Matakuliah ?',
						text: 'Matakuliah dapat di-unapprove melalui menu Detail KRS',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						cancelButtonText: 'Batal',
						confirmButtonText: 'Ya'
					})
					.then(result => {
						if (result.isConfirmed) {
							axios
								.post('/approve-krs/approve_all', {
									tahun_ajaran: this.krs_global['tahun_ajaran'],
									semester: this.krs_global['semester_id'],
									nim: this.mahasiswa['nim']
								})
								.then(({ data }) => {
									this.$swal('', data['msg'], 'success');
									this.getKRSMhs();
								})
								.catch(error => {
									let data = error['response']['data'];
									this.$swal('', data['msg'], 'error');
								});
						}
					})
					.finally(() => {});
			},
			unapproveKrs(krs_id) {
				this.$swal
					.fire({
						title: 'Approve Matakuliah ?',
						text: 'Matakuliah dapat di-unapprove kembali',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						cancelButtonText: 'Batal',
						confirmButtonText: 'Ya'
					})
					.then(result => {
						if (result.isConfirmed) {
							axios
								.post('/approve-krs/accept', {
									krs: krs_id
								})
								.then(({ data }) => {
									this.$swal('', data['msg'], 'success');
									this.getKRSMhs();
								})
								.catch(error => {
									let data = error['response']['data'];
									this.$swal('', data['msg'], 'error');
								});
						}
					})
					.finally(() => {});
			},
			// ================== PAKET MBKM =========================================
			getPaketTawar() {
				axios
					.get('/registrasi-krs-mbkm/paket', {
						params: {
							nim: this.mahasiswa['nim']
						}
					})
					.then(({ data }) => {
						this.paket_mbkm = data;
						this.getKRSMhs();
					});
			},
			openPaketTawar() {
				// this.getPaketTawar();
				this.is_paket_tawar_open = !this.is_paket_tawar_open;
			},
			deletePaketDiambil() {
				console.log(this.paket_mbkm);
				this.$swal
					.fire({
						title: 'Hapus Pengambilan Paket MBKM?',
						text: 'Anda akan menghapus pengambilan paket MBKM ' + this.paket_mbkm['paket_diambil']['paket']['nama_paket'],
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						cancelButtonText: 'Batal',
						confirmButtonText: 'Ya, Hapus!'
					})
					.then(result => {
						if (result.isConfirmed) {
							axios
								.delete('/registrasi-krs-mbkm/paket/' + this.paket_mbkm['paket_diambil']['paketmahasiswa_id'])
								.then(({ data }) => {
									this.$swal('', data['msg'], 'success');
									this.getPaketTawar();
								})
								.catch(error => {
									let data = error['response']['data'];
									this.$swal('', data['msg'], 'error');
								});
						}
					})
					.finally(() => {});
			}
		},
		watch: {
			krs_mhs: function(newVal, oldVal) {
				if (newVal) {
					newVal.forEach(krs => {
						this.jumlah_sks += krs['sks'];
						this.mktawar.forEach(mktawar => {
							if (krs.mktawar_id == mktawar.mktawar_id) {
								mktawar.is_dipilih = 1;
								return false;
							}
						});
					});
				}
			},
			mktawar: function(newVal, oldVal) {
				if (newVal) {
					this.krs_mhs.forEach(krs => {
						newVal.forEach(mktawar => {
							if (krs.mktawar_id == mktawar.mktawar_id) {
								mktawar.is_dipilih = 1;
								return false;
							}
						});
					});
				}
			}
		},
		created() {
			axios.get(`/api/role-info`).then(res => {
				this.role = res['data']['current_role'];

				this.getKRSMhs();
			});

			if (this.mahasiswa['setting']['rule'] == 'paket_mbkm') {
				this.getPaketTawar();
			}
		}
	};
</script>

<style lang="scss" scoped></style>
