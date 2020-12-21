<template>
    <web-layout class="">
        <carousel :images="sliders" height="400px"></carousel>

        <div class="container my-5">
            <div class="d-flex pb-4 justify-content-center align-items-center">
                <h4 class="m-0 px-3 font-weight-bold text-primario">Conocé nuestros productos</h4>
            </div>

            <div class="row">
                <template v-for="item in productos">
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-5">
                        <product-card :item="item" type="1"></product-card>
                    </div>
                </template>
            </div>
        </div>

        <template v-for="(item,index) in bloques">
            <template v-if="index == 0">
                <div class="" style="background-color: #F5F5F5;">
                    <div class="container wow fadeIn py-4" :data-wow-delay="'0.'+index+'s'">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <img :src="item.image" alt="" class="img-fluid mx-auto">
                                <h2 class="mb-3 mt-3 text-primario text-center font-weight-bold">{{ item.title }}</h2>
                                <p class="" v-html="item.text"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </template>
        <div class="container my-5">
            <div class="d-flex mb-4 justify-content-center align-items-center">
                <h4 class="m-0 px-3 font-weight-bold text-primario">Nuestras Categorías</h4>
            </div>

            <div class="row">
                <template v-for="item in familias">
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-5">
                        <product-card :item="item" type="1"></product-card>
                    </div>
                </template>
            </div>
            <div class="text-center">
                <a :href="route('familias')" class="btn btn-primario px-5">Ver más</a>
            </div>
        </div>


        <div class="" style="background-color: #F5F5F5;">
            <div class="container wow fadeIn py-4" data-wow-delay="0.2s">
                <div class="row justify-content-center">
                    <div class="col-sm-10 col-md-8 col-lg-8" v-for="(item,index) in textos">
                        <img :src="item.image" alt="" class="img-fluid mx-auto">
                        <h1 class="my-3 font-weight-bold text-secundario text-center">{{ item.title }}</h1>
                        <div class="" v-html="item.text"></div>
                    </div>
                </div>
            </div>
        </div>

    </web-layout>
</template>

<script>
    import Buscador from '@/Components/BuscadorComponent'
    import Carousel from '@/Components/CarouselComponent'
    import WebLayout from '@/Layouts/WebLayout'
    import ProductCard from '@/Components/ProductCardComponent'
    import Modal from '../../Components/ModalComponent'
    import SelectLevel from '@/Components/SelectLevelWebComponent'
    import Slick from 'vue-slick';

    export default {
        props: {
            sliders: Array,
            imagenes: Array,
            familias: Array,
            productos: Array,
            textos: Array,
            texto_imagen: Array,
        },
        data(){
          return {
              filterByPadreId:'',
              slickOptions: {
                  infinite: true,
                  slidesToShow: 4,
                  slidesToScroll: 1,
                  arrows: true,
                  draggable: true,
                  autoplay: true,
                  autoplaySpeed: 3000,
                  // Any other options that can be got from plugin documentation
              },
          }
        },
        components: {
            Buscador,
            ProductCard,
            SelectLevel,
            WebLayout,
            Carousel,
            Slick,

        },
        methods: {
            buscar(){
                console.log(this.filterByPadreId)
                if (this.filterByPadreId != ''){
                    let seleccionado = this.$page.categorias.find((item)=>{
                        return  item.id == this.filterByPadreId
                    })
                    console.log(seleccionado)

                    location.href = route('familias',{ slug: seleccionado.slug})
                    // this.$inertia.post(route('adm.content.store'), data).then(() => {
                    //
                    // });
                }
            },
            next() {
                this.$refs.slick.next();
            },

            prev() {
                this.$refs.slick.prev();
            },
        },
    }
</script>