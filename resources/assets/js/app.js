window.Vue = require('vue');
import router from './routes';
import store from './store';
import Vuex from 'vuex';
import mixins from './mixins';
// import BootstrapVue from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'vuesax/dist/vuesax.css'; //Vuesax styles
import 'material-icons/iconfont/material-icons.css';

require('./bootstrap');
Vue.use(Vuex);
// Vue.use(BootstrapVue)

// supporting component
// VUESAX
import Vuesax from 'vuesax';
Vue.use(Vuesax);

// vue-bootstrap
import { BTable } from 'bootstrap-vue/esm/components/table/';
Vue.component('b-table', BTable);
import { BSpinner } from 'bootstrap-vue/esm/components/spinner';
Vue.component('b-spinner', BSpinner);
import { BPagination } from 'bootstrap-vue/esm/components/pagination';
Vue.component('b-pagination', BPagination);
import { BForm } from 'bootstrap-vue/esm/components/form';
Vue.component('b-form', BForm);
import { BFormInput } from 'bootstrap-vue/esm/components/form-input';
Vue.component('b-form-input', BFormInput);
import { BFormGroup } from 'bootstrap-vue/esm/components/form-group';
Vue.component('b-form-group', BFormGroup);
import { BFormSelect } from 'bootstrap-vue/esm/components/form-select';
Vue.component('b-form-select', BFormSelect);

import { BFormFile, BModal } from 'bootstrap-vue';
Vue.component('b-form-file', BFormFile);
Vue.component('b-modal', BModal);

// sweetalert2
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

// momentjs;
// Vue.use(require('vue-moment'));
import moment from 'moment';
import 'moment/locale/id';
moment.locale('id');
Vue.filter('formatDateTime', function(value) {
	if (value) {
		return moment(String(value)).format('DD-MM-YYYY HH:mm');
	}
});
import Pagination from 'vue-pagination-2';
Vue.component('pagination', Pagination);

// vue-select
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect);

const Loader = () => System.import(/* webpackChunkName: "loader" */ './components/other/Loader.vue');
Vue.component('v-loader', Loader);
const SyncSiaIndex = () => System.import(/* webpackChunkName: 'sync-sia' */ './components/admin/sinkronisasi/IndexSinkron.vue');
Vue.component('sync-sia', SyncSiaIndex);
const MitraIndex = () => System.import(/* webpackChunkName: 'mitra' */ './components/master/mitra/IndexMitra.vue');
Vue.component('mitra-index', MitraIndex);
const PaketIndex = () => System.import(/* webpackChunkName: 'paket' */ './components/master/paket-mbkm/IndexPaket.vue');
Vue.component('paket-index', PaketIndex);
const PenawaranPaketIndex = () => System.import(/* webpackChunkName: 'penawaran-paket' */ './components/master/penawaran-paket/IndexPenawaran.vue');
Vue.component('penawaranpaket-index', PenawaranPaketIndex);
const RegistrasiKrsMbkm = () => System.import(/* webpackChunkName: 'registrasi-krs-mbkm' */ './components/mhs/registrasi-krs/indexRegis.vue');
Vue.component('regkrsmbkm-index', RegistrasiKrsMbkm);
const IndexLog = () => System.import(/* webpackChunkName: 'log' */ './components/admin/log/IndexLog.vue');
Vue.component('log-index', IndexLog);
const PrestasiIndex = () => System.import(/* webpackChunkName: 'prestasi' */ './components/admin/prestasi/IndexPrestasi.vue');
Vue.component('prestasi-index', PrestasiIndex);

const app = new Vue({
	mixins: [mixins],
	el: '#app',
	router,
	store
	// vuetify
});
