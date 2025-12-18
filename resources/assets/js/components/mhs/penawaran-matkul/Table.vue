<template>
  <div>
    <div class="row mb-2">
      <div class="col-sm-12 col-md-6">
        Menampilkan
        <select v-model="perPage" id>
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
        </select>
        <span>data</span>
      </div>
      <div class="col-sm-12 col-md-6">
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            placeholder="cari.."
            v-model="search"
            aria-describedby="basic-addon1"
          />
          <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">
              <span class="fa fa-search" v-if="search == ''"></span>
              <span
                class="fa fa-times"
                title="Clear"
                @click="search =''"
                style="cursor:pointer"
                v-if="search.length"
              ></span>
            </span>
          </div>
        </div>
      </div>
    </div>
    <b-table
      :items="data"
      :show-empty="showMsg"
      :empty-text="msg"
      :bordered="true"
      :hover="true"
      :thClass="'text-center'"
      :busy="isBusy"
      :filter="search"
      :current-page="currentPage"
      :per-page="perPage"
      :fields="fields"
      outlined
    >
      <template v-slot:table-busy>
        <div class="text-center text-danger my-2">
          <b-spinner small></b-spinner>
          <strong>Loading...</strong>
        </div>
      </template>
    </b-table>
    <b-pagination
      v-show="!isBusy"
      v-model="currentPage"
      :total-rows="totalRow"
      :per-page="perPage"
      align="fill"
      size="sm"
      class="my-0"
    ></b-pagination>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentPage: 1,
      perPage: 10,
      search: "",
      fields: [
        { key: "no", label: "No", thClass: "text-center" },
        { key: "kode", label: "Kode Matakuliah", thClass: "text-center" },
        { key: "nama", label: "Nama Matakuliah", thClass: "text-center" },
        { key: "peng", label: "Pengampu", thClass: "text-center" },
        { key: "sks", label: "SKS", thClass: "text-center" },
        { key: "smt", label: "Smt", thClass: "text-center" }
      ]
    };
  },
  mounted() {},
  methods: {},
  computed: {
    totalRow() {
      return this.$store.getters.getPenawaranMatkulTotalRow;
    },
    showMsg() {
      return this.$store.state.mhs.lihatPenawaranMatkul.showTableMsg;
    },
    msg() {
      return this.$store.state.mhs.lihatPenawaranMatkul.tableMsg;
    },
    isBusy() {
      return this.$store.state.mhs.lihatPenawaranMatkul.isTableBusy;
    },
    data() {
      if (this.$store.state.mhs.lihatPenawaranMatkul.tableData != null) {
        return this.$store.state.mhs.lihatPenawaranMatkul.tableData.map(
          (item, index) => {
            let anyDosen = true;
            if (item.mkpengampu[0] == null) {
              anyDosen = false;
            }

            let dosen;
            if (anyDosen) {
              dosen =
                item.mkpengampu[0].dosen.nama +
                " (" +
                item.mkpengampu[0].status +
                ")";
            } else {
              dosen = "Belum diset";
            }
            return {
              no: index + 1,
              kode: item.mkangkatan.kode_matakuliah,
              nama: item.mkangkatan.nama_matakuliah + " (" + item.kelas + ")",
              peng: dosen,
              sks: item.mkangkatan.sks,
              smt: item.semester
            };
          }
        );
      }
    }
  },
  watch: {}
};
</script>