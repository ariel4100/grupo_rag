<template>
    <app-layout>

        <template #header>
            Familias
        </template>
        <div class="card">
            <div class="card-header">
                <modal
                        title="Familia"
                        title-button="Agregar Familia"
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
                            <div class="form-group col-md-6 d-flex align-items-end">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" v-model="category.featured" :true-value="1" :false-value="0" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1">Mostrar en la Sección Principal?</label>
                                </div>
                            </div>
<!--                            <div class="col-md-12 form-group" v-if="category.padre_id != null">-->
<!--                                <label for="">Texto</label>-->
<!--                                <jodit-vue v-model="category.text[lang]" :id="'text-'+lang"></jodit-vue>-->

<!--                                <textarea v-model="category.text[lang]" class="form-control"  cols="30" rows="3"></textarea>-->
<!--                            </div>-->
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
    import { mapState, mapActions } from 'vuex'


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
                  padre_id: '',
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
            familias_principales(){
                // let selects = this.selectedValue.push({
                //     value: this.selectedCat,
                //     id: this.selectedCat.id,
                // })

                let result = this.categorias.filter((item)=>{
                    if (item.padre_id == null){
                        return item
                    }
                })

                return result
            },
            ...mapState({
                admin: state =>  state.admin,
            }),
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
                    padre_id: '',
                    featured: 0,
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
                data.append('featured', this.category.featured || '')
                data.append('padre_id', this.category.padre_id || '')
                // data.append('hijo', this.category.hijo || '')
                data.append('order', this.category.order || '')
                this.$inertia.post(route('adm.familias.store'), data).then(() => {

                });
            },

            edit(item){
                // console.log(item)
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
                        axios.delete(route('adm.familias.destroy',{id: id})).then((res)=>{
                            console.log(res)
                            if (res.data.status == 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Se elimino correctamente',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                this.$inertia.visit(route('adm.familias.index'), { method: 'get' })
                            }
                        })
                    }
                })

            },
            // del(id){
            //     let data = {}
            //     data.id = id
            //     data.ruta = 'adm.familias.destroy'
            //     this.$inertia.delete(route('adm.familias.destroy',id).url()).then(() => {
            //
            //     })
            //     // this.eliminar(data)
            // },
        },
    }
</script>