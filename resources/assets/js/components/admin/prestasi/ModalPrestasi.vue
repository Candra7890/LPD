<template>
	<b-modal no-close-on-backdrop ref="modalPrestasi" title="Prestasi Mahasiswa" size="xl" v-model="is_modal_open" @hidden="modalClosed">
		<div v-if="ready">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group" style="margin-bottom: 10px;">
						<h5 for="judul">Judul</h5>
						<textarea rows="3" class="form-control" v-model="form['judul']" />
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<h5 for="jenis">Jenis Prestasi</h5>
						<select class="custom-select" v-model="form['jenisprestasi_id']">
							<option v-for="(item, index) in jenis" :key="index" :value="item['jenisprestasi_id']">{{ item['nama_jenis'] }}</option>
						</select>
					</div>
					<div class="form-group">
						<h5 for="peringkat">Peringkat</h5>
						<input type="number" class="form-control" v-model="form['peringkat']" />
					</div>
					<div class="form-group">
						<h5 for="penyelenggara">Penyelenggara</h5>
						<input type="text" class="form-control" v-model="form['penyelenggara']" />
					</div>
					<div class="form-group">
						<h5 for="no_sk">Nomor SK</h5>
						<input type="text" class="form-control" v-model="form['no_sk']" />
					</div>
					<div class="form-group">
						<h5 for="keterangan">Keterangan</h5>
						<textarea rows="3" class="form-control" v-model="form['keterangan']" />
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<h5 for="tingkat">Tingkat Prestasi</h5>
						<select class="custom-select" v-model="form['tingkatprestasi_id']">
							<option v-for="(item, index) in tingkat" :key="index" :value="item['tingkatprestasi_id']">{{ item['nama_tingkat'] }}</option>
						</select>
					</div>
					<div class="form-group">
						<h5 for="tahun">Tahun</h5>
						<input type="number" class="form-control" v-model="form['tahun']" max="9999" />
					</div>
					<div class="form-group">
						<h5 for="lokasi">Lokasi</h5>
						<input type="text" class="form-control" v-model="form['lokasi']" />
					</div>
					<div class="form-group">
						<h5 for="tgl_sk">Tanggal SK</h5>
						<input type="date" class="form-control" v-model="form['tgl_sk']" />
					</div>
				</div>
			</div>
			<hr />
			<h5>Tambahkan Mahasiswa</h5>
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Cari Mahasiswa Berdasarkan NIM" v-model="nim_mhs" />
							<div class="input-group-append">
								<button class="btn btn-danger" type="button" v-on:click="cariMahasiswa"><i class="fa fa-plus"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<table class="table">
						<tbody>
							<tr v-for="(mhs, index) in mahasiswa" :key="index" v-if="mhs['flag'] == 1">
								<td>{{ index + 1 }}</td>
								<td>{{ mhs['nim'] }} - {{ mhs['nama'] }}</td>
								<td>
									<select class="custom-select" v-model="mhs['peran']" placeholder="Pilih Peran (Set Personal Untuk Perorangan)">
										<option value="1">Ketua</option>
										<option value="2">Anggota</option>
										<option value="3">Personal</option>
									</select>
								</td>
								<td>
									<button class="btn btn-sm btn-danger waves-effect waves-light" type="button" @click="hapusItem(mahasiswa, index)">
										<i class="fa fa-trash-o"></i>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<hr />
			<h5>Tambahkan Dosen Pembimbing</h5>
			<div v-for="(item, index) in dosen" :key="index">
				<div class="form-group row" style="margin-bottom: 10px;" v-if="item.flag == 1">
					<label class="col-12">Pembimbing ke-{{ index + 1 }}</label>
					<div class="col-md-10 col-sm-12">
						<v-select v-model="item.dosen_id" :options="dosen_option" label="nama" :reduce="dosen => dosen.dosen_id">
							<template #option="{nip, nama}"> {{ nip }} - {{ nama }}</template>
							<template slot="selected-option" slot-scope="option"> {{ option.nip }} - {{ option.nama }}</template>
						</v-select>
					</div>
					<div class="col-md-2 col-sm-12" style="padding-right:10px;">
						<button class="btn btn-sm btn-info waves-effect waves-light" type="button" @click="tambahItem(dosen, index)" v-if="index == 0">
							<i class="fa fa-plus"></i>
						</button>
						<button class="btn btn-sm btn-danger waves-effect waves-light" type="button" @click="hapusItem(dosen, index)">
							<i class="fa fa-trash-o"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		<v-loader color="#1976d2" :size="150" v-if="!ready"></v-loader>
		<template #modal-footer>
			<div class="row">
				<div class="col-lg-12">
					<button type="button" class="btn waves-effect waves-light btn-outline-danger" @click="savePrestasi">Simpan</button>
					<button type="button" class="btn waves-effect waves-light btn-outline-secondary" @click="is_modal_open = false">Tutup</button>
				</div>
			</div>
		</template>
	</b-modal>
</template>

