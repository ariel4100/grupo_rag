<template>
    <web-layout class="">
        <div class="bg-light">
            <div class="container">
                <h5 class="section-title">
                    {{ t('Políticas de calidad') }}
                </h5>
            </div>
        </div>

        <div class="container wow fadeIn my-4" data-wow-delay="0.2s">
            <div class="row" v-for="(item,index) in textos">
                <div class="col-md-6 col-lg-6 mb-4">
                    <h4 class="mb-3 font-weight-bold text-primario">{{ item.title }}</h4>
                    <p class="" v-html="item.text"></p>
                </div>
                <div class="col-md-6 col-lg-6 mb-4">
                    <img :src="item.image" alt="" class="img-fluid mx-auto w-100">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6 col-lg-6 mb-3" v-for="(file,key) in archivos">

                    <div class="d-flex align-items-center justify-content-between p-3 pb-2" style="background-color: #F8F8F8">
                        <div class="">
                            <div class="text-primario mb-1 fw-medium h6" v-html="file.title"></div>
                            <a :href="file.image" download class="text-muted">DESCARGAR</a>
                        </div>
                        <a :href="file.image" download class=""><i class="fas fa-file-download fa-2x text-primario"></i></a>
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