<template>
	<div>
		<div class="card card-outline-danger" v-if="role['generalization_id'] < 4">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Filter</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label class="font-weight-bold col-md-3">Program Studi</label>
							<div class="col-md-9">
								<select class="custom-select" v-model="filter['prodi_id']">
									<option value="" selected>Semua</option>
									<optgroup v-for="(fakultas, index) in prodi" :key="index" :label="fakultas['nama_fakultas']">
										<option v-for="(item, index) in fakultas['prodi']" :key="index" :value="item['prodi_id']">{{ item['nama_prodi'] }}</option>
									</optgroup>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="font-weight-bold col-md-3">Cari Berdasarkan Nama/Alamat</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="search" v-model="filter['search']" />
							</div>
						</div>
					</div>
					<div class="col-12 text-right">
						<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="fetchMitra()">
							<span class="btn-label"><i class="mdi mdi-magnify"></i></span> Cari
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card card-outline-danger">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Daftar Mitra</h4>
			</div>
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
					<div class="col-md-6 text-right">
						<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="tambahMitra()">
							<span class="btn-label"><i class="mdi mdi-plus"></i></span> Tambah
						</button>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th>Mitra</th>
								<th class="text-center">Kapasitas</th>
								<th>Program Studi</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<tr v-if="mitra.length == 0">
								<td class="text-center" colspan="10">Tidak Ada Data Mitra</td>
							</tr>
							<tr v-if="is_busy">
								<td class="text-center" colspan="10"><i class="fa fa-spinner fa-spin"></i> Memproses...</td>
							</tr>
							<tr v-for="(item, index) in mitra" :key="index" v-else>
								<td class="text-center">{{ item_start_index + index }}</td>
								<td>
									<strong>{{ item['nama_mitra'] }}</strong> <br />
									<span v-if="item['alamat']">
										<i class="mdi mdi-map-marker">{{ item['alamat'] }}</i>
									</span>
								</td>
								<td class="text-center">{{ item['kapasitas'] }}</td>
								<td>{{ item['prodi']['nama_prodi'] }}</td>
								<td class="text-center">
									<button type="button" class="btn btn-danger btn-sm mr-2" v-on:click="editMitra(item)"><i class="mdi mdi-pencil"></i></button>
									<button type="button" class="btn btn-warning btn-sm" v-on:click="deleteMitra(item)"><i class="mdi mdi-delete"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<hr />
				<div class="row">
					<div class="col-md-4 text-center">
						<span v-if="current_page > 1" :class="current_page > 1 ? 'clickable' : ''" v-on:click="fetchMitra(current_page - 1)"> <i class="fa fa-chevron-left mr-2"></i> <strong>Sebelumnya</strong> </span>
					</div>
					<div class="col-md-4 text-center">
						<p>
							Halaman <strong>{{ current_page }}</strong> dari <strong>{{ last_page }}</strong>
						</p>
					</div>
					<div class="col-md-4 text-center">
						<span v-if="last_page > current_page" :class="last_page > current_page ? 'clickable' : ''" v-on:click="fetchMitra(current_page + 1)"> <strong>Selanjutnya</strong> <i class="fa fa-chevron-right ml-2"></i> </span>
					</div>
				</div>
			</div>
		</div>

		<modal-mitra :is_open="is_modal_open" :mitra="mitra_selected" :title="modal_title" :role="role" @modal-closed="toggleModal" @save-succeed="fetchMitra(1)" />
	</div>
</template>

<script>
	import ModalMitra from './ModalMitra.vue';
	export default {
		components: { ModalMitra },
		data() {
			return {
				role: ROLE,
				prodi: PRODI,
				mitra: null,

				is_busy: false,
				page_info: null,
				per_page: 10,
				current_page: 1,
				last_page: 1,
				item_start_index: 1,

				is_modal_open: false,
				modal_title: '',
				mitra_selected: null,

				filter: {
					prodi_id: '',
					search: null
				}
			};
		},
		methods: {
			fetchMitra(page = 1) {
				// if (page == 0 || page > this.last_page) {
				// 	return false;
				// }
				this.is_busy = true;
				axios
					.get('/master/mitra', {
						params: {
							filter: 'data',
							page: page,
							per_page: this.per_page,
							prodi_id: this.filter['prodi_id'],
							search: this.filter['search']
						}
					})
					.then(({ data }) => {
						this.mitra = data['data'];
						this.last_page = data['last_page'];
						this.current_page = data['current_page'];
						this.item_start_index = data['from'];
					})
					.finally(() => {
						this.is_busy = false;
					});
			},
			toggleModal() {
				this.is_modal_open = !this.is_modal_open;
			},
			tambahMitra() {
				this.mitra_selected = null;
				this.modal_title = 'Tambah Mitra Baru';
				this.toggleModal();
			},
			editMitra(data) {
				this.mitra_selected = data;
				this.modal_title = 'Edit Mitra ' + data['nama_mitra'];
				this.toggleModal();
			},
			deleteMitra(data) {
				this.$swal
					.fire({
						title: 'Hapus Mitra?',
						text: 'Anda akan menghapus mitra ' + data['nama_mitra'],
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
								.delete('/master/mitra/' + data['mitra_id'])
								.then(({ data }) => {
									this.$swal('', data['msg'], 'success');
									this.fetchMitra();
								})
								.catch(error => {
									let data = error['response']['data'];
									this.$swal('', data['message'], 'error');
								});
						}
					})
					.finally(() => {});
			}
		},
		watch: {
			per_page: function(new_val, old_val) {
				if (new_val) {
					this.fetchMitra(this.current_page);
				}
			}
		},
		created() {
			this.fetchMitra();
		}
	};
</script>

<style>
	th {
		font-size: 1rem !important;
	}

	.clickable:hover {
		cursor: pointer;
		color: #c80000;
	}
</style>
