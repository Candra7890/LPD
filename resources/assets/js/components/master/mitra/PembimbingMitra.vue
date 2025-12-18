<template>
	<div>
		<div v-for="(item, index) in pembimbing_mitra" :key="index" class="row">
			<div class="col-md-10 col-sm-12">
				<label class="font-weight-bold">Pembimbing {{ romanize(index + 1) }}</label>
				<div class="form-group row">
					<label for="" class="col-md-2 col-sm-12">Nama</label>
					<div class="col-md-10 col-sm-12">
						<input type="text" class="form-control" v-model="item['nama']" />
					</div>
				</div>
				<div class="form-group row">
					<label for="" class="col-md-2 col-sm-12">Kode</label>
					<div class="col-md-10 col-sm-12">
						<input type="text" class="form-control" v-model="item['kode']" />
					</div>
				</div>
			</div>
			<div class="col-md-2 col-sm-12 my-auto" style="padding-right:10px;">
				<button class="btn btn-sm btn-info waves-effect waves-light" type="button" @click="tambahPembimbing()">
					<i class="fa fa-plus"></i>
				</button>

				<button class="btn btn-sm btn-danger waves-effect waves-light" type="button" @click="hapusPembimbing(index)" v-if="pembimbing.length > 1 && index != 0">
					<i class="fa fa-times"></i>
				</button>
			</div>
			<div class="col-md-12 col-sm-12">
				<hr />
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['pembimbing'],
		data() {
			return {
				pembimbing_mitra: this.pembimbing
			};
		},
		methods: {
			tambahPembimbing() {
				this.pembimbing.push({
					nama: null,
					kode: null
				});
			},
			hapusPembimbing(index) {
				this.pembimbing.splice(index, 1);
			},
			romanize(num) {
				let lookup = {
						M: 1000,
						CM: 900,
						D: 500,
						CD: 400,
						C: 100,
						XC: 90,
						L: 50,
						XL: 40,
						X: 10,
						IX: 9,
						V: 5,
						IV: 4,
						I: 1
					},
					roman = '',
					i;
				for (i in lookup) {
					while (num >= lookup[i]) {
						roman += i;
						num -= lookup[i];
					}
				}
				return roman;
			}
		}
	};
</script>

<style lang="scss" scoped></style>
