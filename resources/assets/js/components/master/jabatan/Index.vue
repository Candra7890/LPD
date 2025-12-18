<template>
  <div>
    <div class="row page-titles">
      <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">Master Jabatan</h3>
      </div>
      <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/">Home</a>
          </li>
          <li class="breadcrumb-item active">Jabatan</li>
        </ol>
      </div>
    </div>
    <div class="container-fluid">
      <!-- <v-loader></v-loader> -->
      <div class="card">
        <div class="card-body vs-con-loading__container" id="data-container">
          <div class="row">
            <div class="col-sm-12 mb-5">
              <vs-button
                @click="isOpenCreateModal = !isOpenCreateModal"
                color="primary"
                icon="add"
                type="filled"
                class="vs-con-loading__container"
                :disabled="onInsert"
                id="create-new-data"
              >Baru</vs-button>
            </div>
          </div>

          <vs-table :data="data" search :noDataText="'Data Kosong'">
            <template slot="header">
              <h3>Daftar Jabatan</h3>
            </template>
            <template slot="thead">
              <vs-th>No</vs-th>
              <vs-th>Nama Jabatan</vs-th>
              <vs-th>Aksi</vs-th>
            </template>

            <template slot-scope="{data}">
              <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                <vs-td :data="1">{{ indextr+1 }}</vs-td>

                <vs-td :data="data[indextr].jabatan_nama">{{data[indextr].jabatan_nama}}</vs-td>

                <vs-td :data="data[indextr].jabatan_id">
                  <vs-button
                    icon="create"
                    @click="update(indextr)"
                    size="small"
                    color="primary"
                    type="flat"
                  >Edit</vs-button>
                  <vs-button
                    icon="delete"
                    @click="del(indextr)"
                    size="small"
                    color="danger"
                    type="flat"
                  >Hapus</vs-button>
                </vs-td>
              </vs-tr>
            </template>
          </vs-table>
        </div>
      </div>
    </div>
    <v-create
      :isOpen="isOpenCreateModal"
      @update-state="updateCreateModalState"
      @on-insert="onInsert = !onInsert"
      @refresh="getData"
    ></v-create>
    <v-edit
      @refresh="getData"
      :isOpen="isOpenEditModal"
      :data="selectedObject"
      @update-state="updateEditModalState"
    ></v-edit>
    <v-del
      @refresh="getData"
      :isOpen="isOpenDelModal"
      :data="selectedObject"
      @update-state="updateDelModalState"
    ></v-del>
  </div>
</template>

<script>
import Create from "./Create";
import Edit from "./Edit";
import Del from "./Del";
export default {
  data() {
    return {
      data: [],
      popupActivo: false,
      isOpenCreateModal: false,
      isOpenEditModal: false,
      isOpenDelModal: false,
      onInsert: false,
      onUpdate: false,
      onDelete: false,
      selectedObject: {},
      selectedIndex: 1,
      backgroundLoading: "primary",
      colorLoading: "#fff"
    };
  },
  components: {
    "v-create": Create,
    "v-edit": Edit,
    "v-del": Del
  },
  mounted() {
    this.getData();
  },
  watch: {
    onInsert() {
      let container = "#create-new-data";
      if (this.onInsert) {
        this.$vs.loading({
          background: this.backgroundLoading,
          color: this.colorLoading,
          container: container,
          scale: 0.45
        });
      } else if (!this.onInsert) {
        this.$vs.loading.close(container + ">.con-vs-loading");
      }
    }
  },
  methods: {
    updateCreateModalState(state) {
      this.isOpenCreateModal = !this.isOpenCreateModal;
    },
    updateEditModalState(state) {
      this.isOpenEditModal = !this.isOpenEditModal;
    },
    updateDelModalState(state) {
      this.isOpenDelModal = !this.isOpenDelModal;
    },
    update(index) {
      this.selectedObject = this.data[index];
      this.selectedIndex = index;
      this.isOpenEditModal = !this.isOpenEditModal;
    },

    del(index) {
      this.selectedObject = this.data[index];
      this.selectedIndex = index;
      this.isOpenDelModal = !this.isOpenDelModal;
    },
    getData() {
      let vs = this.$vs;
      this.$vs.loading();
      axios
        .get("/master/jabatan?q=home")
        .then(res => {
          this.data = res.data;
        })
        .catch(err => {
          vs.notify({
            title: "Error",
            text: "Gagal mengambil data jabatan",
            color: "danger",
            icon: "error"
          });
        })
        .finally(() => {
          vs.loading.close();
        });
    }
  }
};
</script>