<template>
	<div>
		<div v-if="!is_show_detail">
			<div class="card card-outline-danger">
				<div class="card-header">
					<h4 class="m-b-0 text-white">Penawaran Paket MBKM</h4>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="form-group row" style="    margin-bottom: 10px;">
								<label for="tahunajaran" class="col-md-3 col-sm-12 font-weight-bold">Tahun Ajaran</label>
								<!-- <input type="text" class="form-control col-md-9 col-sm-12" :value="ta['tahun_ajaran'] + '/' + (ta['tahun_ajaran'] + 1)" disabled /> -->
								<select class="form-control col-md-9 col-sm-12" name="tahun_ajaran" v-model="filter.tahunajaran" required="">
									<option :value="ta['tahun_ajaran']" v-for="(ta, index) in ta_all" :key="index">{{ ta['tahun_ajaran'] }}/{{ ta['tahun_ajaran'] + 1 }}</option>
								</select>
							</div>
							<div class="form-group row">
								<label for="semester" class="col-md-3 col-sm-12 font-weight-bold">Semester</label>
								<!-- <input type="text" class="form-control col-md-9 col-sm-12" :value="ta['semester']['nama_semester']" disabled /> -->
								<select class="form-control col-md-9 col-sm-12" name="semester" v-model="filter.semester" required="">
									<option value="1">Ganjil</option>
									<option value="2">Genap</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12 text-left mt-2">
							<button class="btn btn-secondary waves-effect waves-light" type="button" v-on:click="fetchPenawaranPaket(1)">
								<span class="btn-label"><i class="mdi mdi-refresh"></i></span> Refresh
							</button>
							<button class="btn btn-primary waves-effect waves-light" type="button" v-on:click="openPenawaran()">
								<span class="btn-label"><i class="mdi mdi-plus"></i></span> Generate Penawaran
							</button>
							<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="openDaftarPaket()">
								<span class="btn-label"><i class="mdi mdi-plus"></i></span> Tambah Penawaran
							</button>
							<button class="btn btn-success waves-effect waves-light" type="button" v-on:click="rekapPenawaran()">
								<span class="btn-label"><i class="mdi mdi-file-excel"></i></span> Rekap Penawaran
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Keterangan</h4>
					<h6 class="card-subtitle">Penjelasan terkait penawaran paket MBKM.</h6>
					<ul class="list-icons">
						<li><i class="fa fa-check text-info"></i> Menu Penawaran Paket MBKM digunakan untuk melakukan penawaran Paket MBKM Program Studi kepada Mahasiswa.</li>
						<li><i class="fa fa-check text-info"></i> Mahasiswa dapat mengambil Paket MBKM yang telah ditawarkan sesuai dengan semesternya.</li>
					</ul>
				</div>
			</div>

			<!-- tabel penawaran paket -->
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="row form-group">
								<label for="per_page" class="col-md-2">Per Page</label>
								<div class="col-md-3">
									<select name="per_page" id="per_page" v-model="per_page" class="custom-select">
										<option value="5">5</option>
										<option value="10">10</option>
										<option value="25">25</option>
										<option value="50">50</option>
										<option value="100">100</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6 text-right"></div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th style="width: 30%">Info Paket</th>
									<th class="text-center">Jumlah Peminat</th>
									<th class="text-center">Jumlah Mitra</th>
									<th class="text-center">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<tr v-if="paket.length == 0 && !is_busy">
									<td class="text-center" colspan="10">Tidak Ada Data Paket MBKM</td>
								</tr>
								<tr v-if="is_busy">
									<td class="text-center" colspan="10"><i class="fa fa-spinner fa-spin"></i> Memproses...</td>
								</tr>
								<tr v-for="(item, index) in paket" :key="index" v-else>
									<td class="text-center">{{ item_start_index + index }}</td>
									<td>
										<strong>{{ item['nama_paket'] }}</strong> <br />
										Semester {{ item['semester_diambil'] }}
									</td>
									<td class="text-center">{{ item['paket_mahasiswa'].length }}</td>
									<td class="text-center">{{ item['mitra_count'] }}</td>
									<td class="text-center">
										<button type="button" class="btn btn-danger btn-sm mr-1" v-on:click="detailPenawaran(item)"><i class="mdi mdi-account-multiple"></i></button>
										<button type="button" class="btn btn-warning btn-sm" v-on:click="deletePenawaran(item)"><i class="mdi mdi-delete"></i></button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<hr />
					<div class="row">
						<div class="col-md-4 text-center">
							<span v-if="current_page > 1" class="clickable" v-on:click="fetchPenawaranPaket(current_page - 1)"> <i class="fa fa-chevron-left mr-2"></i> <strong>Sebelumnya</strong> </span>
						</div>
						<div class="col-md-4 text-center">
							<p>
								Halaman <strong>{{ current_page }}</strong> dari <strong>{{ last_page }}</strong>
							</p>
						</div>
						<div class="col-md-4 text-center">
							<span v-if="last_page > current_page" class="clickable" v-on:click="fetchPenawaranPaket(current_page + 1)"> <strong>Selanjutnya</strong> <i class="fa fa-chevron-right ml-2"></i> </span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<transition class="fade">
			<detail-penawaran v-if="is_show_detail" :penawaran="penawaran_selected" @detail-closed="toggleDetail" />
		</transition>

		<!-- modal penawaran -->
		<b-modal ref="my-modal" hide-footer title="Generate Penawaran">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label for="tahunajaran" class="font-weight-bold">Tahun Ajaran</label>
						<input type="text" class="form-control" :value="ta['tahun_ajaran'] + '/' + (ta['tahun_ajaran'] + 1)" disabled />
					</div>
					<div class="form-group">
						<label for="semester" class="font-weight-bold">Semester</label>
						<input type="text" class="form-control" :value="ta['semester']['nama_semester']" disabled />
					</div>
					<!-- <div class="form-group">
						<label for="semester_diambil" class="font-weight-bold">Semester Paket</label>
						<v-select multiple v-model="semester_selected" :options="[6, 7, 8]" />
					</div> -->
				</div>
				<div class="col-md-12 text-right mt-3">
					<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="generatePenawaran()">
						<span class="btn-label"><i class="mdi mdi-plus"></i></span> Generate Penawaran
					</button>
				</div>
			</div>
		</b-modal>

		<!-- modal penawaran individu-->
		<b-modal ref="my-modal-individu" hide-footer title="Generate Penawaran Individu" size="xl">
			<tabel-paket :tahunajar="filter" @refresh-penawaran="fetchPenawaranPaket()" />
		</b-modal>
	</div>
