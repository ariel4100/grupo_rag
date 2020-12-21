<template>
    <div>
        <a v-if="type == 1" :href="item.ruta" class="p-0  nav-link">
            <div class="product-card position-relative border">
                <div class="product-card__mask">
                    <div class="">
                        <!--                        <h5 class="my-2 text-left  text-white">{{ item.title }}</h5>-->
                        <i class="fas fa-plus fa-2x"></i>
                        <!--                        <a :href="item.ruta" class="btn btn-white  btn-rounded text-secundario">VER MÁS</a>-->
                    </div>
                </div>
                <div class="p-3 imagen">
                    <img :src="item.image" :alt="item.title" class="img-fluid">
                </div>
            </div>
            <div class="text-center">
                <p class="mt-2 text-secundario">{{ item.title || 'PISTONES CON PERNO TIK Y NOZUMI' }}</p>
            </div>
        </a>
        <a v-if="type == 'blog'" :href="item.ruta" class="p-0  nav-link">
            <div class="product-card position-relative">
                <div class="product-card__mask">
                    <div class="">
                        <!--                        <h5 class="my-2 text-left  text-white">{{ item.title }}</h5>-->

                        <i class="fas fa-plus fa-2x"></i>
                        <!--                        <a :href="item.ruta" class="btn btn-white  btn-rounded text-secundario">VER MÁS</a>-->
                    </div>
                </div>
                <div class="imagen">
                    <img :src="item.image" :alt="item.title" class="img-fluid">
                </div>
            </div>
            <div class="p-3 text-center">
                <p class="mt-2 text-secundario">{{ item.title || 'PISTONES CON PERNO TIK Y NOZUMI' }}</p>
            </div>
        </a>

        <a v-if="type == undefined" :href="item.ruta" class="p-0 border nav-link">
            <div class="product-card position-relative">
                <div class="product-card__mask">
                    <div class="">
<!--                        <h5 class="my-2 text-left  text-white">{{ item.title }}</h5>-->
                        <i class="fas fa-plus fa-2x"></i>
<!--                        <a :href="item.ruta" class="btn btn-white  btn-rounded text-secundario">VER MÁS</a>-->
                    </div>
                </div>
                <div class="imagen">
                    <img :src="item.image" :alt="item.title" class="img-fluid">
                </div>
            </div>
            <div class="p-3 text-center">
                <p class="mt-2 text-secundario">{{ item.title || 'PISTONES CON PERNO TIK Y NOZUMI' }}</p>
            </div>
        </a>
    </div>
</template>

<script>
    export default {
        props:['item','type','data'],
        data() {
            return {
                show: false,
                name: '',
                nameState: null,
                submittedNames: [],
                items: [],
            }
        },
        created() {
            this.items = this.data || []
        },
        watch: {
            bloques: function () {
                this.$emit('update:model', this.bloques || [])
            },
        },
        methods: {
            checkFormValidity() {
                const valid = this.$refs.form.checkValidity()
                this.nameState = valid
                return valid
            },
            resetModal() {
                this.$emit('show')
            },
            hiddenModal() {
                this.$emit('hidden')
            },

            handleOk(bvModalEvt) {
                this.$emit('ok')
                // Prevent modal from closing
                // bvModalEvt.preventDefault()
                // Trigger submit handler
                // this.handleSubmit()
            },
            handleSubmit() {
                // Exit when the form isn't valid
                if (!this.checkFormValidity()) {
                    return
                }
                // Push the name to submitted names
                this.submittedNames.push(this.name)
                // Hide the modal manually
                this.$nextTick(() => {
                    this.$bvModal.hide('modal-prevent-closing')
                })
            }
        }
    }
</script>
<style lang="scss" scoped>

</style>