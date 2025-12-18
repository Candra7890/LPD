<template>
  <div>
    <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Penawaran Matakuliah</h3>
      </div>
      <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/">Home</a>
          </li>
          <li class="breadcrumb-item active">Kartu Hasil Studi</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid">
      <v-loader v-if="!isFilterReady"></v-loader>
      <div class="card" v-show="isFilterReady">
        <div class="card-body">
          <v-filter></v-filter>
          <v-table></v-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const Filter = () =>
  System.import(/* webpackChunkName: "lihat-penawaran-mk" */ "./Filter.vue");

const Table = () =>
  System.import(/* webpackChunkName: "lihat-penawaran-mk" */ "./Table.vue");

export default {
  components: {
    "v-filter": Filter,
    "v-table": Table
  },
  data() {
    return {
      isFinishLoading: true
    };
  },
  methods: {
    setLoader() {
      this.isFinishLoading = !this.isFinishLoading;
    }
  },
  computed: {
    isFilterReady() {
      return this.$store.state.mhs.lihatPenawaranMatkul.isFilterReady;
    }
  }
};
</script>