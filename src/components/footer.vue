<template>
    <div ref="foot" id="top-footer"></div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "foot",
        components:{axios,},
        data(){
            return{
            }
        },
        methods:{
            loadData(){
                let foot = document.implementation.createDocument('','');
               axios.post('https://cabinet.comformo.com/server/post/','getFooterComformo').then(res=>{
                   foot = document.createRange().createContextualFragment(res.data)
                   this.$refs.foot.innerHTML = foot.getElementById('top-footer').innerHTML
               })
            }
        },
        mounted(){
            this.loadData()
        }
    }
</script>
<style scoped>
  .tg-column-wrapper .tg-column-1, .tg-column-wrapper .tg-column-2, .tg-column-wrapper .tg-column-3, .tg-column-wrapper .tg-column-4, .tg-column-wrapper .tg-column-5 {
    float: left;
    margin-right: 2%;
    margin-left: 2%;
  }

  #top-footer .widget ul {
    margin: 0;
    list-style: none;
  }
  #top-footer .widget ul li {
    position: relative;
    padding: 0 0 10px 0;
    font-size: 12px;
  }
  .tg-container {
    max-width: 1300px;
    margin: 0 auto;
    padding-top: 30px;
    padding-bottom: 30px;
  }
  .textwidget p{
    text-align: left;
    color: #948e8e;
  }
  .subscribe-form .form-control {
    border: 1px solid #fd8e2a!important;
  }
  .subscribe-form .btn {
    color: #ffffff;
  }
  #top-footer .tg-column-3:nth-child(2) {
    width: 44%;
  }
  #top-footer .tg-column-3:nth-child(3) {
    width: 27%;
  }
  @media(max-width: 767px) {
    #top-footer .tg-column-3:nth-child(2) {
      justify-content: space-between;
    }

    #top-footer .tg-column-wrapper .footer-block {
      width: 100%;
      margin: 0 0 30px 0;
    }
  }
</style>
