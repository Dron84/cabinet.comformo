<template>
    <div style="position: fixed; bottom: 30px; right: 30px">
        <div class="addlog" @click="modal = true">
            <div class="add-comp-btn box_shadow_hover_roundshadow"  style="width: 80px;height: 80px;">
                <div>
                    <span></span>
                    <span></span>
                </div>
            </div>

        </div>
        <transition name="addlog" v-if="modal">
            <div class="addlogmodal">
                <div class="modal-wrapper" @click.self="modal = false">
                    <div class="modal-container">
                        <button type="button" class="close" @click=" modal = false">&times;</button>
                            <div class="modal-body">
                                <formselect labelName="User" :options="users" @selected="selectUser($event)"></formselect>
                                <div class="input-wrapper">
                                    <date class="form-control valid" id="dateTo" v-model="dateTo"></date>
                                    <label for="dateTo" class="label-up" style="position: absolute;top: -6px;left: 6px;font-family: 'Brandon Grotesque';font-weight: 500;font-size: .8em;letter-spacing: .05em;line-height: .8em;text-align: left;color: #2f2f2f;background-color: #fff;">Date to Contact</label>
                                </div>
                                <div class="input_group">
                                    <timepicker format="HH:mm" id="timeTo" :minute-interval="5" @change="setTime($event)"></timepicker>
                                    <label for="timeTo" class="label-up" style="position: absolute;top: -6px;left: 6px;font-family: 'Brandon Grotesque';font-weight: 500;font-size: .8em;letter-spacing: .05em;line-height: .8em;text-align: left;color: #2f2f2f;background-color: #fff;">Time to Contact</label>
                                </div>
                                <forminput labelName="Description" @inputModel="descriptionInput($event)"></forminput>
                                <formproductselect :hideSelected="true" @selectedProduct="selectProduct($event)" labelName="Product" :placeholder="''" :multiple="true" :closeOnSelect="false"></formproductselect>
                            </div>
                        <div class="centrize" style="width: 200px;" v-if="!preload">
                            <button v-if="addStatus=='disabled'" type="button" class="submit"  style="width: 100%;" disabled="disabled">Add Log</button>
                            <button v-if="addStatus==''" type="button" class="submit"  style="background-image: -webkit-linear-gradient( 128deg, rgb(255,136,0) 0%, rgb(251,159,53) 0%, rgb(255,136,0) 97%);width: 100%;" @click="addlog()">Add Log</button>
                        </div>
                        <div class="centrize" style="width: 200px;" v-else>
                            <button type="button" class="submit"  style="background-image: -webkit-linear-gradient( 128deg, rgb(255,136,0) 0%, rgb(251,159,53) 0%, rgb(255,136,0) 97%);width: 100%;">Wait
                                <img src="/static/img/loading.gif" alt="" height="20">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import date from 'vuejs-datepicker'
    import forminput from '@/components/forms/formInput'
    import formselect from '@/components/forms/formselect'
    import formproductselect from '@/components/forms/formproductselect.vue'
    import timepicker from 'vue2-timepicker'
    import axios from 'axios'
    let moment = require('moment');
    export default {
        name: "addlog",
        components:{forminput,formselect,date,formproductselect,timepicker},
        data(){
            return{
                modal: false,
                addLog: {
                    status: ''
                },
                users: [],
                selectedUser: {},
                description: '',
                dateTo: '',
                timeTo: {
                    hh: null,
                    mm: null,
                },
                selectedProduct:[],
                preload: false
            }
        },
        methods: {
            createUsersList(){
                let AllUsers = []
                let leads = this.$store.getters.get_salesManagerLeads
                let clients = this.$store.getters.get_salesManagerClients
                AllUsers.push({index: 0,label:'Leads group below', $isDisabled: true })
                leads.forEach(lead=>{
                    AllUsers.push({index: lead.id,label: lead.firstName+' '+lead.lastName})
                })
                AllUsers.push({index: 0,label:'Clients group below', $isDisabled: true })
                clients.forEach(client=>{
                    AllUsers.push({index: client.id,label: client.firstName+' '+client.lastName })
                })
                this.users = AllUsers
            },
            selectUser(data){
                this.selectedUser = data
            },
            descriptionInput(data){
                this.description = data
            },
            customFormatter(date) {
                return moment(date).format('YYYY-MM-DD');
            },
            selectProduct(data){
                this.selectedProduct=data
            },
            setTime(data){
                this.timeTo.hh = data.data.hh
                this.timeTo.mm = data.data.mm
            },
            addlog(){
                // console.log(this.selectedUser,this.selectedProduct,this.description, this.customFormatter(this.dateTo))
                this.preload = true
                let datetime = this.customFormatter(this.dateTo)
                let fd = new FormData
                fd.append('userId', this.selectedUser.index)
                fd.append('productlist',JSON.stringify(this.selectedProduct))
                fd.append('description',this.description)
                fd.append('dateToContact', datetime+' '+this.timeTo.hh+':'+this.timeTo.mm)
                fd.append('log','add')
                axios.post(this.$store.getters.getPostUrl, fd).then(res=>{
                    if(res.data.mess == 'Sql INSERT is ok'){
                        this.preload = false
                        setTimeout(()=>{
                            this.modal = false
                            this.dateTo=''
                        },1000)
                    }
                })
            },
        },
        created(){
            this.createUsersList()
        },
        computed: {
            addStatus() {
                let user, desc, date, time, product = false
                if (this.selectedUser.index!=undefined) {
                    user = true
                }else{
                    user = false
                }
                if(this.description!=''){
                    desc = true
                }else{
                    desc = false
                }
                if(this.dateTo!=''){
                    date = true
                }else{
                    date = false
                }
                if(this.timeTo.hh!=null&&this.timeTo.mm!=null){
                    time = true
                }else{
                    time = false
                }
                if(this.selectedProduct.length>0){
                    product = true
                }else{
                    product = false
                }
                if(user&&desc&&date&&time&&product){
                    return ''
                }else{
                    return 'disabled'
                }
            }

        }
    }
</script>

<style scoped>

</style>