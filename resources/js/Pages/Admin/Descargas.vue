<template>
    <app-layout>

        <template #header>
            Descargas
        </template>
        <div class="card">
            <div class="card-header">
                <modal
                        title="Descarga"
                        title-button="Agregar Archivo"
                        @ok="add()"
                        @hidden="reset()"
                >
                    <template #idioma="{ lang }">
                        <div class="row">
                            <div class="col-md-10 form-group">
                                <label for="">Titulo</label>
                                <input type="text" v-model="category.title[lang]" class="form-control">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="">Orden</label>
                                <input type="text" v-model="category.order" class="form-control" placeholder="aa, bb, cc, etc...">
                            </div>
                        </div>
                    </template>
                    <template #default>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Imagen</label>
                                <image-custom :model.sync="category.image"></image-custom>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Archivo pdf/word/excel</label>
                                <image-custom :model.sync="category.file"></image-custom>
                            </div>
                        </div>
                    </template>
                </modal>
            </div>
            <div class="card-body">
                <custom-table
                        :items="categorias"
                >
                    <template #action="{ item }">
                        <button @click="edit(item)" data-target="#category" class="btn btn-warning btn-circle" data-toggle="modal">
                            <i class="far fa-edit"></i>
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
    import SelectLevel from '@/Components/SelectLevelComponent'
    import AppLayout from '@/Layouts/AppLayout'
    import ImageFile from '@/Components/ImageComponent'
    import Modal from '@/Components/ModalComponent'
    import Table from '@/Components/TableComponent'


    export default {
        props: {
            categorias: Array,
            contenido: Object,
            section: '',
        },
        data(){
          return {
              selectedCat: '',
              // selectedValue: [],
              category: {
                  id: '',
                  title: {},
                  text: {},
                  file: '',
                  featured: 0,
                  image: '',
                  order: '',
              },
          }
        },
        components: {
            SelectLevel,
            Modal,
            AppLayout,
            'image-custom': ImageFile,
            'custom-table': Table,
        },

        computed:{

        },
        methods: {

            reset(){
                this.category = {
                    id: '',
                    title: {},
                    text: {},
                    file: '',
                    featured: 0,
                    image: '',
                    order: '',
                };
            },
            add(){
                let data = new FormData()

                data.append('id', this.category.id)
                data.append('title', JSON.stringify(this.category.title) || '')
                data.append('image', this.category.image || '')
                data.append('file', this.category.file || '')
                data.append('order', this.category.order || '')
                this.$inertia.post(route('adm.descargas.store'), data).then(() => {

                });
            },

            edit(item){
                console.log(item)
                this.category = JSON.parse(JSON.stringify(item))
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
                        this.$inertia.delete(route('adm.descargas.destroy',{id: id})).then(() => {
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