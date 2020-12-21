<template>
    <app-layout>
        <template #header>
            Metadatos
        </template>
        <div class="card" >
            <div class="card-header">
                <modal
                        title="Metadatos"
                        title-button=""
                        @ok="add()"
                        @hidden="reset()"
                >

                    <template #idioma="{ lang }">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Sección</label>
                                <input type="text" v-model="content.section" readonly class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Titulo</label>
                                <input type="text" v-model="content.title[lang]" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Keywords</label>
                                <input type="text" v-model="content.keyword[lang]" placeholder="Empresa, Soluciones. etc..." class="form-control">
                                <small>Separar por coma (,)</small>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Descripción</label>
                                <textarea v-model="content.description[lang]" class="form-control"  cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </template>

                </modal>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Sección</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,index) in items">
                        <td>{{ item.section || '' }}</td>
                        <td>{{ item.description.es || '' }}</td>
                        <td>
                            <button @click="editcontent(item)" class="btn btn-warning btn-circle">
                                <i class="fas fa-exclamation-triangle"></i>
                            </button>
<!--                            <button @click="delcontent(item.id)" class="btn btn-danger btn-circle">-->
<!--                                <i class="fas fa-trash"></i>-->
<!--                            </button>-->
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
    import Block from '../../Components/BlockComponent'
    import SelectMultiple from '@/Components/SelectMultipleComponent'

    export default {
        props: {
            items: Array,
        },
        data(){
          return {
              loader: 1,

              content: {
                  id: '',
                  section: '',
                  keyword: {},
                  description: {},
                  title: {},
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
            add(){
                let formData = new FormData()

                formData.append('id', this.content.id)
                formData.append('section', this.content.section || '')
                formData.append('keyword', JSON.stringify(this.content.keyword));
                formData.append('description', JSON.stringify(this.content.description));
                formData.append('title', JSON.stringify(this.content.title));

                this.$inertia.post(route('adm.metas.store'), formData).then(() => {

                });
            },
            reset(){
                this.content = {
                    id: '',
                    section: '',
                    keyword: {},
                    description: {},
                    title: {},
                };
            },

            editcontent(item){
                console.log(item)
                this.content = JSON.parse(JSON.stringify(item))
                this.$root.$emit('bv::show::modal','modal-prevent-closing')

            },
            delcontent(id){
                Swal.fire({
                    title: '¿Estas seguro de eliminar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        this.$inertia.delete(route('adm.metas.destroy',{id: id})).then(() => {
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