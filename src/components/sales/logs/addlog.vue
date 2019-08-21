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
                                    <label for="dateTo" class="label-up">Date to Contact</label>
                                </div>
                                <forminput labelName="Description" @inputModel="descriptionInput($event)"></forminput>
                                <formproductselect :hideSelected="true" @selectedProduct="selectProduct($event)" labelName="Product" :placeholder="''" :multiple="true" :closeOnSelect="false"></formproductselect>
                            </div>
                        <div class="centrize" style="width: 200px;">
                            <button v-if="addStatus==''" type="button" class="submit"  style="background-image: -webkit-linear-gradient( 128deg, rgb(255,136,0) 0%, rgb(251,159,53) 0%, rgb(255,136,0) 97%);width: 100%;" @click="addlog()">Add Log</button>
                            <button v-else-if="addStatus=='wait'" type="button" class="submit"  style="background-image: -webkit-linear-gradient( 128deg, rgb(255,136,0) 0%, rgb(251,159,53) 0%, rgb(255,136,0) 97%);width: 100%;">Wait
                                <img src="/static/img/loading.gif" alt="" height="20"></button>
                            <button v-else-if="addStatus=='added'" type="button" class="submit"  style="background-image: -webkit-linear-gradient( 128deg, rgb(255,136,0) 0%, rgb(251,159,53) 0%, rgb(255,136,0) 97%);width: 100%;">Log is Added</button>
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
    import axios from 'axios'
    let moment = require('moment');
    export default {
        name: "addlog",
        components:{forminput,formselect,date,formproductselect},
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
                selectedProduct:{},
                addStatus: '',
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
            addlog(){
                console.log(this.selectedUser,this.selectedProduct,this.description, this.customFormatter(this.dateTo))
                this.addStatus = 'wait'
                let fd = new FormData
                fd.append('userId', this.selectedUser.index)
                fd.append('productlist',JSON.stringify(this.selectedProduct))
                fd.append('description',this.description)
                fd.append('dateToContact',this.customFormatter(this.dateTo))
                fd.append('log','add')
                axios.post(this.$store.getters.getPostUrl, fd).then(res=>{
                    // console.log(res.data)
                    if(res.data.mess == 'Sql INSERT is ok'){
                        this.addStatus = 'added'
                        setTimeout(()=>{
                            this.addStatus = ''
                            this.modal = false
                            this.dateTo=''
                        },5000)
                    }
                })
            },
        },
        created(){
            this.createUsersList()
        }
    }
</script>

<style scoped>

</style>