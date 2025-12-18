<template>
	<b-modal ref="modalMitra" title="Daftar Penawaran Matakuliah" centered size="xxl" ok-only ok-title="Tutup" ok-variant="secondary" v-model="isModalOpen" @hidden="modalClosed">
		<div v-if="ready">
			<div class="alert alert-info mb-2">
				<h5 class="text-info"><i class="fa fa-exclamation-circle"></i> Informasi</h5>
				{{ status_krs ? status_krs['msg'] : 'Tidak ada informasi tambahan' }}
			</div>
			<b-form-input v-model="filter" type="search" id="filterInput" placeholder="Cari matakuliah ..."> </b-form-input>
			<hr />
			<b-table hover show-empty class="table" :busy="isBusy" :items="mktawar" :fields="fields" :current-page="currentPage" :per-page="perPage" :filter="filter" :filterIncludedFields="filterOn" @filtered="onFiltered">
				<template v-slot:table-busy>
					<div class="text-center text-danger my-2">
						<b-spinner class="align-middle"></b-spinner>
						<strong>Loading...</strong>
					</div>
				</template>

				<template v-slot:cell(index)="data">
					{{ data.index + 1 }}
				</template>

				<template v-slot:cell(matakuliah)="data">
					[ <strong>{{ data.item['kode_matakuliah'] }}</strong> ] {{ data.item['nama_matakuliah'] }} <br />
					<!-- Semester {{ data.item['semester'] }} <br /> -->
					Kelas {{ data.item['kelas'] }} <br />
				</template>

				<template v-slot:cell(prodi)="data">
					{{ data.item['fakultas']['nama_fakultas'] }} <br />
					Program Studi {{ data.item['prodi']['nama_prodi'] }}
				</template>

				<template v-slot:cell(status)="data">
					{{ data.item['is_cross_study'] == 1 ? 'Lintas Prodi' : 'Reguler' }}
				</template>

				<template v-slot:cell(jadwal)="data"> {{ data.item['hari'] }}, {{ data.item['jam_mulai'] }} - {{ data.item['jam_berakhir'] }} </template>

				<template v-slot:cell(actions)="row">
					<strong v-if="row.item.is_dipilih == 1">Matakuliah Sudah Diambil</strong>
					<button v-else type="button" class="btn btn-danger btn-sm" v-on:click="addMatkul(row.item)"><i class="fa fa-plus"></i></button>
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
		<v-loader color="#1976d2" :size="150" v-if="!ready"></v-loader>
	</b-modal>
</template>

<script>
	export default {
		props: ['is_open', 'setting', 'mktawar', 'jumlah_sks', 'status_krs'],
		data() {
			return {
				isModalOpen: false,
				ready: true,
				fields: [
					{
						key: 'index',
						label: 'Index',
						class: 'text-center',
						filterByFormatted: true
					},
					{
						key: 'matakuliah',
						label: 'Matakuliah',
						filterByFormatted: true
					},
					{
						key: 'prodi',
						label: 'Fakultas/Prodi',
						filterByFormatted: true
					},
					{
						key: 'semester',
						label: 'Semester',
						class: 'text-center',
						filterByFormatted: true
					},
					{
						key: 'sks',
						label: 'Jumlah SKS',
						class: 'text-center',
						filterByFormatted: true
					},
					{
						key: 'status',
						label: 'Status',
						class: 'text-center',
						filterByFormatted: true
					},
					{
						key: 'jadwal',
						label: 'Jadwal Perkuliahan',
						class: 'text-center'
					},
					{ key: 'actions', label: 'Aksi', class: 'text-center' }
				],
				isBusy: false,
				totalRows: 1,
				currentPage: 1,
				perPage: 10,
				pageOptions: [10, 15, 25, 50],
				filter: null,
				filterOn: ['kode_matakuliah', 'nama_matakuliah', 'prodi', 'fakultas']
			};
		},
		watch: {
			is_open: function(newVal, oldVal) {
				if (newVal) {
					this.isModalOpen = true;
				}
			},
			mktawar: function(newVal, oldVal) {
				if (newVal) {
					this.totalRows = newVal.length;
				}
			},
			jumlah_sks: function(newVal, oldVal) {
				if (newVal >= this.setting['maks_sks']) {
					this.isModalOpen = false;
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
			addMatkul(matkul) {
				this.$emit('add-matkul', matkul);
			}
		}
	};
</script>

<style lang="scss" scoped></style>
