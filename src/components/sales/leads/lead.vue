<template>
    <div>
        <h4 class="centrize" style="margin-bottom: 30px;">About Lead: "{{client.firstName+' '+client.lastName}}"</h4>
        <div class="row">
            <div class="col-md-4 border">
                <h3 style="margin: 20px;">Client info:</h3>
                <div class="centrize">
                    <div class="change_avatar" style="width: 100px;height: 100px;"><img
                            :src="checkAvatar(client.avatar)" alt="avatar" style="width: 100px; height: 100px;"></div>
                </div>
                <div class="centrize">{{client.firstName+' '+client.lastName}}</div>
                <div>
                    <p style="text-align: left; font-size: .9em;"><b>About this contact</b><span style="position: relative;top: -2px;left: 20px;" class="onmouse" @click="editLead = true"><svg height="20px" viewBox="0 -1 401.52289 401" width="20px" xmlns="http://www.w3.org/2000/svg"><path d="m370.589844 250.972656c-5.523438 0-10 4.476563-10 10v88.789063c-.019532 16.5625-13.4375 29.984375-30 30h-280.589844c-16.5625-.015625-29.980469-13.4375-30-30v-260.589844c.019531-16.558594 13.4375-29.980469 30-30h88.789062c5.523438 0 10-4.476563 10-10 0-5.519531-4.476562-10-10-10h-88.789062c-27.601562.03125-49.96875 22.398437-50 50v260.59375c.03125 27.601563 22.398438 49.96875 50 50h280.589844c27.601562-.03125 49.96875-22.398437 50-50v-88.792969c0-5.523437-4.476563-10-10-10zm0 0"/><path d="m376.628906 13.441406c-17.574218-17.574218-46.066406-17.574218-63.640625 0l-178.40625 178.40625c-1.222656 1.222656-2.105469 2.738282-2.566406 4.402344l-23.460937 84.699219c-.964844 3.472656.015624 7.191406 2.5625 9.742187 2.550781 2.546875 6.269531 3.527344 9.742187 2.566406l84.699219-23.464843c1.664062-.460938 3.179687-1.34375 4.402344-2.566407l178.402343-178.410156c17.546875-17.585937 17.546875-46.054687 0-63.640625zm-220.257812 184.90625 146.011718-146.015625 47.089844 47.089844-146.015625 146.015625zm-9.40625 18.875 37.621094 37.625-52.039063 14.417969zm227.257812-142.546875-10.605468 10.605469-47.09375-47.09375 10.609374-10.605469c9.761719-9.761719 25.589844-9.761719 35.351563 0l11.738281 11.734375c9.746094 9.773438 9.746094 25.589844 0 35.359375zm0 0"/></svg></span></p>
                    <editLead :id="$route.params.id" v-if="editLead==true" @close="editLead=false"></editLead>
                    <hr>
                    <p style="text-align: left; font-size: .9em;" v-if="client.email!=''">Email: <br><a
                            :href="'mailto:'+client.email">{{client.email}}</a></p>
                    <p style="text-align: left; font-size: .9em;" v-if="client.phone!=''">Phone: <br><a
                            :href="'tel:+'+client.phone">+{{client.phone}}</a></p>
                    <p style="text-align: left; font-size: .9em;" v-if="client.instagram!=''&&client.instagram!=null">
                        Instagram: <br>
                        <instagram :href="client.instagram"></instagram>
                    </p>
                    <p style="text-align: left; font-size: .9em;" v-if="client.facebook!=''&&client.facebook!=null">
                        Facebook: <br>
                        <facebook :href="client.facebook"></facebook>
                    </p>
                    <p style="text-align: left; font-size: .9em;" v-if="client.twitter!=''&&client.twitter!=null">
                        Twitter: <br>
                        <twitter :href="client.twitter"></twitter>
                    </p>
                    <p style="text-align: left; font-size: .9em;" v-if="client.Country!=''&&client.Country!=null">
                        Country: <br>{{getCountryName(client.Country)}}&nbsp&nbsp<img
                            :src="getCountryImg(client.Country)" alt="" style="height: 25px;"></p>
                    <br>
                    <p style="text-align: left; font-size: .9em;" v-if="client.type!=''&&client.type!=null">What
                        need:<br>
                    <ul>
                        <li v-for="need in JSON.parse(client.type)">{{need.label}},</li>
                    </ul>
                    </p>
                    <p style="text-align: left; font-size: .9em;" v-if="client.status!=''&&client.status!=null">Status:
                        <br>{{client.status}}</p>
                    <p style="text-align: left; font-size: .9em;"
                       v-if="client.description!=''&&client.description!=null">Description: <br>{{client.description}}
                    </p>
                    <p style="text-align: left; font-size: .9em;" v-if="client.regDate!=''&&client.regDate!=null">
                        Registration Date: <br>{{client.regDate}}
                    </p>
                </div>
                <br>
                <div class="centrize">
                    <button class="button" data-toggle="modal" data-target="#addInvoce" style="margin-bottom: 30px;">Add
                        Invoce
                    </button>
                </div>
                <div id="addInvoce" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                        style="width: 22px;height: 22px;right: -3px;top: -4px;line-height: 5px;display: flex;justify-content: center;">
                                    &times;
                                </button>
                                <h4 class="modal-title centrize">Add Invoce</h4>
                            </div>
                            <div class="modal-body">
                                <form-input @inputModel="setInvoceNum($event)" labelName="Number"></form-input>
                                <form-input @inputModel="setInvoceSum($event)" labelName="Sum"></form-input>
                                <form-input @inputModel="setInvoceDesc($event)" labelName="Description"></form-input>
                                <form-input @inputModel="setInvoceCN($event)" labelName="Company Name"></form-input>
                                <formInputwebsite @inputModel="setInvoceWebsite($event)"
                                                  labelName="Company website"></formInputwebsite>
                                <!--<form-input @inputModel="setInvocePSP($event)" labelName="PSP"></form-input>-->
                                <formselectCountry countryComplect="our"
                                                   @selectedCountry="selectedCountry($event)"
                                                   labelName="Select Country where open a company"></formselectCountry>
                                <div class="centrize">
                                    <button class="button" @click.prevent="addInvoce()" style="margin-top: 20px;"
                                            data-dismiss="modal">Add
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-1"></div>
            <div class="col-md-7 border" style="background-color: rgba(204,204,204,.2);">
                <h3 style="margin: 10px;">Lead LOG</h3>
                <logsList :id="$route.params.id"></logsList>
            </div>
        </div>


    </div>
