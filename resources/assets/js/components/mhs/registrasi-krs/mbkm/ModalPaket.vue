<template>
	<b-modal ref="modalMitra" title="Daftar Penawaran Paket MBKM" centered select-mode="single" size="xxl" ok-only ok-title="Tutup" ok-variant="secondary" v-model="isModalOpen" @hidden="modalClosed">
		<div v-if="ready">
			<b-form-input v-model="filter" type="search" id="filterInput" placeholder="Cari Paket MBKM ..."> </b-form-input>
			<hr />
			<b-table show-empty class="table" :busy="isBusy" :items="paket_tawar" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" @filtered="onFiltered">
				<template v-slot:table-busy>
					<div class="text-center text-danger my-2">
						<b-spinner class="align-middle"></b-spinner>
						<strong>Loading...</strong>
					</div>
				</template>

				<template v-slot:cell(index)="data">
					{{ data.index + 1 }}
				</template>

				<template v-slot:cell(paket)="data">
					<strong>{{ data.item['nama_paket'] }}</strong>
				</template>

				<template v-slot:cell(detail)="row">
					<button type="button" class="btn btn-danger btn-sm" @click="toggleDetails(row)"><i class="fa fa-eye"></i> {{ row.detailsShowing ? 'Tutup' : 'Tampilkan' }}</button>
				</template>
				<template v-slot:row-details="{ item }">
					<v-loader color="#1976d2" :size="150" v-if="isLoading"></v-loader>
					<div v-else class="row">
						<div class="col-md-1"></div>
						<div class="col-md-11">
							<table class="table table-borderless table-sm">
								<thead>
									<tr>
										<th class="text-center">#</th>
										<th>Kode Matakuliah</th>
										<th>Nama Matakuliah</th>
										<th class="text-center">Semester</th>
										<th class="text-center">SKS</th>
									</tr>
								</thead>
								<tbody v-if="detail_paket.length > 0">
									<tr v-for="(det_item, index) in detail_paket" :key="index">
										<td class="text-center">{{ index + 1 }}</td>
										<td>{{ det_item['kode_matakuliah'] }}</td>
										<td>{{ det_item['nama_matakuliah'] }}</td>
										<td class="text-center">{{ det_item['semester'] }}</td>
										<td class="text-center">{{ det_item['sks'] }}</td>
									</tr>
								</tbody>
								<tbody v-else>
									<tr>
										<td colspan="10" class="text-center">Data Tidak Ditemukan</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</template>

				<template v-slot:cell(actions)="row">
					<button type="button" class="btn btn-danger btn-sm" @click="choosePaket(row.item)"><i class="fa fa-plus"></i></button>
				</template>
			</b-table>
			<div class="row">
				<div class="col-md-4">
					<b-form-group label="Per page" label-cols-sm="6" label-cols-md="4" label-cols-lg="3" label-align-sm="right" label-size="sm" label-for="perPageSelect" class="mb-0">
						<b-form-select v-model="perPage" id="perPageSelect" size="sm" :options="pageOptions"></b-form-select>
					</b-form-group>
				</div>
				<div class="col-md-4 ml-auto">
					<div class="ml-auto">
						<b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill" size="sm" class="my-0"></b-pagination>
					</div>
				</div>
			</div>
		</div>
	</b-modal>
</template>

<script>
	export default {
		props: ['is_open', 'paket_tawar', 'mahasiswa'],
		data() {
			return {
				isModalOpen: false,
				ready: true,
				fields: [
					{
						key: 'index',
						label: 'No',
						class: 'text-center',
						filterByFormatted: true
					},
					{
						key: 'paket',
						label: 'Paket',
						filterByFormatted: true
					},
					{
						key: 'semester_diambil',
						label: 'Semester',
						class: 'text-center',
						filterByFormatted: true
					},
					{ key: 'detail', label: 'Daftar Matakuliah', class: 'text-center' },
					{ key: 'actions', label: 'Aksi', class: 'text-center' }
				],
				isBusy: false,
				totalRows: 1,
				currentPage: 1,
				perPage: 10,
				pageOptions: [10, 15, 25, 50],
				filter: null,
				filterOn: ['kode_matakuliah', 'nama_matakuliah', 'prodi', 'fakultas'],

				paket_selected: null,
				detail_paket: [],
				isLoading: true
			};
		},
		watch: {
			is_open: function(newVal, oldVal) {
				if (newVal) {
					this.isModalOpen = true;
				}
			},
			paket_selected: function(newVal, oldVal) {
				if (newVal) {
					this.getMatakuliah();
				}
			}
		},
		methods: {
			modalClosed() {
				this.$emit('modal-closed');
			},
			onFiltered(filteredItems) {
				this.totalRows = filteredItems.length;
				this.currentPage = 1;
			},
			toggleDetails(row) {
				if (row.detailsShowing) {
					this.$set(row.item, '_showDetails', false);
				} else {
					this.paket_tawar.forEach(item => {
						this.$set(item, '_showDetails', false);
					});

					this.$nextTick(() => {
						this.$set(row.item, '_showDetails', true);
						this.paket_selected = row.item['paket_id'];
					});
				}
			},
			getMatakuliah() {
				this.isLoading = true;
				axios
					.get('/registrasi-krs-mbkm/paket/' + this.paket_selected + '/matakuliah')
					.then(({ data }) => {
						this.detail_paket = data['matakuliah'];
					})
					.finally(() => {
						this.isLoading = false;
					});
			},
			choosePaket(item) {
				axios
					.post('/registrasi-krs-mbkm/paket', {
						tahunajaran: item['tahunajaran'],
						semester: item['semester'],
						paket_id: item['paket_id'],
						pakettawar_id: item['pakettawar_id'],
						nim: this.mahasiswa['nim']
					})
					.then(({ data }) => {
						this.$swal('', data['msg'], 'success');
						this.isModalOpen = false;
						this.$emit('pilihpaket-succeed');
					})
					.catch(error => {
						let data = error['response']['data'];
						this.$swal('', data['msg'], 'error');
					});
			}
		}
	};
</script>

<style lang="scss" scoped></style>
