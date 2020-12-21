<template>
    <web-layout class="">
        <div class="bg-terciario">
            <div class="container">
                <h5 class="section-title text-white">
                    <i class="fas fa-home"></i>
                    <a :href="route('familias')" class="text-white">
                        {{ t('PRODUCTOS') }}
                    </a>
                    <a v-if="familia" :href="route('productos',{ slug: familia.slug })" class="text-white">
                        {{ (familia ? '| '+familia.title : '') }}
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
                        <div class="col-md-6 mb-5">
                            <div class="border">
                                <carousel :images="gallery"  producto="1"></carousel>
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <h4 class="text-primario">
                                {{ producto.title }}
                            </h4>

                            <div class="" v-html="producto.text"></div>
                            <a v-if="producto.file" :href="producto.file" download   class="btn btn-outline-primario">Ficha Técnica <i class="fas fa-file-download  fa-lg"></i></a>
                            <a :href="route('presupuesto')" class="btn btn-primario text-white">Solicitar presupuesto</a>
                        </div>
                        <div class="col-md-4 mb-5 d-flex justify-content-center align-items-center" v-if="producto.video" style="background-color:#F6F6F6;">
                            <div class="">
                                <p style="white-space: pre-line;">{{ producto.text_video }}</p>
                            </div>
                        </div>
                        <div class="col-md-8 mb-5" v-if="producto.video">
                            <iframe width="100%" height="300" :src="'https://www.youtube.com/embed/'+producto.video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="col-md-12" v-if="productos.length > 0">
                            <h5 class="text-secundario">Productos relacionados</h5>
                            <hr   class="mt-1 bg-secundario">
                            <div class="row">
                                <template v-for="item in productos">
                                    <div class="col-md-4 col-sm-6 col-lg-4 mb-4">
                                        <product-card :item="item" type="1"></product-card>

                                    </div>
                                </template>
                            </div>
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