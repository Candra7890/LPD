export default {
    setRole: (state, data) => {
        state.role = data
    },
    setTahunAjaran: (state, data) => {
        state.tahun_ajaran = data
    },
    setSemester: (state, data) => {
        state.semester = data
    },
    setMhsLihatPenawaranMatkulFilterStatus: (state, data) => {
        state.mhs.lihatPenawaranMatkul.isFilterReady = data
    },
    setKrsAktif: (state, data) => {
        state.krsAktif = data
    },
    setMhsLihatPenawaranMatkulTableData: (state, data) => {
        state.mhs.lihatPenawaranMatkul.tableData = data
        state.mhs.lihatPenawaranMatkul.tableMsg = "Tidak ada data"
        state.mhs.lihatPenawaranMatkul.isTableBusy = !state.mhs.lihatPenawaranMatkul.isTableBusy
    },
    setMhsLihatPenawaranMatkulTableLoading: (state, status) => {
        state.mhs.lihatPenawaranMatkul.isTableBusy = status
    },
    sethsLihatPenawaranMatkulTableMsg: (state, msg) => {
        state.mhs.lihatPenawaranMatkul.tableData = null
        state.mhs.lihatPenawaranMatkul.isTableBusy = !state.mhs.lihatPenawaranMatkul.isTableBusy
        state.mhs.lihatPenawaranMatkul.tableMsg = msg
    }
}