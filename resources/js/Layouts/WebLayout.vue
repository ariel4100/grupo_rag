<template>
    <div class="">
        <!-- Page Heading -->
        <header-component/>
        <!-- Page Content -->
        <main>
            <slot></slot>
        </main>

        <footer-component/>

        <!-- Modal -->
        <div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ t('Registro') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="errors.length > 0" class="alert alert-danger">
                            <p v-for="(item,key) in errors">
                                {{ item.length > 0 ? item[0] : '' }}
                            </p>
                        </div>
                        <form class="row" @submit.prevent="registrar()">
                            <div class="col-md-6 form-group">
                                <label for="">{{ t('Nombre') }}</label>
                                <input type="text" class="form-control" v-model="registro.name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">{{ t('Usuario') }}</label>
                                <input type="text" class="form-control" v-model="registro.username" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Email</label>
                                <input type="email" class="form-control" v-model="registro.email" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">{{ t('Clave') }}</label>
                                <input type="password" class="form-control" v-model="registro.password"  required>
                            </div>
                            <div class="col-md-12 text-right">
                                <button type="submit" v-if="loader == 1" class="btn btn-primario text-white">{{ t('Registrar') }}</button>
                                <button type="button" v-if="loader == 0" class="btn btn-primario text-white">{{ t('Verificando') }} <i class="fas fa-sync fa-spin text-white"></i></button>
                                <button type="button" v-if="loader == 2" class="btn btn-primario text-white">{{ t('Ingresando') }} <i class="fas fa-sync fa-spin"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Portal -->
        <portal-target name="modal" multiple>
        </portal-target>
    </div>
</template>

<script>
    import Header from '@/Components/HeaderComponent'
    import Footer from '@/Components/FooterComponent'
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

    export default {
        components: {
            'header-component' : Header,
            'footer-component' : Footer,
            JetApplicationMark,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
                error: 0,
                errors: [],
                loader: true,
                registro: {
                    nombre: '',
                    email: '',
                    password: '',
                    username: '',
                },
            }
        },

        methods: {
            registrar(){
                this.loader = false
                if (this.registro.nombre == '' || this.registro.email == '' || this.registro.password == '' || this.registro.username == ''){
                    this.errors = [{ error : 'Complete lo Campos'}]
                }
                axios.post(route('auth.registro',this.registro).url()).then(response => {
                   console.log(response)
                    if (response.data.hasOwnProperty('errors'))
                    {
                        this.loader = true;
                        this.errors = response.data.message;
                    }else{
                        this.loader = 0;
                        setTimeout(()=>{
                            this.loader = 2;
                            location.href = route('privada.home')
                        },3000)
                    }
                    location.href = route('privada.home')
                }).catch(error => {
                    console.log(error.response)
                    // console.log(error.response.data.errors)
                    if (error.response.data.hasOwnProperty('errors'))
                    {
                        this.loader = true;
                        this.errors = error.response.data.errors;
                    }
                    this.loader = true;
                });
            },
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                axios.post(route('logout').url()).then(response => {
                    window.location = '/';
                })
            },
        }
    }
</script>
