<template>
    <web-layout class="">
        <carousel :images="sliders"></carousel>
        <div class="container my-5">
            <h4 class="text-primario">Buscador</h4>
            <div class="row">
                <div class="col-md-4">
                    <input type="search" v-model="search" class="form-control" placeholder="Buscar...">
                </div>
                <div class="col-md-4">
                    <a @click="buscar()" class="btn btn-secundario   mt-md-0 text-nowrap">Buscar</a>
                </div>
            </div>
            <template v-if="productos.length  == 0">
                <h4 class="my-5">No hay Resultados</h4>
            </template>
            <div class="row mt-5">
                <template v-for="item in productos">
                    <div class="col-md-4 col-sm-6 col-lg-3 mb-4">
                        <product-card :item="item" type="1"></product-card>
                    </div>
                </template>
            </div>
        </div>
    </web-layout>
</template>

<script>
    import Carousel from '@/Components/CarouselComponent'
    import WebLayout from '@/Layouts/WebLayout'
    import ProductCard from '@/Components/ProductCardComponent'

    export default {
        props: {
            productos: Array,
        },
        data(){
          return {
              search:'',

          }
        },
        components: {
            ProductCard,
            WebLayout,
        },
        methods: {
            buscar(){
                console.log(this.search)

                    this.$inertia.get(route('buscador',{ name: this.search})).then(() => {

                    });

            },

        },
    }
</script>