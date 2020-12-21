<template>
    <app-layout>

        <template #header>
            Subfamilias
        </template>
        <div class="card">
            <div class="card-header">
                <modal
                        title="Subfamilia"
                        title-button="Agregar Subfamilia"
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
                            <div class="col-md-6 form-group">
                                <label for="">Familia</label>
                                <select v-model="category.padre_id" id="" class="form-control">
                                    <option :value="item.id" v-for="item in familias">
                                        {{ item.title }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group" >
                                <label for="">Texto</label>
                                <jodit-vue v-model="category.text[lang]" :id="'text-'+lang"></jodit-vue>
<!--                                <textarea v-model="category.text[lang]" class="form-control"  cols="30" rows="3"></textarea>-->
                            </div>
                        </div>
                    </template>
                    <template #default>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Imagen</label>
                                <image-custom :model.sync="category.image"></image-custom>
                            </div>
                        </div>
                    </template>
                </modal>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Titulo</th>
                        <th scope="col">Orden</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="(item,index) in items">
                        <tr class=" "  >
                            <td>{{ item.title.es || '' }}</td>
                            <td>{{ item.order || '' }}</td>
                            <td>
                                <button @click="edit(item)" data-target="#category" class="btn btn-warning btn-circle" data-toggle="modal">
                                    <i class="far fa-edit"></i>
                                </button>
                                <button @click="duplicate(item)" class="btn btn-info btn-circle">
                                    <i class="far fa-clone"></i>
                                </button>
                                <button @click="del(item)" class="btn btn-danger btn-circle">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import SelectLevel from '@/Components/SelectLevelComponent'
    import AppLayout from '@/Layouts/AppLayout'
    import ImageFile from '@/Components/ImageComponent'
    import Modal from '@/Components/ModalComponent'

    export default {
        props: {
            items: Array,
            familias: Array,
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
                  padre_id: '',
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
        },

        computed:{

        },
        methods: {

            reset(){
                this.category = {
                    id: '',
                    title: {},
                    text: {},
                    padre_id: '',
                    hijo: [],
                    image: '',
                    order: '',
                };
            },
            add(){
                let data = new FormData()

                data.append('id', this.category.id)
                data.append('title', JSON.stringify(this.category.title) || '')
                data.append('text', JSON.stringify(this.category.text) || '')
                data.append('image', this.category.image || '')
                data.append('padre_id', this.category.padre_id || '')
                // data.append('hijo', this.category.hijo || '')
                data.append('order', this.category.order || '')
                this.$inertia.post(route('adm.subfamilias.store'), data).then(() => {

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
                        this.$inertia.delete(route('adm.subfamilias.destroy',{id: id})).then(() => {
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

            duplicate(id){
                Swal.fire({
                    title: '¿Estas seguro de duplicar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        this.$inertia.get(route('adm.subfamilias.show',{id: id})).then(() => {
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