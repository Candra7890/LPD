export default {
    getRole: (context) => {
        return new Promise((resolved, reject) => {
            if (context.state.role != null || context.state.role != '') {
                axios.get(`/api/role-info`).then(res => {
                    context.commit('setRole', res.data)
                    resolved(res)
                }).catch(err => {
                    reject(err)
                })
            } else return resolved(context.state.role)
        })
    },
    getTahunAjaran: (context) => {
        return new Promise((resolved, reject) => {
            axios.get(`/api/aktivasi-krs`).then(res => {
                context.commit('setTahunAjaran', res.data)
                resolved(res)
            }).catch(err => {
                rejecr(err)
            })
        })
    },
    getSemester: (context) => {
        return new Promise((resolved, reject) => {
            axios.get(`/api/semester`).then(res => {
                context.commit('setSemester', res.data)
                resolved(res)
            }).catch(err => {
                reject(err)
            })
        })
    },
    getKrsAktif: (context) => {
        return new Promise((resolved, reject) => {
            axios.get(`/api/krs-aktif`).then(res => {
                context.commit('setKrsAktif', res.data)
                resolved(res)
            }).catch(err => {
                reject(err)
            })
        })
    },
    getPenawaranMatkul: (context, param) => {
        if (context.state.role)
            var str = "";
        for (var key in param) {
            if (str != "") {
                str += "&";
            }
            str += key + "=" + encodeURIComponent(param[key]);
        }

        return new Promise((resolved, reject) => {
            axios.get(`/api/penawaran-matkul?${str}`).then(res => {
                context.commit('setMhsLihatPenawaranMatkulTableData', res.data);
                resolved(res)
            }).catch(err => {
                reject(err)
            })
        })
    }
}