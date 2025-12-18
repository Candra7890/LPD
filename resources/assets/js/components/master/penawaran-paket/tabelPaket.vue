<template>
	<div>
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
						<th style="width: 30%">Nama Paket</th>
						<th class="text-center">Semester</th>
						<th class="text-center">Jumlah Matakukiah</th>
						<th class="text-center">Jumlah SKS</th>
						<th class="text-center">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr v-if="list_paket.length == 0 && !is_busy">
						<td class="text-center" colspan="10">Tidak Ada Data Paket MBKM</td>
					</tr>
					<tr v-if="is_busy">
						<td class="text-center" colspan="10"><i class="fa fa-spinner fa-spin"></i> Memproses...</td>
					</tr>
					<tr v-for="(item, index) in list_paket" :key="index" v-else>
						<td class="text-center">{{ item_start_index + index }}</td>
						<td>
							<strong>{{ item['nama_paket'] }}</strong> <br />
						</td>
						<td class="text-center">{{ item['semester_diambil'] }}</td>
						<td class="text-center">{{ item['matakuliah'].length }}</td>
						<td class="text-center">{{ item['sks_count'] }}</td>
						<td class="text-center">
							<button type="button" class="btn btn-danger btn-sm mr-1" v-on:click="tawarPaket(item)"><i class="mdi mdi-plus"></i></button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-4 text-center">
				<span v-if="current_page > 1" class="clickable" v-on:click="fetchListPaket(current_page - 1)"> <i class="fa fa-chevron-left mr-2"></i> <strong>Sebelumnya</strong> </span>
			</div>
			<div class="col-md-4 text-center">
				<p>
					Halaman <strong>{{ current_page }}</strong> dari <strong>{{ last_page }}</strong>
				</p>
			</div>
			<div class="col-md-4 text-center">
				<span v-if="last_page > current_page" class="clickable" v-on:click="fetchListPaket(current_page + 1)"> <strong>Selanjutnya</strong> <i class="fa fa-chevron-right ml-2"></i> </span>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['tahunajar'],
		data() {
			return {
				is_busy: false,
				page_info: null,
				per_page: 10,
				current_page: 1,
				last_page: 1,
				item_start_index: 1,

				list_paket: []
			};
		},
		watch: {
			per_page: function(new_val, old_val) {
				if (new_val) {
					this.fetchListPaket(this.current_page);
				}
			}
		},
		methods: {
			fetchListPaket(page = 1) {
				this.is_busy = true;
				axios
					.get('/master/paket', {
						params: {
							filter: 'tawar',
							page: page,
							per_page: this.per_page,
							tahunajaran: this.tahunajar['tahunajaran'],
							semester: this.tahunajar['semester']
						}
					})
					.then(({ data }) => {
						this.list_paket = data['data'];
						this.last_page = data['last_page'];
						this.current_page = data['current_page'];
						this.item_start_index = data['from'];

						this.list_paket.forEach(element => {
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
			tawarPaket(item) {
				let form = {
					tahunajaran: this.tahunajar['tahunajaran'],
					semester: this.tahunajar['semester'],
					paket_id: item['paket_id']
				};

				axios
					.post('/penawaran-paket-individu', form)
					.then(({ data }) => {
						this.fetchListPaket(1);
						this.$swal('', data['msg'], 'success');
						this.$emit('refresh-penawaran');
					})
					.catch(error => {
						let data = error['response']['data'];
						this.$swal('', data['message'], 'error');
					});
			}
		},
		created() {
			this.fetchListPaket();
		}
	};
</script>

<style lang="scss" scoped></style>
