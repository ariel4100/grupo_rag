<template>
    <div class=" ">
        <template>
            <div id="timeline" class="carousel slide" data-ride="carousel">

                <div class="carousel-inner">
                    <div class="carousel-item"  v-for="(item,index) in data" :class="index == 0 ? 'active'  : ''">
<!--                        <img :src="item.image || ''" class="d-block w-100" alt="...">-->
                        <div class=" ">
                            <div class="container  wow fadeInLeft">
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <h5 class="font-weight-bold text-primario text-center">{{ item.title }}</h5>
                                        <p class="text-center" v-html="item.text"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="position-relative container mt-5">
                    <ol class="carousel-indicators" style="border-top: 2px solid #0D5075;z-index: 0;">
                        <li v-for="(item,index) in data" data-target="#timeline" :data-slide-to="index" :class="index == 0 ? 'active mx-2'  : ''" ></li>
                    </ol>
                    <div class="position-absolute-0" style="margin-right: 15%; margin-left: 15%; z-index: 2; top:unset">
                        <div class="d-flex justify-content-between">
                            <a class="carousel-control-pre flecha" href="#timeline" role="button" data-slide="prev">
<!--                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
                                <i class="fas fa-chevron-left"></i>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-nex flecha" href="#timeline" role="button" data-slide="next">
<!--                                <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
                                <i class="fas fa-chevron-right"></i>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </template>
    </div>

</template>
<script>
    export default {
        props: ['data','onlyImage'],
        data(){
            return{
                displayImage: false,
                image: '',
                URL: window.location.origin+'/',
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
    .flecha {
        color: #0D5075;
        border: 2px solid #0D5075;
        top: unset;
        border-radius: 5rem;
        width: auto;
        padding: .5rem .9rem .5rem .9rem;
        background-color: #e0e0e0;
        z-index: 2;
    }
    #timeline .carousel-indicators li {
        opacity: 1;
        transition: all 0.5s ease-out;
        z-index: 1;
        border: 2px solid #0D5075;
        margin-top: -0.5rem;
    }

    #timeline .carousel-indicators .active {
        background-color: #0D5075;
        transform: scale(1.5);
        background-clip: unset;
        /* transition: 200s ease-in; */
    }
</style>
