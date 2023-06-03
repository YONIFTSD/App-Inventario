<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo de Ingreso Gerencial | Nuevo</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/ingreso-gerencial/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">
              
                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Código" :description="errors.code">
                            <b-form-input readonly class="text-center" size="sm" v-model="income.code"></b-form-input>
                        </b-form-group> 
                    </b-col>

                     <b-col md="4">
                        <b-form-group label="Tipo de Ingreso" :description="errors.id_type_income">
                            <b-form-select size="sm" v-model="income.id_type_income" :options="type_income"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Año" :description="errors.year">
                            <b-form-select size="sm" v-model="income.year" :options="year"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Mes" :description="errors.month">
                            <b-form-select size="sm" v-model="income.month" :options="month"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Medio de Pago" :description="errors.payment_method">
                            <b-form-select size="sm" v-model="income.payment_method" :options="payment_method"></b-form-select>
                        </b-form-group> 
                    </b-col>

           
                    <b-col md="2">
                        <b-form-group label="Total PEN" :description="errors.total_pen">
                            <b-form-input type="number" class="text-end" step="any" size="sm" v-model="income.total_pen"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Total USD" :description="errors.total_usd">
                            <b-form-input type="number" class="text-end" step="any" size="sm" v-model="income.total_usd"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="8">
                        <b-form-group label="Observación">
                            <b-form-input size="sm"  v-model="income.observation"></b-form-input>
                        </b-form-group> 
                    </b-col>

             
                </b-row>
                
                <b-row class="justify-content-center">
                    <b-col md="2">
                        <b-form-group>
                            <b-button @click="GetBalanceByMonth" class="form-control" size="sm" variant="primary" type="button">Obtener Ingresos</b-button>
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
        module:'ManagementIncome',
        role:'Add',
        income:{
            id_income:'',
            id_user:'',
            id_type_income:'',
            description:'',
            code:'',
            date:moment(new Date()).local().format("YYYY-MM-DD"),
            year:moment(new Date()).local().format("YYYY"),
            month:moment(new Date()).local().format("MM"),
            payment_method:'008',
            observation:'',
            total_pen:'0.00',
            total_usd:'0.00',
            state:'1',
        },
        type_income:[],
        business:[],
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
        state:[
            {value:1,text:'Activo'},
            {value:0,text:'Inactivo'},
        ],
        coin:[
            {value:'PEN',text:'PEN'},
            {value:'USD',text:'USD'},
        ],
        payment_method:[
            {value:"008",text:'Efectivo'},
            {value:"001",text:'Depósito en cuenta'},
            {value:"002",text:'Giro'},
            {value:"003",text:'Transferencia de fondos'},
            {value:"004",text:'Orden de pago'},
            {value:"005",text:'Tarjeta de Débito'},
        ],
        errors:{
            description:'',
            id_type_income:'',
            code:'',
            date:'',
            payment_method:'',
            observation:'',
            total_pen:'',
            total_usd:'',
        },
        validate: false,
        
      }
    },
    mounted() {
        this.GetCorrelative();
        this.GetExchangeRate();
        this.ListTypeIncome();
     
    },
    methods: {
        ListTypeIncome,
        GetCorrelative,
        Validate,
        AddManagementIncome,
        GetExchangeRate,
        GetBalanceByMonth,
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

function ListTypeIncome() {
    let me = this;
    let url = this.url_base + "type-income/list-active";
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        me.type_income = [{value:'',text:'-- Seleccione una opcion --'}];
        if (response.data.status == 200) {
            for (let index = 0; index < response.data.result.length; index++) {
                const element = response.data.result[index];
                me.type_income.push({value:element.id_type_income,text:element.name});
            }
    
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function GetBalanceByMonth() {
     let me = this;
    let url = this.url_base + "management-incomes/get-balance-by-month";
    let data = {
        year:this.income.year,
        month:this.income.month,
        id_user:this.muser.id_user,
    };
    
    axios({
        method: "POST",
        url: url,
        data:data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.income.total_pen = response.data.result.total_balance_pen;
            me.income.total_usd = response.data.result.total_balance_usd;
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function GetExchangeRate() {
    let me = this;
    let url = this.url_base + "data-manager/get-exchange-rate/"+me.income.date;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.income.exchange_rate = response.data.result.venta;
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function GetCorrelative() {
    let me = this;
    let url = this.url_base + "data-manager/get-correlative-by-module/ManagementIncome"
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
           me.income.code = response.data.result.number
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function AddManagementIncome() {

    let me = this;
    let url = this.url_base + "management-incomes/add";
    this.income.id_user = this.muser.id_user;
    let data = this.income;
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 201) {
            Swal.fire({ icon: 'success', text: response.data.message, timer: 3000})
            me.$router.push({name: "ManagementIncomeList" });

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
    

    this.errors.id_type_income = this.income.id_type_income.length == 0 ? 'Seleccione un tipo de ingreso':'';
    this.errors.code = this.income.code.length == 0 ? 'Ingrese un código':'';
    this.errors.year = this.income.year.length == 0 ? 'Seleccione un año':'';
    this.errors.month = this.income.month.length == 0 ? 'Seleccione un mes':'';
    this.errors.payment_method = this.income.payment_method.length == 0 ? 'Seleccione un medio de pago':'';
    this.errors.total_pen = this.income.total_pen.length == 0 ? 'Ingrese un monto':'';
    this.errors.total_usd = this.income.total_usd.length == 0 ? 'Ingrese un monto':'';



    if (this.errors.id_type_income.length > 0) this.validate = true;
    if (this.errors.code.length > 0) this.validate = true;
    if (this.errors.year.length > 0) this.validate = true;
    if (this.errors.month.length > 0) this.validate = true;
    if (this.errors.payment_method.length > 0) this.validate = true;
    if (this.errors.total_pen.length > 0) this.validate = true;
    if (this.errors.total_usd.length > 0) this.validate = true;

    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de registrar el ingreso gerencial?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.AddManagementIncome();
      }
    });
}
</script>