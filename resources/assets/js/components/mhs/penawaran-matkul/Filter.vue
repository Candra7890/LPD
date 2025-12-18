<template>
  <div v-if="isReady">
    <div class="row">
      <div class="col-sm-12 col-md-2">
        <div class="waves-effect" style="padding: 8px;" @click="showFilter = !showFilter">
          <span>
            <i class="mdi mdi-filter-variant mr-1"></i>
          </span>
          <h5 style="display:inline">Filter</h5>
        </div>
      </div>
      <transition name="fade">
        <div class="col-sm-12 col-md-10" v-show="!showFilter">
          <div style="padding: 8px;">
            Menampilkan data untuk:
            <b>{{ filterString }}</b>
          </div>
        </div>
      </transition>
    </div>
    <transition name="fade">
      <div v-show="showFilter">
        <div class="row mt-3">
          <div class="col-sm-12 col-md-3">
            <div class="form-group">
              <label class="control-label">Tahun Ajaran</label>
              <v-select
                :options="tahunAjaran"
                :searchable="true"
                :labelNotFound="'Data tidak ditemukan untuk pencarian'"
                :disabledProp="'1'"
                :labelSearchPlaceholder="'cari'"
                v-model="tahunAjaranSelected"
              />
            </div>
          </div>
          <div class="col-sm-12 col-md-3">
            <div class="form-group">
              <label class="control-label">Semester</label>
              <v-select
                :options="semester"
                :searchable="true"
                :labelNotFound="'Data tidak ditemukan untuk pencarian'"
                :labelSearchPlaceholder="'cari'"
                :disabledProp="'1'"
                v-model="semesterSelected"
              />
            </div>
          </div>
        </div>
        <button
          @click="submit"
          type="button"
          class="btn waves-effect waves-light btn-outline-secondary"
        >Submit</button>
      </div>
    </transition>
    <hr />

    <!-- <button class="btn btn-outline-primary waves-effect waves-light" type="button"></button> -->
  </div>
</template>
<script>
const VSelect = () =>
  System.import(
    /* webpackChunkName: "v-select"*/ "@alfsnd/vue-bootstrap-select"
  );

export default {
  components: {
    "v-select": VSelect
  },
  data() {
    return {
      showFilter: false,
      perPage: 10,
      tahunAjaranSelected: 0,
      semesterSelected: 0,
      itemToLoad: 3,
      loadedItem: 0,
      filterStatus: this.$store.state.mhs.lihatPenawaranMatkul.isFilterReady
    };
  },
  created() {
    this.$store.dispatch("getTahunAjaran").then(res => {
      this.loadedItem++;
    });

    this.$store.dispatch("getSemester").then(res => {
      this.loadedItem++;
    });

    this.$store.dispatch("getKrsAktif").then(res => {
      this.tahunAjaranSelected = {
        value: res.data.tahun_ajaran,
        text: res.data.tahun_ajaran + "/" + (res.data.tahun_ajaran + 1)
      };

      this.semesterSelected = {
        value: res.data.semester.semester_id,
        text: res.data.semester.nama_semester
      };
      this.loadedItem++;
    });
  },
  computed: {
    tahunAjaran() {
      return this.$store.getters.getTahunAjaran.map((item, key) => {
        return {
          value: item.tahun_ajaran,
          text: item.tahun_ajaran + "/" + (item.tahun_ajaran + 1)
        };
      });
    },
    semester() {
      return this.$store.getters.getSemester(0).map((item, key) => {
        return {
          value: item.semester_id,
          text: item.nama_semester
        };
      });
    },
    isReady() {
      if (this.itemToLoad == this.loadedItem) {
        return true;
      } else {
        return false;
      }
    },
    filterString() {
      let string = "";
      if (this.tahunAjaranSelected != 0)
        string += this.tahunAjaranSelected.text;
      if (string != "") string += ", ";
      if (this.semesterSelected != 0) string += this.semesterSelected.text;
      return string;
    }
  },
  watch: {
    isReady(newValue) {
      this.$store.commit(
        "setMhsLihatPenawaranMatkulFilterStatus",
        this.isReady
      );
      if (newValue == true) {
        this.getData();
      }
    }
  },
  methods: {
    submit() {
      this.showFilter = !this.showFilter;
      this.$store.commit("setMhsLihatPenawaranMatkulTableLoading", true);
      this.getData();
    },
    getData() {
      // p: this.$store.getters.getRole.prodi_id,
      // pr: this.$store.getters.getRole.program_id,
      let param = {
        ta: this.tahunAjaranSelected.value,
        smt: this.semesterSelected.value
      };

      let vm = this;
      this.$store.dispatch("getPenawaranMatkul", param).catch(err => {
        vm.$store.commit(
          "sethsLihatPenawaranMatkulTableMsg",
          "Terjadi error pada sistem"
        );
      });
    }
  }
};
</script>