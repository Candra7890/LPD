import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
// list other supporting component
import Loader from './components/other/Loader'
import BError from './components/other/Error'

function lazyLoad(component) {
    return () => ({
        component: component,
        loading: Loader,
        delay: 200,
        error: BError,
        timeout: 10000,
    })
}

// list component used
const LihatPenawaranMatkul = lazyLoad(System.import( /* webpackChunkName: "lihat-penawaran-mk" */ './components/mhs/penawaran-matkul/Index.vue'))
const MasterJabatan = lazyLoad(System.import( /* webpackChunkName: "master-jabatan" */ './components/master/jabatan/Index'))
const SkMengjar = lazyLoad(System.import( /* webpackChunkName:'sk-mengajar' */ './components/admin/sk-mengajar/Index'));
const SkMengjarCreate = lazyLoad(System.import( /* webpackChunkName: 'sk-mengajar-create' */ './components/admin/sk-mengajar/Create'))


export default new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [{
            path: '/lihat-penawaran-matkul',
            name: 'lihat-penawaran-matkul',
            component: LihatPenawaranMatkul
        }, {
            path: '/master/jabatan',
            name: 'master.jabatan',
            component: MasterJabatan
        }, {
            path: '/sk-mengajar',
            name: 'sk-mengajar',
            component: SkMengjar
        },
        {
            path: '/sk-mengajar/create',
            name: 'sk-mengajar-create',
            component: SkMengjarCreate
        }
    ]
})