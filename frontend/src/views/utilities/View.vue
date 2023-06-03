<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo de Utiliadad | Ver</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/utilidad/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form>
              
                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Código" :description="errors.code">
                            <b-form-input disabled class="text-center" size="sm" v-model="utility.code"></b-form-input>
                        </b-form-group> 
                    </b-col>


                    <b-col md="2">
                        <b-form-group label="Año" :description="errors.year">
                            <b-form-select disabled size="sm" v-model="utility.year" :options="year"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Mes" :description="errors.month">
                            <b-form-select disabled size="sm" v-model="utility.month" :options="month"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Observación">
                            <b-form-input disabled size="sm"  v-model="utility.observation"></b-form-input>
                        </b-form-group> 
                    </b-col>  

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
                                <tr v-for="(item, it) in utility_detail_income" :key="it">
                                    <th class="text-center">{{ it + 1}}</th>
                                    <td class="text-start">{{item.year + " - " +NameMonth(item.month)}}</td>
                                    <td class="text-start">{{item.description}}</td>
                                    <td class="text-end">{{item.total_usd}}</td>
                                    <td class="text-end">{{item.total_pen}}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-center">TOTALES</th>
                                    <th class="text-end">{{  utility.income_total_usd }}</th>
                                    <th class="text-end">{{  utility.income_total_pen }}</th>
                                </tr>
                            </tfoot>
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
                                <tr v-for="(item, it) in utility_detail_expense" :key="it">
                                    <th class="text-center">{{ it + 1}}</th>
                                    <td class="text-start">{{item.year + " - " +NameMonth(item.month)}}</td>
                                    <td class="text-start">{{item.description}}</td>
                                    <td class="text-end">{{item.total_usd}}</td>
                                    <td class="text-end">{{item.total_pen}}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-center">TOTALES</th>
                                    <th class="text-end">{{  utility.expense_total_usd }}</th>
                                    <th class="text-end">{{  utility.expense_total_pen }}</th>
                                </tr>
                            </tfoot>
                            </table>
                        </div>
                    </b-col>



                    <b-col md="9">
                      
                    </b-col>
           
            
                    <b-col md="3"> 
                        <b-input-group prepend="Utilidad PEN">
                            <b-form-input class="text-end" v-model="utility.balance_total_pen" disabled type="text"></b-form-input>
                        </b-input-group>
                        <b-input-group class="mt-1" prepend="Utilidad USD">
                            <b-form-input class="text-end" v-model="utility.balance_total_usd" disabled type="text"></b-form-input>
                        </b-input-group>
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
    props: ['id_utility'],
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'Utility',
        role:2,
        utility:{
            id_expense:'',
            id_user:'',
            id_business:'',
            code:'',
            date:moment(new Date()).local().format("YYYY-MM-DD"),
            year:moment(new Date()).local().format("YYYY"),
            month:moment(new Date()).local().format("MM"),
            observation:'',
            income_total_pen:'0.00',
            income_total_usd:'0.00',
            expense_total_pen:'0.00',
            expense_total_usd:'0.00',
            balance_total_pen:'0.00',
            balance_total_usd:'0.00',
            state:'1',
        },
        utility_detail_income:[],
        utility_detail_expense:[],
        business:[],
        state:[
            {value:1,text:'Activo'},
            {value:0,text:'Inactivo'},
        ],
        coin:[
            {value:'PEN',text:'PEN'},
            {value:'USD',text:'USD'},
        ],
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
        month:[
            {value:"01",text:'Enero'},
            {value:"02",text:'Febrero'},
            {value:"03",text:'Marzo'},
            {value:"04",text:'Abril'},
            {value:"05",text:'Mayo'},
            {value:"06",text:'Junio'},
            {value:"07",text:'Julio'},
            {value:"08",text:'Agosto'},
            {value:"09",text:'Septiembre'},
            {value:"10",text:'Octubre'},
            {value:"11",text:'Noviembre'},
            {value:"12",text:'Diciembre'},
        ],
        errors:{
            id_business:'',
            code:'',
            date:'',
            year:'',
            month:'',
            total_pen:'',
            total_usd:'',
        },
        validate: false,
        
      }
    },
    mounted() {
        this.ViewUtility();
    },
    methods: {
        ViewUtility,
        NameMonth,
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

function ViewUtility() {
    let me = this;
    let id_utility = je.decrypt(me.id_utility);
    let url = this.url_base + "utilities/view/"+id_utility
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
           me.utility.id_utility = response.data.result.id_utility;
           me.utility.id_user = response.data.result.id_user;
           me.utility.code = response.data.result.code;
           me.utility.year = response.data.result.year;
           me.utility.month = response.data.result.month;
           me.utility.observation = response.data.result.observation;
           me.utility.income_total_pen = response.data.result.income_total_pen;
           me.utility.income_total_usd = response.data.result.income_total_usd;
           me.utility.expense_total_pen = response.data.result.expense_total_pen;
           me.utility.expense_total_usd = response.data.result.expense_total_usd;
           me.utility.balance_total_pen = response.data.result.balance_total_pen;
           me.utility.balance_total_usd = response.data.result.balance_total_usd;
           me.utility.state = response.data.result.state;

            me.utility_detail_income = response.data.result.utility_detail_income;
            me.utility_detail_expense = response.data.result.utility_detail_expense;

        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}



</script>