<template>
    <div class="col-md-12">
        <div class="row" :class="rowClass">
            <div class="" :class="familiasClass ? familiasClass : 'col-md-12'">
                <div class="">
                    <label for="" v-if="label">{{ label }}</label>
                    <multiselect v-model="selected" :options="categoriasFilterPadre"
                                 :searchable="true"
                                 :close-on-select="false"
                                 :show-labels="false"
                                 placeholder="Ud. quiere..."
                                 track-by="id"
                                 label="title"
                    ></multiselect>

<!--                    <select v-model="selected" id="" class="form-control">-->
<!--                        <option :value="item" class="" v-for="item in categorias" v-if="item.padre_id == null">-->
<!--                            {{ item.title.es || item.title }}-->
<!--                        </option>-->
<!--                    </select>-->
                </div>
            </div>
            <template v-for="(hijos,index) in selectedValue">
                <template v-if="hijos.value.child_families.length > 0">
                    <div class=""  :class="hijosClass ? hijosClass : 'col-md-4'">
                        <div class="">
                            <!--                        <label for=""></label>-->

                            <multiselect v-model="hijos.data" :options="hijos.value.child_families"
                                         @input="changeSelected(hijos.data)"
                                         :searchable="true"
                                         :close-on-select="true"
                                         :show-labels="false"
                                         placeholder=""
                                         track-by="id"
                                         label="title"
                            ></multiselect>

                            <!--                            <select @change="changeSelected($event,index)"  id=""  class="form-control">-->
                            <!--                                <option value="">Sin padre</option>-->
                            <!--                                <option :value="item.id" class="" v-for="item in hijos.value.child_families">-->
                            <!--                                    {{ item.title.es || '' }}-->
                            <!--                                </option>-->
                            <!--                            </select>-->

                        </div>
                    </div>
                </template>

            </template>
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props:['familias','model','label','familiasClass','hijosClass','rowClass'],
        data() {
            return {
                selectedValue: [],
                selected: '',
                categorias: [],
                padre: {},
            }
        },
        watch: {
            selectedValue: function(val, oldVal) {
                console.log(['aca entra',this.padre])
                this.$emit('update:model', this.padre.id || this.selected.id)
            },
            // whenever question changes, this function will run
            selected: function (newQuestion, oldQuestion) {
                this.padre = {}
                this.selectedValue = []
                let selects = this.selectedValue.push({
                    value: this.selected,
                    id: this.selected.id,
                })
            }
        },
        created(){
          this.categorias = this.familias
        },
        computed:{
            categoriasFilterPadre(){
                // let selects = this.selectedValue.push({
                //     value: this.selectedCat,
                //     id: this.selectedCat.id,
                // })
                let result = this.categorias.filter((item) => {
                    if(item.padre_id == null) {
                        return item
                    }
                });
                return result
            },
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
            toggleSelected(e){
              console.log(e)
            },
            changeSelected(data,index){
                console.log([data]);
                let id = data.id
                //
                // let value = this.categorias.find((item)=>{
                //     // console.log(item)
                //     return item.id == id
                // })
                //
                //


                if (this.selectedValue.length > 1){
                    let key = this.selectedValue.findIndex(item => item.padre_id === data.padre_id);
                    console.log([data,key]);
                    if (key > 0){
                        let eliminar_varios = this.selectedValue.length - key
                        // console.log(['acacacaca',eliminar_varios])
                        this.selectedValue.splice(key,eliminar_varios);
                    }

                }

                this.padre = data
                // this.selectedValue.filter((item)=>{
                //     item.padre_id == value.padre_id
                // })
                //
                // let index = this.familias_hijos.findIndex(()=>{
                //
                // });
                this.selectedValue.push({
                    value: data,
                    padre_id: data.padre_id,
                    id: parseInt(id),
                })
            },

        }
    }
</script>