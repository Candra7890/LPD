<template>
  <div>
    <vs-popup class="holamundo" title="Hapus Jabatan" :active.sync="open">
      <vs-row>
        <vs-col vs-type="flex" vs-w="12">
          <p>{{ text }}</p>
        </vs-col>
      </vs-row>
      <vs-button color="primary" @click="closeModal" type="flat">Batal</vs-button>
      <vs-button
        id="delete-btn"
        class="vs-con-loading__container mt-4"
        @click="deleteData()"
        type="relief"
        color="danger"
        :disabled="onDelete"
      >Hapus</vs-button>
    </vs-popup>
  </div>
</template>

<script>
export default {
  props: ["isOpen", "data"],
  data() {
    return {
      jabatanName: "",
      open: false,
      onDelete: false,
      loadingData: {
        background: "danger",
        color: "#fff",
        container: "#delete-btn",
        scale: 0.45
      }
    };
  },
  watch: {
    isOpen() {
      this.open = this.isOpen;
      if (!this.open) {
        this.$emit("update-state");
      }
    }
  },
  computed: {
    text() {
      if (this.open) {
        return `Apakah anda yakin ingin menghapus jabatan '${this.data.jabatan_nama}'?`;
      } else return "";
    }
  },
  methods: {
    openLoadingContained() {
      this.$vs.loading(this.loadingData);
      setTimeout(() => {
        this.$vs.loading.close("#delete-btn>.con-vs-loading");
      }, 3000);
    },
    closeModal() {
      this.open = false;
    },
    deleteData() {
      this.onDelete = true;
      let vs = this.$vs;
      vs.loading(this.loadingData);
      axios
        .post(`/master/jabatan/${this.data.jabatan_id}`, {
          _method: "DELETE"
        })
        .then(res => {
          vs.notify({
            title: "Sukses",
            text: "Berhasil menghapus jabatan",
            color: "success",
            icon: "check_box"
          });
          this.$emit("refresh");
        })
        .catch(err => {
          console.log(err);
          vs.notify({
            title: "Error",
            text: "Gagal menghapus jabatan",
            color: "danger",
            icon: "error"
          });
        })
        .finally(() => {
          this.onDelete = false;
          vs.loading.close("#delete-btn>.con-vs-loading");
          this.closeModal();
        });
    }
  }
};
</script>