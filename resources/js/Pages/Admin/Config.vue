<template>
    <app-layout>
        <template #header>
            {{ $page.contenido.section }}
        </template>
        <div class="row">
            <div class="col-12">
                <div class="row" >
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Logos</h6>
                            </div>
                            <div class="card-body">
                                <!--                            <a @click="addImage" class="btn btn-info btn-md">Agregar</a>-->
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-4 text-center" v-for="(item,index) in images">
                                        <image-custom
                                                :model.sync="item.image"
                                                id="input-logo-header"
                                                :label-text="'Seleccione ' + (index==0 ? 'Favicon' : index==1 ? 'Header' : 'Footer')"
                                        ></image-custom>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div  class="">
                    <div class="text-center" v-html="title['es']"></div>
                    <!--                <nav>-->
                    <!--                    <div class="nav nav-tabs" id="nav-tab" role="tablist">-->
                    <!--                        <a v-for="(item,index,k) in idioma" class="nav-item nav-link" :class="k == 0 ? 'active' : ''" :id="'lang-'+index" data-toggle="tab" :href="'#nav-'+index" role="tab" :aria-controls="'nav-'+index" aria-selected="true">{{ item.name }}</a>-->
                    <!--                    </div>-->
                    <!--                </nav>-->
                    <div class="tab-content  mb-4" id="nav-tabContent">
                        <div v-for="(lang,key) in Object.keys($page.idioma)" class="tab-pane fade" :class="key == 0 ? ' show active' : ''" :id="'nav-'+key" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="form-group">
                                <h6 class="p-3 bg-info text-white">Copie de <a href="https://www.google.com/maps" target="_blank" class="text-dark">Google Maps</a>  la ubicación de la Empresa dale en Compartir / Insertar mapa / iFrame</h6>
                                <textarea class="form-control" v-model="title[lang]" :id="'title-'+key" cols="30" rows="3" placeholder="UBICACIÓN DE GOOGLE MAPS"></textarea>
                                <!--                            <input type="text" class="form-control" v-model="content.title[key]" placeholder="Titulo Marcas" :id="'title-'+index">-->
                            </div>
                            <div class="">
                                <!--<input type="text" class="d-none" v-model="item.text = 's'">-->
                                <!--                                <jodit-vue :config="config" v-model="text[index]" :id="'text-'+index"></jodit-vue>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header bg-warning py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-white">Direcciones ( Copie de <a href="https://www.google.com/maps" target="_blank" class="text-dark">Google Maps</a>   la ubicación de la Empresa dale en Compartir / Copiar enlace  )</h6>
                                <div class="card-header-buttons">
                                    <button type="button" class="btn btn-info" @click="addAddress()">
                                        <i class="fas fa-plus"></i>
                                        Agregar
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <draggable v-model="content.address" class="row" draggable=".draggable-item" >
                                    <div class="col-sm-12 col-md-6 col-lg-4 draggable-item" v-for="(item, index) in content.address" :key="index">
                                        <div class="row">
                                            <div class="col-12">
                                                <fieldset class="position-relative">
                                                    <span @click="deleteItem({index: index, state: 'address'})(index)" class="badge badge-danger text-white rounded-circle position-absolute" style="top: 0; right: 0; cursor: pointer;">X</span>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" id="basic-addon1">
                                                                <i class="fas fa-map-marker-alt "></i>
                                                            </div>
                                                        </div>
                                                        <textarea v-model="item.address" class="form-control" placeholder="Dirección" cols="30" rows="3"></textarea>
                                                    </div>
                                                    <div class="md-form my-1">
                                                        <input type="text" v-model="item.link" class="form-control my-0" placeholder="Link">
                                                        <small>ENLACE DE GOOGLE MAPS</small>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Redes Sociales</h6>
                                <div class="card-header-buttons">
                                    <button type="button" class="btn btn-info" @click="addRedes()">
                                        <i class="fas fa-plus"></i>
                                        Agregar
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <draggable v-model="content.redes" class="row" draggable=".draggable-item" @change="log">
                                    <div class="col-sm-12 col-md-6 col-lg-4 draggable-item" v-for="(item, index) in content.redes" :key="index">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <fieldset class="position-relative">
                                                    <span @click="deleteItem({index: index, state: 'redes'})(index)" class="badge badge-danger text-white rounded-circle position-absolute" style="top: 0; right: 0; cursor: pointer;">X</span>
                                                    <select class="form-control mb-3" v-model="item.type">
                                                        <option value="fab fa-facebook-f">Facebook</option>
                                                        <option value="fab fa-instagram">Instagram</option>
                                                        <option value="fas fa-play">Youtube</option>
                                                        <option value="fab fa-linkedin-in">Linkedin</option>
                                                        <option value="fab fa-twitter">Twitter</option>
                                                    </select>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" id="basic-addon3" v-if="item.type == 'fab fa-facebook-f'">
                                                                <i class="fab fa-facebook-f"></i>
                                                            </div>
                                                            <div class="input-group-text" id="basic-addon3" v-else-if="item.type == 'fab fa-instagram'">
                                                                <i class="fab fa-instagram"></i>
                                                            </div>
                                                            <div class="input-group-text" id="basic-addon3" v-else-if="item.type == 'fas fa-play'">
                                                                <i class="fas fa-play"></i>
                                                            </div>
                                                            <div class="input-group-text" id="basic-addon3" v-else-if="item.type == 'fab fa-linkedin-in'">
                                                                <i class="fab fa-linkedin-in"></i>
                                                            </div>
                                                            <div class="input-group-text" id="basic-addon3" v-else-if="item.type == 'fab fa-twitter'">
                                                                <i class="fab fa-twitter"></i>
                                                            </div>
                                                        </div>
                                                        <input v-model="item.link" type="text" class="form-control" placeholder="www.facebook.com">
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Teléfonos</h6>
                                <div class="card-header-buttons">
                                    <button type="button" class="btn btn-info" @click="addPhone()">
                                        <i class="fas fa-plus"></i>
                                        Agregar
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <draggable v-model="content.phones" class="row" draggable=".draggable-item" @change="log">
                                    <div class="col-sm-12 col-md-6 col-lg-4 draggable-item" v-for="(item, index) in content.phones" :key="index">
                                        <div class="row">
                                            <div class="col-12">
                                                <fieldset class="position-relative">
                                                    <span @click="deleteItem({index: index, state: 'phones'})" class="badge badge-danger text-white rounded-circle position-absolute" style="top: 0; right: 0; cursor: pointer;">X</span>
                                                    <select class="form-control mb-3" v-model="item.type">
                                                        <option value="tel">Teléfono</option>
                                                        <option value="cel">Celular</option>
                                                        <option value="wha">Whatsapp</option>
                                                    </select>
                                                    <small>Ingrese el número visible</small>
                                                    <div class="input-group md-form mb-3">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text"   v-if="item.type == 'tel'">
                                                                <i class="fas fa-phone"></i>
                                                            </div>
                                                            <div class="input-group-text"   v-else-if="item.type == 'cel'">
                                                                <i class="fas fa-mobile-alt"></i>
                                                            </div>
                                                            <div class="input-group-text"   v-else-if="item.type == 'wha'">
                                                                <i class="fab fa-whatsapp"></i>
                                                            </div>
                                                        </div>
                                                        <input v-model="item.numero_visible" type="text" class="form-control" >
                                                    </div>
                                                    <small>Ingrese solo números para el link
                                                        <template v-if="item.type == 'wha' && item.numero != ''">
                                                            <a :href="'https://wa.me/'+item.numero" target="_blank" class=""><i class="fas fa-external-link-alt"></i></a>
                                                        </template>
                                                        <template v-if="item.type == 'tel' && item.numero != ''">
                                                            <a :href="'tel:'+item.numero" class=""><i class="fas fa-external-link-alt"></i></a>
                                                        </template>
                                                        <template v-if="item.type == 'cel' && item.numero != ''">
                                                            <a :href="'tel:'+item.numero" class=""><i class="fas fa-external-link-alt"></i></a>
                                                        </template>
                                                    </small>
                                                    <div class="md-form mb-3">
                                                        <input v-model="item.numero" type="text" placeholder="Número" class="form-control" >
                                                    </div>

                                                    <!--                                                    <div class="custom-control custom-switch mt-2">-->
                                                    <!--                                                        <input type="checkbox" class="custom-control-input" v-model="item.header" :id="'customSwitch'+index" v-bind:true-value="1" v-bind:false-value="0">-->
                                                    <!--                                                        <label class="custom-control-label fz-16" :for="'customSwitch'+index">¿En la cabecera?</label>-->
                                                    <!--                                                    </div>-->
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Emails</h6>
                                <div class="card-header-buttons">
                                    <button type="button" class="btn btn-info" @click="addEmail()">
                                        <i class="fas fa-plus"></i>
                                        Agregar
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <draggable v-model="content.emails" class="row" draggable=".draggable-item" @change="log">
                                    <div class="col-sm-12 col-md-6 col-lg-4 draggable-item" v-for="(item, index) in content.emails" :key="index">
                                        <div class="row">
                                            <div class="col-12">
                                                <fieldset class="position-relative">
                                                    <span @click="deleteItem({index: index, state: 'emails'})" class="badge badge-danger text-white rounded-circle position-absolute" style="top: 0; right: 0; cursor: pointer;">X</span>
                                                    <h6>Sección</h6>
                                                    <select class="form-control mb-3" v-model="item.section">
                                                        <option :value="0">Todos</option>
                                                        <option v-for="seccion in content.secciones" :value="seccion">{{seccion}}</option>
                                                    </select>
