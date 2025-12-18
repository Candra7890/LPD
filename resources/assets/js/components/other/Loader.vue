<template>
	<div>
		<div class="text-center col-sm-12 pt-5">
			<pulse-loader :color="'#c80000'"></pulse-loader>
			<h6 class="mt-5" style="color:#c80000">Sedang Memproses...</h6>
		</div>
	</div>
</template>

<script>
import PulseLoader from 'vue-spinner/src/RotateLoader.vue';
export default {
	components: {
		'pulse-loader': PulseLoader
	}
};
</script>
