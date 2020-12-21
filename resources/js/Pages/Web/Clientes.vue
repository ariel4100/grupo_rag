 <template>
    <web-layout class="">
        <div class="bg-light">
            <div class="container">
                <h5 class="section-title">
                    {{ t('Clientes') }}
                </h5>
            </div>
        </div>
        <section class="" >
            <div class="container py-4" >
                <div class="row justify-content-center">
                    <div class="col-6 col-md-3 col-lg-2 wow fadeIn py-4" :data-wow-delay="'0.'+index+'2s'" v-for="(item,index) in clientes">
                        <div class="clientes">
                            <img :src="item.image" alt="" class="img-fluid mx-auto">
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </web-layout>
</template>

<script>
    import Carousel from '@/Components/CarouselComponent'
    import TimeLine from '@/Components/TimeLineCarouselComponent'
    import WebLayout from '@/Layouts/WebLayout'
    import ImageFile from '../../Components/ImageComponent'
    import Modal from '../../Components/ModalComponent'
    import Slick from 'vue-slick';
    export default {
        props: {
            clientes: Array,

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
              slickOptions: {
                  infinite: true,
                  slidesToShow: 4,
                  slidesToScroll: 1,
                  arrows: false,
                  draggable: false,
                  // Any other options that can be got from plugin documentation
              },
          }
        },
        components: {
            TimeLine,
            Slick,
            Modal,
            WebLayout,
            Carousel,
            'image-custom': ImageFile,
        },
        methods: {

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
         border: 1px solid #707070;
         min-height: 160px;
     }
 </style>