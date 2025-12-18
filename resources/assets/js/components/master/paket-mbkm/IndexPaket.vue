<template>
	<div>
		<div class="card card-outline-danger">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Master Paket MBKM</h4>
			</div>
			<div class="card-body">
				<div v-if="!is_show_detail">
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
							<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="tambahPaket()">
								<span class="btn-label"><i class="mdi mdi-plus"></i></span> Tambah
							</button>
							<button class="btn btn-secondary waves-effect waves-light" type="button" v-on:click="fetchPaket()">
								<span class="btn-label"><i class="mdi mdi-refresh"></i></span> Refresh
							</button>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th style="width: 30%">Nama Paket</th>
									<th class="text-center">Semester</th>
									<th class="text-center">Jumlah Matakukiah</th>
									<th class="text-center">Jumlah SKS</th>
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
									</td>
									<td class="text-center">{{ item['semester_diambil'] }}</td>
									<td class="text-center">{{ item['matakuliah'].length }}</td>
									<td class="text-center">{{ item['sks_count'] }}</td>
									<td class="text-center">
										<button type="button" class="btn btn-danger btn-sm mr-1" v-on:click="editPaket(item)"><i class="mdi mdi-pencil"></i></button>
										<button type="button" class="btn btn-warning btn-sm" v-on:click="deletePaket(item)"><i class="mdi mdi-delete"></i></button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<hr />
					<div class="row">
						<div class="col-md-4 text-center">
							<span v-if="current_page > 1" class="clickable" v-on:click="fetchPaket(current_page - 1)"> <i class="fa fa-chevron-left mr-2"></i> <strong>Sebelumnya</strong> </span>
						</div>
						<div class="col-md-4 text-center">
							<p>
								Halaman <strong>{{ current_page }}</strong> dari <strong>{{ last_page }}</strong>
							</p>
						</div>
						<div class="col-md-4 text-center">
							<span v-if="last_page > current_page" class="clickable" v-on:click="fetchPaket(current_page + 1)"> <strong>Selanjutnya</strong> <i class="fa fa-chevron-right ml-2"></i> </span>
						</div>
					</div>
				</div>

				<transition class="fade">
					<div v-if="is_show_detail">
						<form-paket @detail-closed="toggleShowDetail" @save-succeed="fetchPaket" :paket="paket_selected" :jenis="jenis" />
					</div>
				</transition>
			</div>
		</div>
	</div>
</template>

<script>
	import FormPaket from './FormPaket.vue';
	export default {
		components: { FormPaket },
		data() {
			return {
				paket: [],
				jenis: JENIS,

				is_busy: false,
				page_info: null,
				per_page: 10,
				current_page: 1,
				last_page: 1,
				item_start_index: 1,

				is_show_detail: false,
				paket_selected: null
			};
		},
		watch: {
			per_page: function(new_val, old_val) {
				if (new_val) {
					this.fetchPaket(this.current_page);
				}
			}
		},
		methods: {
			fetchPaket(page = 1) {
				this.is_busy = true;
				axios
					.get('/master/paket', {
						params: {
							filter: 'data',
							page: page,
							per_page: this.per_page
						}
					})
					.then(({ data }) => {
						this.paket = data['data'];
						this.last_page = data['last_page'];
						this.current_page = data['current_page'];
						this.item_start_index = data['from'];

						this.paket.forEach(element => {
							let sks_count = 0;
							element['matakuliah'].forEach(element => {
								sks_count += element['sks'];
							});

							element.sks_count = sks_count;
						});
					})
					.finally(() => {
						this.is_busy = false;
					});
			},
			toggleShowDetail() {
				this.is_show_detail = !this.is_show_detail;
			},
			tambahPaket() {
				this.paket_selected = null;
				this.toggleShowDetail();
			},
			editPaket(paket) {
				this.paket_selected = paket;
				this.toggleShowDetail();
			},
			deletePaket(item) {
				this.$swal
					.fire({
						title: 'Hapus Paket?',
						text: 'Anda akan menghapus paket ' + item['nama_paket'],
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
								.delete('/master/paket/' + item['paket_id'])
								.then(({ data }) => {
									this.$swal('', data['msg'], 'success');
									this.fetchPaket();
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
		created() {
			this.fetchPaket();
		}
	};
</script>

<style lang="css" scoped>
	th {
		font-size: 1rem !important;
	}

	.clickable:hover {
		cursor: pointer;
		color: #c80000;
	}

	.fade-enter-active,
	.fade-leave-active {
		transition: opacity 0.2s;
	}
	.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
		opacity: 0;
	}
</style>
