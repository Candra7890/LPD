export default {
    getRole: state => {
        return state.role
    },
    getTahunAjaran: (state) => {
        return state.tahun_ajaran
    },
    getSemester: (state) => (id = 0) => {
        if (id == 0) return state.semester
        return state.semester.find((val) => {
            return val.semester_id = id
        })
    },
    getKrsAktif: state => {
        return state.krsAktif
    },
    getPenawaranMatkulTotalRow: state => {
        if (state.mhs.lihatPenawaranMatkul.tableData != null) {
            return state.mhs.lihatPenawaranMatkul.tableData.length
        }
        return 0;
    }
}