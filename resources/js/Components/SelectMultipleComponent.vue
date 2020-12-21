<template>
    <div class="">
        <multiselect
                v-model="value"
                :options="data"
                :multiple="true"
                :close-on-select="false"
                :clear-on-select="false"
                :preserve-search="true"
                placeholder=""
                label="title"
                track-by="id"
                :preselect-first="false"
                selectedLabel="Seleccionado"
                selectLabel="Presione enter para seleccionar"
                deselectLabel="Presione enter para borrar"
        >
            <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} opciones seleccionados</span></template>
        </multiselect>
<!--        <multiselect v-model="value" :options="data" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="title" track-by="id" :preselect-first="true">-->
<!--            <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>-->
<!--        </multiselect>-->
    </div>
</template>

<script>
    export default {
        props:['data','model'],
        data() {
            return {
                selectedValue: [],
                categorias: [],
                value: '',
            }
        },
        watch: {
            value: function(val, oldVal) {
                this.$emit('update:model', this.value || '')
            },

        },
        created(){
            this.value = this.model
        },
        computed:{
            // familias_hijos(){
            //     // let selects = this.selectedValue.push({
            //     //     value: this.selectedCat,
            //     //     id: this.selectedCat.id,
            //     // })
            //     let result = this.selectedValue.reduce((unique, o) => {
            //         if(!unique.some(obj => obj.id === o.id && obj.value === o.value && obj.padre_id === o.padre_id)) {
            //             unique.push(o);
            //         }
            //         return JSON.parse(JSON.stringify(unique));
            //     },[]);
            //     return result
            // },
        },

        methods: {
            title (item) {
                if (item.title.es){
                    return item.title.es
                } else{
                    return item.title
                }

            },
            changeSelected(event,index){
                console.log([event.target.value,index]);
                let id = event.target.value

                let value = this.categorias.find((item)=>{
                    // console.log(item)
                    return item.id == id
                })




                if (this.selectedValue.length > 1){
                    let key = this.selectedValue.findIndex(item => item.padre_id === value.padre_id);
                    console.log([value,index,key]);
                    if (key > 0){
                        let eliminar_varios = this.selectedValue.length - key
                        console.log(['acacacaca',eliminar_varios])
                        this.selectedValue.splice(key,eliminar_varios);
                    }

                }

                this.padre = value
                // this.selectedValue.filter((item)=>{
                //     item.padre_id == value.padre_id
                // })
                //
                // let index = this.familias_hijos.findIndex(()=>{
                //
                // });
                this.selectedValue.push({
                    value: value,
                    padre_id: value.padre_id,
                    id: parseInt(id),
                })
            },

        }
    }
</script>