</template>

<script>
    import changeStatus from '@/components/forms/changeStatus'
    import instagram from '@/components/forms/social/instagram'
    import facebook from '@/components/forms/social/facebook'
    import twitter from '@/components/forms/social/twitter'
    import formInput from '@/components/forms/formInput'
    import formInputwebsite from '@/components/forms/formInputwebsite'
    import formselect from '@/components/forms/formselect'
    import formselectCountry from '@/components/forms/formselectCountry'
    import logsList from '@/components/sales/logsList.vue'
    import editLead from '@/components/sales/leads/editlead.vue'
    import axios from 'axios'

    const {base64encode, base64decode} = require('nodejs-base64');

    export default {
        name: "company",
        components: {
            changeStatus,
            instagram,
            facebook,
            twitter,
            formInput,
            formselect,
            formInputwebsite,
            formselectCountry,
            logsList,
            editLead,
        },
        data() {
            return {
                client: {},
                company: {},
                docs: {},
                editLead: false,
                StatusDropdownList: [
                    {
                        index: 'Cancel',
                        label: 'Cancel'
                    },
                    {
                        index: 'Confirm',
                        label: 'Confirm'
                    },
                ],

                filterList: [
                    {index: null, label: 'Not filtered'},
                    {index: 'loaded', label: 'loaded'},
                    {index: 'Cancel', label: 'Cancel'},
                    {index: 'Confirm', label: 'Confirm'},
                ],
                invoce: {
                    num: '',
                    sum: 0,
                    description: '',
                    companyName: '',
                    jurisdiction: '',
                    psp: '',
                    website: '',
                }
            }
        },
        methods: {
            loadData() {
                let Clients = this.$store.getters.get_salesManagerLeads
                let ClientsCompany = this.$store.getters.get_salesManagerClientsCompanys
                let id = this.$route.params.id.split(',')
                Clients.forEach(item => {
                    if (item.id == id[0]) {
                        this.client = item
                    }
                })
                ClientsCompany.forEach(item => {
                    if (item.id == id[1]) {
                        this.company = item.company
                        this.docs = item.docs
                    }
                })
            },
            getCountryName(id) {
                const countrys = this.$store.getters.getOurCountry
                for (let i = 0; i < countrys.length; i++) {
                    if (countrys[i].id == id) {
                        return countrys[i].jurisdictionname
                    }
                }
            },
            getCountryImg(id) {
                const countrys = this.$store.getters.getOurCountry
                for (let i = 0; i < countrys.length; i++) {
                    if (countrys[i].id == id) {
                        return '/static/img/flag/' + countrys[i].code.toLowerCase() + '.png'
                    }
                }
            },
            CheckPaymentStatus(status) {
                if (status != null) {
                    return 'Paid'
                } else {
                    return 'Pending Payment'
                }
            },
            checkAvatar(img) {
                if (img != '' && img != null) {
                    return img
                } else {
                    return '/static/img/avatar.svg'
                }
            },
            base64decode(string) {
                return base64decode(string)
            },
            base64encode(string) {
                return base64encode(string)
            },
            changeFilter(filters) {
                console.log(filters)
                if (filters != null) {
                    let searchRow = document.getElementsByClassName('searchRow')
                    for (let j = 0; j < searchRow.length; j++) {
                        let search = searchRow[j].getElementsByClassName('searchStatus')
                        for (let i = 0; i < search.length; i++) {
                            let searchtext = filters.toUpperCase()
                            let innertext = search[i].innerText.toUpperCase()
                            if (innertext.indexOf(searchtext) > -1) {
                                searchRow[j].style.display = "grid";
                            } else {
                                searchRow[j].style.display = "none";
                            }
                        }
                    }
                } else {
                    let searchRow = document.getElementsByClassName('searchRow')
                    for (let j = 0; j < searchRow.length; j++) {
                        searchRow[j].style.display = "grid";
                    }
                }

            },
            changeStatus(status, id) {
                axios.post(this.$store.getters.getPostUrl, 'setDocStatus=' + status + '&docID=' + id)
                    .then(res => {
                        if (res.data.mess == 'Sql UPDATE is ok') {
                            this.loadAllData()
                        }
                    })
            },
            loadUrl(row, id) {
                return '/server/post/getFile.php?loadmyfile=' + row.base_name + '&companyId=' + id + '&type=' + row.type
            },
            showUrl(row, id) {
                return '/server/post/getFile.php?showmyfile=' + row.base_name + '&companyId=' + id + '&type=' + row.type
            },
            selectedCountry(data) {
                this.invoce.jurisdiction = data.index
            },
            addInvoce() {
                let fd = new FormData
                let userId = this.$route.params.id
                fd.append('num', this.invoce.num)
                fd.append('sum', this.invoce.sum)
                fd.append('description', this.invoce.description)
                fd.append('companyName', this.invoce.companyName)
                fd.append('jurisdictionId', this.invoce.jurisdiction)
                fd.append('CompanyWebsite', this.invoce.website)
                fd.append('PSP', this.invoce.psp)
                fd.append('userId', userId)
                fd.append('invoce', 'add')
                // console.log(this.invoce.num,this.invoce.sum,this.invoce.description,this.invoce.companyName,this.invoce.jurisdiction,userId)
                axios.post(this.$store.getters.getPostUrl, fd).then(res => {
                    if (res.data.company.mess == 'Sql INSERT is ok' && res.data.invoce.mess == 'Sql INSERT is ok' && res.data.user.mess == 'Sql INSERT is ok') {
                        this.$router.push({path: '/sales/client/' + userId})
                    }
                })
            },
            setInvoceNum(e) {
                this.invoce.num = e
            },
            setInvoceSum(e) {
                this.invoce.sum = e
            },
            setInvoceDesc(e) {
                this.invoce.description = e
            },
            setInvoceCN(e) {
                this.invoce.companyName = e
            },
            setInvoceWebsite(e) {
                // console.log(e)
                this.invoce.website = e.input
            },
            setInvocePSP(e) {
                this.invoce.psp = e
            },
        },
        mounted() {
            this.loadData()
        }

    }
</script>

<style scoped>

</style>