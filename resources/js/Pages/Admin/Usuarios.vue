<template>
    <app-layout>
        <template #header>
            Usuarios
        </template>
        <div class="card">
            <div class="card-header">
                <modal
                        :lang="false"
                        title="Nuevo Usuario"
                        title-button="Agregar Usuario"
                        @ok="add()"
                        @hidden="reset()"
                >
                    <template #default>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Nombre y Apellido</label>
                                <input type="text" v-model="user.name" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Usuario</label>
                                <input type="text" v-model="user.username" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Email</label>
                                <input type="email" v-model="user.email" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <password-input
                                        placeholder=""
                                        label="Contraseña"
                                        v-model="user.password"
                                >
                                </password-input>
                            </div>
                        </div>

                    </template>
                </modal>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,index) in items">
                        <td>{{ item.name || '' }}</td>
                        <td>{{ item.email }}</td>
                        <td>
                            <button @click="edit(item)" data-target="#user" class="btn btn-warning btn-circle" data-toggle="modal">
                                <i class="fas fa-exclamation-triangle"></i>
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
    import PasswordInput from '@/Components/InputPassword'
    import AppLayout from '@/Layouts/AppLayout'
    import ImageFile from '@/Components/ImageComponent'
    import Modal from '@/Components/ModalComponent'

    export default {
        props: {
            items: Array,
            contenido: Object,
            section: '',
        },
        data(){
          return {

              user: {
                  id: '',
                  name:'',
                  username:'',
                  email: '',
                  password: '',
              },
          }
        },
        components: {
            PasswordInput,
            Modal,
            AppLayout,
            'image-custom': ImageFile,
        },
        methods: {

            reset(){
                this.user = {
                    id: '',
                    name:'',
                    username:'',
                    email: '',
                    password: '',
                };
            },
            add(){
                let data = new FormData()
                data.append('id', this.user.id)
                data.append('name', this.user.name || '')
                data.append('email', this.user.email || '')
                data.append('username', this.user.username || '')
                data.append('password', this.user.password || '')
                this.$inertia.post(route('adm.usuarios.store'), data).then(() => {

                });
            },

            edit(item){
                console.log(item)
                this.user = JSON.parse(JSON.stringify(item))
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
                        axios.delete(route('adm.usuarios.destroy',{id: id})).then((res)=>{
                            console.log(res)
                            if (res.data.status == 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Se elimino correctamente',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                                this.$inertia.visit(route('adm.usuarios.index'), { method: 'get' })
                            }
                        })
                    }
                })

            },
        },
    }
</script>