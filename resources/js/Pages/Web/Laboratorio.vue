 <template>
    <web-layout class="">
        <div class="bg-light">
            <div class="container">
                <h5 class="section-title">
                    {{ t('Laboratorio') }}
                </h5>
            </div>
        </div>

            <template >
                <div class="container wow fadeIn py-4" :data-wow-delay="'0.2s'">
                    <div class="row" v-for="(item,index) in bloques" >
                        <div class="col-md-6 col-lg-6 mb-4 order-2" :class="index == 1 ? 'order-md-1' : ''">
                            <h4 class="mb-3 fw-medium text-terciario">{{ item.title }}</h4>
                            <p class="" v-html="item.text"></p>
                        </div>
                        <div class="col-md-6 col-lg-6 mb-4 order-1">
                            <img :src="item.image" alt="" class="img-fluid mx-auto">
                        </div>
                    </div>
                </div>
            </template>


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
            bloques: Array,
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