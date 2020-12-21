<template>
    <div>
        <b-tabs card>
            <b-tab v-for="(lang,key) in Object.keys($page.idioma)" :key="'dyn-tab-' + key" :title="$page.idioma[lang].name ">
                <div class="text-center">
                    <button type="button" @click="addBlock(lang)" class="btn btn-info mb-4">{{ btnTitle || 'Agregar Bloque' }}</button>
                </div>
                <template v-if="only == undefined">
                    <div class="row border p-3 mb-4 position-relative" v-for="(item,key) in bloques">
                        <span @click="del(item,key)" class="badge badge-danger text-white rounded-circle position-absolute" style="top: 0; right: 0; cursor: pointer;">X</span>

                        <div class="col-md-6">
                            <div class="col-md-12 form-group">
                                <label for="">Titulo</label>
                                <input type="text" v-model="item.title[lang]" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Texto</label>
                                <jodit-vue v-model="item.text[lang]" :id="'Texto-'+lang"></jodit-vue>
                                <!--                            <textarea v-model="item.text[lang]" class="form-control"  cols="30" rows="3"></textarea>-->
                            </div>
                            <slot name="idioma" :item="item" :lang="lang"></slot>
                        </div>
                        <div class="col-md-6">
                            <image-custom :model.sync="item.image"></image-custom>
                        </div>
                    </div>
                </template>
                <template v-if="only == 'text'">
                    <div class="row border p-3 mb-4">
                        <div  v-for="(item,key) in bloques" class=" mb-4 position-relative" :class="bloques.length == 1 ? 'col-md-12' : 'col-md-6 col-lg-6'">
                            <span @click="del(item,key)" class="badge badge-danger text-white rounded-circle position-absolute" style="top: 0; right: 0; cursor: pointer;">X</span>

                            <div class="col-md-12 form-group">
                                <label for="">Titulo</label>
                                <input type="text" v-model="item.title[lang]" class="form-control">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Texto</label>
                                <jodit-vue v-model="item.text[lang]" :id="'Texto-'+lang"></jodit-vue>
                                <!-- <textarea v-model="item.text[lang]" class="form-control"  cols="30" rows="3"></textarea>-->
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="only == 'image'">
                    <div class="row border p-3 mb-4">
                        <div  v-for="(item,key) in bloques" class="col-md-4 mb-4 position-relative">
                            <span @click="del(item,key)" class="badge badge-danger text-white rounded-circle position-absolute" style="top: -5px; right: 5px; cursor: pointer;     z-index: 5;;">X</span>


                            <div class="form-group" v-if="$page.contenido.section == 'representadas'">
                                <label for="">URL</label>
                                <input type="text" v-model="item.text[lang]" class="form-control">
                            </div>
                            <div class="">
                                <image-custom :model.sync="item.image"></image-custom>
                            </div>
                            <div class="form-group">
                                <label for="">Texto</label>
<!--                                 <textarea v-model="item.title[lang]" class="form-control"  cols="30" rows="2"></textarea>-->
                                <jodit-vue v-model="item.title[lang]" :id="'Texto-'+lang"></jodit-vue>

<!--                                <input type="text" v-model="item.title[lang]" class="form-control">-->
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="only == 'video'">
                    <div class="row border p-3 mb-4">
                        <div  v-for="(item,key) in bloques" class="col-md-6 mb-4 position-relative">
                            <span @click="del(item,key)" class="badge badge-danger text-white rounded-circle position-absolute" style="top: 0; right: 0; cursor: pointer;">X</span>

                            <div class="col-md-12 form-group">
                                <label for="">Codigo de youtube - <small>https://www.youtube.com/watch?v=<b>HFOslNedk38</b></small></label>
                                <input type="text" v-model="item.title[lang]" class="form-control mb-3">
                                <iframe width="100%" height="100%" :src="'https://www.youtube.com/embed/'+item.title[lang]" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="">Texto</label>
                                <jodit-vue v-model="item.text[lang]" :id="'Texto-'+lang"></jodit-vue>
                                <!-- <textarea v-model="item.text[lang]" class="form-control"  cols="30" rows="3"></textarea>-->
                            </div>
                        </div>
                    </div>
                </template>
            </b-tab>
            <slot></slot>
        </b-tabs>
    </div>
</template>

<script>
    import ImageFile from './ImageComponent'

    export default {
        components: {
            'image-custom': ImageFile,
        },
        props:['model','only','btnTitle','type'],
        data() {
            return {
                show: false,
                name: '',
                nameState: null,
                submittedNames: [],
                bloques: [],
            }
        },
        created() {
            this.bloques = this.model || []
        },
        watch: {
            model: function(){
                console.log('entra en model')
                this.bloques = this.model
            },
            bloques: {
                handler(val){
                    console.log('entra')
                    this.$emit('update:model', this.bloques || [])
                },
                deep: true
            },
        },
        methods: {
            checkFormValidity() {
                const valid = this.$refs.form.checkValidity()
                this.nameState = valid
                return valid
            },
            resetModal() {
                this.$emit('show')
            },
            hiddenModal() {
                this.$emit('hidden')
            },

            addBlock() {
                let objeto = new Object();
                console.log(Object.keys(this.$page.idioma))
                Object.keys(this.$page.idioma).map((item)=>{
                    objeto[item] = ''
                    return objeto
                })
                console.log(objeto)
                this.bloques.push({
                    title: JSON.parse(JSON.stringify(objeto)),
                    text: JSON.parse(JSON.stringify(objeto)),
                    type: this.type || '',
                    image:'',
                })
            },

            del(item,key){
                console.log([item,key])
                if (item.id) {
                    Swal.fire({
                        title: '¿Estas seguro de eliminar?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.value) {
                            this.$inertia.get(route('adm.content.destroy.block',{id: item.id})).then(() => {

                            })
                        }
                    })
                }else{
                    this.bloques.splice(key,1);
                }


            },

            handleSubmit() {
                // Exit when the form isn't valid
                if (!this.checkFormValidity()) {
                    return
                }
                // Push the name to submitted names
                this.submittedNames.push(this.name)
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-prevent-closing')
                })
            }
        }
    }
</script>
<style>
    .tabs .card-header{
        display: none !important;
    }
</style>