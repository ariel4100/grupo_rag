require('./bootstrap');

require('moment');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { Inertia } from '@inertiajs/inertia'
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
import NProgress from 'nprogress'


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
                    color: '#CB7DAF',
                },
                {
                    nombre: 'EMPRESA',
                    route: 'empresa',
                    url: 'empresa',
                    mostrar: 1,
                    color: '#FF7614',
                },
                {
                    nombre: 'TRATAMIENTOS',
                    route: 'familias',
                    url: 'familias',
                    mostrar: 1,
                    color: '#FDC308',
                },
                {
                    nombre: 'CLIENTES',
                    route: 'clientes',
                    url: 'clientes',
                    mostrar: 1,
                    color: '#479837',
                },
                {
                    nombre: 'CALIDAD',
                    route: 'calidad',
                    url: 'calidad',
                    mostrar: 1,
                    color: '#0087CE',
                },
                {
                    nombre: 'LABORATORIO',
                    route: 'laboratorio',
                    url: 'laboratorio',
                    mostrar: 1,
                    color: '#C0448A',
                },
                {
                    nombre: 'SOLICITAR PRESUPUESTO',
                    route: 'presupuesto',
                    url: 'presupuesto',
                    mostrar: 1,
                    color: '#20B0E4',
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

// InertiaProgress.init({
//     // The delay after which the progress bar will
//     // appear during navigation, in milliseconds.
//     delay: 0,
//
//     // The color of the progress bar.
//     color: 'red',
//
//     // Whether to include the default NProgress styles.
//     includeCSS: true,
//
//     // Whether the NProgress spinner will be shown.
//     showSpinner: true,
// })

const app = document.getElementById('app');
NProgress.configure({
    ease: 'ease',
    speed: 500,
    showSpinner: false,

});
Inertia.on('start', () => NProgress.start())
Inertia.on('finish', () => NProgress.done())

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
