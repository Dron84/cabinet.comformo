<template>
    <div class="input_group_select">
        <Multiselect v-model="value" :options="options" :placeholder="placeholder" :label="selectLabelName" :track-by="selectLabelIndex" :searchable="searchable" @input="onSelect" :class="[value!='' ? 'ok' : 'err']" :multiple="multiple" :close-on-select="closeOnSelect" :hideSelected="hideSelected"></Multiselect>
        <label class="label-up" style="position: absolute;top: -6px;left: 6px;font-family: 'Brandon Grotesque';font-weight: 500;font-size: .8em;letter-spacing: .05em;line-height: .8em;text-align: left;z-index: 1;color: #2f2f2f;background-color: #fff;">{{labelName}}</label>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        name: "formproductselect",
        components:{Multiselect,},
        date(){
            return{
                value: null,
                options: [
                    {label: 'Company', index: 1},
                    {label: 'Bank Account', index: 2},
                    {label: 'Structure',index: 3},
                    {label: 'PSP', index: 4},
                    {label: 'Website', index: 5}
                ]
            }
        },
        props:{
            labelName:{
                type: String,
                default: 'Product'
            },
            placeholder: {
                type: String,
                default: 'Select one',
            },
            selectLabelName: {
                type: String,
                default: 'label',
            },
            selectLabelIndex: {
                type: String,
                default: 'index',
            },
            searchable: {
                type: Boolean,
                default: true
            },
            multiple: {
                type: Boolean,
                default: false
            },
            closeOnSelect:{
                type: Boolean,
                default: true
            },
            hideSelected:{
                type: Boolean,
                default: false
            },
        },
        methods:{
            onSelect(){
                this.$emit('selectedProduct',this.value)
            }
        }
    }
</script>

<style scoped>

</style>