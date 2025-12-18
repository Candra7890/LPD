import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import {
    Ripple
} from 'vuetify/lib/directives'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify, {
    components: {
        VCard
    },
    directives: {
        Ripple
    }
})

const opt = {}
export default new Vuetify(opt)