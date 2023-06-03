<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="12">
                    <strong>Reporte Utilidad Acumulado</strong>
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">
              
                <b-row class="justify-content-center">


                    <b-col md="2">
                        <b-form-group label="Desde">
                            <input class="form-control text-center form-control-sm" :max="report.to" type="month" size="sm" v-model="report.from" >
                        </b-form-group> 
                    </b-col>

                     <b-col md="2">
                        <b-form-group label="Hasta">
                            <input class="form-control text-center form-control-sm" :min="report.from" type="month" size="sm" v-model="report.to" >
                        </b-form-group> 
                    </b-col>

           

                    <b-col md="2">
                        <b-form-group label="Moneda" :description="errors.coin">
                            <b-form-select size="sm" v-model="report.coin" :options="coin"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="1">
                        <b-form-group label=".">
                            <b-button class="form-control" size="sm" variant="primary" type="submit"><font-awesome-icon icon="fa-solid fa-magnifying-glass" /></b-button>
                        </b-form-group> 
                    </b-col>

                    <b-col md="1">
                        <b-form-group label=".">
                            <b-button class="form-control" @click="ExportExcel" size="sm" variant="success" type="button"><font-awesome-icon icon="fa-solid fa-file-excel" /></b-button>
                        </b-form-group> 
                    </b-col>
             

             
                </b-row>

                <b-row>
                    <b-col md="12">
                        <div class="table-responsive table-data">
                            <table class="table table-hover table-striped table-bordered align-middle ">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="16%" class="text-center text-white" >s</th>
                                        <th  v-for="(item, it) in title" :key="it"  class="text-center text-white" >{{item}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr>
                                        <th class="text-success">INGRESOS</th>
                                        <td v-for="(item, it) in income" :key="it" class="text-end"><strong>{{coin_name == "PEN" ? "S/":"$" }}</strong> {{income[it]}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-success">EGRESOS</th>
                                        <td v-for="(item, it) in expense" :key="it" class="text-end"><strong>{{coin_name == "PEN" ? "S/":"$" }}</strong> {{expense[it]}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-success">RESULTADO</th>
                                        <td v-for="(item, it) in balance" :key="it" class="text-end"><strong>{{coin_name == "PEN" ? "S/":"$" }}</strong> {{balance[it]}}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-success">SALDO ACUMULADO</th>
                                        <td v-for="(item, it) in balance_final" :key="it" class="text-end"><strong>{{coin_name == "PEN" ? "S/":"$" }}</strong> {{balance_final[it]}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </b-col>
                </b-row>
                
               
            </b-form>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>

    <LoadingComponent :is-visible="isLoading" />
  <!-- <Keypress key-event="keyup" :key-code="115" @success="Validate" /> -->
</template>

<script>

const axios = require("axios").default;
const Swal = require("sweetalert2");
const je = require("json-encrypt");
var moment = require("moment");

import LoadingComponent from '@/views/pages/Loading'
import { computed } from 'vue'
import { useStore } from 'vuex'
import CodeToName from "@/assets/js/CodeToName";
export default {
    name: 'UserAdd',
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'ReportUtility',
        role:'List',
        report:{
            from:moment().subtract(11, 'month').local().format("YYYY-MM"),
            to:moment(new Date()).local().format("YYYY-MM"),  
            year:moment(new Date()).local().format("YYYY"),
            coin:'PEN',
        },
        coin_name:'',
        title:[],
        income:[],
        expense:[],
        balance:[],
        balance_final:[],
        year:[
            {value:"2020",text:'2020'},
            {value:"2021",text:'2021'},
            {value:"2022",text:'2022'},
            {value:"2023",text:'2023'},
            {value:"2024",text:'2024'},
            {value:"2025",text:'2025'},
            {value:"2026",text:'2026'},
            {value:"2027",text:'2027'},
            {value:"2028",text:'2028'},
        ],
        coin:[
            {value:'PEN',text:'PEN'},
            {value:'USD',text:'USD'},
        ],
        errors:{
            year:'',
            coin:'',
        },
        validate: false,
        
      }
    },
    mounted() {
   
    },
    methods: {
        Validate,
        Report,
        ExportExcel,
    },
    setup() {
        const store = useStore()
        const user = window.localStorage.getItem("user");
        return {
            url_base: computed(() => store.state.url_base),
            muser: JSON.parse(JSON.parse(je.decrypt(user))),
        }
    },
    
}

function ExportExcel(){
    let me = this;
    let url = me.url_base + "excel-report-utility/"+me.report.from+"/"+me.report.to+"/"+me.report.coin;
    window.open(url,'_blank');
}

function Report() {

    let me = this;
    let url = this.url_base + "report/utility";
    let data = this.report;
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.coin_name = me.report.coin;
            me.title = response.data.result.title;
            me.income = response.data.result.income;
            me.expense = response.data.result.expense;
            me.balance = response.data.result.balance;
            me.balance_final = response.data.result.balance_final;
        }else{
            Swal.fire({ icon: 'error', text: response.data.message, timer: 3000})
        }
        me.isLoading = false;
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}

function Validate() {
    this.validate = false;
    
    this.errors.year = this.report.year.length == 0 ? 'Seleccione un año':'';
    this.errors.coin = this.report.coin.length == 0 ? 'Seleccione una moneda':'';

    if (this.errors.year.length > 0 ) this.validate = true;
    if (this.errors.coin.length > 0 ) this.validate = true;

    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

    this.Report();
    
}
</script>