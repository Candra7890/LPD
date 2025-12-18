<template>
	<div>
		<div class="card card-outline-danger">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Data Prestasi Mahasiswa</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="form-group row" style="margin-bottom: 10px;">
							<label for="tahunajaran" class="col-md-3 col-sm-12 font-weight-bold">Tahun Ajaran</label>
							<select class="col-md-9 col-sm-12 custom-select" v-model="filter['aktivasi_id']">
								<option v-for="(item, index) in tahunajaran" :key="index" :value="item['aktivasi_id']" :selected="item['status_aktif'] === 1">
									{{ item['tahun_ajaran'] + '/' + (item['tahun_ajaran'] + 1) }} - {{ item['semester']['nama_semester'] }}
								</option>
							</select>
						</div>
					</div>
					<div class="col-lg-12 text-left mt-2">
						<button class="btn btn-secondary waves-effect waves-light" type="button" v-on:click="fetchPrestasi(1)">
							<span class="btn-label"><i class="mdi mdi-refresh"></i></span> Refresh
						</button>
						<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="openPrestasi">
							<span class="btn-label"><i class="mdi mdi-plus"></i></span> Tambah Prestasi
						</button>
					</div>
				</div>
			</div>
		</div>

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
								<th>Mahasiswa</th>
								<th class="text-center">Peringkat</th>
								<th>Prestasi</th>
								<th>Penyelenggara</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<tr v-if="prestasi.length == 0 && !is_busy">
								<td class="text-center" colspan="10">Tidak Ada Data Prestasi Mahasiswa</td>
							</tr>
							<tr v-if="is_busy">
								<td class="text-center" colspan="10"><i class="fa fa-spinner fa-spin"></i> Memproses...</td>
							</tr>
							<tr v-for="(item, index) in prestasi" :key="index" v-else>
								<td class="text-center">{{ item_start_index + index }}</td>
								<td>
									<ol>
										<li v-for="(mhs, index) in item['mhs']" :key="index">
											[ <b>{{ mhs['nim'] }}</b> ] <b>{{ mhs['nama_tercetak'] }}</b> - {{ mhs['pivot']['peran'] == 3 ? 'Personal' : mhs['pivot']['peran'] == 2 ? 'Anggota' : 'Ketua' }}
										</li>
									</ol>
								</td>
								<td class="text-center">{{ item['peringkat'] }}</td>
								<td>
									<b>{{ item['judul'] }}</b> <br />
									Tahun : {{ item['tahun'] }} <br />
									Tingkat : {{ item['tingkat']['nama_tingkat'] }} <br />
									Jenis : {{ item['jenis']['nama_jenis'] }} <br />
								</td>
								<td>
									<b>{{ item['penyelenggara'] }}</b> <br />
									Lokasi : {{ item['lokasi'] }} <br />
								</td>
								<td class="text-center">
									<button type="button" class="btn btn-danger btn-sm mb-1" v-on:click="editPrestasi(item)"><i class="mdi mdi-pencil"></i></button> <br />
									<button type="button" class="btn btn-warning btn-sm" v-on:click="deletePrestasi(item)"><i class="mdi mdi-delete"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<hr />
				<div class="row">
					<div class="col-md-4 text-center">
						<span v-if="current_page > 1" class="clickable" v-on:click="fetchPrestasi(current_page - 1)"> <i class="fa fa-chevron-left mr-2"></i> <strong>Sebelumnya</strong> </span>
					</div>
					<div class="col-md-4 text-center">
						<p>
							Halaman <strong>{{ current_page }}</strong> dari <strong>{{ last_page }}</strong>
						</p>
					</div>
					<div class="col-md-4 text-center">
						<span v-if="last_page > current_page" class="clickable" v-on:click="fetchPrestasi(current_page + 1)"> <strong>Selanjutnya</strong> <i class="fa fa-chevron-right ml-2"></i> </span>
					</div>
				</div>
			</div>
		</div>

		<modal-prestasi :is_open="is_modal_open" :prestasi="prestasi_selected" :tingkat="tingkat" :jenis="jenis" @modal-closed="toggleModal" @save-succeed="fetchPrestasi(1)"></modal-prestasi>
	</div>
</template>

<script>
	import ModalPrestasi from './ModalPrestasi.vue';
	export default {
		data() {
			return {
				tahunajaran: TAHUNAJARAN,
				tingkat: TINGKAT,
				jenis: JENIS,
				filter: {
					aktivasi_id: null
				},

				prestasi: [],
				prestasi_selected: null,

				is_busy: false,
				page_info: null,
				per_page: 10,
				current_page: 1,
				last_page: 1,
				item_start_index: 1,

				is_modal_open: false
			};
		},
		methods: {
			fetchPrestasi(page = 1) {
				this.is_busy = true;
				axios
					.get('/prestasi-mahasiswa', {
						params: {
							filter: 'data',
							aktivasi: this.filter['aktivasi_id'],
							page: page,
							per_page: this.per_page
						}
					})
					.then(({ data }) => {
						this.prestasi = data['data'];
						this.last_page = data['last_page'];
						this.current_page = data['current_page'];
						this.item_start_index = data['from'];
					})
					.finally(() => {
						this.is_busy = false;
					});
			},
			openPrestasi() {
				this.prestasi_selected = null;
				this.toggleModal();
			},
			editPrestasi(data) {
				this.prestasi_selected = data;
				this.toggleModal();
			},
			deletePrestasi(data) {
				console.log(data);
				this.$swal
					.fire({
						title: 'Hapus Prestasi?',
						text: 'Anda akan menghapus Prestasi ' + data['mhs']['nama_tercetak'],
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
								.delete('/prestasi-mahasiswa/' + data['prestasi_id'])
								.then(({ data }) => {
									this.$swal('', data['msg'], 'success');
									this.fetchPrestasi(1);
								})
								.catch(error => {
									let data = error['response']['data'];
									this.$swal('', data['message'], 'error');
								});
						}
					})
					.finally(() => {});
			},
			toggleModal() {
				this.is_modal_open = !this.is_modal_open;
			}
		},
		created() {
			this.tahunajaran.map(ta => {
				if (ta['status_aktif'] == 1) {
					this.filter['aktivasi_id'] = ta['aktivasi_id'];
				}
			});
		},
		components: { ModalPrestasi }
	};
</script>

<style lang="scss" scoped></style>
