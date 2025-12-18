<template>
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-xs-12 col-sm-2">
					<i class="ti-info-alt text-center text-danger" style="font-size: 100px;margin: 25px;display: block; padding-bottom: 5px; padding-right: 5px;"></i>
				</div>
				<div class="col-xs-12 col-sm-10 mt-2">
					<h3 class="text-danger">Mohon Maaf</h3>
					<h4 class="card-title">Saat ini anda tidak dapat melakukan Registrasi KRS karena alasan berikut:</h4>
					<ul class="list-icons">
						<li v-for="(item, index) in errors" :key="index"><i class="fa fa-chevron-right"></i> {{ item }}</li>
					</ul>
					<p>Silakan kembali ke halaman ini jika syarat diatas telah terpenuhi. Terimakasih.</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['errors']
	};
</script>

<style lang="scss" scoped></style>
