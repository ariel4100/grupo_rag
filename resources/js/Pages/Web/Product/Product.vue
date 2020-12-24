<template>
    <web-layout class="">
        <div class="bg-light">
            <div class="container">
                <h5 class="section-title text-dark">
                    <i class="fas fa-home"></i>
                    <a :href="route('familias')" class="text-dark">
                        {{ t('PRODUCTOS') }}
                    </a>
                    {{ (producto ? '| '+producto.title : '') }}
                </h5>
            </div>
        </div>
        <div class="container my-5">
            <div class="row">
                <div class="col-md-3">
                    <sidenav
                            :familia-id="familia.id"
                            :producto-id="producto.id"
                            :familias="familias"
                    ></sidenav>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="border">
                                <carousel :images="gallery"  arrows="1" producto="1"></carousel>
                            </div>
                            <figure class="row mt-4">
                                <div class="col-md-2"  v-for="item in gallery">
                                    <img
                                            :src="item"
                                            class="figure-img img-fluid rounded shadow-3 mb-3"
                                            alt="..."
                                            style="max-height: 90px;"
                                    />
                                </div>
                            </figure>
                        </div>
                        <div class="col-md-12 mb-5">
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                                <h4 class="text-dark font-weigth-bold">
                                    {{ producto.title }}
                                </h4>
                                <a :href="route('presupuesto')" class="btn btn-primario text-white">Solicitar presupuesto</a>
                            </div>

                            <div class="" v-html="producto.text"></div>
                        </div>
                        <div class="col-md-4 mb-5 d-flex justify-content-center align-items-center pr-md-0" v-if="producto.video" style="background-color:#F6F6F6;">
                            <div class="py-4">
                                <p style="white-space: pre-line;">{{ producto.text_video }}</p>
                            </div>
                        </div>
                        <div class="col-md-8 mb-5 pl-md-0" v-if="producto.video">
                            <iframe width="100%" height="300" :src="'https://www.youtube.com/embed/'+producto.video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </web-layout>
</template>

<script>
    import Carousel from '@/Components/CarouselComponent'
    import Sidenav from '@/Components/SidenavComponent'
    import WebLayout from '@/Layouts/WebLayout'
    import ImageFile from '@/Components/ImageComponent'
    import ProductCard from '@/Components/ProductCardComponent'
    export default {
        props: {
            gallery: Array,
            productos: Array,
            familias: Array,
            producto: Object,
            familia: Object,
        },
        data(){
          return {
              text:'',
              slider: {
                  title: '',
                  text: '',
                  order: '',
                  image: '',
              },
          }
        },
        components: {
            ProductCard,
            Sidenav,
            WebLayout,
            Carousel,
            'image-custom': ImageFile,
        },
        methods: {
            saveContent(){
                let data = {
                    id: this.contenido.id,
                    contenido: this.content,
                }
                // data.append('content', this.content || '')
                // data.append('id', this.contenido.id || '')
                this.$inertia.post(route('adm.content.store'), data).then(() => {

                });
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
            asset(img){
                if (img){
                    return 'storage/'+img
                }
                return '';
            },
        },
    }
</script>