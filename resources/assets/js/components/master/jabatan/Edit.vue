<template>
  <div>
    <vs-popup class="holamundo" title="Edit Jabatan" :active.sync="open">
      <vs-row>
        <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12">
          <vs-input
            label-placeholder="Nama Jabatan"
            style="width:100%"
            v-model="data.jabatan_nama"
          />
        </vs-col>
      </vs-row>
      <vs-button
        ref="loadableButton"
        id="update-btn"
        class="vs-con-loading__container mt-4"
        @click="updateData()"
        type="relief"
        vslor="primary"
        :disabled="onUpdate"
      >Simpan</vs-button>
    </vs-popup>
  </div>
</template>

<script>
export default {
  props: ["isOpen", "data"],
  data() {
    return {
      open: false,
      onUpdate: false,
      loadingData: {
        background: "primary",
        color: "#fff",
        container: "#update-btn",
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
    jabatanNama() {
      if (this.open) {
        return this.data.jabatan_nama;
      }

      return "";
    }
  },
  methods: {
    openLoadingContained() {
      this.$vs.loading(this.loadingData);
      setTimeout(() => {
        this.$vs.loading.close("#update-btn>.con-vs-loading");
      }, 3000);
    },
    closeModal() {
      this.open = false;
    },
    updateData() {
      this.onUpdate = true;
      let vs = this.$vs;
      vs.loading(this.loadingData);

      axios
        .post(`/master/jabatan/${this.data.jabatan_id}`, {
          _method: "PUT",
          name: this.data.jabatan_nama
        })
        .then(res => {
          vs.notify({
            title: "Sukses",
            text: res.data.msg,
            color: "success",
            icon: "check_box"
          });
        })
        .catch(err => {
          console.log(err);
          vs.notify({
            title: "Error",
            text: "Gagal mengubah jabatan",
            color: "danger",
            icon: "error"
          });
        })
        .finally(() => {
          this.$emit("refresh");
          this.$vs.loading.close("#update-btn>.con-vs-loading");
          this.onUpdate = false;
          this.open = false;
        });
    }
  }
};
</script>