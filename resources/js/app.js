require('./bootstrap');

require('moment');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'jodit/build/jodit.min.css'
import JoditVue from 'jodit-vue'
import Slick from 'vue-slick';
import Multiselect from 'vue-multiselect'
import store from './Store'
import money from 'v-money'

// register directive v-money and component <money>
Vue.use(money, {
    decimal: ',',
    thousands: '.',
    prefix: '$ ',
    precision: 2,
    masked: false
})

Vue.filter('toCurrency', function (numero, decimales = 2) {
    let separadorDecimal = ','
    let separadorMiles = '.'
    let partes, array;

    if ( !isFinite(numero) || isNaN(numero = parseFloat(numero)) ) {
        return "";
    }
    if (typeof separadorDecimal==="undefined") {
        separadorDecimal = ",";
    }
    if (typeof separadorMiles==="undefined") {
        separadorMiles = "";
    }

    // Redondeamos
    if ( !isNaN(parseInt(decimales)) ) {
        if (decimales >= 0) {
            numero = numero.toFixed(decimales);
        } else {
            numero = (
                Math.round(numero / Math.pow(10, Math.abs(decimales))) * Math.pow(10, Math.abs(decimales))
            ).toFixed();
        }
    } else {
        numero = numero.toString();
    }

    // Damos formato
    partes = numero.split(".", 2);
    array = partes[0].split("");
    for (var i=array.length-3; i>0 && array[i-1]!=="-"; i-=3) {
        array.splice(i, 0, separadorMiles);
    }
    numero = array.join("");

    if (partes.length>1) {
        numero += separadorDecimal + partes[1];
    }

    return numero;
});
Vue.mixin({
    data(){
        return {
            menu: [
                {
                    nombre: 'Inicio',
                    route: 'home',
                    url: 'home',
                    mostrar: 1,
                },
                {
                    nombre: 'EMPRESA',
                    route: 'empresa',
                    url: 'empresa',
                    mostrar: 1,
                },
                {
                    nombre: 'TRATAMIENTOS',
                    route: 'familias',
                    url: 'familias',
                    mostrar: 1,
                },
                {
                    nombre: 'CLIENTES',
                    route: 'clientes',
                    url: 'clientes',
                    mostrar: 1,
                },
                {
                    nombre: 'CALIDAD',
                    route: 'calidad',
                    url: 'calidad',
                    mostrar: 1,
                },
                {
                    nombre: 'LABORATORIO',
                    route: 'laboratorio',
                    url: 'laboratorio',
                    mostrar: 1,
                },
                {
                    nombre: 'SOLICITAR PRESUPUESTO',
                    route: 'empresa',
                    url: 'descargas',
                    mostrar: 1,
                },
                {
                    nombre: 'Contacto',
                    route: 'contacto',
                    url: 'contacto',
                    mostrar: 0,
                },
            ]
        }
    },
    methods: {
        t(key) {
            // console.log('aca')
            let item = 0
            if(this.$page.traducciones){
                item = this.$page.traducciones.find((item) => {
                    if(item.key == key){
                        return item
                    }
                })
            }
            if(item){
                return item.traduccion
            }else{
                return key
            }
        },
        logout() {
            axios.post(route('logout').url()).then(response => {
                window.location = route('home');
            })
        },
    }
})
Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(JoditVue)

Vue.component(JoditVue)
Vue.component(Slick)
Vue.component(money)

Vue.component('multiselect', Multiselect)

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
    store,
}).$mount(app);
