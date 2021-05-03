<template>
    <web-layout class="">
        <carousel :images="sliders" height="400px"></carousel>

        <div class="container my-5">
<!--            <div class="d-flex pb-4 justify-content-center align-items-center">-->
<!--                <h4 class="m-0 px-3 font-weight-bold  ">Conocé nuestros tratamientos</h4>-->
<!--            </div>-->

            <div class="row">
                <template v-for="item in industrias">
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-5">
                        <div class="h-100">
                            <a  :href="route('industrias')" class="p-0  nav-link">
                                <div class="product-card position-relative   border">
                                    <div class="product-card__mask">
                                        <div class="">
                                            <div class=" imagen">
                                                <img :src="item.image" :alt="'Grupo Rag industrias'" class="img-fluid">
                                            </div>
                                            <h5 class="fw-medium text-white mt-2" v-html="item.title"></h5>
<!--                                            <i class="fas fa-plus fa-2x"></i>-->
                                            <a :href="route('industrias')" class="btn btn-white fw-medium btn-rounded text-primario">VER MÁS</a>
                                        </div>
                                    </div>
                                    <div class=" imagen">
                                        <img :src="item.image" :alt="'Grupo Rag industrias'" class="img-fluid">
                                    </div>
                                    <div class="texto">
                                        <h5 class="fw-medium text-primario p-3 mt-2" v-html="item.title"></h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </div>


        <div class="d-flex align-items-center" v-for="(item,index) in bloques" style="background-image: url('imagenes/home-banner.jpg');background-position: center; background-size: cover; min-height: 300px;" :style="{ backgroundImage: 'url(' + item.image + ')' }">
            <div class="row justify-content-center align-items-center">

                <div class="col-md-3 text-right">
                    <h2 class="my-3 font-weight-bold text-white text-end">{{ item.title }}</h2>
                    <a href="" class="btn btn-white text-dark rounded-pill">Conocenos</a>
                </div>
                <div class="col-md-4">
                    <div class="my-3 text-left text-white pl-md-4" style="border-left: 2px solid white;" v-html="item.text"></div>
                </div>
            </div>
        </div>

        <h3 class="my-4 font-weight-bold text-primario text-uppercase text-center">Servicios</h3>

        <section class="container-fluid mt-5">
            <div class="row align-items-center">
                <div class="col-md-4 d-flex align-items-center border p-4 " style="min-height: 200px;" v-for="(item,key) in texto_imagen">
                    <div class="d-flex align-items-center">
                        <img :src="item.image" alt="grupo rag" class="img-fluid">
                        <div class="pl-4 " v-html="item.title"></div>
                    </div>
                </div>
            </div>
        </section>
<!--        <section class="container my-5">-->
<!--            <slick ref="slick" :options="slickOptions">-->
<!--                <div v-for="(item,key) in clientes" class="">-->
<!--                    <div class="col my-3">-->
<!--                        <div class="clientes">-->
<!--                            <img :src="item.image" :alt="item.title" class="img-fluid">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </slick>-->
<!--        </section>-->
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
            industrias: Array,
            textos: Array,
            texto_imagen: Array,
            bloques: Array,
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
