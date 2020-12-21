<template>
    <web-layout class="">
        <div class="bg-terciario">
            <div class="container">
                <h5 class="section-title">
                    {{ t('Solicitar presupuesto') }}
                </h5>
            </div>
        </div>

        <form @submit.prevent="enviar" class="container my-5">
            <div v-if="$page.flash.success" class="alert alert-success">
                {{ $page.flash.success }}
            </div>
            <div v-if="$page.flash.error" class="alert alert-danger">
                {{ $page.flash.error }}
            </div>
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div v-if="step == 1" class="row">
                        <div class="col-md-12 mb-5">
                            <img :src="$page.appUrl+'/imagenes/pre1.png'" alt="" class="img-fluid mx-auto">
                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="text" class="form-control" v-model="mail.nombre" required placeholder="Ingresar nombre *">
                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="email" class="form-control" v-model="mail.email" required placeholder="Ingrese su correo electrónico *">
                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="text" class="form-control" v-model="mail.telefono" required placeholder="Ingrese teléfono *">
                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="text" class="form-control" v-model="mail.empresa" required placeholder="Empresa">
                        </div>
                        <div class="col-md-12 text-right mt-4">
                            <a @click="next()" class="btn btn-primario text-white">siguiente <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div v-if="step == 2" class="row">
                        <div class="col-md-12 mb-5">
                            <img :src="$page.appUrl+'/imagenes/pre2.png'" alt="" class="img-fluid mx-auto">
                        </div>
                        <div class="col-md-12 mb-4">
                            <textarea v-model="mail.mensaje" class="form-control" cols="30" rows="7" placeholder="Escriba su mensaje..."></textarea>
                        </div>
                        <div class="col-md-8 col-lg-6 mb-4">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" @change="onFileChange" id="customFileLang" lang="es">
                                <label class="custom-file-label" for="customFileLang" v-if="file == 0">Seleccionar Archivo</label>
                                <label class="custom-file-label" for="customFileLang" v-else>{{ file.name }}</label>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-between align-items-center mt-4">
                            <a @click="prev()" class="btn btn-outline-primario text-color ">VOLVER</a>
                            <a @click="enviar()" v-if="loading == 0" class="btn btn-primario  text-white">Consultar <i class="fas fa-chevron-right"></i></a>
                            <a v-if="loading == 1" class="btn btn-primario  text-white">ENVIANDO <i class="fas fa-spinner fa-spin "></i></a>
                        </div>
                    </div>

                </div>
            </div>

        </form>

    </web-layout>
</template>

<script>
    import InputImage from '@/Components/CarouselComponent'
    import Carousel from '@/Components/CarouselComponent'
    import WebLayout from '@/Layouts/WebLayout'
    import ImageFile from '../../Components/ImageComponent'
    import Modal from '../../Components/ModalComponent'

    export default {
        props: {
            sliders: Array,
            bloques: Array,
            contenido: Object,
        },
        data() {
            return {
                text: '',
                step: 1,
                mail: {
                    nombre: '',
                    apellido: '',
                    email: '',
                    asunto: '',
                    telefono: '',
                    mensaje: '',
                },
                asuntos: [
                    'Venta',
                    'Distribuidor',
                    'Servicios/Mantemiento',
                    'Proveedores',
                    'Educativa',
                    'Ente estatal',
                    'Otros',
                ],
                files: 0,
                file: 0,
                loading: 0,
            }
        },
        components: {
            Modal,
            WebLayout,
            Carousel,
            'image-custom': ImageFile,
        },
        methods: {
            onFileChange(e) {
                let file = e.target.files[0];
                this.file = file

            },
            enviar() {

                if (this.mail.nombre == '' || this.mail.mensaje == '' || this.mail.email == '' || this.mail.telefono == '') {
                    return false;
                }
                this.loading = true;
                let form = new FormData()

                // if (this.files.length > 0) {
                //     this.files.forEach(function (file, index) {
                //         if (file && file instanceof File) {
                //             form.append('attached[' + index + ']', file);
                //         }
                //         if (typeof file === 'string' || file instanceof String) {
                //             form.append('attached[' + index + ']', file);
                //         }
                //         if (typeof file === 'object' || file instanceof Object) {
                //             form.append('attached[' + index + ']', file.path);
                //         }
                //     })
                // }

                form.append('datos', JSON.stringify(this.mail));
                form.append('attached',this.file);

                this.$inertia.post(route('mail.presupuesto'), form).then((res) => {
                    // if (res.data.status == 'success'){
                    //     this.$bvToast.toast('¡Gracias por Suscribirte!', {
                    //         title: `FABRIMATICA S.A.`,
                    //         variant: 'success',
                    //         solid: true
                    //     })
                    // }
                    console.log(res)
                    this.mail = {
                        nombre: '',
                        apellido: '',
                        email: '',
                        asunto: '',
                        telefono: '',
                        mensaje: '',
                    },
                        this.file = 0
                        this.step = 1
                    form.delete('attached')
                    this.loading = false;
                });


                // axios.post(route('mail.newsletter'), { email: this.email}).then((res) => {
                //     // console.log(res)
                //     this.email = ''
                //     if (res.data.status == 'success'){
                //         this.$bvToast.toast('¡Gracias por Suscribirte!', {
                //             title: `FABRIMATICA S.A.`,
                //             variant: 'success',
                //             solid: true
                //         })
                //     }
                //     this.email = ''
                // });
                // data.append('content', this.content || '')
                // data.append('id', this.contenido.id || '')

            },

            prev(){
                this.step = 1
            },
            next(){
                if (this.mail.nombre == '' || this.mail.email == '' || this.mail.telefono == '') {
                    return false;
                }
                this.step = 2

            }
        },
    }
</script>
<style>

    .file-input {
        position: relative;
    }

    .file-input > [type='file'] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        z-index: 10;
        cursor: pointer;
    }

    .file-input > .button {
        display: inline-block;
        cursor: pointer;
        background: #eee;
        padding: 8px 16px;
        border-radius: 2px;
        margin-right: 8px;
    }

    .file-input:hover > .button {
        background: dodgerblue;
        color: white;
    }


</style>