<template>
  <div>
    <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">SK Mengajar</h3>
      </div>
      <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/">Home</a>
          </li>
          <li class="breadcrumb-item active">SK Mengajar</li>
        </ol>
      </div>
    </div>

    <div class="container-fluid">
      <!-- <v-loader></v-loader> -->
      <div class="card">
        <div class="card-body vs-con-loading__container">
          <div class="row">
            <div class="col-sm-12 mb-5">
              <vs-button
                @click="$router.push({ name: 'sk-mengajar-create'})"
                color="primary"
                icon="add"
                type="filled"
                class="vs-con-loading__container"
                id="create-new-data"
              >Baru</vs-button>
            </div>
          </div>

          <vs-table :data="data" search :noDataText="'Data Kosong'">
            <template slot="header">
              <h3>Daftar Setting SK Mengajar Per Tahun Ajaran</h3>
            </template>

            <template slot="thead">
              <vs-th>No</vs-th>
              <vs-th>NO SK</vs-th>
              <vs-th>Tahun Ajaran</vs-th>
              <vs-th>Tgl Penandatangan</vs-th>
              <vs-th>Aksi</vs-th>
            </template>

            <template slot-scope="{data}">
              <vs-tr :key="index" v-for="(tr, index) in data">
                <vs-td>{{ index+1 }}</vs-td>
                <vs-td>{{ tr.no_sk }}</vs-td>
                <vs-td>{{ (tr.tahunajaran+'/'+(tr.tahunajaran+1)) + ' ' + ((tr.semester == 1) ? 'Ganjil' : 'Genap') }}</vs-td>
                <vs-td>{{ tr.tgl_penandatangan }}</vs-td>
                <vs-td>{{ tr.semester }}</vs-td>

                <template class="expand-user" slot="expand">
                  <vs-list>
                    <vs-list-item title="Wakil Ketua I" :subtitle="tr.waka1.nama"></vs-list-item>
                    <vs-list-item title="Kabag AUAK" :subtitle="tr.kabagauak.nama"></vs-list-item>
                    <vs-list-item title="Wakil Ketua II" :subtitle="tr.waka2.nama"></vs-list-item>
                    <vs-list-item title="Penandatangan" :subtitle="tr.penandatangan.nama"></vs-list-item>
                  </vs-list>
                </template>
              </vs-tr>
            </template>
          </vs-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: []
    };
  },
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      let vs = this.$vs;
      vs.loading();

      axios
        .get("?q=home")
        .then(res => {
          console.log(res);
          this.data = res.data;
        })
        .catch(err => {
          console.log(err);
        })
        .finally(() => {
          vs.loading.close();
        });
    }
  }
};
</script>