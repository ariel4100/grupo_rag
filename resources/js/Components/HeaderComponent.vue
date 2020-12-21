<template>
    <header>
        <div class="bg-dark">
            <div class="container">
                <div class="d-flex justify-content-md-between  text-white">
                    <div class="d-flex align-items-center py-2">

                        <div class="">
                            <a :href="item.link" target="_blank" class="px-2 py-1 text-white" v-for="item in $page.redes">
                                <i class="" :class="item.type"></i>
                            </a>
                        </div>
                        <div class="border-left px-2 d-md-block d-none" v-if="$page.whatsapps.length > 0">
                            <i class="fab fa-whatsapp"></i>
                            <a :href="'tel:'+wha.numero" v-for="wha in $page.whatsapps.slice(0,1)" class="text-white">
                                {{ wha.numero_visible }}
                            </a>
                        </div>
                        <div class="border-left px-2 d-md-block d-none" v-if="$page.emails.length > 0">
                            <i class="fas fa-envelope"></i>
                            <a :href="'mailto:'+mail.email" class="text-white" v-for="mail in $page.emails.slice(0,1)">
                                {{ mail.email }}
                            </a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center py-2">
                        <div class="">
                            <a :href="route('contacto')" class="px-4 py-3 text-white bg-primario text-uppercase fw-medium" >
                                Contacto
                            </a>
                        </div>
                        <a :href="route('buscador')" class="px-2" >
                            <i class="fas fa-search fa-lg text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-0">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto text-center text-start d-flex justify-content-between w-100">
                        <li class="nav-item" v-for="item in menu.slice(0,4)" v-if="item.mostrar == 1">
                            <a class="nav-link fw-medium text-uppercase py-md-4" :class="item.url.split(',').includes($page.currentRouteName) ? 'activo' : ''" :href="route(item.route)">{{ t(item.nombre) }}</a>
                        </li>
                        <a class="navbar-brand" :href="route('home')">
                            <img :src="$page.header" alt="" class="img-fluid" style="max-width: 255px;">
                        </a>
                        <li class="nav-item" v-for="item in menu.slice(4)" v-if="item.mostrar == 1">
                            <a class="nav-link fw-medium text-uppercase py-md-4" :class="item.url.split(',').includes($page.currentRouteName) ? 'activo' : ''" :href="route(item.route)">{{ t(item.nombre) }}</a>
                        </li>
<!--                        <li class="nav-item bg-primario">-->
<!--                            <a class="nav-link p-4"   :href="route('buscador')">-->
<!--                                <i class="fas fa-search fa-lg text-white"></i>-->
<!--                            </a>-->
<!--                        </li>-->
                    </ul>
                </div>
            </div>
        </nav>

    </header>
</template>

<script>
    import Login from '@/Components/LoginComponent'
    export default {
        components: {
          'login-component': Login
        },
        props:['title'],
        data() {
            return {

            }
        },
        methods: {

        }
    }
</script>