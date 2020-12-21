
import Vue from 'vue'
import Vuex from 'vuex'
import { Inertia } from '@inertiajs/inertia'
import admin from './modules/admin'
import carrito from './modules/carrito'
window.inertia = Inertia



Vue.use(Vuex)

export default new Vuex.Store({
    state: {

    },
    actions: {

    },
    modules: {
        admin,
        carrito,
    },

})