<template>
    <web-layout class="">
        <carousel :images="sliders"></carousel>

        <div class="container-fluid wow fadeIn " data-wow-delay="0.2s">
            <div class="row" >
                <div class="col-md-6 col-lg-6  d-flex flex-column  px-5 py-5" v-for="(item,index) in textos" :style="index == 0 ? 'background-color: #ECECEC;' : ''">
                    <p class="" v-html="item.text"></p>
                    <div class="text-center mt-auto">
                        <a v-if="item.image" :href="item.image" donwload class="btn btn-primario  rounded-pill text-white">
                            {{ item.title }}
                            <i class="fas fa-download fa-lg text-primario rounded-circle p-2 bg-white"></i>
                        </a>
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
    export default {
        props: {
            sliders: Array,
            textos: Array,
            archivos: Array,
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
          }
        },
        components: {
            TimeLine,
            Modal,
            WebLayout,
            Carousel,
            'image-custom': ImageFile,
        },
        methods: {
            saveContent(){
                let data = {
                    id: this.contenido.id,
                    contenido: this.content,
                }
                // data.append('content', this.content || '')
                // data.append('id', this.contenido.id || '')
                this.$inertia.post(route('adm.content.store'), data).then(() => {

                });
            },
            addSlider() {
                let data = new FormData()
                data.append('id', this.slider.id || '')
                data.append('title', this.slider.title || '')
                data.append('text', this.slider.text || '')
                data.append('order', this.slider.order || '')
                data.append('section', this.contenido.section || '')
                data.append('image', this.slider.image || '')
                this.$inertia.post(route('adm.content.slider'), data).then(() => {
                    $('.modal').modal('hide');
                });
            },
            editSlider(item){
                console.log(item)
                this.slider = JSON.parse(JSON.stringify(item))
            },
            delSlider(id){
                Swal.fire({
                    title: '¿Estas seguro de eliminar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value) {
                        this.$inertia.replace(route('adm.content.destroy.slider',{id: id})).then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Se elimino correctamente',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        })
                    }
                })

            },
            asset(img){
                if (img){
                    return 'storage/'+img
                }
                return '';
            },
        },
    }
</script>
