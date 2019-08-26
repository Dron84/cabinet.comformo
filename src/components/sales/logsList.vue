<template>
    <div class="table" style="margin-top: 10px; max-height: 100%;">
            <div class="tableHeader">
                <div class="centrize">last Date</div>
                <div class="centrize">Description</div>
                <div class="centrize">What product need</div>
                <div class="centrize">Date to Contact</div>
            </div>
            <div class="table_body" style="max-height: 100%;" v-if="preload == true">
                <div class="tableRow searchRow">
                    <div class="centrize"><img src="/static/img/loading.gif" alt="" height="20"></div>
                </div>
            </div>
            <div class="table_body" style="max-height: 100%;" v-else-if="preload == false && logsList.length>0 && logsList!='Sql is empty'">
                <div class="tableRow searchRow" v-for="item in logsList">
                    <div class="centrize">{{item.date}}</div>
                    <div class="centrize">{{item.description}}</div>
                    <div class="centrize">{{generateProductList(item.productlist)}}</div>
                    <div class="centrize">{{item.dateToContact}}</div>
                </div>
            </div>
            <div class="table_body" v-else-if="preload == false && logsList=='Sql is empty'">
                <div class="tableRow searchRow">
                    <div class="centrize">No logs data found</div>
                </div>
            </div>
        </div>
</template>

<script>
    import axios  from 'axios'
    export default {
        name: "logsList",
        components:{},
        data(){
            return{
                logsList: [],
                preload: false
            }
        },
        props:{
            id:{
                type: String,
                required: true
            }
        },
        methods:{
            loadLogsList(){
                this.preload = true
                axios.post(this.$store.getters.getPostUrl,'log=load&userId='+this.id)
                    .then(res=>{
                        this.logsList = res.data
                        this.preload = false
                    })
            },
            generateProductList(list){
                let newList = []
                let List = JSON.parse(list)
                List.forEach(product=>{
                    newList.push(product.label)
                })
                return newList.join(', ')
            }
        },
        created(){
            this.loadLogsList()
        }
    }
</script>

<style scoped>

</style>