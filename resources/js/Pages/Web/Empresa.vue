 <template>
    <web-layout class="">
        <carousel :images="sliders" height="400px"></carousel>

            <template >
                <div class="container wow fadeIn py-4" :data-wow-delay="'0.2s'">
                    <div class="row">
                        <div class="col-md-6" v-for="(item,index) in textos">
                            <h3 class="mb-3 text-primario">{{ item.title }}</h3>
                            <p class="" v-html="item.text"></p>
                        </div>
                    </div>
                </div>
            </template>


        <div class="" >
            <div class="container wow fadeIn py-4" data-wow-delay="0.2s">
                <div class="row justify-content-center">
                    <div class="col-md-4 col-lg-4" v-for="(item,index) in texto_imagen">
                        <img :src="item.image" alt="" class="img-fluid mx-auto">
                        <div class="my-3 text-center" v-html="item.title"></div>
                    </div>
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
            textos: Array,
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