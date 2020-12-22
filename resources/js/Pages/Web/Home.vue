<template>
    <web-layout class="">
        <carousel :images="sliders" height="400px"></carousel>

        <div class="container my-5">
            <div class="d-flex pb-4 justify-content-center align-items-center">
                <h4 class="m-0 px-3 font-weight-bold  ">Conocé nuestros tratamientos</h4>
            </div>

            <div class="row">
                <template v-for="item in productos">
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-5">
                        <product-card :item="item" type="1"></product-card>
                    </div>
                </template>
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
                    <div class="col-md-10 wow fadeIn py-4" data-wow-delay="0.2s">
                        <div class="row justify-content-center">
                            <div class="col-md-4 col-lg-4" v-for="(item,index) in empresa">
                                <img :src="item.image" alt="" class="img-fluid mx-auto">
                                <div class="my-3 text-center" v-html="item.title"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <section class="container my-5">
            <slick ref="slick" :options="slickOptions">
                <div v-for="(item,key) in clientes" class="">
                    <div class="col my-3">
                        <div class="clientes">
                            <img :src="item.image" :alt="item.title" class="img-fluid">
                        </div>
                    </div>
                </div>
            </slick>
        </section>
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
            clientes: Array,
            empresa: Array,
            productos: Array,
            textos: Array,
            texto_imagen: Array,
        },
        data(){
          return {
              filterByPadreId:'',
              slickOptions: {
                  infinite: true,
                  slidesToShow: 6,
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
<style>
    .clientes{
        display: flex;
        justify-content: center;
        align-items: center;
        max-height: 250px;
        border: 1px solid #D5D5D5;
        min-height: 160px;
    }
</style>