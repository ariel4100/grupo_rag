<template>
    <app-layout>
        <template #header>
            {{ $page.contenido.section }}
        </template>
        <div class="card" >
            <template v-if="['inicio','empresa','calidad'].includes($page.contenido.section)">
                <div class="card-header">
                    <modal
                            title="Nuevo Slider"
                            title-button="Agregar Slider"
                            @ok="addSlider()"
                            @hidden="reset()"
                    >
                        <template #idioma="{ lang }">
                            <div class="row">
                                <div class="col-md-10 form-group">
                                    <label for="">Titulo</label>
                                    <input type="text" v-model="slider.title[lang]" class="form-control">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label for="">Orden</label>
                                    <input type="text" v-model="slider.order" class="form-control">
                                </div>
                                <div class="col-md-12 form-group">
                                    <label for="">Texto</label>

                                    <textarea v-model="slider.text[lang]" class="form-control"  cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </template>
                        <template #default>
                            <div class="form-group col-md-12">
                                <label>Imagen</label>
                                <image-custom :model.sync="slider.image"></image-custom>
                            </div>
                        </template>
                    </modal>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Imagen</th>
                            <th scope="col">Titulo</th>
                            <th scope="col">Orden</th>
                            <th scope="col">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in sliders">
                            <td>
                                <img :src="item.image" alt="" class="img-fluid" width="100px">
                            </td>
                            <td>{{ item.title.es }}</td>
                            <td>{{ item.order }}</td>
                            <td>
                                <button @click="editSlider(item)" class="btn btn-warning btn-circle">
                                    <i class="far fa-edit"></i>
                                </button>
                                <button @click="delSlider(item.id)" class="btn btn-danger btn-circle">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </template>


            <div class="card-body">
                <block v-if="['empresa','inicio','calidad'].includes($page.contenido.section)"
                       :model.sync="bloques"
                ></block>
                <block v-if="['videos'].includes($page.contenido.section)"
                       btn-title="Agregar Videos"
                       only="video"
                       type="video"
                       :model.sync="videos"
                ></block>
                <block v-if="[ 'empresa'].includes($page.contenido.section)"
                       :model.sync="timelines"
                       btn-title="Agregar Textos"
                       only="text"
                       type="texto"
                ></block>
                <block v-if="['calidad', 'inicio','servicios','industrias'].includes($page.contenido.section)"
                       :model.sync="images"
                       btn-title="Agregar Archivo/Imagen"
                       only="image"
                       type="img"
                ></block>
            </div>
            <div class="">
                <button type="button" class="btn btn-info" @click="saveContent">Guardar cambios</button>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout'
    import ImageFile from '../../Components/ImageComponent'
    import Modal from '../../Components/ModalComponent'
    import Block from '../../Components/BlockComponent'
    import SelectMultiple from '@/Components/SelectMultipleComponent'

    export default {
        props: {
            sliders: Array,
            bloques: Array,
            imagenes: Array,
            images: Array,
            timelines: Array,
            contenido: Object,
            productos: Array,
            videos: Array,
        },
        data(){
            return {
                loader: 1,
                content: this.contenido.data || {},
                slider: {
                    title: {},
                    text: {},
                    order: '',
                    image: '',
                },
            }
        },
        components: {

            Modal,
            Block,
            AppLayout,
            SelectMultiple,
            'image-custom': ImageFile,
        },
        created(){
            this.loader = 0
            setTimeout(() => {
                this.loader = 1
            },3000)
        },
        methods: {
            saveContent(){
                let formData = new FormData()
                let self = this
                //concateno los bloques junto con el timelina xq van en la misma tabla
                let all_bloques = this.bloques.concat(this.timelines).concat(this.images).concat(this.videos)
                if (all_bloques) {
                    let self = this
                    Object.keys(all_bloques).forEach(function(key){
                        let file = all_bloques[key]
                        // console.log(file)
                        if (file && file instanceof File) {
                            formData.append('bloques['+key+']', file);
                        }
                        if (typeof file === 'string' || file instanceof String) {
                            formData.append('bloques['+key+']', file);
                            // formData.append('images['+key+'][title]', JSON.stringify(file.title));
                            // formData.append('images['+key+'][text]', JSON.stringify(file.text));
                        }
                        if (typeof file === 'object' || file instanceof Object) {
                            formData.append('bloques['+key+'][image]', file.image);
                            formData.append('bloques['+key+'][id]', file.id || '');
                            formData.append('bloques['+key+'][title]', JSON.stringify(file.title));
                            formData.append('bloques['+key+'][text]', JSON.stringify(file.text));
                            formData.append('bloques['+key+'][type]', file.type || '');
                            if (file.productos && file.productos.length > 0){
                                formData.append('bloques['+key+'][productos]', JSON.stringify(file.productos));
                            }
                        }
                    })
                }
                if (this.imagenes) {
                    Object.keys(this.imagenes).forEach(function(key){
                        let file = self.imagenes[key]
                        // console.log(file)
                        if (file && file instanceof File) {
                            formData.append('imagenes['+key+']', file);
                        }
                        if (typeof file === 'string' || file instanceof String) {
                            formData.append('imagenes['+key+']', file);
                            // formData.append('images['+key+'][title]', JSON.stringify(file.title));
                            // formData.append('images['+key+'][text]', JSON.stringify(file.text));
                        }
                        if (typeof file === 'object' || file instanceof Object) {
                            formData.append('imagenes['+key+'][image]', file);
                        }
                    })
                }
                formData.append('id', this.contenido.id)
                formData.append('section', this.contenido.section || '')
                // data.append('content', this.content || '')
                // data.append('id', this.contenido.id || '')
                this.$inertia.post(route('adm.content.store'), formData).then(() => {

                });
            },

            del(id){
                Swal.fire({
                    title: '¿Estas seguro de eliminar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        this.$inertia.get(route('block.destroy',{id: id})).then(() => {
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: 'Se elimino correctamente',
                            //     showConfirmButton: false,
                            //     timer: 2000
                            // })
                            $('.modal').modal('hide');
                        })
                    }
                })

            },
            reset(){
                this.slider = {
                    id: '',
                    title: {},
                    text: {},
                    order: '',
                    image: '',
                };
            },
            addSlider() {
                let data = new FormData()
                data.append('id', this.slider.id || '')
                data.append('title', JSON.stringify(this.slider.title) || '')
                data.append('text', JSON.stringify(this.slider.text) || '')
                data.append('order', this.slider.order || '')
                data.append('section', this.contenido.section || '')
                data.append('image', this.slider.image || '')
                this.$inertia.post(route('adm.content.slider'), data).then((res) => {
                    console.log(res)
                    // if (res.data.hasOwnProperty('status')) {
                    //     if (res.data.status == 'error'){
                    //         return false
                    //     }
                    // }
                    this.$nextTick(() => {
                        this.$bvModal.hide('modal-prevent-closing')
                    })
                });
            },
            editSlider(item){
                console.log(item)
                this.slider = JSON.parse(JSON.stringify(item))
                this.$root.$emit('bv::show::modal','modal-prevent-closing')

            },
            delSlider(id){
                Swal.fire({
                    title: '¿Estas seguro de eliminar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        this.$inertia.replace(route('adm.content.destroy.slider',{id: id})).then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Se elimino correctamente',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        })
                    }
                })

            },
        },
    }
</script>
