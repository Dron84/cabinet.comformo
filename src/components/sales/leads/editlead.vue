<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container" style="width: 90%;">
                <button type="button" class="close" @click="$emit('close',true)" style="min-width: 33px;">&times;</button>
                <h3>Edit lead</h3>
                <div class="tripple">
                    <div class="input_group ">
                        <input type="text" id="firstName" v-model="firstName" :class="[firstName!='' ? okClass : errorClass]">
                        <label for="firstName">First Name</label>
                    </div>
                    <div class="input_group">
                        <input type="text" id="lastName" v-model="lastName" :class="[lastName!='' ? okClass : errorClass]">
                        <label for="lastName">Last Name</label>
                    </div>
                    <div class="input_group">
                        <input type="text" id="middleName" v-model="middleName">
                        <label for="middleName">Middle Name</label>
                    </div>
                </div>
                <div class="tripple">
                    <div class="input_group ">
                        <input type="text" id='phone' :class='[phone_valid ? okClass : errorClass]' v-model="phone" tabindex="5"
                               required @change="checkPhone">
                        <label for="phone">Phone</label>
                    </div>
                    <div class="input_group">
                        <input type="text" id='email' :class="[isEmailValid()]" v-model="email" tabindex="3" required>
                        <label for="email">Email</label>
                    </div>
                    <formproductselect :hideSelected="true" @selectedProduct="selectedType($event)" labelName="What product needs" :placeholder="''" :multiple="true" :closeOnSelect="false"></formproductselect>
                </div>
                <div class="duble_side_box">

                    <div class="input_group">
                <textarea id="description" v-model="description" rows="3"
                          :class="[description!='' ? okClass : errorClass]"></textarea>
                        <label for="description">Description</label>
                    </div>
                </div>
                <div class="tripple">
                    <div class="input_group">
                        <input type="text" id="instagram" v-model="instagram">
                        <label for="instagram">Link to Instagram</label>
                    </div>
                    <div class="input_group">
                        <input type="text" id="facebook" v-model="facebook">
                        <label for="facebook">Link to Facebook</label>
                    </div>
                    <div class="input_group">
                        <input type="text" id="twitter" v-model="twitter">
                        <label for="twitter">Link to Twitter</label>
                    </div>
                </div>
                <div class="tripple">
                    <formUsersStatus labelName="Users status" @selectedStatus="selectStatus($event)"></formUsersStatus>
                    <formselectCountry countryComplect="all" @selectedCountry="selectCountry($event)" :placeholder="''"
                                       :multiple="true" :closeOnSelect="false" :values="country"></formselectCountry>
                </div>
                <div class="centrize">
                    <button class="button" @click="addLead()" :disabled="checkLeads()" ref="addlead">Edit Lead</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import formselect from '@/components/forms/formselect.vue'
    import formselectCountry from '@/components/forms/formselectCountry.vue'
    import formUsersStatus from '@/components/forms/formUsersStatus.vue'
    import formproductselect from '@/components/forms/formproductselect.vue'
    import axios from 'axios'

    export default {
        name: "editlead",
        components: {formselect, formselectCountry,formUsersStatus,formproductselect},
        data() {
            return {
                typeOptions: [
                    {label: 'Company', index: 1}, {label: 'Bank Account', index: 2},
                    {label: 'Structure',index: 3}, {label: 'PSP', index: 4}, {label: 'Website', index: 5}
                ],
                okClass: 'ok',
                errorClass: 'err',
                type: null,
                firstName: '',
                lastName: '',
                middleName: '',
                phone: '',
                email: '',
                instagram: '',
                facebook: '',
                twitter: '',
                status: {},
                statusElse: '',
                description: '',
                country: null,
                phone_valid: '',
                phone_carrier: '',
                phone_country_code: '',
                phone_country_name: '',
                phone_country_prefix: '',
                phone_international_format: '',
                phone_line_type: '',
                phone_local_format: '',
                phone_location: '',
                phone_number: '',
                reg: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/,
            }
        },
        props:{
            id: '',
        },
        methods: {
            addLead() {
                let fd = new FormData
                let c = []
                let country = null
                if(this.country.length>1){
                    this.country.forEach(item => {
                        c.push(item.index)
                        country = c.join(',')
                    })
                }else{
                    country = this.country
                }
                fd.append('firstName', this.firstName)
                fd.append('lastName', this.lastName)
                fd.append('middleName', this.middleName)
                fd.append('phone', this.phone)
                fd.append('email', this.email)
                fd.append('type', JSON.stringify(this.type))
                fd.append('status', this.status.label)
                if (this.status.index == 2) {
                    fd.append('statusElse', this.statusElse)
                }
                fd.append('Country', country)
                fd.append('description', this.description)
                fd.append('instagram', this.instagram)
                fd.append('facebook', this.facebook)
                fd.append('twitter', this.twitter)
                fd.append('person', 'editLead')
                fd.append('id',this.id)
                axios.post(this.$store.getters.getPostUrl, fd).then(res => {
                    if (res.data.mess == 'Sql INSERT is ok') {
                        this.clearInputs()
                        this.getAllData()
                        this.$refs.addlead.innerText = 'SAVED'
                        setTimeout(() => {
                            this.$refs.addlead.innerText = 'Edit Lead'
                        }, 5000)
                    }
                })
            },
            checkLeads() {
                if (this.country != '' && this.firstName != '' && this.lastName != '' && this.isEmailValid() == 'ok' && this.type != '' && this.status != '' && this.description != '') {
                    return false
                } else {
                    return true
                }
            },
            checkPhone() {
                axios.get('http://apilayer.net/api/validate?access_key=b0d668b30957a7b8b63149412ee30ab5&number=' + phone.value + '&country_code=&format=0')
                    .then((res) => {
                        this.phone_carrier = res.data.carrier
                        this.phone_country_code = res.data.country_code
                        this.phone_country_name = res.data.country_name
                        this.phone_country_prefix = res.data.country_prefix
                        this.phone_international_format = res.data.international_format
                        this.phone_line_type = res.data.line_type
                        this.phone_local_format = res.data.local_format
                        this.phone_location = res.data.location
                        this.phone_number = res.data.number
                        this.phone_valid = res.data.valid
                    })
            },
            isEmailValid() {
                return (this.email == "") ? "" : (this.reg.test(this.email)) ? 'ok' : 'err'
            },
            clearInputs() {
                this.firstName = ''
                this.lastName = ''
                this.middleName = ''
                this.phone = ''
                this.email = ''
                this.type = null
                this.status = {}
                this.country = null
                this.description = ''
                this.instagram = ''
                this.facebook = ''
                this.twitter = ''
            },
            getAllData() {
                let leads = this.$store.getters.get_salesManagerLeads
                let countrys = this.$store.getters.getAllCountry
                leads.forEach(lead=>{
                    if(lead.id==this.id){
                        // console.log(lead)
                        this.firstName = lead.firstName
                        this.lastName = lead.lastName
                        this.middleName = lead.middleName
                        this.phone = lead.phone
                        this.email = lead.email
                        this.type = lead.type
                        this.status = lead.status
                        countrys.forEach(cou=>{
                            console.log(cou)
                            if(cou.id==lead.Country){
                                this.country.push({index: cou.id,code: cou.code, label: cou.jurisdictionname})
                            }
                        })
                        this.description = lead.description
                        this.instagram = lead.instagram
                        this.facebook = lead.facebook
                        this.twitter = lead.twitter
                    }
                })
            },
            selectedType(data) {
                this.type = data
            },
            selectStatus(data) {
                // console.log(data)
                this.status = data.status
                this.statusElse = data.statusElse
            },
            selectCountry(data) {
                this.country = data
            }
        },
        created(){
            this.getAllData()
        }
    }
</script>
