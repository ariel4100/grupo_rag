<template>
    <div class="">
        <label for="">{{ label }}</label>
        <div class="position-relative d-flex justify-content-end align-items-center">
            <i @click="ver_pass = !ver_pass" v-if="ver_pass == 0" class="fas fa-eye-slash position-absolute mr-2 pointer"></i>
            <i @click="ver_pass = !ver_pass" v-if="ver_pass == 1" class="far fa-eye position-absolute mr-2 pointer"></i>
            <input :type="ver_pass == 0 ? 'password' : 'text'"
                   v-bind:value="value"
                   v-on:input="$emit('input', $event.target.value)"
                   class="form-control"
                   :placeholder="placeholder"
                   maxlength="45"
            >
        </div>
     </div>
</template>


<script>
    export default {
        props: ['value','placeholder','label'],
        data(){
            return {
                ver_pass: 0,
                loaded: 1
            }
        },
        created () {

        },
        methods:{

        }
    }
</script>
<style lang="scss">
    @import '../../sass/variables';

    .pointer{
        cursor: pointer;
    }
    .custom-mask{
        cursor: pointer;
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
    }
    /*.hover-img:hover{*/
    /*    background-color: red;*/
    /*}*/
</style>