<template>
  <div>
    <vs-popup class="holamundo" title="Buat Jabatan Baru" :active.sync="open">
      <vs-row>
        <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12">
          <vs-input label-placeholder="Nama Jabatan" style="width:100%" v-model="jabatanName" />
        </vs-col>
      </vs-row>
      <vs-button
        ref="loadableButton"
        id="insert-btn"
        class="vs-con-loading__container mt-4"
        @click="insertToServer"
        type="relief"
        :disabled="onInsert"
        vslor="primary"
      >Simpan</vs-button>
    </vs-popup>
  </div>
</template>

<script>
export default {
  props: ["isOpen"],
  data() {
    return {
      jabatanName: "",
      open: false,
      backgroundLoading: "primary",
      colorLoading: "#fff",
      onInsert: false
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
  methods: {
    insertToServer() {
      this.onInsert = true;
      this.$emit("on-insert");
      let vs = this.$vs;
      vs.loading({
        background: this.backgroundLoading,
        color: this.colorLoading,
        container: "#insert-btn",
        scale: 0.45
      });

      axios
        .post("/master/jabatan", {
          name: this.jabatanName
        })
        .then(res => {
          vs.notify({
            title: "Sukses",
            text: "Berhasil menambah jabatan baru",
            color: "success",
            icon: "check_box"
          });
          this.$emit("refresh");
        })
        .catch(err => {
          console.log(err);
          vs.notify({
            title: "Error",
            text: "Gagal menambah jabatan baru",
            color: "danger",
            icon: "error"
          });
        })
        .finally(() => {
          this.$vs.loading.close("#insert-btn>.con-vs-loading");
          this.onInsert = false;
          this.$emit("on-insert");
          this.open = false;
        });
    }
  }
};
</script>