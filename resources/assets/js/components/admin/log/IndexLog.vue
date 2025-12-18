<template>
	<div>
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-6">
						<div class="row form-group">
							<label for="per_page" class="col-md-2">Per Page</label>
							<div class="col-md-3">
								<select name="per_page" id="per_page" v-model="per_page" class="custom-select">
									<option value="10">10</option>
									<option value="25">25</option>
									<option value="50">50</option>
									<option value="100">100</option>
									<option value="250">250</option>
									<!-- <option value="">Semua</option> -->
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6 text-right">
						<button class="btn btn-secondary waves-effect waves-light" type="button" v-on:click="fetchLog()">
							<span class="btn-label"><i class="mdi mdi-refresh"></i></span> Refresh
						</button>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th>Aksi</th>
								<th>User</th>
								<th>Tanggal</th>
								<th class="text-center">Detail</th>
							</tr>
						</thead>
						<tbody>
							<tr v-if="list_log.length == 0 && !is_busy">
								<td class="text-center" colspan="10">Tidak Ada LOG</td>
							</tr>
							<tr v-if="is_busy">
								<td class="text-center" colspan="10"><i class="fa fa-spinner fa-spin"></i> Memproses...</td>
							</tr>
							<tr v-for="(item, index) in list_log" :key="index" v-else>
								<td class="text-center">{{ item_start_index + index }}</td>
								<td>
									<b>{{ JSON.parse(item['log_action'])['MENU'] }}</b> <br />
								</td>
								<td>
									<i class="mdi mdi-account"></i> <b>{{ item['user']['identifier'] }}</b> - {{ item['user']['jenisuser_sso'] == 1 ? 'Mahasiswa' : item['user']['jenisuser_sso'] == 2 ? 'Dosen' : 'Pegawai' }} <br />
									<i class="mdi mdi-web"></i> {{ item['log_browser'] }} <br />
									<!-- <i class="mdi mdi-access-point"></i>
									<span v-if="item['hide_ip'] == 1">{{ item['log_ip'] }}</span>
									<span v-if="item['hide_ip'] == 0">*****************</span>
									<i class="mdi mdi-eye ml-3 clickable" v-on:click="showIp(index)"></i> -->
								</td>
								<td>
									{{ item['updated_at'] | formatDateTime }}
								</td>
								<td class="text-center">
									<button type="button" class="btn btn-danger btn-sm mr-1" v-on:click="checkPass(item)"><i class="mdi mdi-eye"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<hr />
				<div class="row">
					<div class="col-md-4 text-center">
						<span v-if="current_page > 1" class="clickable" v-on:click="fetchLog(current_page - 1)"> <i class="fa fa-chevron-left mr-2"></i> <strong>Sebelumnya</strong> </span>
					</div>
					<div class="col-md-4 text-center">
						<p>
							Halaman <strong>{{ current_page }}</strong> dari <strong>{{ last_page }}</strong>
						</p>
					</div>
					<div class="col-md-4 text-center">
						<span v-if="last_page > current_page" class="clickable" v-on:click="fetchLog(current_page + 1)"> <strong>Selanjutnya</strong> <i class="fa fa-chevron-right ml-2"></i> </span>
					</div>
				</div>
			</div>
		</div>

		<!-- detail LOG -->
		<b-modal ref="my-modal" hide-footer title="Detail Log" size="xl">
			<div class="row" v-if="selected_log">
				<div class="col-md-12">
					<h4>
						&nbsp;<b class="text-danger">{{ JSON.parse(selected_log['log_action'])['MENU'] }}</b>
					</h4>
					<div class="pull-left">
						<address>
							<p class="m-l-5">
								Username : <b>{{ selected_log['user']['identifier'] }}</b> <br />
								Jenis User : <b>{{ selected_log['user']['jenisuser_sso'] == 1 ? 'Mahasiswa' : selected_log['user']['jenisuser_sso'] == 2 ? 'Dosen' : 'Pegawai' }}</b> <br />
								Browser : <b>{{ selected_log['log_browser'] }}</b> <br />
								<!-- IP Address : <b>{{ selected_log['log_ip'] }}</b> <br /> -->
							</p>
						</address>
					</div>
					<div class="pull-right text-right">
						<address>
							<p class="m-r-5">
								Created : <b>{{ selected_log['created_at'] | formatDateTime }}</b> <br />
								Last Modified : <b>{{ selected_log['updated_at'] | formatDateTime }}</b> <br />
							</p>
						</address>
					</div>
				</div>
				<div class="col-md-12">
					<hr />
					<span style="font-weight:bold" class="text-uppercase">Detail Data : </span>
					<div class="card card-body">
						{{ JSON.parse(selected_log['log_action'])['LOG'] }}
					</div>
					<hr />
					<span style="font-weight:bold" class="text-uppercase">Post Request : </span>
					<div class="card card-body">
						{{ JSON.parse(selected_log['log_action'])['QUERY'] }}
					</div>
				</div>
			</div>
		</b-modal>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				is_busy: false,
				page_info: null,
				per_page: 50,
				current_page: 1,
				last_page: 1,
				item_start_index: 1,

				list_log: [],
				selected_log: null,

				is_detail_shown: false
			};
		},
		watch: {
			per_page: function(new_val, old_val) {
				this.fetchLog(this.current_page);
			}
		},
		methods: {
			fetchLog(page = 1) {
				this.is_busy = true;
				axios
					.get('', {
						params: {
							filter: 'data',
							page: page,
							per_page: this.per_page
						}
					})
					.then(({ data }) => {
						this.list_log = data['data'];
						this.last_page = data['last_page'];
						this.current_page = data['current_page'];
						this.item_start_index = data['from'];

						this.list_log.forEach(element => {
							element.hide_ip = 1;
						});
					})
					.finally(() => {
						this.is_busy = false;
					});
			},
			detailLog(item) {
				if (!this.is_detail_shown) {
					this.$swal('', 'Anda tidak diijinkan melihat detail log', 'error');
					return false;
				}
				this.selected_log = item;
				this.$refs['my-modal'].show();
			},
			checkPass(item) {
				if (this.is_detail_shown == false) {
					this.$swal
						.fire({
							title: 'Masukkan Password',
							input: 'password',
							inputAttributes: {
								autocapitalize: 'off'
							},
							showCancelButton: true,
							confirmButtonText: 'Submit',
							showLoaderOnConfirm: true,
							preConfirm: login => {
								return axios
									.post('/api/cek-cred', {
										password: login
									})
									.then(({ data }) => {
										return data['status'];
									})
									.catch(error => {
										this.$swal.showValidationMessage(`Request failed: ${error['response']['data']['message']}`);
									});
							},
							allowOutsideClick: () => !this.$swal.isLoading()
						})
						.then(result => {
							if (result.isConfirmed) {
								this.is_detail_shown = true;
								this.detailLog(item);
							}
						});
				} else {
					this.detailLog(item);
				}
			},
			showIp(index) {
				if (this.list_log[index]['hide_ip'] == 1) {
					this.list_log[index].hide_ip = 0;
				} else {
					this.list_log[index].hide_ip = 1;
				}

				alert(this.list_log[index]['hide_ip']);
			}
		},
		created() {
			this.fetchLog();
		}
	};
</script>

<style lang="css" scoped>
	.blurry-text {
		color: transparent;
		text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
	}

	.clickable:hover {
		cursor: pointer;
	}
</style>
