<template>
    <div>
        <b-button @click="show=true" v-if="titleButton">{{titleButton}}</b-button>
<!--        <teleport to="#body" >-->
            <b-modal
                    v-model="show"
                    size="lg"
                    :no-close-on-backdrop="true"
                    id="modal-prevent-closing"
                    ref="modal"
                    :title="title"
                    @show="resetModal"
                    @hidden="hiddenModal"
                    @ok="handleOk"
                    cancel-title="Cerrar"
            >
                <template v-if="idioma">
                    <b-tabs card>
                        <b-tab v-for="(lang,key) in Object.keys($page.idioma)" :key="'dyn-tab-' + key" :title="$page.idioma[lang].name">
                            <!--                        <pre>-->
                            <!--                            {{ $page.idioma[lang].name }}-->
                            <!--                        </pre>-->
                            <slot name="idioma" :lang="lang"></slot>
                        </b-tab>
                    </b-tabs>
                </template>
                <div class="" style="padding: 1.25rem;">
                    <slot></slot>

                </div>
            </b-modal>
<!--        </teleport>-->
    </div>
</template>

<script>
    export default {
        props:['title','titleButton','lang'],
        data() {
            return {
                idioma: 1,
                show: false,
                name: '',
                nameState: null,
                submittedNames: []
            }
        },
        created(){
          this.idioma = this.lang == false ? 0 : 1
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
<style>
    .modal-body .tabs .card-header{
        display: none !important;
    }
</style>