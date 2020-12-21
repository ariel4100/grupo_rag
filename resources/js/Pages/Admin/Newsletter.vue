<template>
    <app-layout>
        <template #header>
            Newsletter
        </template>
        <div class="card" >

            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Email</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,index) in items">
                        <td>{{ item.email || '' }}</td>
                        <td></td>
                        <td>
<!--                            <button @click="editcontent(item)" class="btn btn-warning btn-circle">-->
<!--                                <i class="fas fa-exclamation-triangle"></i>-->
<!--                            </button>-->
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

        },
        methods: {
            add(){
                let formData = new FormData()

                formData.append('id', this.content.id)
                formData.append('section', this.content.section || '')
                formData.append('keyword', JSON.stringify(this.content.keyword));
                formData.append('description', JSON.stringify(this.content.description));

                this.$inertia.post(route('adm.metas.store'), formData).then(() => {

                });
            },
            reset(){
                this.content = {
                    id: '',
                    section: '',
                    keyword: {},
                    description: {},
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