<script>
	export default {
		props: ['is_open', 'jenis', 'tingkat', 'prestasi'],
		data() {
			return {
				is_modal_open: false,
				ready: true,
				dosen_option: [],

				nim_mhs: null,
				mhs_found: {
					status: false,
					data: null,
					msg: '',
					load: false
				},

				form: {
					judul: null,
					tahun: null,
					jenisprestasi_id: null,
					tingkatprestasi_id: null,
					peringkat: null,
					penyelenggara: null,
					lokasi: null,
					keterangan: null,
					no_sk: null,
					tgl_sk: null
				},

				mahasiswa: [],
				dosen: [{ dosen_id: null, prestasi_id: null, prestasidosen_id: null, flag: 1 }]
			};
		},
		created() {
			this.getDosen();
		},
		watch: {
			is_open: function(newVal, oldVal) {
				if (newVal) {
					this.is_modal_open = true;

					if (this.prestasi != null) {
						//edit
						this.form.prestasi_id = this.prestasi['prestasi_id'];
						this.form.judul = this.prestasi['judul'];
						this.form.tahun = this.prestasi['tahun'];
						this.form.jenisprestasi_id = this.prestasi['jenisprestasi_id'];
						this.form.tingkatprestasi_id = this.prestasi['tingkatprestasi_id'];
						this.form.peringkat = this.prestasi['peringkat'];
						this.form.penyelenggara = this.prestasi['penyelenggara'];
						this.form.lokasi = this.prestasi['lokasi'];
						this.form.keterangan = this.prestasi['keterangan'];
						this.form.tgl_sk = this.prestasi['tgl_sk'];
						this.form.no_sk = this.prestasi['no_sk'];

						this.mahasiswa = this.prestasi['mhs'].map(mhs => {
							return {
								mahasiswa_id: mhs['mahasiswa_id'],
								nama: mhs['nama_tercetak'],
								nim: mhs['nim'],
								flag: 1,
								prestasi_id: mhs['pivot']['prestasi_id'],
								prestasimhs_id: mhs['pivot']['prestasimhs_id'],
								peran: mhs['pivot']['peran']
							};
						});

						this.dosen = this.prestasi['dosen'].map(dosen => {
							return {
								dosen_id: dosen['dosen_id'],
								prestasi_id: dosen['pivot']['prestasi_id'],
								prestasidosen_id: dosen['pivot']['prestasidosen_id'],
								flag: 1
							};
						});
					}
				} else {
					this.is_modal_open = false;
				}
			}
		},
		methods: {
			modalClosed() {
				this.$emit('modal-closed');
				this.form = {
					judul: null,
					tahun: null,
					jenisprestasi_id: null,
					tingkatprestasi_id: null,
					peringkat: null,
					penyelenggara: null,
					lokasi: null,
					keterangan: null,
					no_sk: null,
					tgl_sk: null
				};

				this.mahasiswa = [];
				this.dosen = [{ dosen_id: null, prestasi_id: null, prestasidosen_id: null, flag: 1 }];

				this.mhs_found['status'] = false;
				this.mhs_found['msg'] = '';
			},
			cariMahasiswa() {
				this.mhs_found['load'] = true;
				axios
					.post('/api/mhs/get_by_nim', { nim: this.nim_mhs })
					.then(({ data }) => {
						if (data['status']) {
							if (this.mhs_found['data'] == null || data['data']['nim'] != this.mhs_found['data']['nim']) {
								this.mhs_found = data;

								if (this.mahasiswa.length == 0) {
									this.mahasiswa = [
										{
											mahasiswa_id: data['data']['mahasiswa_id'],
											nama: data['data']['nama'],
											nim: data['data']['nim'],
											flag: 1,
											prestasi_id: null,
											prestasimhs_id: null,
											peran: null
										}
									];
								} else {
									this.mahasiswa.push({
										mahasiswa_id: data['data']['mahasiswa_id'],
										nama: data['data']['nama'],
										nim: data['data']['nim'],
										flag: 1,
										prestasi_id: null,
										prestasimhs_id: null,
										peran: null
									});
								}
							}
						}
					})
					.catch(({ response }) => {
						this.mhs_found = response['data'];
					})
					.finally(() => {
						this.mhs_found['load'] = false;
					});
			},
			savePrestasi() {
				this.form['mahasiswa'] = this.mahasiswa;
				this.form['dosen'] = this.dosen;

				axios
					.post('/prestasi-mahasiswa', this.form)
					.then(({ data }) => {
						this.$swal('', data['msg'], 'success');
						this.is_modal_open = false;
						this.$emit('save-succeed');
					})
					.finally(() => {
						// this.is_busy = false;
					});
			},
			tambahItem(array, index) {
				array.push({ dosen_id: null, prestasi_id: null, prestasidosen_id: null, flag: 1 });
			},
			hapusItem(array, index) {
				if (array[index].prestasi_id == null) {
					array.splice(index, 1);
				} else {
					array[index].flag = 0;
					array.push(array.splice(index, 1)[0]);
				}
			},
			getDosen() {
				axios.get('/api/prodi/0/dosen').then(({ data }) => {
					this.dosen_option = data['msg'];
				});
			}
		}
	};
</script>

<style lang="scss" scoped></style>
