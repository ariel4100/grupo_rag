<template>
    <div class=" ">
        <template v-if="onlyImage">
            <img :src="onlyImage" alt="" class="d-block w-100">
        </template>
        <template v-else>
            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
<!--                <ol class="carousel-indicators">-->
<!--                    <li v-for="(item,index) in images" data-target="#carouselExampleCaptions" :data-slide-to="index" :class="index == 0 ? 'active'  : ''" ></li>-->
<!--                </ol>-->
                <div class="carousel-inner" >
                    <div class="carousel-item" v-for="(item,index) in images" :class="index == 0 ? 'active'  : ''" :style="height ? 'max-height:' + height : ''">
                        <img v-if="producto == 1" :src="item || ''" class="img-fluid mx-auto" :alt="item.title">
                        <img v-else :src="item.image || ''" class="d-block w-100" alt="...">
                        <div class="carousel-caption-custom wow fadeInLeft d-flex align-items-center text-white">
                            <div class="container d-none d-lg-block">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h1 class="font-weight-bold">{{ item.title }}</h1>
                                        <p class="" v-html="item.text"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <template v-if="arrows == 1">
                    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </template>
            </div>
        </template>
    </div>

</template>
<script>
    export default {
        props: ['images','onlyImage','producto','arrows','height'],
        data(){
            return{
                displayImage: false,
                image: '',
                URL: this.$page.appUrl,
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
                if (this.image && this.image instanceof File) {
                    return URL.createObjectURL(this.image)
                }
                if (typeof this.image === 'string' || this.image instanceof String) {
                    if (this.link == 0){
                        return this.URL+this.image
                    }else{
                        return this.image
                    }

                    // return publicPATH+this.image
                }
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
