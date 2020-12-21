<template>
    <div class="card">
        <div class="preview-image">
            <div class="preview-image-empty"></div>
            <div class="preview-image-container" v-if="displayImage">
                <img :src="getPreviewImage()">
            </div>
            <div class="preview-image-container unselected" v-else>
                <div class="unselected-text">
                    <i class="far fa-2x fa-file-image"></i><br>
                    Imagen/Archivo no Disponible
                </div>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ labelText }}</h5>
            <label class="btn btn-block btn-light">
                <input type="file" class="d-none" @change="onFileChange($event)">
                <i class="fas fa-images"></i>
                Seleccionar
            </label>
        </div>
    </div>

<!-- <div class="input-group mb-3">
    <div class="input-group-prepend">
        <label class="input-group-text" :for="id" id="inputGroupFileAddon01"><i class="fas fa-2x fa-images"></i></label>
    </div>
    <div class="custom-file">
        <input type="file" class="custom-file-input" :id="id"  @change="onFileChange($event)" aria-describedby="inputGroupFileAddon01">
        <label class="custom-file-label" :data-label-text="labelText" :for="id" aria-label="test">
            <img :src="getPreviewImage()" v-if="displayImage" style="max-height: 100%;">
        </label>
    </div>
</div>
 --></template>
<script>
    export default {
        props: ['model','id', 'labelText','link'],
        data(){
            return{
                displayImage: false,
                image: '',
                URL: this.$page.appUrl,
                publicPATH: this.$page.appUrl,
            }
        },
        created() {
            if (typeof this.image === 'string' || this.image instanceof String) {
                if (this.model != '') {
                    this.image = this.model
                    this.displayImage = true
                }
            }
        },
        watch: {
            model: function(val, oldVal) {
                this.image = val
                this.displayImage = true
            }
        },
        methods: {
            onFileChange(e) {
                this.displayImage = false
                let file = e.target.files[0];
                this.image = file
                this.$emit('update:model', file)
                this.displayImage = true
            },
            getPreviewImage() {
                let file = this.image
                // console.log(file)
                if (file){
                    if (file.type == 'application/pdf') {
                        return this.publicPATH + '/icons/pdf.svg'
                    }
                    let zipExt = ['application/zip', 'application/x-zip-compressed']
                    if (zipExt.includes(file.type)) {
                        return this.publicPATH + '/icons/zip.svg'
                    }
                    let txtExt = ['text/csv', 'text/xml', 'text/plain']
                    if (txtExt.includes(file.type)) {
                        return this.publicPATH + '/icons/txt.svg'
                    }
                    let xlsExt = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel']
                    if (xlsExt.includes(file.type)) {
                        return this.publicPATH + '/icons/xls.svg'
                    }
                    let docExt = ['application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document']
                    if (docExt.includes(file.type)) {
                        return this.publicPATH + '/icons/doc.svg'
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
                }

                // if (this.image && this.image instanceof File) {
                //     return URL.createObjectURL(this.image)
                // }
                // if (typeof file === 'string' || file instanceof String) {
                //     return this.image
                //     // return this.publicPATH+this.image
                // }


                if (typeof file === 'string' || file instanceof String) {

                    let extension = file.split('/').pop().split('.').pop();
                    if(extension == 'pdf'){
                        return this.publicPATH + '/icons/pdf.svg'
                    }
                    if(extension == 'rar'){
                        return this.publicPATH + '/icons/raw.svg'
                    }
                    if(extension == 'text'){
                        return this.publicPATH + '/icons/txt.svg'
                    }

                    let extXls = ['xlsx', 'xls']
                    if (extXls.includes(extension)) {
                        return this.publicPATH + '/icons/xls.svg'
                    }
                    if (extension == 'zip') {
                        return this.publicPATH + '/icons/zip.svg'
                    }
                    let extDoc = ['docx', 'doc']
                    if (extDoc.includes(extension)) {
                        return this.publicPATH + '/icons/doc.svg'
                    }
                    let extImg = ['jpg', 'png','jpge','svg','gif','bmp']
                    if (extImg.includes(extension)) {
                        return this.image
                    }
                    // return  this.publicPATH+file.ficha.split('/').pop()
                }


                return this.publicPATH + '/icons/raw.svg'
            },
        }
  }
</script>
<style lang="scss" scoped>
    .custom-file-label {
        height: 100px;
    }
    .custom-file-label::after {
        content: attr(data-label-text) !important;
        height: auto !important;
        justify-content: center;
        align-items: center;
        display: flex;
    }
    .custom-file {
        height: 100px !important;
    }
    .preview-image {
        position: relative;
        &-empty {
            padding-bottom: 60%;
        }
        &-container {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            border-bottom: 1px solid #f3f1f9;
            img {
                max-width: 100%;
                max-height: 100%;
            }
            .unselected-text {
                display: none;
                text-align: center;
            }
            &.unselected {
                background-color: #D8D8D8;
                .unselected-text {
                    display: block;
                    color: #BABABA;
                    font-weight: bold;
                }
            }
        }
    }
</style>