</template>

<script>
	import DetailPenawaran from './detailPenawaran.vue';
	import TabelPaket from './tabelPaket.vue';
	export default {
		components: { DetailPenawaran, TabelPaket },
		data() {
			return {
				ta: TA,
				ta_all: TA_ALL,
				paket: [],
				is_busy: false,
				page_info: null,
				per_page: 10,
				current_page: 1,
				last_page: 1,
				item_start_index: 1,

				semester_selected: [],

				is_show_detail: false,
				penawaran_selected: null,
				filter: {
					tahunajaran: '',
					semester: ''
				}
			};
		},
		watch: {
			per_page: function(new_val, old_val) {
				if (new_val) {
					this.fetchPenawaranPaket(this.current_page);
				}
			}
		},
		methods: {
			fetchPenawaranPaket(page = 1) {
				this.is_busy = true;
				axios
					.get('/penawaran-paket', {
						params: {
							filter: 'data',
							page: page,
							per_page: this.per_page,
							tahunajaran: this.filter.tahunajaran,
							semester: this.filter.semester
						}
					})
					.then(({ data }) => {
						this.paket = data['data'];
						this.last_page = data['last_page'];
						this.current_page = data['current_page'];
						this.item_start_index = data['from'];

						if (this.paket.length == 0) {
							//empty
						}
					})
					.finally(() => {
						this.is_busy = false;
					});
			},
			openPenawaran() {
				this.$swal
					.fire({
						title: 'Tidak Terdapat Penawaran',
						text: 'Tidak terdapat penawaran paket MBKM untuk tahun ajaran aktif, lakukan penawaran?',
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						cancelButtonText: 'Batal',
						confirmButtonText: 'Ya, Tawarkan!'
					})
					.then(result => {
						if (result.isConfirmed) {
							this.$refs['my-modal'].show();
						}
					})
					.finally(() => {});
			},
			generatePenawaran() {
				let form = {
					tahunajaran: this.ta['tahun_ajaran'],
					semester: this.ta['semester_id'],
					semester_diambil: this.semester_selected
				};

				axios
					.post('/penawaran-paket', form)
					.then(({ data }) => {
						this.fetchPenawaranPaket(1);
						this.$swal('', data['msg'], 'success');
						this.$refs['my-modal'].hide();
					})
					.catch(error => {
						let data = error['response']['data'];
						this.$swal('', data['message'], 'error');
					});
			},
			toggleDetail() {
				this.is_show_detail = !this.is_show_detail;
			},
			detailPenawaran(item) {
				this.penawaran_selected = item;
				this.toggleDetail();
			},
			deletePenawaran(item) {
				this.$swal
					.fire({
						title: 'Hapus Penawaran Paket?',
						text: 'Anda akan menghapus penawaran paket ' + item['nama_paket'],
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
								.post('/penawaran-paket/hapus', { pakettawar_id: item['pakettawar_id'] })
								.then(({ data }) => {
									if (data['success']) {
										this.$swal('', data['msg'], 'success');
										this.fetchPenawaranPaket(this.current_page);
									} else {
										this.$swal('', data['msg'], 'error');
									}
								})
								.catch(error => {
									let data = error['response']['data'];
									this.$swal('', data['message'], 'error');
								});
						}
					})
					.finally(() => {});
			},
			openDaftarPaket() {
				this.$refs['my-modal-individu'].show();
			},
			rekapPenawaran(){
				window.open('/penawaran-paket/rekap?tahunajaran=' + this.filter.tahunajaran + '&semester=' + this.filter.semester + '&output=excel', '_blank');
			}
		},
		created() {
			this.filter.tahunajaran = this.ta['tahun_ajaran'];
			this.filter.semester = this.ta['semester_id'];
		}
	};
</script>

<style lang="css" scoped>
	.form-group {
		margin-bottom: 10px;
	}
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity 0.2s;
	}
	.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
		opacity: 0;
	}
</style>
