<template>
    <div class="container">
        <h3>Client name: {{client.firstName+' '+client.lastName}}</h3>
        <p class="centrize">Client companys below</p>
        <div class="companys">
            <div class="companys_body" v-if="companys.length>0">
                <div class="companys_company box_shadow_hover_roundshadow" v-for="item in companys">
                    <router-link :to="'/sales/clients/'+$route.params.id+'/'+$route.params.id+','+item.id" style="text-decoration: none">
                        <img :src="getCountry(item.jurisdiction).CountryImg" class="company_flag"/>
                        <div class="company_date">{{item.datetime}}</div>
                        <h3 class="company_header">{{item.companyName}}</h3>
                        <div class="company_country">{{getCountry(item.jurisdiction).CountryName}}</div>
                        <div class="centrize">
                            <div class="doughnut">
                                <DoughnutChart :percent="getPercent(item)" :foregroundColor="ChartColor(parseInt(getPercent(item)))" :backgroundColor="chart.backgroundColor" :radius="chart.radius" :width="chart.width" :height="chart.height" :strokeWidth="chart.strokeWidth" :visibleValue="chart.visibleValue" :classValue="chart.classValue"></DoughnutChart>
                                <div class="doughnut_chart_after" :style="ChartStyle(ChartColor(parseInt(getPercent(item))))">{{Math.round(getPercent(item))}}%</div>
                            </div>
                        </div>
                        <div class="company_more box_shadow">more details</div>
                    </router-link>
                </div>
            </div>
            <div v-else class="centrize">There are no companies in this client</div>
        </div>
    </div>
</template>

<script>
    import DoughnutChart from 'vue-doughnut-chart'
    export default {
        name: "clientcompanys",
        components:{DoughnutChart,},
        data(){
            return{
                client: {},
                companys: [],
                chart: {
                    backgroundColor: "transperent",
                    radius: 90,
                    width: 140,
                    height: 140,
                    strokeWidth: 15,
                    visibleValue: false,
                    classValue: "percent"
                },
            }
        },
        methods:{
            loadSalesData(){
                let Clients = this.$store.getters.get_salesManagerClients
                let ClientsCompanys = this.$store.getters.get_salesManagerClientsCompanys
                // console.log('ClientsCompany',ClientsCompany)
                Clients.forEach(Client=>{
                    if(String(Client.id) == String(this.$route.params.id)){
                        this.client = Client
                    }
                })
                ClientsCompanys.forEach(Company=>{
                    // console.log('ClientsCompany item',item)
                    if(String(Company.applicantid)==String(this.$route.params.id)){
                        this.companys.push(Company)
                    }
                })
            },
            ChartColor(percent){
                let color = ''
                if(percent>=0&&percent<=12){
                    color="#c53312"
                }else if(percent > 12 && percent<=25){
                    color='#c53312'
                }else if(percent > 25 && percent<=37){
                    color='#ee5d11'
                }else if(percent > 37 && percent<=50){
                    color='#fb9f35'
                }else if(percent > 50 && percent<=62){
                    color='#dad00b'
                }else if(percent > 62 && percent<=75){
                    color='#c5e204'
                }else if(percent > 75 && percent<=87){
                    color='#62e502'
                }else if(percent > 87){
                    color='#0bc64c'
                }
                return color
            },
            ChartStyle(color){
                return 'background-color:'+color+';'
            },
            getPercent(item){
                let CompanyPercent = 0
                let data = JSON.parse(item.companyStatus)
                if(data.general==100){
                    CompanyPercent = CompanyPercent+25
                }else if(data.general>=50&&data.general<=100){
                    CompanyPercent = CompanyPercent+5
                }else if(data.general<50){
                    CompanyPercent = CompanyPercent+0.25
                }
                if(data.ubo==100){
                    CompanyPercent = CompanyPercent+25
                }else if(data.ubo>=50&&data.ubo<=100){
                    CompanyPercent = CompanyPercent+5
                }else if(data.ubo<50){
                    CompanyPercent = CompanyPercent+0.25
                }
                if(data.dillegance==100){
                    CompanyPercent = CompanyPercent+25
                }else if(data.dillegance>=50&&data.dillegance<=100){
                    CompanyPercent = CompanyPercent+5
                }else if(data.dillegance<50){
                    CompanyPercent = CompanyPercent+0.25
                }
                if(data.fatca==100){
                    CompanyPercent = CompanyPercent+25
                }else if(data.fatca>=50&&data.fatca<=100){
                    CompanyPercent = CompanyPercent+5
                }else if(data.fatca<50){
                    CompanyPercent = CompanyPercent+0.25
                }
                if (item.docs=='Sql is empty'){
                    if(CompanyPercent>5){
                        CompanyPercent = (CompanyPercent-5)
                    }
                }
                return CompanyPercent
            },
            getCountry(id){
                const countrys = this.$store.getters.getOurCountry
                for(let i=0; i<countrys.length; i++){
                    if(countrys[i].id == id){
                        return {'CountryImg': '/static/img/flag/'+countrys[i].code.toLowerCase()+'.png', 'CountryName': countrys[i].jurisdictionname}
                    }
                }
            },
        },
        mounted(){
            this.loadSalesData()
        }
    }
</script>

<style scoped>

</style>