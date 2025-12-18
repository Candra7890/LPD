<template>
	<b-modal ref="modalMitra" :title="title" size="xl" v-model="isModalOpen" @hidden="modalClosed">
		<div v-if="ready">
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label class="font-weight-bold">Pilih Program Studi</label>
						<select class="custom-select" v-model="form['prodi_id']">
							<option v-for="(item, index) in prodis" :key="index" :value="item['prodi_id']">{{ item['nama_prodi'] }}</option>
						</select>
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group">
						<label class="font-weight-bold">Nama Mitra</label>
						<input type="text" class="form-control" v-model="form['nama_mitra']" />
					</div>
					<div class="form-group">
						<label class="font-weight-bold">No SK</label>
						<input type="text" class="form-control" v-model="form['no_sk']" />
					</div>
					<div class="form-group">
						<label class="font-weight-bold">Kapasitas</label>
						<input type="number" class="form-control" v-model="form['kapasitas']" />
					</div>
				</div>
				<div class="col-lg-6 col-sm-12">
					<div class="form-group">
						<label class="font-weight-bold">Alamat Mitra</label>
						<input type="text" class="form-control" v-model="form['alamat_mitra']" />
					</div>
					<div class="form-group">
						<label for="" class="font-weight-bold">File SK</label>
						<b-form-file
							accept=".jpg, .jpeg, .png, .pdf"
							name="file_sk"
							v-model="form['file_sk']"
							:state="Boolean(form['file_sk'])"
							:placeholder="uploaded_file != null ? 'File SK Sudah Diunggah' : 'Silahkan Upload File SK'"
							drop-placeholder="Drop file here..."
						></b-form-file>
						<div class="mt-3 text-muted" v-if="uploaded_file != null">
							Uploaded File : <a :href="'/' + url_sk" target="_blank">{{ uploaded_file }}</a>
						</div>
					</div>
				</div>
				<div class="col-12">
					<hr />
					<label class="font-weight-bold">Pembimbing/Pembina dari Mitra</label>
					<pembimbing-mitra :pembimbing="form['pembimbing']" />
				</div>
			</div>
		</div>
		<v-loader color="#1976d2" :size="150" v-if="!ready"></v-loader>
		<template #modal-footer>
			<div class="row">
				<div class="col-lg-12">
					<button type="button" class="btn waves-effect waves-light btn-outline-danger" @click="saveMitra">Simpan</button>
					<button type="button" class="btn waves-effect waves-light btn-outline-secondary" @click="isModalOpen = false">Batal</button>
				</div>
			</div>
		</template>
	</b-modal>
</template>

<script>
	import PembimbingMitra from './PembimbingMitra.vue';
	export default {
		props: ['is_open', 'title', 'mitra', 'role'],
		components: { PembimbingMitra },
		data() {
			return {
				isModalOpen: false,
				ready: true,
				form: {
					mitra_id: null,
					nama_mitra: null,
					alamat_mitra: null,
					kapasitas: null,
					prodi_id: null,
					no_sk: null,
					file_sk: null,
					pembimbing: [
						{
							nama: null,
							kode: null
						}
					]
				},
				url_sk: null,
				uploaded_file: null,
				prodis: null
			};
		},
		watch: {
			is_open: function(newVal, oldVal) {
				if (newVal) {
					this.isModalOpen = true;
					this.uploaded_file = null;

					if (this.mitra != null) {
						//edit
						this.form.mitra_id = this.mitra['mitra_id'];
						this.form.nama_mitra = this.mitra['nama_mitra'];
						this.form.alamat_mitra = this.mitra['alamat'];
						this.form.prodi_id = this.mitra['prodi_id'];
						this.form.no_sk = this.mitra['no_sk'];
						this.form.kapasitas = this.mitra['kapasitas'];
						this.url_sk = this.mitra['file_sk'];

						if (this.mitra['file_sk']) {
							let parts = this.mitra['file_sk'].split('/');
							this.uploaded_file = parts[parts.length - 1];
						}

						let pembimbing = JSON.parse(this.mitra['pembimbing']);
						if (pembimbing.length > 1) {
							this.form.pembimbing = pembimbing;
						}
					}

					if (this.role['generalization_id'] == 4) {
						this.form.prodi_id = this.role['prodi_id'];
					}
				} else {
					this.isModalOpen = false;
				}
			}
		},
		methods: {
			modalClosed() {
				this.$emit('modal-closed');
				this.clearModal();
			},
			clearModal() {
				this.form = {
					nama_mitra: null,
					alamat_mitra: null,
					prodi_id: null,
					no_sk: null,
					file_sk: null,
					pembimbing: [
						{
							nama: null,
							kode: null
						}
					]
				};
			},
			getProdi() {
				axios.get('/master/prodi/all/getallprodi').then(({ data }) => {
					this.prodis = data;
				});
			},
			saveMitra() {
				let formData = new FormData();

				if (this.form['mitra_id']) {
					formData.append('mitra_id', this.form['mitra_id']);
				}

				formData.append('nama_mitra', this.form['nama_mitra']);
				formData.append('alamat_mitra', this.form['alamat_mitra']);
				formData.append('kapasitas', this.form['kapasitas']);
				formData.append('no_sk', this.form['no_sk']);
				formData.append('prodi_id', this.form['prodi_id']);

				// jangan simpan pembimbing yg kosong
				let pembimbing_filtered = this.form['pembimbing'].filter(el => el['nama'] != null && el['nama'] != '');

				if (pembimbing_filtered.length > 1) {
					formData.append('pembimbing', JSON.stringify(pembimbing_filtered));
				}

				if (this.form['file_sk'] != null) {
					formData.append('file_sk', this.form['file_sk']);
				}

				axios
					.post('/master/mitra', formData, {
						headers: {
							'Content-Type': 'multipart/form-data'
						}
					})
					.then(({ data }) => {
						console.log(data);
						if (data['success']) {
							this.$swal('', data['msg'], 'success');
							this.$emit('save-succeed');
							this.isModalOpen = false;
						} else {
							this.$swal('', 'Silahkan Lengkapi Isian Nama Mitra dan Program Studi !', 'error');
						}
					})
					.catch(error => {
						let data = error['response']['data'];
						console.log(data);
						this.$swal('', data['message'], 'error');
					});
			}
		},
		created() {
			this.getProdi();
		}
	};
</script>

<style lang="scss" scoped></style>
