<template>
    <web-layout class="">
        <div class="bg-terciario">
            <div class="container">
                <h5 class="section-title ">
                    <i class="fas fa-home"></i>
                    <a :href="route('familias')" class="text-white">
                        {{ t('PRODUCTOS') }}
                    </a>
                    <a v-if="familia" :href="route('productos',{ slug: familia.slug })" class="text-white">
                        {{ (familia ? '| '+familia.title : '') }}
                    </a>

                </h5>
            </div>
        </div>

        <div v-if="sidenav == 1" class="container my-5">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <sidenav
                            :familia-id="familia.id"
                            :familias="familias"
                    ></sidenav>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        <template v-for="item in productos">
                            <div class="col-sm-6 col-md-4 col-lg-4 mb-5">
                                <product-card :item="item" type="1"></product-card>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="container my-5">
            <div class="row">
                <template v-for="item in familias">
                    <div class="col-sm-6 col-md-4 col-lg-4 mb-5">
                        <product-card :item="item" type="1"></product-card>
                    </div>
                </template>
            </div>
        </div>
    </web-layout>
</template>

<script>
    import Carousel from '@/Components/CarouselComponent'
    import Sidenav from '@/Components/SidenavComponent'
    import WebLayout from '@/Layouts/WebLayout'
    import ProductCard from '@/Components/ProductCardComponent'

    export default {
        props: {
            familias: Array,
            familia: Object,
            productos: Array,
            sidenav: Number,
        },
        data(){
          return {
              filterByPadreId:'',
          }
        },
        components: {
            Sidenav,
            ProductCard,
            WebLayout,
            Carousel,
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
            elimLastSelected(){

            },

        },
    }
</script>