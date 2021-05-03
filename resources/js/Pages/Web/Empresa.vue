 <template>
    <web-layout class="">
        <carousel :images="sliders" height="400px"></carousel>

        <div class="container wow fadeIn py-4" :data-wow-delay="'0.2s'">
            <div class="row"  v-for="(item,index) in textos">
                <div class="col-md-6">
                    <img :src="item.image" alt="" class="img-fluid">
                </div>
                <div class="col-md-6">
                    <h3 v-if="item.title" class="mb-3 text-primario">{{ item.title }}</h3>
                    <p class="mt-4 mt-md-0" v-html="item.text"></p>
                </div>
            </div>
        </div>
            <template >
                <div class="container wow fadeIn py-4" :data-wow-delay="'0.2s'">
                    <div class="row"  >
                        <div class="col-md-3 mt-4" v-for="(item,index) in texto_imagen">
                            <hr width="25" class="bg-primario pt-1 mb-2">
                            <h4 class="mb-3 font-weight-bold text-primario">{{ item.title }}</h4>
                            <p class="" v-html="item.text"></p>
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
