<template>
    <app-layout>

        <template #header>
            Categorias
        </template>
        <div class="card">
            <div class="card-header">
                <modal
                        title="Nueva Categoria"
                        title-button="Agregar Categoria"
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
                                <input type="text" v-model="category.order" class="form-control">
                            </div>
                            <div class="col-md-12 form-group" v-if="category.section != 'blog'">
                                <label for="">Descripción</label>
                                <jodit-vue v-model="category.text[lang]" :id="'text-'+lang"></jodit-vue>

<!--                                <textarea v-model="category.text[lang]" class="form-control"  cols="30" rows="3"></textarea>-->
                            </div>
                        </div>
                    </template>
                    <template #default>
                        <div class="form-group col-md-12" v-if="category.section != 'blog'">
                            <label>Imagen</label>
                            <image-custom :model.sync="category.image"></image-custom>
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
                    <tr v-for="(item,index) in categorias">
                        <td>{{ item.title.es || '' }}</td>
                        <td>{{ item.order }}</td>
                        <td>
                            <button @click="edit(item)" data-target="#category" class="btn btn-warning btn-circle" data-toggle="modal">
                                <i class="far fa-edit"></i>
                            </button>

                            <button @click="del(item)" class="btn btn-danger btn-circle">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout'
    import ImageFile from '../../Components/ImageComponent'
    import Modal from '../../Components/ModalComponent'
    import { mapState, mapActions } from 'vuex'

    export default {
        props: {
            categorias: Array,
            contenido: Object,
            section: '',
        },
        data(){
          return {

              category: {
                  id: '',
                  title: {},
                  text: {},
                  image: '',
                  section: 'blog',
                  order: '',
              },
          }
        },
        components: {
            Modal,
            AppLayout,
            'image-custom': ImageFile,
        },
        methods: {
            ...mapActions('admin', [
                'eliminar',
            ]),
            reset(){
                this.category = {
                    id: '',
                    title: {},
                    text: {},
                    image: '',
                    section: 'blog',
                    order: '',
                };
            },
            add(){
                let data = new FormData()
                data.append('id', this.category.id)
                data.append('title', JSON.stringify(this.category.title) || '')
                data.append('text', JSON.stringify(this.category.text) || '')
                if (this.section) {
                    data.append('image', this.category.image || '')
                    data.append('section', this.section || '')
                }
                data.append('order', this.category.order || '')
                this.$inertia.post(route('adm.categorias.store'), data).then(() => {

                });
            },

            edit(item){
                console.log(item)
                this.category = JSON.parse(JSON.stringify(item))
                this.$root.$emit('bv::show::modal','modal-prevent-closing')
            },
            del(id){
                this.eliminar(route('adm.categorias.destroy',{id: id}))
            },
        },
    }
</script>