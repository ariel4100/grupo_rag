<template>
    <div>
        <nav>
            <div class="nav nav-tabs scrollbar-dusty-grass square thin" style="flex-wrap: unset ; overflow-x: auto; overflow-y: hidden" id="nav-tab" role="tablist">
                <a class="nav-link nav-link-custom text-color" :class="key == 0 ? 'active' : ''" v-for="(item,key) in items" :id="'dyn-tab-'+key" data-toggle="tab" :href="'#nav-tab-'+key" role="tab" :aria-controls="'nav-tab-'+key" :aria-selected="key == 0 ? 'true' : 'false'">
                    {{ item.title }}
                </a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade" :class="key == 0 ? 'show active' : ''" v-for="(item,key) in items" :id="'nav-tab-'+key" role="tabpanel" :aria-labelledby="'dyn-tab-'+key">
                <slot :item="item"></slot>
            </div>
        </div>
<!--        <b-tabs class="mt-3" nav-class="nav-custom"  active-nav-item-class="active-tab">-->
<!--            <b-tab v-for="(item,key) in items" :key="'dyn-tab-' + key"  title-item-class="nav-item-custom" title-link-class="nav-link-custom">-->
<!--                <template #title>-->
<!--                    {{ item.title }}-->
<!--&lt;!&ndash;                    <b-spinner type="grow" small></b-spinner> I'm <i>custom</i> <strong>title</strong>&ndash;&gt;-->
<!--                </template>-->
<!--                <slot :item="item"></slot>-->
<!--            </b-tab>-->
<!--        </b-tabs>-->
    </div>
</template>

<script>
    export default {
        props:['title','titleButton','data'],
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