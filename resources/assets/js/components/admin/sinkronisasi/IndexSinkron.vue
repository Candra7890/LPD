<template>
	<div>
		<div class="row page-titles">
			<div class="col-lg-12 text-center">
				<h3 class="m-t-20 text-warning">
					Peringatan!
				</h3>
				<h3 class="">
					Menu <strong>Import Data</strong> adalah menu yang berfungsi untuk meng-import data dari SIA ke Nata Citta. <br />
					Gunakanlah menu ini jika terdapat perubahan data pada SIA.
				</h3>
			</div>
		</div>

		<div class="card card-body">
			<transition name="fade">
				<div class="col-lg-12 text-center m-t-20" v-if="!show_detail">
					<div v-if="!is_loading">
						<h5 class="text-muted">Master Data</h5>
						<div class="row">
							<span class="col-md-3 " v-on:click="syncMasterItem(index)" v-for="(item, index) in sync_master" :key="index">
								<div class="my-2 trans ">
									<div class="col-sm-12 text-danger pt-3">
										<!-- <i class="fa fa-check"></i> -->
									</div>
									<h4 style="font-weight: bold;" class="text-danger text-center">
										{{ item['name'] }}
									</h4>
									<p class="text-center">
										<small>
											Import data <strong>{{ item['name'] }}</strong> ke <strong>Nata Citta</strong>
										</small>
									</p>
								</div>
							</span>
						</div>
						<h5 class="text-muted">Transaksi Semester</h5>
						<div class="row">
							<span :class="'col' + (sync_transaksi.length > 3 ? '-md-3' : '')" v-on:click="syncTransItem(index)" v-for="(item, index) in sync_transaksi" :key="index">
								<div class="my-2 trans ">
									<div class="col-sm-12 text-danger pt-3">
										<!-- <i class="fa fa-check"></i> -->
									</div>
									<h4 style="font-weight: bold;" class="text-danger text-center">
										{{ item['name'] }}
									</h4>
									<p class="text-center">
										<small>
											Import data <strong>{{ item['name'] }}</strong> ke <strong>Nata Citta</strong>
										</small>
									</p>
								</div>
							</span>
						</div>
					</div>
					<v-loader v-else />
				</div>
				<div class="col-lg-12 text-center m-t-10" v-else>
					<h4 class="">Silahkan Pilih Filter Data</h4>
					<h5 class="text-muted">Filter Data Dapat Diisi untuk mempercepat proses Import Data</h5>
					<hr />
					<div class="row">
						<div class="col-md-4 text-left">
							<label for="">Pilih Program Studi</label>
							<select class="custom-select col-12" v-model="filter['prodi_id']" :disabled="!filter['prodi_enabled']">
								<option v-for="(item, index) in prodis" :key="index" :value="item['prodi_id']">{{ item['nama_prodi'] }}</option>
							</select>

							<h5 class="text-muted font-weight-italic m-t-10">*Filter yang tidak digunakan dalam proses import data akan otomatis ter-disabled</h5>
						</div>
						<div class="col-md-4 text-left">
							<label for="">Pilih Angkatan</label>
							<select class="custom-select col-12" v-model="filter['angkatan_id']" :disabled="!filter['angkatan_enabled']">
								<option v-for="(item, index) in angkatan" :key="index" :value="item['angkatan_id']">{{ item['tahun'] }}</option>
							</select>
						</div>
						<div class="col-md-4 text-left">
							<label for="">Pilih Tahun Ajaran</label>
							<select class="custom-select col-12" v-model="tahunajar_selected" :disabled="!filter['tahunajaran_enabled']">
								<option v-for="(item, index) in tahunajars" :key="index" :value="item">{{ item['tahun_ajaran'] + '/' + (item['tahun_ajaran'] + 1) + ' Semester ' + item['semester']['nama_semester'] }}</option>
							</select>
						</div>
						<div class="col-md-12">
							<button class="btn btn-danger waves-effect waves-light m-t-20" type="button" v-on:click="syncData" :disabled="is_loading">
								<span class="btn-label"><i class="fa " v-bind:class="{ 'fa-spin fa-spinner': is_loading, 'fa-cloud-download': !is_loading }"></i></span>
								Import Data
							</button>
							<button class="btn btn-secondary waves-effect waves-light m-t-20" type="button" v-on:click="toggleDetail" :disabled="is_loading">
								<span class="btn-label"><i class="fa fa-times"></i></span>Batal
							</button>
						</div>
					</div>
				</div>
			</transition>
		</div>

		<div class="card">
			<div class="card-body">
				<h4 class="card-title">Riwayat Sinkronisasi</h4>
				<h6 class="card-subtitle">
					Daftar riwayat sinkronisasi yang telah dilakukan sebelumnya
				</h6>
				<hr />
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
				</div>
				<table class="table">
					<thead>
						<tr>
							<th class="text-center">No.</th>
							<th class="">Log</th>
							<th class="text-center">Waktu</th>
							<th class="">Detail</th>
						</tr>
					</thead>
					<tbody>
						<tr v-if="is_busy">
							<td class="text-center" colspan="10"><i class="fa fa-spinner fa-spin"></i> Memproses...</td>
						</tr>
						<tr v-for="(item, index) in history_sync" :key="index" v-else>
							<td class="text-center font-weight-bold">{{ item_start_index + index }}</td>
							<td>
								<span class="font-weight-bold">{{ JSON.parse(item['log_action'])['LOG'] }}</span> <br />
							</td>
							<td class="text-center">{{ item['created_at'] }}</td>
							<td>
								IP : <strong>{{ item['log_ip'] }}</strong> <br />
								BROWSER : <strong>{{ item['log_browser'] }}</strong> <br />
								USER : <strong>{{ item['user']['identifier'] }}</strong>
							</td>
						</tr>
					</tbody>
				</table>
				<hr />
				<div class="row">
					<div class="col-md-4 text-center">
						<span v-if="current_page > 1" :class="current_page > 1 ? 'clickable' : ''" v-on:click="getLog(current_page - 1)"> <i class="fa fa-chevron-left mr-2"></i> <strong>Sebelumnya</strong> </span>
					</div>
					<div class="col-md-4 text-center">
						<p>
							Halaman <strong>{{ current_page }}</strong> dari <strong>{{ last_page }}</strong>
						</p>
					</div>
					<div class="col-md-4 text-center">
						<span v-if="last_page > current_page" :class="last_page > current_page ? 'clickable' : ''" v-on:click="getLog(current_page + 1)"> <strong>Selanjutnya</strong> <i class="fa fa-chevron-right ml-2"></i> </span>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				sync_master: [
					{ name: 'FAKULTAS', url: '/api/sync-sia/init-fakultas', params: '' },
					{ name: 'PRODI', url: '/api/sync-sia/init-prodi', params: '' },
					{ name: 'DOSEN', url: '/api/sync-sia/init-dosen', params: '' },
					{ name: 'MAHASISWA', url: '/api/sync-sia/init-mahasiswa/', id: 'prodi_id', params: '' },
					{ name: 'KURIKULUM', url: '/api/sync-sia/init-kurikulum', params: '' },
					{ name: 'MATAKULIAH', url: '/api/sync-sia/init-matakuliah', params: 'prodi_id, kurikulum_id' },
					{ name: 'SEMESTER (AKTIVASI)', url: '/api/sync-sia/init-semester', params: '' },
					{ name: 'RUANGAN', url: '/api/sync-sia/init-ruangan', params: '' }
				],
				sync_transaksi: [
					{ name: 'KELAS KULIAH', url: '/api/sync-sia/kelas', params: 'prodi_id, tahunajaran, semester' },
					{ name: 'PENGAMPU', url: '/api/sync-sia/pengampu', params: 'prodi_id, tahunajaran, semester' },
					{ name: 'KRS', url: '/api/sync-sia/krs', params: 'prodi_id, tahunajaran, semester' }
				],

				fields: [
					{ key: 'index', label: 'No. ', thStyle: 'width: 5%', class: 'text-center' },
					{ key: 'log_action', label: 'Aksi', thClass: 'text-center', thStyle: 'width: 40%' },
					{ key: 'created_at', label: 'Waktu', thClass: 'text-center' }
				],
				is_busy: false,
				page_info: null,
				per_page: 5,
				current_page: 1,
				last_page: 1,
				item_start_index: 1,

				show_detail: false,
				tipe_sync: 1, //1 untuk master, 2 untuk transaksi

				history_sync: null,
				prodis: null,
				tahunajars: null,
				angkatan: null,

				is_loading: false,

				filter: {
					prodi_id: null,
					prodi_enabled: false,
					tahunajaran: null,
					semester: null,
					tahunajaran_enabled: false,
					angkatan_id: null,
					angkatan_enabled: false
				},
				tahunajar_selected: null,

				IndexSelected: 0
			};
		},
		methods: {
			onFiltered(filteredItems) {
				this.totalRows = filteredItems.length;
				this.currentPage = 1;
			},
			toggleDetail() {
				this.show_detail = !this.show_detail;
			},
			syncData() {
				let index = [];
				if (this.tipe_sync == 1) {
					index = this.sync_master;
				} else {
					index = this.sync_transaksi;
				}

				this.$swal
					.fire({
						title: 'Import Data?',
						text: 'Anda akan mengimport data ' + index[this.IndexSelected]['name'],
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						cancelButtonText: 'Batal',
						confirmButtonText: 'Ya, Import!'
					})
					.then(result => {
						if (result.isConfirmed) {
							this.is_loading = true;
							axios
								.get(index[this.IndexSelected]['url'], { params: this.filter })
								.then(({ data }) => {
									let response = 'Berhasil mengimport ' + data['sukses'] + ' ' + index[this.IndexSelected]['name'];
									this.$swal('', response, 'success');
								})
								.catch(error => {
									let data = error['response']['data'];
									console.log(data);
									this.$swal('', data['msg'], 'error');
								})
								.finally(() => {
									this.is_loading = false;
									this.getLog(1);
								});
						}
					})
					.finally(() => {});
			},
			syncMasterItem(index) {
				this.IndexSelected = index;
				this.tipe_sync = 1;

				if (index == 3 || index == 5) {
					// mahasiswa dan matakuliah
					if (index == 3) {
						this.filter['prodi_enabled'] = true;
						this.filter['angkatan_enabled'] = true;
						this.filter['tahunajaran_enabled'] = false;
					} else if (index == 5) {
						this.filter['prodi_enabled'] = true;
						this.filter['angkatan_enabled'] = false;
						this.filter['tahunajaran_enabled'] = false;
					}
					this.tahunajar_selected = null;
					this.toggleDetail();
					return false;
				}

				this.syncData();
			},
			syncTransItem(index) {
				this.IndexSelected = index;
				this.tipe_sync = 2;

				this.filter['prodi_enabled'] = true;
				this.filter['tahunajaran_enabled'] = true;
				this.filter['angkatan_enabled'] = false;

				this.toggleDetail();
			},
			getLog(curr_page) {
				// if (page == 0 || page > this.last_page) {
				// 	return false;
				// }
				this.is_busy = true;
				axios
					.get('/api/sync-sia/log?per_page=' + this.per_page + '&page=' + curr_page + '&filter=')
					.then(({ data }) => {
						this.history_sync = data['data'];
						this.last_page = data['last_page'];
						this.current_page = data['current_page'];
						this.item_start_index = data['from'];
					})
					.finally(() => {
						this.is_busy = false;
					});
			},
			getProdi() {
				axios.get('/master/prodi/all/getallprodi').then(({ data }) => {
					this.prodis = data;
				});
			},
			getTahunajaran() {
				axios.get('/aktivasi-krs/all').then(({ data }) => {
					this.tahunajars = data;
				});
			},
			getAngkatan() {
				axios.get('/master/angkatan?type=api').then(({ data }) => {
					this.angkatan = data;
				});
			}
		},
		created() {
			this.getLog(1);
			this.getProdi();
			this.getTahunajaran();
			this.getAngkatan();
		},
		watch: {
			tahunajar_selected: function(newVal, oldVal) {
				if (newVal) {
					this.filter['tahunajaran'] = newVal['tahun_ajaran'];
					this.filter['semester'] = newVal['semester_id'];
				}
			},
			per_page: function(new_val, old_val) {
				if (new_val) {
					this.getLog(this.current_page);
				}
			}
		}
	};
</script>

<style lang="css">
	.trans {
		-webkit-transition: 0.1s ease-in;
		-o-transition: 0.1s ease-in;
		transition: 0.1s ease-in;
		position: relative;
		border: 1px solid #c80000;
		border-radius: 0.3rem;
	}

	.trans:hover {
		-webkit-box-shadow: 0 5px 50px rgba(0, 0, 0, 0.05);
		box-shadow: 0 5px 50px rgba(0, 0, 0, 0.05);
		-webkit-transform: scale(1.1);
		-ms-transform: scale(1.1);
		transform: scale(1.1);
		background: #ffffff;
		/*border: 2px solid #ffb74d;*/
		z-index: 10;
		cursor: pointer;
	}

	.clickable:hover {
		cursor: pointer;
		color: #c80000;
	}

	.table,
	th,
	td {
		vertical-align: middle;
	}
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity 0.3s ease;
	}

	.fade-enter-from,
	.fade-leave-to {
		opacity: 0;
	}
</style>
