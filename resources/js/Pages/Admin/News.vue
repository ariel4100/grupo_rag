<template>
    <app-layout>
        <template #header>
            Noticias
        </template>
        <div class="card">
            <div class="card-header">
                <modal
                        title="Noticia"
                        title-button="Agregar Noticia"
                        @ok="add()"
                        @hidden="reset()"
                >
                    <template #idioma="{ lang }">
                        <div class="row">
                            <div class="col-md-10 form-group">
                                <label for="">Titulo</label>
                                <input type="text" v-model="novedad.title[lang]" class="form-control">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="">Orden</label>
                                <input type="text" v-model="novedad.order" class="form-control">
                            </div>
                            <div class="form-group col-md-12">
                                <label>Categoria</label>
                                <select v-model="novedad.category_id" id="" class="form-control">
                                    <option v-for="item in categorias" :value="item.id">{{ item.title }}</option>
                                </select>

                            </div>

                            <div class="form-group col-md-12">
                                <label>Texto</label>
                                <jodit-vue v-model="novedad.text[lang]" :id="'Texto-'+lang"></jodit-vue>

<!--                                <textarea name="" id="" cols="30" rows="3" class="form-control" v-model="novedad.text[lang]"></textarea>-->
                            </div>
                        </div>
                    </template>
                    <div class="form-group col-md-6 d-flex align-items-end">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" v-model="novedad.featured" :true-value="1" :false-value="0" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1">Mostrar en Sección Principal?</label>
                        </div>
                    </div>
                    <div class="form-group col-md-12" >
                        <label>Agregar fotos</label>
                        <custom-gallery   label="" :model.sync="novedad.image" :link="0" class=""></custom-gallery>
                    </div>
                </modal>
            </div>
            <div class="card-body">
                <custom-table
                        :items="novedades"
                >
                    <template #action="{ item }">
                        <button @click="edit(item)" class="btn btn-warning btn-circle" data-toggle="modal">
                            <i class="far fa-edit"></i>
                        </button>
<!--                        <button @click="duplicate(item)" class="btn btn-info btn-circle">-->
<!--                            <i class="far fa-clone"></i>-->
<!--                        </button>-->
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
    import AppLayout from '../../Layouts/AppLayout'
    import ImageFile from '../../Components/ImageComponent'
    import CustomGallery from '../../components/CustomGalleryComponent';
    import Modal from '../../Components/ModalComponent'
    import Table from '@/Components/TableComponent'
    import { mapState, mapActions } from 'vuex'

    export default {
        props: {
            novedades: Array,
            categorias: Array,
            contenido: Object,
        },
        data(){
          return {
              show: 1,
              novedad: {
                  id: '',
                  title: {},
                  text: {},
                  image: [],
                  order: '',
                  featured: 0,
                  category_id: '',
              },
          }
        },
        components: {
            AppLayout,
            Modal,
            'image-custom': ImageFile,
            'custom-gallery': CustomGallery,
            'custom-table': Table,
        },
        methods: {
            ...mapActions('admin', [
                'eliminar',
            ]),
            reset(){
                this.novedad = {
                    id: '',
                    title: {},
                    text: {},
                    image: [],
                    order: '',
                    featured: 0,
                    category_id: '',
                };
            },
            add(){
                let formData = new FormData();

                if (this.novedad.image) {
                    let self = this
                    Object.keys(this.novedad.image).forEach(function(key){

                        let file = self.novedad.image[key]
                        if (file && file instanceof File) {
                            formData.append('images['+key+']', file);
                        }
                        if (typeof file === 'string' || file instanceof String) {
                            formData.append('images['+key+']', file);
                        }
                        if (typeof file === 'object' || file instanceof Object) {
                            // console.log( file.image)
                            formData.append('images['+key+']', file.path);
                            // self.formData.append('images['+key+'][title]', file.title);
                        }
                    })
                }

                formData.append('id', this.novedad.id || '');
                formData.append('title', JSON.stringify(this.novedad.title) || '')
                formData.append('text', JSON.stringify(this.novedad.text) || '')
                formData.append('category_id', this.novedad.category_id || '');
                formData.append('featured', this.novedad.featured || '')
                formData.append('order', this.novedad.order || '');
                this.$inertia.post(route('adm.noticias.store'), formData).then(() => {

                });
            },

            edit(item){
                console.log(item)
                let data = JSON.parse(JSON.stringify(item))
                this.novedad = data
                // this.novedad.title = data.title
                // this.novedad.text = data.text
                // this.novedad.order = data.order
                // this.novedad.category_id = data.category_id
                // this.novedad.image = data.image
                this.show = 0
                let self = this
                this.$root.$emit('bv::show::modal','modal-prevent-closing')

                setTimeout(function(){
                    self.show = 1;
                }, 1000);
            },
            del(id){
                this.eliminar(route('adm.noticias.destroy',{id: id}))
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
                        this.$inertia.get(route('adm.noticias.show',{id: id})).then(() => {
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
        },
    }
</script>