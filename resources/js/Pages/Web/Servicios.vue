 <template>
    <web-layout class="">
        <div class="bg-primario">
            <div class="container">
                <h5 class="section-title text-white">
                    {{ t('Servicios') }}
                </h5>
            </div>
        </div>
        <div class="container wow fadeIn py-4" :data-wow-delay="'0.2s'">
            <div class="row">
                <div class="col-md-4 mt-4" v-for="(item,index) in servicios">
                    <img :src="item.image" alt="" class="img-fluid">
                    <h5 class="mt-4 text-center mt-md-3 text-primario" v-html="item.title"></h5>
                </div>
            </div>
        </div>

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
            sliders: Array,
            servicios: Array,
            texto_imagen: Array,

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
