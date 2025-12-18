<template>
	<div>
		<form action="" id="form-paket">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label class="font-weight-bold" for="nama_paket">Nama Paket</label>
						<input class="form-control" type="text" name="nama_paket" v-model="form['nama_paket']" />
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="font-weight-bold" for="jenis_id">Jenis Merdeka Belajar</label>
						<select v-model="form['jenis_id']" class="custom-select">
							<option :value="item['jenis_id']" v-for="(item, index) in jenis" :key="index">{{ item['nama_jenis'] }}</option>
						</select>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="font-weight-bold" for="semester_diambil">Semester Diambil</label>
						<input class="form-control" type="number" name="semester_diambil" v-model="form['semester_diambil']" />
					</div>
				</div>
				<div class="col-md-12 col-sm-12">
					<div class="form-group">
						<label for="nama_paket" class="font-weight-bold">Daftar Matakuliah</label>
						<div v-for="(item, index) in form['matakuliah']" :key="index">
							<div class="form-group row" style="margin-bottom: 10px;" v-if="item.flag == 1">
								<label class="col-12">Matakuliah ke-{{ index + 1 }}</label>
								<div class="col-md-10 col-sm-12">
									<v-select v-model="item.matakuliah_id" :options="matkul_list" label="nama_matakuliah" :reduce="matakuliah => matakuliah.matakuliah_id">
										<template #option="{kode_matakuliah, nama_matakuliah, semester, sks}"> {{ kode_matakuliah }} - {{ nama_matakuliah }} - Semester {{ semester }} - {{ sks }} SKS </template>
										<template slot="selected-option" slot-scope="option"> {{ option.kode_matakuliah }} - {{ option.nama_matakuliah }} - Semester {{ option.semester }} - {{ option.sks }} SKS </template>
									</v-select>
								</div>
								<div class="col-md-2 col-sm-12" style="padding-right:10px;">
									<button class="btn btn-sm btn-info waves-effect waves-light" type="button" @click="tambahMatakuliah(index)">
										<i class="fa fa-plus"></i>
									</button>

									<button class="btn btn-sm btn-danger waves-effect waves-light" type="button" @click="hapusMatakuliah(index)">
										<i class="fa fa-times"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="col-lg-12 text-right">
					<button class="btn btn-danger waves-effect waves-light" type="button" v-on:click="savePaket()">
						<span class="btn-label"><i class="mdi mdi-content-save"></i></span> Simpan
					</button>
					<button class="btn btn-secondary waves-effect waves-light" type="button" v-on:click="back()">
						<span class="btn-label"><i class="mdi mdi-arrow-left-bold"></i></span> Kembali
					</button>
				</div>
			</div>
		</form>
	</div>
</template>

<script>
	export default {
		props: ['paket', 'jenis'],
		data() {
			return {
				form: {
					paket_id: null,
					nama_paket: null,
					semester_diambil: null,
					jenis_id: null,
					matakuliah: [{ matakuliah_id: null, flag: 1, paketmatakuliah_id: null }]
				},
				matkul_list: []
			};
		},
		methods: {
			back() {
				this.$emit('detail-closed');
			},
			savePaket() {
				let url = '/master/paket';
				let method = 'POST';
				if (this.form['paket_id'] != null) {
					url = '/master/paket/' + this.form['paket_id'];
					method = 'PUT';
				}

				axios({ method: method, url: url, data: this.form })
					.then(({ data }) => {
						if (data['status']) {
							this.$swal('', data['msg'], 'success');
							this.$emit('detail-closed');
							this.$emit('save-succeed');
						} else {
							this.$swal('', data['msg'], 'error');
						}
					})
					.catch(error => {
						let data = error['response']['data'];
						let err = data['msg'];
						this.$swal('', err, 'error');
					});
			},
			getMatakuliah() {
				axios.get('/api/matakuliah').then(({ data }) => {
					this.matkul_list = data;
				});
			},
			tambahMatakuliah(index) {
				this.form['matakuliah'].push({
					matakuliah_id: null,
					flag: 1,
					paketmatakuliah_id: null
				});
			},
			hapusMatakuliah(index) {
				if (this.form['matakuliah'][index].paketmatakuliah_id == null) {
					this.form['matakuliah'].splice(index, 1);
				} else {
					this.form['matakuliah'][index].flag = 0;
					this.form['matakuliah'].push(this.form['matakuliah'].splice(index, 1)[0]);
				}
			}
		},
		created() {
			this.getMatakuliah();

			if (this.paket != null) {
				this.form['paket_id'] = this.paket['paket_id'];
				this.form['jenis_id'] = this.paket['jenis_id'];
				this.form['nama_paket'] = this.paket['nama_paket'];
				this.form['semester_diambil'] = this.paket['semester_diambil'];

				// this.form['matakuliah'] = [];
				// this.paket['matakuliah'].forEach(matkul => {
				// 	this.form['matakuliah'].push({ matakuliah_id: matkul['matakuliah_id'], flag: 1, paketmatakuliah_id: matkul['pivot']['matakuliah_id'] });
				// });

				if (this.paket['matakuliah'].length > 0) {
					this.form['matakuliah'] = this.paket['matakuliah'].map(matkul => {
						return { matakuliah_id: matkul['matakuliah_id'], flag: 1, paketmatakuliah_id: matkul['pivot']['paketmatakuliah_id'] };
					});
				}
			}
		}
	};
</script>

<style lang="scss" scoped></style>
