<template>
	<div>
		<div class="card card-outline-danger">
			<div class="card-header">
				<h4 class="m-b-0 text-white">Detail Penawaran Paket MBKM</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<div class="pull-left">
							<address>
								<h3>
									&nbsp;<b class="text-danger">{{ penawaran['nama_paket'] }} - Semester {{ penawaran['semester_diambil'] }}</b>
								</h3>
								<p class="m-l-5" style="font-weight: 500;">
									Program Studi {{ penawaran['nama_prodi'] }} <br />
									{{ penawaran['nama_fakultas'] }} <br />
									Tahun Ajaran {{ penawaran['tahunajaran'] + '/' + (penawaran['tahunajaran'] + 1) }} <br />
									Semester {{ penawaran['semester'] == 1 ? 'Ganjil' : 'Genap' }}
								</p>
							</address>
						</div>
						<div class="pull-right text-right">
							<button class="btn btn-secondary waves-effect waves-light" type="button" v-on:click="$emit('detail-closed')">
								<span class="btn-label"><i class="mdi mdi-arrow-left-bold"></i></span> Kembali
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<div class="d-flex flex-wrap">
					<div>
						<h4 class="card-title">Daftar Peminat</h4>
						<h6 class="card-subtitle">List Mahasiswa yang mengambil paket {{ penawaran['nama_paket'] }} - Semester {{ penawaran['semester_diambil'] }}</h6>
					</div>
					<div class="ml-auto align-self-center">
						<ul class="list-inline m-b-0">
							<button class="btn btn-secondary waves-effect waves-light" type="button" v-on:click="fetchPeminat()">
								<span class="btn-label"><i class="mdi mdi-refresh"></i></span> Refresh
							</button>
							<!-- <button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="cetakPenawaranPaket()">
								<span class="btn-label"><i class="mdi mdi-printer"></i></span> PDF
							</button>
							<button class="btn btn-success waves-effect waves-light" type="button" v-on:click="cetakPenawaranPaket()">
								<span class="btn-label"><i class="mdi mdi-printer"></i></span> Excel
							</button> -->
							<div class="btn-group">
								<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<span class="btn-label"><i class="mdi mdi-printer"></i></span> Cetak
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" :href="'/penawaran-paket/cetak?pakettawar_id=' + penawaran['pakettawar_id']">Cetak PDF</a>
									<a class="dropdown-item" :href="'/penawaran-paket/cetak?pakettawar_id=' + penawaran['pakettawar_id'] + '&output=excel'">Cetak Excel</a>
								</div>
							</div>
						</ul>
					</div>
				</div>
				<hr />
				<div class="row">
					<div class="col-md-9">
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
					<div class="col-md-3 text-right">
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control" id="searchbox" placeholder="Cari berdasarkan Nama atau NIM" v-model="search_box" />
								<div class="input-group-append">
									<span class="input-group-text" id="basic-addon2">
										<i class="ti-search"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th class="text-center" style="width: 5%">No</th>
								<th style="width: 10%">NIM</th>
								<th style="width: 20%">Nama Mahasiswa</th>
								<th style="width: 30%">Mitra & Dosen Pembimbing</th>
								<th style="width: 7%">Nilai Angka</th>
								<th style="width: 13%">Nilai Huruf</th>
								<th style="width: 5%" class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<tr v-if="mahasiswa.length == 0 && !is_busy">
								<td class="text-center" colspan="10">Tidak Ada Data Peminat Paket MBKM</td>
							</tr>
							<tr v-if="is_busy">
								<td class="text-center" colspan="10"><i class="fa fa-spinner fa-spin"></i> Memproses...</td>
							</tr>
							<tr v-for="(item, index) in mahasiswa" :key="index" v-else>
								<td class="text-center">{{ item_start_index + index }}</td>
								<td>{{ item['mahasiswa']['nim'] }}</td>
								<td>
									<span :class="item['is_approved'] == 1 ? '' : 'crossed'">
										{{ item['mahasiswa']['nama_tercetak'] }}
									</span>
									<strong v-if="item['is_approved'] == 0" class="text-danger">
										<br />
										Mahasiswa Belum Di-approve
									</strong>
									<strong v-if="item['unapprove'] > 0" class="text-danger">
										<br />
										KRS Belum Di-approve
									</strong>
								</td>
								<td>
									<div class="row">
										<label for="" class="col-md-3 font-weight-bold">Mitra : </label>
										<v-select
											class="col-md-9"
											append-to-body
											v-model="item.mitra_id"
											:options="mitra"
											label="nama_mitra"
											:reduce="mitra => mitra.mitra_id"
											:disabled="item['is_approved'] == 1 ? false : true"
											@input="onMitraSelected(item.mitra_id, index)"
										>
											<template #option="{nama_mitra, nama_prodi}"> {{ nama_mitra }} - Prodi {{ nama_prodi }}</template>
											<template slot="selected-option" slot-scope="option"> {{ option.nama_mitra }} - Prodi {{ option.nama_prodi }} </template>
										</v-select>
									</div>
									<div class="row mt-1">
										<label for="" class="col-md-3 font-weight-bold">Pembimbing 1 : </label>
										<v-select class="col-md-9" append-to-body v-model="item.dosen_id" :options="dosen" label="nama" :reduce="dosen => dosen.dosen_id" :disabled="item['is_approved'] == 1 ? false : true">
											<template #option="{nama, nip}"> {{ nip }} - {{ nama }}</template>
											<template slot="selected-option" slot-scope="option"> {{ option.nip }} - {{ option.nama }} </template>
										</v-select>
									</div>
									<div class="row mt-1">
										<label for="" class="col-md-3 font-weight-bold">Pembimbing 2 : </label>
										<v-select class="col-md-9" append-to-body v-model="item.dosen_id_2" :options="dosen" label="nama" :reduce="dosen => dosen.dosen_id" :disabled="item['is_approved'] == 1 ? false : true">
											<template #option="{nama, nip}"> {{ nip }} - {{ nama }}</template>
											<template slot="selected-option" slot-scope="option"> {{ option.nip }} - {{ option.nama }} </template>
										</v-select>
									</div>
								</td>
								<td>
									<input v-if="item['unapprove'] <= 0" step=".01" pattern="^-?(?:[0-9]+|[0-9]*\.[0-9]+)$" type="number" class="form-control" v-model="item.nilai_angka" @change="reconfigureNilaiHuruf(index)" />
								</td>
								<td>
									<span v-for="(nilai, index2) in master_nilai" :key="index2" v-if="item['unapprove'] <= 0">
										<input
											type="radio"
											:id="'radio' + item['paketmahasiswa_id'] + '' + nilai['masternilai_id']"
											:name="'nilai_huruf[' + index + ']'"
											class="with-gap radio-col-light-blue"
											:checked="item['nilai_huruf'] == nilai['nilai_huruf']"
											:value="nilai['nilai_huruf']"
											v-model="item['nilai_huruf']"
											@change="reconfigureNilaiAngka(index)"
										/>
										<label :for="'radio' + item['paketmahasiswa_id'] + '' + nilai['masternilai_id']">{{ nilai.nilai_huruf }}</label>
									</span>
								</td>
								<td class="text-center">
									<button v-if="item['is_approved'] == 1" type="button" class="btn btn-danger btn-sm mr-1" v-on:click="simpanIndividu(item)"><i class="mdi mdi-content-save"></i></button>
									<button v-if="item['is_approved'] == 0" type="button" class="btn btn-info btn-sm mr-1" v-on:click="approveMhs(item)"><i class="mdi mdi-check"></i></button>
									<button v-if="item['is_approved'] == 1" type="button" class="btn btn-warning btn-sm mr-1 mt-1" v-on:click="openConfigSK(item)"><i class="mdi mdi-file-document-box"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<hr />
				<div class="row">
					<div class="col-md-4 text-center">
						<span v-if="current_page > 1" class="clickable" v-on:click="fetchPeminat(current_page - 1)"> <i class="fa fa-chevron-left mr-2"></i> <strong>Sebelumnya</strong> </span>
					</div>
					<div class="col-md-4 text-center">
						<p>
							Halaman <strong>{{ current_page }}</strong> dari <strong>{{ last_page }}</strong>
						</p>
					</div>
					<div class="col-md-4 text-center">
						<span v-if="last_page > current_page" class="clickable" v-on:click="fetchPeminat(current_page + 1)"> <strong>Selanjutnya</strong> <i class="fa fa-chevron-right ml-2"></i> </span>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 text-right">
						<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="storeAll">
							<span class="btn-label"><i class="mdi mdi-content-save"></i></span> Simpan Semua
						</button>
					</div>
				</div>
			</div>
		</div>

		<b-modal ref="sk-modal" size="lg" centered hide-footer title="SK MBKM">
			<div class="form-group">
				<label class="font-weight-bold">No SK</label>
				<div>
					<input type="text" class="form-control" v-model="sk_form['no_sk']" />
				</div>
			</div>
			<div class="form-group">
				<label class="font-weight-bold">Tgl SK</label>
				<div>
					<input class="form-control" type="date" v-model="sk_form['tgl_sk']" />
				</div>
			</div>
			<div class="text-right">
				<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="simpanSK">
					<span class="btn-label"><i class="mdi mdi-content-save"></i></span> Simpan SK
				</button>
			</div>
		</b-modal>
	</div>
