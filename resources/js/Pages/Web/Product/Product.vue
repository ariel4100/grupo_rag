<template>
    <web-layout class="">
        <div class="bg-primario">
            <div class="container">
                <h5 class="section-title text-white">
                    <i class="fas fa-home text-white"></i>
                    <a :href="route('familias')" class="text-white">
                        {{ t('Productos') }}
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
                        <div class="col-md-6 mb-3">
                            <div class="border">
                                <carousel :images="gallery"  arrows="1" producto="1"></carousel>
                            </div>
                             
                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                                <h3 class="text-primario font-weight-bold">
                                    {{ producto.title }}
                                </h3>
                                <div class="py-3" v-html="producto.text"></div>

                                <a v-if="producto.file" :href="producto.file" target="_blank" class="btn btn-outline-primario rounded-pill text-primario">
                                    Ficha Técnica
                                    <i class="fas fa-file-download text-primario pl-2"></i>
                                </a>
                                <a :href="route('presupuesto')" class="btn btn-primario rounded-pill text-white">Solicitar presupuesto</a>
                            </div>

                        </div>
                        <div class="col-md-12" v-if="producto.description"  >
                            <div class="table-responsive">
                                <div class="py-4" v-html="producto.description">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" v-if="producto_related.length > 0">
                            <h4 class="font-weight-bold text-primario my-4">PRODUCTOS RELACIONADOS </h4>
                             <div class="row">
                                <div class="col-sm-6 col-md-4 col-lg-4 mb-5"  v-for="item in producto_related" :key="item.id">
                                    <product-card :item="item"></product-card>
                                </div>
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
            producto_related: Array,
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
