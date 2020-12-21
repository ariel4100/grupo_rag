<template>
    <div class="">
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #122B3B !important" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
<!--                    <div class="sidebar-brand-icon rotate-n-15">-->
<!--                        <i class="fas fa-laugh-wink"></i>-->
<!--                    </div>-->
                    <div class="sidebar-brand-text mx-3">{{ $page.appName || 'ADMINISTRADOR'}}</div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" :href="route('dashboard')">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Panel</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Publicos
                </div>
                <template v-for="(item,index) in header">
                    <li v-if="item.submenu.length > 0" class="nav-item">
                        <a class="nav-link collapsed" :href="'#submenu'+index" data-toggle="collapse" :data-target="'#submenu'+index" aria-expanded="true" :aria-controls="'submenu'+index">
                            <span class="" v-html="item.icon"></span>
                            <span>{{ item.nombre }}</span>
                        </a>
                        <div :id="'submenu'+index" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <template v-for="data in item.submenu">
                                    <inertia-link class="collapse-item" :href="data.ruta">
                                        {{ data.nombre }}
                                    </inertia-link>
                                </template>
                            </div>
                        </div>
                    </li>
                    <li v-else class="nav-item">
                        <inertia-link class="nav-link" :href="item.ruta">
                            <span class="" v-html="item.icon"></span>
                            <span>{{ item.nombre }}</span>
                        </inertia-link>
                    </li>
                </template>
                <!-- Divider -->
                <hr class="sidebar-divider">

                <div class="sidebar-heading">
                    Configuración
                </div>

<!--                <li class="nav-item">-->
<!--                    <inertia-link class="nav-link" :href="route('adm.clientes.index')">-->
<!--                        <i class="fas fa-fw fa-chart-area"></i>-->
<!--                        <span>SEO</span>-->
<!--                    </inertia-link>-->
<!--                </li>-->
                <li class="nav-item">
                    <inertia-link class="nav-link" :href="route('adm.usuarios.index')">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Usuarios</span>
                    </inertia-link>
                </li>
                <li class="nav-item">
                    <inertia-link class="nav-link" :href="route('adm.metas.index')">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Metadatos</span>
                    </inertia-link>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>


                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <!-- Nav Item - Alerts -->
                            <li class="nav-item d-none dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <!-- Counter - Alerts -->
                                    <span class="badge badge-danger badge-counter">3+</span>
                                </a>
                                <!-- Dropdown - Alerts -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Alerts Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 12, 2019</div>
                                            <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-success">
                                                <i class="fas fa-donate text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 7, 2019</div>
                                            $290.29 has been deposited into your account!
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-warning">
                                                <i class="fas fa-exclamation-triangle text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 2, 2019</div>
                                            Spending Alert: We've noticed unusually high spending for your account.
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                </div>
                            </li>

                            <!-- Nav Item - Messages -->
                            <li class="nav-item d-none dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-envelope fa-fw"></i>
                                    <!-- Counter - Messages -->
                                    <span class="badge badge-danger badge-counter">7</span>
                                </a>
                                <!-- Dropdown - Messages -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                    <h6 class="dropdown-header">
                                        Message Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                                            <div class="status-indicator bg-success"></div>
                                        </div>
                                        <div class="font-weight-bold">
                                            <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                                            <div class="status-indicator"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                                            <div class="small text-gray-500">Jae Chun · 1d</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                                            <div class="status-indicator bg-warning"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                                            <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                                            <div class="status-indicator bg-success"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                                            <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                                </div>
                            </li>

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $page.user.name }}</span>
                                    <img class="img-profile rounded-circle" :src="$page.user.profile_photo_url" :alt="$page.user.name">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
<!--                                    <inertia-link class="dropdown-item" :href="route('profile.show')" :class="route().current('profile.show') ? 'active' : ''">-->
<!--                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>-->
<!--                                        Perfil-->
<!--                                    </inertia-link>-->

                                    <div class="dropdown-divider"></div>
                                    <form method="POST" @submit.prevent="logout">
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </li>

                        </ul>

                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

<!--                        <div v-if="$page.flash.message" class="alert alert-success">-->
<!--                            {{ $page.flash.message }}-->
<!--                        </div>-->
                        <main>
                            <slot></slot>
                        </main>

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; {{ $page.appName || 'Administrador'}} 2020</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>

 </template>
<script>
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    var publicPATH = '';
    export default {
        components: {
            JetResponsiveNavLink,
        },
        data(){
            return{
                header: [
                    {
                        nombre: 'Inicio',
                        icon: '<i class="fas fa-home"></i>',
                        submenu: [],
                        ruta: route('adm.content.index',{ section: 'inicio'}),
                    },
                    {
                        nombre: 'Empresa',
                        icon: '<i class="fas fa-building"></i>',
                        submenu: [],
                        ruta: route('adm.content.index',{ section: 'empresa'}),
                    },
                    {
                        nombre: 'Productos',
                        icon: '<i class="fas fa-cart-plus"></i>',
                        submenu: [
                            {
                                nombre: 'Familias',
                                ruta: route('adm.familias.index'),
                            },
                            {
                                nombre: 'Productos',
                                ruta: route('adm.productos.index'),
                            },
                        ],
                        ruta: route('adm.content.index',{ section: 'contacto'}),
                    },
                    {
                        nombre: 'Calidad',
                        icon: '<i class="fas fa-download"></i>',
                        submenu: [],
                        ruta: route('adm.content.index',{ section: 'calidad'}),
                    },
                    {
                        nombre: 'Contacto',
                        icon: '<i class="fas fa-fw fa-cog"></i>',
                        submenu: [],
                        ruta: route('adm.content.index',{ section: 'contacto'}),
                    },
                ],
             }
        },
        created() {

        },

        methods: {
            logout() {
                axios.post(route('logout').url()).then(response => {
                    window.location = route('home');
                })
            },
        }
  }
</script>
<style scoped>

</style>