</template>

<script>
	export default {
		props: ['penawaran'],
		data() {
			return {
				is_busy: false,
				page_info: null,
				per_page: 50,
				current_page: 1,
				last_page: 1,
				item_start_index: 1,
				search_box: '',

				is_row_disabled: false,

				user_info: this.$store.state.role,
				mahasiswa: [],
				mitra: [],
				dosen: [],

				master_nilai: [],
				mitra_map: null,
				display_sk: false,

				sk_form: {
					paketmahasiswa_id: null,
					no_sk: null,
					tgl_sk: null
				}
			};
		},
		watch: {
			per_page: function(new_val, old_val) {
				if (new_val) {
					this.fetchPeminat(this.current_page);
				}
			},
			search_box: function(new_val, old_val) {
				if (new_val) {
					console.log(new_val);
					this.fetchPeminat();
				} else if (new_val == '') {
					this.fetchPeminat();
				}
			},
			mahasiswa: function(new_val, old_val) {
				if (new_val) {
					this.mitra_map = this.mahasiswa.map(mhs => {
						return {
							mitra_id: mhs['mitra_id']
						};
					});
				}
			}
		},
		methods: {
			fetchPeminat(page = 1) {
				this.is_busy = true;
				axios
					.get('/penawaran-paket/peminat', {
						params: {
							pakettawar_id: this.penawaran['pakettawar_id'],
							page: page,
							per_page: this.per_page,
							search: this.search_box
						}
					})
					.then(({ data }) => {
						this.mahasiswa = data['data'];

						this.last_page = data['last_page'];
						this.current_page = data['current_page'];
						this.item_start_index = data['from'];
					})
					.finally(() => {
						this.is_busy = false;
					});
			},
			fetchMitra() {
				axios
					.get('/master/mitra', {
						params: {
							filter: 'available'
						}
					})
					.then(({ data }) => {
						this.mitra = data;
					});
			},
			fetchDosen() {
				axios.get('/api/prodi/0/dosen').then(({ data }) => {
					this.dosen = data['msg'];
				});
			},
			simpanPeminatNilai(arr_data) {
				this.is_row_disabled = true;

				axios
					.post('/penawaran-paket/peminat', arr_data)
					.then(({ data }) => {
						this.$swal('', data['msg'], 'success');
						this.fetchMitra();
						this.fetchPeminat(1);
					})
					.catch(error => {
						let data = error['response']['data'];
						if (data['msg'] == 'mitra_overload') {
							this.$swal('', 'Mitra berikut telah melebihi batas kapasitas : \n' + data['data'], 'error');
						} else {
							this.$swal('', data['msg'], 'error');
						}
					})
					.finally(() => {
						this.is_row_disabled = false;
					});
			},
			simpanIndividu(item) {
				let arr_data = [
					{
						paketmahasiswa_id: item['paketmahasiswa_id'],
						mitra_id: item['mitra_id'],
						dosen_id: item['dosen_id'],
						dosen_id_2: item['dosen_id_2'],
						nilai_huruf: item['nilai_huruf'],
						nilai_angka: item['nilai_angka'],
						nilai_konversi: item['nilai_konversi'],
						is_approved: 1
					}
				];

				this.simpanPeminatNilai(arr_data);
			},
			approveMhs(item) {
				let arr_data = [
					{
						paketmahasiswa_id: item['paketmahasiswa_id'],
						mitra_id: item['mitra_id'],
						dosen_id: item['dosen_id'],
						dosen_id_2: item['dosen_id_2'],
						is_approved: 1
					}
				];
				axios
					.post('/penawaran-paket/peminat', arr_data)
					.then(({ data }) => {
						this.$swal('', 'Mahasiswa Berhasil di Approve', 'success');
						this.fetchPeminat(1);
					})
					.catch(error => {
						let data = error['response']['data'];
						this.$swal('', data['msg'], 'error');
					});
			},
			storeAll() {
				let arr_data = this.mahasiswa.map(mhs => {
					return { paketmahasiswa_id: mhs['paketmahasiswa_id'], mitra_id: mhs['mitra_id'], dosen_id: mhs['dosen_id'], is_approved: 1, nilai_huruf: mhs['nilai_huruf'], nilai_angka: mhs['nilai_angka'], nilai_konversi: mhs['nilai_konversi'] };
				});

				this.simpanPeminatNilai(arr_data);
			},
			fetchMasterNilai() {
				axios.get('/master/masternilai/prodi/' + this.penawaran.prodi_id).then(({ data }) => {
					this.master_nilai = data;
				});
			},
			reconfigureNilaiAngka(index) {
				let this_mhs = this.mahasiswa[index];

				this.master_nilai.forEach(mnilai => {
					if (this_mhs['nilai_huruf'] == mnilai['nilai_huruf']) {
						this.mahasiswa[index]['nilai_angka'] = mnilai['nilai_bawah'];
						this.mahasiswa[index]['nilai_konversi'] = mnilai['nilai_angka'];
						return false;
					}
				});
			},
			reconfigureNilaiHuruf(index) {
				let this_mhs = this.mahasiswa[index];

				this.master_nilai.forEach(mnilai => {
					if (this_mhs['nilai_angka'] >= mnilai['nilai_bawah'] && this_mhs['nilai_angka'] <= mnilai['nilai_atas']) {
						this.mahasiswa[index]['nilai_huruf'] = mnilai['nilai_huruf'];
						this.mahasiswa[index]['nilai_konversi'] = mnilai['nilai_angka'];
						return false;
					}
				});
			},
			onMitraSelected(mitra_id, index) {
				let mitra_lama = this.mitra_map[index]['mitra_id'];
				let mitra_baru = this.mahasiswa[index]['mitra_id'];

				if (mitra_lama != mitra_baru) {
					// mitra berubah
					let index_mitralama = this.mitra.findIndex(mitra => {
						return mitra_lama == mitra['mitra_id'];
					});
					let index_mitrabaru = this.mitra.findIndex(mitra => {
						return mitra_baru == mitra['mitra_id'];
					});

					// cek dulu
					if (this.mitra[index_mitrabaru]['kapasitas'] <= this.mitra[index_mitrabaru]['selected_count']) {
						this.$swal('', 'Mitra ' + this.mitra[index_mitrabaru]['nama_mitra'] + ' sudah melebihi kapasitas, silahkan pilih mitra yang lain', 'error');
						this.mahasiswa[index]['mitra_id'] = this.mitra[index_mitralama]['mitra_id'];
						return false;
					}

					// ubah jumlah selected, kurangi yg lama & tambah yg baru
					this.mitra[index_mitralama]['selected_count'] -= 1;
					this.mitra[index_mitrabaru]['selected_count'] += 1;

					this.mitra_map[index]['mitra_id'] = mitra_id;
				}
			},
			openConfigSK(item) {
				this.sk_form['paketmahasiswa_id'] = item['paketmahasiswa_id'];
				this.sk_form['no_sk'] = item['no_sk'];
				this.sk_form['tgl_sk'] = item['tgl_sk'];
				this.$refs['sk-modal'].show();
			},
			simpanSK() {
				axios
					.post('/penawaran-paket/simpan-sk', this.sk_form)
					.then(({ data }) => {
						this.$swal('', data['msg'], 'success');
						this.fetchMitra();
						this.fetchPeminat(1);
						this.$refs['sk-modal'].hide();
					})
					.catch(error => {
						let data = error['response']['data'];

						this.$swal('', data['msg'], 'error');
					})
					.finally(() => {});
			},
			cetakPenawaranPaket() {
				window.open('/penawaran-paket/cetak?pakettawar_id=' + this.penawaran['pakettawar_id']);
			},
			cetakPenawaranPaketExcel() {
				window.open('/penawaran-paket/cetak?pakettawar_id=' + this.penawaran['pakettawar_id'] + '&output=excel');
			}
		},
		created() {
			this.fetchMitra();
			this.fetchDosen();
			this.fetchMasterNilai();
			this.fetchPeminat();
		}
	};
</script>

<style lang="css" scoped>
	.crossed {
		text-decoration: line-through;
		text-decoration-color: #c80000;
	}
</style>
