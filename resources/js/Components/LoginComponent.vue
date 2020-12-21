<template>

        <div class="position-relative d-flex justify-content-center m-3">
            <div class="arrow-up d-none d-md-block"></div>

            <div class="text-center">
                <p v-if="error != ''" class="text-terciario mb-0">{{ error }}</p>
                <div class="form-group pt-3">
                    <input type="text" class="form-control" :placeholder="t('Usuario')" v-model="user.username">
                </div>
<!--                <div class="form-group pt-3">-->
<!--                    <input type="email" class="form-control" :placeholder="'Email'" v-model="user.email">-->
<!--                </div>-->
                <div class="form-group">
                    <input type="password" class="form-control" v-on:keyup.enter="login()" :placeholder="t('Contraseña')" v-model="user.password">
                </div>
                <!--<div class="form-group">-->
                <!--<div class="form-check">-->
                <!--<input type="checkbox" class="form-check-input" id="dropdownCheck2">-->
                <!--<label class="form-check-label" for="dropdownCheck2">-->
                <!--Remember me-->
                <!--</label>-->
                <!--</div>-->
                <!--</div>-->
                <!--<i class="fas fa-circle-notch fa-spin p-1"></i>-->
                <div class="py-3">
                    <a v-if="loader == 1" @click="login()" class="btn btn-secundario btn-block text-white">{{ t('Ingresar') }}</a>
                    <a v-if="loader == 0" class="btn btn-secundario btn-block text-white" >{{ t('Verificando') }} <i class="fas fa-sync fa-spin text-white"></i></a>
                    <a v-if="loader == 2" class="btn btn-success btn-block text-white" >{{ t('Ingresando') }} <i class="fas fa-sync fa-spin"></i></a>
                </div>
                <div class="">
                    <!-- Button trigger modal -->
                    <a  class="text-color p-0" data-toggle="modal" data-target="#register">
                        {{ t('Crear nueva cuenta') }}
                    </a>

<!--                    <a :href="urlRegister" class="">{{ t('Nueva_Cuenta') }}</a>-->
<!--                    <a :href="urlReset" class="nav-link text-white p-0">¿Olvidaste tu contraseña?</a>-->
                </div>
            </div>
<!--            <a   class="nav-link py-2 px-4" style="border-radius: 5rem">-->
<!--                Registrar un nuevo usuario-->
<!--            </a>-->
            <!-- Modal -->
        </div>
</template>

<script>
    export default {
        props:{
            lang: Object,
            urlLogin: String,
            urlRegister: String,
            urlReset: String,
        },
        data(){
            return{
                user:{
                    email:'',
                    username:'',
                    password:'',
                    client: 1,
                },
                loader: true,
                error: '',
            }
        },
        mounted() {
            // console.log(this.lang)
        },
        methods:{
            login(){
                this.loader = false
                // console.log(this.user)
                if (this.user.username == '' || this.user.password == '')
                {
                    this.loader = true
                    this.error = 'Complete los campos'
                    return false
                }

                // this.$inertia.post(route('login'), {
                //     name: this.user.name,
                //     email: this.user.email,
                //     _token: this.$page.props.csrf_token,
                // })

                axios.post(route('auth.login'),this.user).then(res => {
                    // console.log(res)
                    if (res.data.hasOwnProperty('errors'))
                    {
                        this.loader = true;
                        this.error = res.data.message;
                    }else{
                        this.loader = 0;
                        setTimeout(()=>{
                            this.loader = 2;
                            location.href = route('privada.home')
                        },3000)
                    }

                }).catch(error => {
                    console.log(error.response)
                    // console.log(error.response.data.errors)
                    if (error.response.data.hasOwnProperty('errors'))
                    {
                        this.loader = true;
                        this.error = error.response.data.message;
                    }
                    this.loader = true;
                });
            }
        }
    }
</script>
<style>
    .flecha-up {
        width:0px;
        height:0px;
        border-left:25px solid transparent; /* izquierda flecha */
        border-right:25px solid transparent; /* derecha flecha */
        border-bottom:25px solid #0A0A0A; /* base flecha y color*/
        font-size:0px;
        line-height:0px;
    }
    .box::-moz-placeholder{
        color: #fff;
    }
</style>
