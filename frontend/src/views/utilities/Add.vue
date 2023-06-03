<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo de Utiliadad | Nuevo</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/utilidad/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">
              
                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Código" :description="errors.code">
                            <b-form-input readonly class="text-center" size="sm" v-model="utility.code"></b-form-input>
                        </b-form-group> 
                    </b-col>


                    <b-col md="2">
                        <b-form-group label="Año" :description="errors.year">
                            <b-form-select size="sm" v-model="utility.year" :options="year"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Mes" :description="errors.month">
                            <b-form-select size="sm" v-model="utility.month" :options="month"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Observación">
                            <b-form-input size="sm"  v-model="utility.observation"></b-form-input>
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
                
                <b-row class="justify-content-center">
                    <b-col md="2">
                        <b-form-group>
                            <b-button type="button" @click="GetMonthlyUtility" class="form-control" size="sm" variant="primary"> Obtener Utilidad Mensual</b-button>
                        </b-form-group> 
                    </b-col>
                    <b-col md="2">
                        <b-form-group>
                            <b-button class="form-control" size="sm" variant="primary" type="submit"><font-awesome-icon icon="fa-solid fa-floppy-disk" /> Guardar (F4)</b-button>
                        </b-form-group> 
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
        this.GetCorrelative();
    },
    methods: {
        GetCorrelative,
        GetMonthlyUtility,
        Validate,
        AddUtility,

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

function GetCorrelative() {
    let me = this;
    let url = this.url_base + "data-manager/get-correlative-by-module/ManagementUtility"
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
           me.utility.code = response.data.result.number
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function GetMonthlyUtility() {
    let me = this;
    let url = this.url_base + "utilities/get-utilities";
    let data = {
        year: this.utility.year,
        month: this.utility.month,
    };
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
           me.utility_detail_income = response.data.result.incomes;
           me.utility_detail_expense = response.data.result.expenses;
           me.utility.income_total_pen = response.data.result.total.income_pen;
           me.utility.income_total_usd = response.data.result.total.income_usd;
           me.utility.expense_total_pen = response.data.result.total.expense_pen;
           me.utility.expense_total_usd = response.data.result.total.expense_usd;
           me.utility.balance_total_pen = response.data.result.total.balance_pen;
           me.utility.balance_total_usd = response.data.result.total.balance_usd;
        }
        me.isLoading = false;
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}


function AddUtility() {

    let me = this;
    let url = this.url_base + "utilities/add";
    this.utility.id_user = this.muser.id_user;
    this.utility.utility_detail_income = this.utility_detail_income;
    this.utility.utility_detail_expense = this.utility_detail_expense;
    let data = this.utility;
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 201) {
            Swal.fire({ icon: 'success', text: response.data.message, timer: 3000})
            me.$router.push({name: "UtilityList" });
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
    
    this.errors.code = this.utility.code.length == 0 ? 'Ingrese un código':'';
    this.errors.year = this.utility.year.length == 0 ? 'Seleccione un año':'';
    this.errors.month = this.utility.month.length == 0 ? 'Seleccione un mes':'';
    this.errors.balance_total_pen = this.utility.balance_total_pen.length == 0 ? 'Ingrese un monto':'';
    this.errors.balance_total_usd = this.utility.balance_total_usd.length == 0 ? 'Ingrese un monto':'';


    if (this.errors.id_business.length > 0) this.validate = true;
    if (this.errors.code.length > 0) this.validate = true;
    if (this.errors.year.length > 0) this.validate = true;
    if (this.errors.month.length > 0) this.validate = true;
    if (this.errors.balance_total_pen.length > 0) this.validate = true;
    if (this.errors.balance_total_usd.length > 0) this.validate = true;

    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de registrar la utilidad?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.AddUtility();
      }
    });
}
</script>