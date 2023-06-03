<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="12">
                    <strong>Reporte de Gastos Externos</strong>
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">
              
                <b-row class="justify-content-center">


                    <b-col md="2">
                        <b-form-group label="Mes">
                            <input class="form-control text-center form-control-sm" type="month" size="sm" v-model="report.month" >
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
                    <b-col md="6">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle ">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center text-white" colspan="5">INGRESO MENSUAL</th>
                                </tr>
                                <tr>
                                    <th width="3%" class="text-center text-white" >#</th>
                                    <th width="17%" class="text-center text-white" >Mes</th>
                                    <th width="56%" class="text-center text-white" >Descripción</th>
                                    <th width="12%" class="text-center text-white" >T. USD</th>
                                    <th width="12%" class="text-center text-white" >T. PEN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, it) in detail_income" :key="it">
                                    <th class="text-center">{{ it + 1}}</th>
                                    <td class="text-start">{{item.year + " - " +item.month}}</td>
                                    <td class="text-start">{{item.description}}</td>
                                    <td class="text-end">{{item.total_usd}}</td>
                                    <td class="text-end">{{item.total_pen}}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-center">TOTALES</th>
                                    <th class="text-end">{{  total.income_usd }}</th>
                                    <th class="text-end">{{  total.income_pen }}</th>
                                </tr>
                            </tfoot>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle ">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center text-white" colspan="5">DIFERENCIA EFECTIVO</th>
                                </tr>
                                <tr>
                                    <th colspan="3" width="76%" class="text-center text-white" >Descripción</th>
                                    <th width="12%" class="text-center text-white" >T. USD</th>
                                    <th width="12%" class="text-center text-white" >T. PEN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="3" class="text-center">INGRESO EFECTIVO</th>
                                    <td class="text-end">{{total.income_usd}}</td>
                                    <td class="text-end">{{total.income_pen}}</td>
                                    
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-center">EGRESO EFECTIVO</th>
                                     <th class="text-end">{{  total.expense_usd }}</th>
                                    <th class="text-end">{{  total.expense_pen }}</th>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </b-col>
                 

                    <b-col md="6">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered align-middle ">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center text-white" colspan="5">EGRESO MENSUAL</th>
                                </tr>
                                <tr>
                                    <th width="3%" class="text-center text-white" >#</th>
                                    <th width="17%" class="text-center text-white" >Mes</th>
                                    <th width="56%" class="text-center text-white" >Descripción</th>
                                    <th width="12%" class="text-center text-white" >T. USD</th>
                                    <th width="12%" class="text-center text-white" >T. PEN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, it) in detail_expense" :key="it">
                                    <th class="text-center">{{ it + 1}}</th>
                                    <td class="text-start">{{item.year + " - " +item.month}}</td>
                                    <td class="text-start">{{item.description}}</td>
                                    <td class="text-end">{{item.total_usd}}</td>
                                    <td class="text-end">{{item.total_pen}}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-center">TOTALES</th>
                                    <th class="text-end">{{  total.expense_usd }}</th>
                                    <th class="text-end">{{  total.expense_pen }}</th>
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                    </b-col>



                    <b-col md="8">
                      
                    </b-col>
           
            
                    <b-col md="4"> 
                        <b-input-group prepend="Restante Efectivo PEN">
                            <b-form-input class="text-end" v-model="total.balance_pen" disabled type="text"></b-form-input>
                        </b-input-group>
                        <b-input-group class="mt-1" prepend="Restante Efectivo USD">
                            <b-form-input class="text-end" v-model="total.balance_usd" disabled type="text"></b-form-input>
                        </b-input-group>
                    </b-col>
                </b-row>
                
               
            </b-form>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>

    <LoadingComponent :is-visible="isLoading" />
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
        module:'ReportUtilityManagementMonth',
        role:'List',
        report:{
            month:moment().local().format("YYYY-MM"),
        },
        
        detail_income:[],
        detail_expense:[],

        total:{
            income_pen:'0.00',
            income_usd:'0.00',
            expense_pen:'0.00',
            expense_usd:'0.00',
            balance_pen:'0.00',
            balance_usd:'0.00',
        },
        validate: false,
        errors: {
            month: '',
        }
     
        
      }
    },
    mounted() {
   
    },
    methods: {
        Validate,
        Report,
        NameMonth,
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
function NameMonth(code) {
  return CodeToName.NameMonth(code);
}

function ExportExcel(){
    let me = this;
    let url = me.url_base + "excel-report-month-utility-management/"+me.report.month;
    window.open(url,'_blank');
}

function Report() {

    let me = this;
    let url = this.url_base + "report/month-utility-management";
    let data = this.report;
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.detail_income = response.data.result.detail_income;
            me.detail_expense = response.data.result.detail_expense;
            me.total = response.data.result.total;
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
    
    this.errors.month = this.report.month.length == 0 ? 'Seleccione un año':'';

    if (this.errors.month.length > 0 ) this.validate = true;

    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

    this.Report();
    
}
</script>