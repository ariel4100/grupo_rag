<template>
    <app-layout>

        <template #header>
            Productos
        </template>
        <div class="card">
            <div class="card-header">
                <modal
                        title="Producto"
                        title-button="Agregar Producto"
                        @ok="add()"
                        @hidden="reset()"
                >
                    <template #idioma="{ lang }">
                        <div class="row">
                            <div class="col-md-10 form-group">
                                <label for="">Titulo</label>
                                <input type="text" v-model="product.title[lang]" class="form-control">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="">Orden</label>
                                <input type="text" v-model="product.order" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Texto</label>
                                <jodit-vue v-model="product.text[lang]" :id="'Texto-'+lang"></jodit-vue>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Texto de Video</label>
                                    <textarea v-model="product.text_video[lang]" class="form-control"  cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Codigo de youtube - <small>https://www.youtube.com/watch?v=<b>V74HTkRH_Rg</b></small></label>
                                    <input type="text" v-model="product.video" class="form-control">
                                </div>
                                <div class="embed-responsive embed-responsive-16by9" >
                                    <iframe class="embed-responsive-item" :src="'https://www.youtube.com/embed/'+product.video" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template #default>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Familias</label>
                                <multiselect v-model="familia_selected"  @select="clear_family" :options="familias" placeholder="Familia" label="title" track-by="id"></multiselect>

<!--                                <select v-model="familia_selected" id="" class="form-control">-->
<!--                                    <option value="" disabled selected>Familia</option>-->
<!--                                    <option :value="item" v-for="item in familias">-->
<!--                                        {{ item.title }}-->
<!--                                    </option>-->
<!--                                </select>-->
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Productos Relacionados</label>
                                <select-multiple
                                        :data="productos"
                                        :model.sync="product.productos"
                                ></select-multiple>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 d-flex align-items-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" v-model="product.featured" :true-value="1" :false-value="0" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1">Mostrar en la Sección Principal?</label>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Archivo</label>
                                <image-custom :model.sync="product.file"></image-custom>
                            </div>
                            <div class="col-md-12" >
                                <label>Agregar fotos</label>
                                <custom-gallery   label="" :model.sync="product.gallery" :link="0" class=""></custom-gallery>
                            </div>
                        </div>
                    </template>
                </modal>
            </div>
            <div class="card-body">
<!--                <table class="table">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th scope="col">Titulo</th>-->
<!--                        <th scope="col">Orden</th>-->
<!--                        <th scope="col">Acciones</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody>-->
<!--                    <tr v-for="(item,index) in productos">-->
<!--                        <td>{{ item.title.es || '' }}</td>-->
<!--                        <td>{{ item.order }}</td>-->
<!--                        <td>-->
<!--                            <button @click="edit(item)" data-target="#category" class="btn btn-warning btn-circle" data-toggle="modal">-->
<!--                                <i class="far fa-edit"></i>-->
<!--                            </button>-->
<!--                            <button @click="duplicate(item)" class="btn btn-info btn-circle">-->
<!--                                <i class="far fa-clone"></i>-->
<!--                            </button>-->
<!--                            <button @click="del(item)" class="btn btn-danger btn-circle">-->
<!--                                <i class="fas fa-trash"></i>-->
<!--                            </button>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->

                <custom-table
                        :items="productos"
                >
                    <template #action="{ item }">
                        <button @click="edit(item)" data-target="#category" class="btn btn-warning btn-circle" data-toggle="modal">
                            <i class="far fa-edit"></i>
                        </button>
                        <button @click="duplicate(item)" class="btn btn-info btn-circle">
                            <i class="far fa-clone"></i>
                        </button>
                        <button @click="del(item)" class="btn btn-danger btn-circle">
                            <i class="fas fa-trash"></i>
                        </button>
                    </template>
                </custom-table>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import SelectMultiple from '@/Components/SelectMultipleComponent'
    import AppLayout from '@/Layouts/AppLayout'
    import ImageFile from '@/Components/ImageComponent'
    import Modal from '@/Components/ModalComponent'
    import CustomGallery from '../../components/CustomGalleryComponent';
    import Table from '@/Components/TableComponent'

    export default {
        props: {
            familias: Array,
            subfamilias: Array,
            productos: Array,
            contenido: Object,
            section: '',
        },
        data(){
          return {
              familia_selected: '',
              product: {
                  id: '',
                  title: {},
                  description: {},
                  text: {},
                  text_video: {},
                  family_id: '',
                  video: '',
                  productos: [],
                  banner: '',
                  gallery: [],
                  file: '',
                  order: '',
              },
          }
        },
        components: {
            SelectMultiple,
            Modal,
            AppLayout,
            'custom-gallery': CustomGallery,
            'image-custom': ImageFile,
            'custom-table': Table,

        },
        // watch:{
        //     familia_selected(){
        //         this.product.family_id = ''
        //     }
        // },
        computed:{
            subfamilias_filter(){
                let result = this.subfamilias.filter((item) => {
                    return item.padre_id ==  this.familia_selected.id
                })
                return result;
            }
        },
        methods: {
            clear_family(){
                this.product.family_id = ''
            },
            reset(){
                this.product = {
                    id: '',
                    title: {},
                    description: {},
                    text: { es: ''},
                    text_video: {},
                    family_id: '',
                    video: '',
                    productos: [],
                    banner: '',
                    gallery: [],
                    file: '',
                    order: '',
                    featured: 0,
                };
            },
            add(){
                let data = new FormData()

                if (this.product.gallery) {
                    let self = this
                    Object.keys(this.product.gallery).forEach(function(key){

                        let file = self.product.gallery[key]
                        if (file && file instanceof File) {
                            data.append('gallery['+key+']', file);
                        }
                        if (typeof file === 'string' || file instanceof String) {
                            data.append('gallery['+key+']', file);
                        }
                        if (typeof file === 'object' || file instanceof Object) {
                            // console.log( file.image)
                            data.append('gallery['+key+']', file);

                            // self.formData.append('images['+key+'][title]', file.title);
                        }
                    })
                }


                data.append('id', this.product.id)
                data.append('title', JSON.stringify(this.product.title) || '')
                data.append('text', JSON.stringify(this.product.text) || '')
                data.append('text_video', JSON.stringify(this.product.text_video) || '')
                data.append('description', JSON.stringify(this.product.description) || '')
                data.append('productos', JSON.stringify(this.product.productos || []))
                data.append('family_id', this.familia_selected.id || '')
                data.append('banner', this.product.banner || '')
                data.append('archivo', this.product.file || '')
                data.append('video', this.product.video || '')
                data.append('order', this.product.order || '')
                data.append('featured', this.product.featured || '')

                this.$inertia.post(route('adm.productos.store'), data).then(() => {

                });
            },



            duplicate(id){
                Swal.fire({
                    title: '¿Estas seguro de duplicar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        this.$inertia.get(route('adm.productos.show',{id: id})).then(() => {
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: 'Se elimino correctamente',
                            //     showConfirmButton: false,
                            //     timer: 2000
                            // })

                        })
                    }
                })

            },
            edit(item){
                console.log(item)
                this.familia_selected = item.family || {}
                this.product = JSON.parse(JSON.stringify(item))
                this.$root.$emit('bv::show::modal','modal-prevent-closing')
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
                        axios.delete(route('adm.productos.destroy',{id: id})).then((res)=>{
                            console.log(res)
                            if (res.data.status == 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Se elimino correctamente',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                this.$inertia.visit(route('adm.productos.index'), { method: 'get' })
                            }
                        })
                    }
                })

            },
        },
    }
</script>