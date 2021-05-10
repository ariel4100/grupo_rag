<template>
    <!-- Footer -->

    <footer class="page-footer font-small bg-secundario">
        <section class="bg-primario py-4">
            <div class="d-flex align-items-center justify-content-center  ">
                <div class="rounded-circle border d-flex justify-content-center align-items-center mx-2" style="height:35px; width: 35px"  v-for="item in $page.redes" >
                    <a :href="item.link" target="_blank" class="text-white" >
                        <i class="text-white" :class="item.type"></i>
                    </a>
                </div>
            </div>
        </section>
        <!-- Footer Links -->
        <div class="footer-image" :style="'background-image: url('+$page.appUrl+'/imagenes/footer.jpg );'" style="  background-size: cover; background-repeat: no-repeat; background-position: top;">
            <div class="container text-center text-md-left">
                <!-- Grid row -->
                <div class="row pt-5">
                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-4 mx-auto mb-4">
                        <!-- Content -->
                        <div class="row">
                            <div class="col-md-6">
                                <img :src="$page.footer" alt="" class="img-fluid mx-auto mr-md-3" style="">
                            </div>

                        </div>

<!--                        <div class="d-flex justify-content-center align-items-center pt-4">-->
<!--                            <h6 class="text-primario mt-2">Seguínos en: </h6>-->
<!--                            <div class="d-flex align-items-center justify-content-center justify-content-md-start">-->
<!--                                <div class="rounded-circle border border-primario d-flex justify-content-center align-items-center mx-2" style="height:40px; width: 40px"  v-for="item in $page.redes" >-->
<!--                                    <a :href="item.link" target="_blank" class="text-primario" >-->
<!--                                        <i class="" :class="item.type"></i>-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
<!--                    <div class="col-md-2 col-lg-2 mx-auto mb-4">-->
<!--                        &lt;!&ndash; Content &ndash;&gt;-->
<!--                        <img :src="$page.image_calidad" alt="" class="img-fluid mx-auto ml-md-0" style="">-->

<!--                    </div>-->
                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">

                        <!-- Links -->
                        <h6 class="text-uppercase text-primario font-weight-bold">{{ t('Secciones')}}</h6>
                        <div class="d-flex justify-content-center justify-content-md-start flex-md-row flex-column  ">
                            <div class="mr-md-4">
                                <p v-for="item in menu.slice(0,4)" class="mb-1">
                                    <a :href="route(item.route)" class="fz-14 hover-link text-uppercase">{{  t(item.nombre) }}</a>
                                </p>


                            </div>
                            <div class="">
                                <p v-for="item in menu.slice(4)" class="mb-1">
                                    <a :href="route(item.route)" class="fz-14 hover-link text-uppercase">{{ item.nombre }}</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-md-0 mb-4">

                        <!-- Links -->
                        <h6 class="text-uppercase text-primario font-weight-bold">{{ t('Grupo Rag')}}</h6>
                        <div class="d-flex justify-content-center justify-content-md-start flex-md-row flex-column text-white">
                            <ul class="list-group mb-4 mb-md-0 mr-md-3 text-white">
                                <li class="list-group-item bg-transparent border-0 fz-15 d-flex align-items-center px-0 py-1 mb-2 flex-md-row flex-column">
                                    <i class="fas fa-map-marker-alt fa-lg mr-md-3 mt-2 mr-2"></i>
                                    <div class="">
                                        <a :href="item.link" v-for="item in $page.direcciones.slice(0,1)" target="_blank" class=" hover-link" style="white-space: pre-line;">{{ item.address }}</a>
                                    </div>
                                </li>

                                <li v-if="$page.telefonos.length > 0" class="list-group-item bg-transparent border-0 fz-15 d-flex align-items-center px-0 py-1 mb-2 flex-md-row flex-column">
                                    <i class="fas fa-phone-volume fa-lg mr-md-3 mb-2"></i>
                                    <div class="d-flex flex-column">
                                        <template v-for="item in $page.telefonos">
                                            <template v-if="item.type == 'tel'">
                                                <a :href="'tel:'+item.numero" class="hover-link">
                                                    {{ item.numero_visible }}
                                                </a>
                                            </template>
                                        </template>
                                    </div>
                                </li>
                                <li v-if="$page.whatsapps.length > 0" class="list-group-item bg-transparent  border-0 fz-15 d-flex align-items-center px-0 py-1 mb-2 flex-md-row flex-column">
                                    <i class="fab fa-whatsapp fa-lg mr-md-3 mb-md-0 mb-2"></i>
                                    <div class="d-flex flex-column">
                                        <template v-for="item in $page.whatsapps">
                                            <template v-if="item.type == 'wha'">
                                                <a :href="'https://wa.me/'+item.numero" class="hover-link">
                                                    {{ item.numero_visible }}
                                                </a>
                                            </template>
                                        </template>
                                    </div>
                                </li>

                                <li v-if="$page.emails.length > 0" class="list-group-item bg-transparent border-0 d-flex fz-15 px-0 py-1 mb-2 flex-md-row flex-column">
                                    <i class="fas fa-envelope fa-lg  mr-md-3 mt-2"></i>
                                    <div class="">
                                        <a :href="'mailto:'+item.email" class="hover-link d-block" v-for="item in $page.emails.slice(0,3)">
                                            {{ item.email }}
                                        </a> 
                                    </div>
                                </li>
                            </ul>

                        </div>
                    </div>



                </div>
                <!-- Grid row -->
            </div>
        </div>
        <!-- Footer Links -->
    </footer>
    <!-- Footer -->
</template>

<script>
    export default {
        props:['title'],
        data() {
            return {
                email: ''
            }
        },
        methods: {
            enviar(){
                if(this.email == ''){
                    return false
                }
                axios.post(route('mail.newsletter'), { email: this.email}).then((res) => {
                   // console.log(res)
                    this.email = ''
                    if (res.data.status == 'success'){
                        this.$bvToast.toast('¡Gracias por Suscribirte!', {
                            title: `EMONA S.R.L.`,
                            variant: 'success',
                            solid: true
                        })
                    }
                    this.email = ''
                });
            }
        }
    }
</script>
<style>

</style>