<!--                                                    <div class="md-form mb-3">-->
<!--                                                        <input v-model="item.title" type="text" class="form-control" placeholder="Texto">-->
<!--                                                        <small>Texto que acompaña al mail</small>-->
<!--                                                    </div>-->
                                                    <div class="md-form mb-3 input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" >
                                                                <i class="fas fa-mail-bulk"></i>
                                                            </div>
                                                        </div>
                                                        <input v-model="item.email" type="email" class="form-control" placeholder="ingrese@email.com">
                                                    </div>
                                                    <!--                                                <div class="custom-control custom-switch">-->
                                                    <!--                                                    <input-->
                                                    <!--                                                            type="checkbox"-->
                                                    <!--                                                            v-bind:true-value="1"-->
                                                    <!--                                                            v-bind:false-value="0"-->
                                                    <!--                                                            v-model.number="item.notify_contact"-->
                                                    <!--                                                            class="custom-control-input"-->
                                                    <!--                                                            :id="'notify_contact'+index"-->
                                                    <!--                                                    >-->
                                                    <!--                                                    <label class="custom-control-label" :for="'notify_contact'+index">Se le notifica cuando se envie un mensaje en la sección contacto</label>-->
                                                    <!--                                                </div>-->
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Google reCAPTCHA ( Para la comunicación entre tu sitio web y el servicio reCAPTCHA. )</h6>
                                <!--                            <div class="card-header-buttons">-->
                                <!--                                <button type="button" class="btn btn-info" @click="addGoogle()">-->
                                <!--                                    <i class="fas fa-plus"></i>-->
                                <!--                                    Agregar-->
                                <!--                                </button>-->
                                <!--                            </div>-->
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 draggable-item" v-for="(item, index) in content.google" :key="index">
                                        <div class="row">
                                            <div class="col-12">
                                                <fieldset class="position-relative">
                                                    <!--  <span @click="deleteGoogle(index)" class="badge badge-danger text-white rounded-circle position-absolute" style="top: 0; right: 0; cursor: pointer;">X</span>-->
                                                    <p class="mb-3">
                                                        {{ item.title }}
                                                    </p>
                                                    <div class="md-form mb-0 input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" >
                                                                <i class="fas fa-key"></i>
                                                            </div>
                                                        </div>
                                                        <input v-model="item.key" type="text" class="form-control" placeholder="Ingrese clave">
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 d-sm-flex align-items-center justify-content-end">
                        <button type="button" @click="saveContent"  class=" btn btn-primary shadow-sm">
                            <!--<i class="fas fa-save fa-sm text-white-50"></i>-->
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import draggable from 'vuedraggable'
    import AppLayout from '../../Layouts/AppLayout'
    import ImageFile from '../../Components/ImageComponent'
    export default {
        props: {
            contenido: Object,
            imagenes: Array,
        },
        data(){
            return {
                content: this.contenido.data || {
                    secciones: [],
                    phones: [],
                    emails: [],
                    address: [],
                    redes: [],
                    google: [
                        {
                            title: 'Ingrese clave de sitio web.',
                            key: ''
                        },
                        {
                            title: 'Ingrese clave secreta.',
                            key: ''
                        }
                    ]
                },
                title: this.contenido.title || {},
            }
        },
        components: {
            AppLayout,
            draggable,
            'image-custom': ImageFile,
        },
        computed:{
          images(){
              let result = []
              if (this.imagenes.length > 0){
                  result = this.imagenes
              } else{
                  result = [
                      {
                          image:'',
                          title:'Logo Favicon',
                          subtitle:'',
                          text:'',
                      },
                      {
                          image:'',
                          title:'Logo Header',
                          subtitle:'',
                          text:'',
                      },
                      {
                          image:'',
                          title:'Logo Footer',
                          subtitle:'',
                          text:'',
                      },
                  ]
              }

              return result
          }
        },
        methods: {
            //Elimina los item de todos los array en contacto
            deleteItem(data){

                this.content[data.state].splice(data.index, 1);
            },
            saveContent(){
                let data = {
                    id: this.contenido.id,
                    contenido: this.content,
                }

                let formData = new FormData();

                if (this.images) {
                    let self = this;
                    Object.keys(this.images).forEach(function(key){

                        let file = self.images[key]
                        if (file && file instanceof File) {
                            formData.append('images['+key+']', file);
                        }
                        if (typeof file === 'string' || file instanceof String) {
                            formData.append('images['+key+']', file);
                        }
                        if (typeof file === 'object' || file instanceof Object) {
                            // console.log( file.image)
                            formData.append('images['+key+'][image]', file.image);
                            formData.append('images['+key+'][title]', file.title);
                        }
                    })
                }
                formData.append('id',this.contenido.id)
                formData.append('contenido',JSON.stringify(this.content))
                formData.append('iframe',JSON.stringify(this.title))
                // data.append('content', this.content || '')
                // data.append('id', this.contenido.id || '')
                this.$inertia.post(route('adm.content.store'), formData).then(() => {

                });
                // this.$inertia.post(route('adm.content.store'), data)
            },
            addSlider() {
                let data = new FormData()
                data.append('id', this.slider.id || '')
                data.append('title', this.slider.title || '')
                data.append('text', this.slider.text || '')
                data.append('order', this.slider.order || '')
                data.append('section', this.contenido.section || '')
                data.append('image', this.slider.image || '')
                this.$inertia.post(route('adm.content.slider'), data).then(() => {
                    $('.modal').modal('hide');
                });

            },
            editSlider(item){
                console.log(item)
                this.slider = JSON.parse(JSON.stringify(item))
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

            addText() {
                this.content.text.push({
                    seccion: 'contacto',
                    texto: ''
                });
            },
            addPhone() {
                this.content.phones.push({
                    type: 'tel',
                    numero: '',
                    numero_visible: '',
                    header: 0,
                });
            },
            addRedes() {
                this.content.redes.push({
                    type: 'tel',
                    numero: '',
                    numero_visible: '',
                    header: 0,
                });
            },
            addEmail() {
                this.content.emails.push({
                    section: 0,
                    title: '',
                    email: '',
                    notify_contact: 0
                });
            },
            addAddress() {
                this.content.address.push({
                    address: '',
                    link: '',
                    // notify_contact: 0
                });
            },
            addGoogle() {
                this.content.google.push({
                    title: '',
                    key: '',
                });
            },
            log(){

            },
        },
    }
</script>
<style>

    fieldset{
        border: 1px solid #dedede;
        padding: 16px;
    }
    legend{
        font-size: 16px;
        width: auto;
        text-transform: uppercase;
    }
</style>