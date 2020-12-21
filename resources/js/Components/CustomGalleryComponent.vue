<template>
    <fieldset @dragover="onDropGalleryOver" @drop="onDropGallery">
        <legend>{{ label }}</legend>
            <draggable v-model="gallery" class="row">
<!--            <draggable v-model="gallery" class="row" draggable=".item">-->
                <div class="col-md-3 item" v-for="(item, index) in gallery" :key="index">
                    <div class="gallery-item draggable-item" :for="id">
                        <div class="gallery-item-overlay"></div>
                        <div class="gallery-item-container">
                            <img :src="createImageURL(item)" alt="">
                        </div>
                        <div class="gallery-item-controls">
                            <button type="button" class="btn btn-danger" @click="deleteFileGallery(index)"><i class="fas fa-trash-alt"></i></button>
                        </div>
<!--                        <div class="gallery-item-path">-->
<!--                            {{ createImageName(item) }}-->
<!--                        </div>-->
                    </div>
                </div>
                <div slot="footer" class="col-md-3">
                    <label class="gallery-item" :for="id">
                        <input type="file" :id="id" class="d-none" accept="image/x-png,image/gif,image/jpeg" @change="onFileGallery($event)" multiple>
                        <div class="gallery-item-overlay"></div>
                        <div class="gallery-item-container">
                            <div class="gallery-item-container">
                                <span class="text-center">
                                    <i class="fas fa-upload fa-4x"></i>
<!--                                    <img :src="url+'/img/icons/foto-upl.png'" alt="" class="img-fluid">-->
                                </span>
                            </div>
                        </div>
                    </label>
                </div>
            </draggable>
    </fieldset>
</template>
<script>
    import draggable from 'vuedraggable'
    var publicPATH = window.location.origin+'/';
    export default {
        props: {
            model: {
                type: Array,
            },
            label: {
                type: String,
                default: 'Fotos del Producto'
            },
            link: Number
            /*id: {
                type: String,
                default: ''
                // default: Math.random().toString(36).substring(2)
            },*/
        },
        components: {
            draggable,
        },
        data(){
            return{
                gallery: [],
                id: '',
                url: window.location.origin+'/',
            }
        },
        created() {
            this.gallery = this.model || []
        },
        mounted () {
            this.id = this._uid.toString() + Math.random().toString(36).substring(2)
        },
        watch: {
            gallery: function(val, oldVal) {
                this.$emit('update:model', this.gallery || [])
            }
        },
        methods: {
            onDropGalleryOver(e) {
                var path = e.path || (e.composedPath && e.composedPath())
                e.preventDefault()
                if (e.dataTransfer.effectAllowed != 'move') {
                    path.every(function (element) {
                        if (element.localName == 'fieldset') {
                            element.style.backgroundColor = "#dedede"
                            return false
                        }
                        return true
                    })
                }
            },
            onDropGallery(e) {
                var path = e.path || (e.composedPath && e.composedPath())
                e.preventDefault();
                path.every(function (element) {
                    if (element.localName == 'fieldset') {
                        element.style.backgroundColor = ""
                        return false
                    }
                    return true
                })
                for (let index = 0; index < e.dataTransfer.files.length; index++) {
                    this.gallery.push(e.dataTransfer.files[index])
                }
                return true
            },
            onFileGallery(e){
                let maxsize = 2097152 //2MB

                // if (e.target.files.length <= 4)
                // {
                //
                // }
                for (let index = 0; index < e.target.files.length; index++) {
                    let file = e.target.files[index];
                        if (file.size > maxsize){
                            Swal.fire({
                                title: '¿Esta seguro de agregar esta imagen?',
                                html: 'Esta imagen <b>'+file.name+'</b> pesa mas de 2MB',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#1CA345',
                                cancelButtonColor: '#A3130E',
                                confirmButtonText: 'Si agregar',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.value) {
                                    if (this.gallery.length > 3){return false;}
                                    this.gallery.push(file)
                                }
                            })
                        }else{
                            if (this.gallery.length > 3){return false;}
                            this.gallery.push(file)
                        }
                        // console.log(e.target.files[index])
                    }

                return true
            },
            createImageURL(file){

                if (file.type == 'application/pdf') {
                    return publicPATH + '/img/icons/pdf.svg'
                }
                if (file.type == 'application/zip') {
                    return publicPATH + '/img/icons/zip.svg'
                }
                let txtExt = ['text/csv', 'text/xml', 'text/plain']
                if (txtExt.includes(file.type)) {
                    return publicPATH + '/img/icons/txt.svg'
                }

                let xlsExt = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
                if (xlsExt.includes(file.type)) {
                    return publicPATH + '/img/icons/xls.svg'
                }
                let docExt = ['application/msword']
                if (docExt.includes(file.type)) {
                    return publicPATH + '/img/icons/doc.svg'
                }
                let imgExt = ['image/jpeg', 'image/png']
                if (imgExt.includes(file.type)) {
                    if (file && file instanceof File) {
                        return URL.createObjectURL(file)
                    }
                    if (typeof file === 'object' || file instanceof Object) {
                        return file.url
                    }
                }
                // return publicPATH + '/img/icons/raw.svg'

                if (typeof file === 'string' || file instanceof String) {
                    if (this.link == 0)
                    {
                        return  file
                    }else{
                        return  publicPATH+'storage/'+file
                    }
                    // return  file
                }
                return  file.url
            },
            createImageName(file) {
                if (file && file instanceof File) {
                    return file.name
                }
                if (typeof file === 'string' || file instanceof String) {
                    return file.split('/').pop()
                }
                if (typeof file === 'object' || file instanceof Object) {
                    if(file.url) {
                        return file.url.split('/').pop()
                    }
                }
            },
            getPreviewImage(languageKey) {
                let image = this.image[languageKey]
                if (image && image instanceof File) {
                    return URL.createObjectURL(image)
                }

                if (typeof image === 'string' || image instanceof String) {
                    return image
                }
            },
            deleteFileGallery(index) {
                // Swal.fire({
                //     title: '¿Estas seguro de eliminar?',
                //     icon: 'warning',
                //     showCancelButton: true,
                //     confirmButtonText: 'Si',
                //     cancelButtonText: 'No'
                // }).then((result) => {
                //     if (result.value) {
                //         axios.get(route('seller.article.destroy', { id: producto.id}).url())
                //         Swal.fire({
                //             icon: 'success',
                //             title: 'Se elimino correctamente',
                //             showConfirmButton: false,
                //             timer: 2000
                //         })
                //
                //     }
                // })

                this.gallery.splice(index, 1);
            }
        }
  }
</script>
<style lang="scss" scoped>
    .gallery-item {
        position: relative;
        width: 100%;
        margin-bottom: 5px;
    }
    .gallery-item-controls {
        position: absolute;
        right: 0;
        top: 0;
    }
    .gallery-item-container{
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2px;
        border: solid 1px #CCC;
        border-style: dotted;
        border-radius: .5rem;
        img {
            max-width: 100%;
            max-height: 100%;
        }
    }
    .gallery-item-overlay {
        padding-bottom: 100%;
    }
    .gallery-item-path {
        position: absolute;
        width: 100%;
        font-size: 12px;
        line-height: 14px;
        border-top: 1px solid #000;
        padding: 2px 5px 4px 5px;
        background-color: #00000085;
        color: aliceblue;
        transition: .2s bottom;
    }
    .draggable-item {
        cursor: move;
        overflow: hidden;
        &:hover .gallery-item-path {
            bottom: 0;
            margin-top: 0;
        }
    }
</style>
