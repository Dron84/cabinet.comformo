<template>
    <div class="table" style="margin-top: 10px; max-height: 100%;">
        <div class="tableHeader">
            <div class="centrize">Id</div>
            <div class="centrize">Number Invoce</div>
            <div class="centrize">Sum</div>
            <div class="centrize">Description</div>
            <div class="centrize">Status <changeStatus imageLink="/static/img/filter.svg" imageTitle="Change Filter" :dropDownList="filterList" statusNow="Not filtered" @selectedItem="changeFilter($event)"></changeStatus></div>
        </div>
        <div class="table_body" style="max-height: 100%;" v-if="invoces.length==0">
            <div class="tableRow searchRow">
                <div class="centrize">No invoces</div>
            </div>
        </div>
        <div class="table_body" style="max-height: 100%;" v-else>
            <div class="tableRow searchRow" v-for="item in invoces">
                <div class="centrize">{{item.id}}</div>
                <div class="centrize">{{item.num}}</div>
                <div class="centrize">{{item.sum}}</div>
                <div class="centrize">{{item.description}}</div>
                <div class="centrize"><changeStatus :statusNow="item.status" :dropDownList="StatusDropdownList" @selectedItem="changeStatus($event,item.id)"></changeStatus></div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import changeStatus from '@/components/forms/changeStatus.vue'
    export default {
        name: "invoceList",
        components:{changeStatus,},
        data(){
            return{
                invoces: [],
                StatusDropdownList: [
                    {
                        index:'Cancel',
                        label:'Cancel'
                    },
                    {
                        index:'Confirm',
                        label:'Confirm'
                    },
                ],
                filterList: [
                    {index: null, label: 'Not filtered'},
                    {index: 'loaded', label: 'loaded'},
                    {index: 'Cancel', label: 'Cancel'},
                    {index: 'Confirm', label: 'Confirm'},
                ],
            }
        },
        props:{
          id:{
              type: String,
              required: true
          }
        },
        methods:{
            loadInvoces(){
                axios.post(this.$store.getters.getPostUrl,'invoce=load&ids='+this.id).then(res=>{
                    // console.log(res.data)
                    if(res.data!='Sql is empty'){
                        this.invoces = res.data
                    }
                })
            }
        },
        created(){
            this.loadInvoces()
        }

    }
</script>

<style scoped>

</style>