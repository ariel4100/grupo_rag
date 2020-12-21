<template>
    <header>
        <div class="bg-primario">
            <div class="container">
                <div class="d-flex justify-content-md-end  text-white">
                    <div class="d-flex align-items-center py-2">
                        <div class="md-form input-group  my-0">
                            <input type="text" class="form-control" placeholder="Buscando..." aria-describedby="material-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text md-addon text-white" id="material-addon2"><i class="fas fa-search"></i></span>
                            </div>
                        </div>

                        <template v-if="$page.auth.check == true">
                            <div class="dropdown">
                                <a class="nav-link text-white texx dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $page.auth.user.username.toUpperCase() || 'CLIENTE'}}  <i class="fas fa-user mr-2  text-dark"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" :href="route('privada.home')">Pedidos</a>
                                    <a class="dropdown-item" @click="logout()">Salir</a>
                                </div>
                            </div>

                        </template>

                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-0">
            <div class="container">
                <a class="navbar-brand" :href="route('home')">
                    <img :src="$page.header" alt="" class="img-fluid" style="max-width: 300px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto text-center text-start">
                        <li class="nav-item" >
                            <a class="nav-link fw-medium text-uppercase py-md-4" :class="'privada.home' == $page.currentRouteName ? 'activo' : ''" :href="route('privada.home')">PEDIDOS</a>
                        </li>
                        <li class="nav-item" >
                            <a class="nav-link fw-medium text-uppercase py-md-4" :class="'privada.carrito' == $page.currentRouteName ? 'activo' : ''" :href="route('privada.carrito')">CARRITO</a>
                        </li>
                        <li class="nav-item" >
                            <a class="nav-link fw-medium text-uppercase py-md-4" :class="'privada.estado.cuenta' == $page.currentRouteName ? 'activo' : ''" :href="route('privada.estado.cuenta')">ESTADO DE PEDIDOS</a>
                        </li>
                        <li class="nav-item" >
                            <a class="nav-link fw-medium text-uppercase py-md-4" :class="'privada.envios' == $page.currentRouteName ? 'activo' : ''" :href="route('privada.envios')">ENVIOS</a>
                        </li>
                        <li class="nav-item" >
                            <a class="nav-link fw-medium text-uppercase py-md-4" :class="'privada.reclamos' == $page.currentRouteName ? 'activo' : ''" :href="route('privada.reclamos')">RECLAMOS</a>
                        </li>
                        <li class="nav-item" >
                            <a class="nav-link fw-medium text-uppercase py-md-4" :class="'privada.historico' == $page.currentRouteName ? 'activo' : ''" :href="route('privada.historico')">HISTORICO</a>
                        </li>
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