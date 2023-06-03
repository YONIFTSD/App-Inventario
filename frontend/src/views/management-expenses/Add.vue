<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo de Egreso Gerencial | Nuevo</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/egreso-gerencial/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">
              
                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Código" :description="errors.code">
                            <b-form-input readonly class="text-center" size="sm" v-model="expense.code"></b-form-input>
                        </b-form-group> 
                    </b-col>

                     <b-col md="4">
                        <b-form-group label="Descripción" :description="errors.description">
                            <b-form-input size="sm" v-model="expense.description"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Año" :description="errors.year">
                            <b-form-select size="sm" v-model="expense.year" :options="year"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Mes" :description="errors.month">
                            <b-form-select size="sm" v-model="expense.month" :options="month"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Medio de Pago" :description="errors.payment_method">
                            <b-form-select size="sm" v-model="expense.payment_method" :options="payment_method"></b-form-select>
                        </b-form-group> 
                    </b-col>

                   <b-col md="2">
                        <b-form-group label="Moneda" :description="errors.coin">
                            <b-form-select size="sm" v-model="expense.coin" :options="coin"></b-form-select>
                        </b-form-group> 
                    </b-col>
                    
                    <b-col md="2">
                        <b-form-group label="Tipo Cambio" :description="errors.exchange_rate">
                            <b-form-input type="number" class="text-end" step="any" size="sm" v-model="expense.exchange_rate"></b-form-input>
                        </b-form-group> 
                    </b-col>
           
                    <b-col md="2">
                        <b-form-group label="Total" :description="errors.total">
                            <b-form-input type="number" class="text-end" step="any" size="sm" v-model="expense.total"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Observación">
                            <b-form-input size="sm"  v-model="expense.observation"></b-form-input>
                        </b-form-group> 
                    </b-col>

             
                </b-row>
                
                <b-row class="justify-content-center">
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
        module:'ManagementExpense',
        role:'Add',
        expense:{
            id_expense:'',
            id_user:'',
            description:'',
            code:'',
            date:moment(new Date()).local().format("YYYY-MM-DD"),
            year:moment(new Date()).local().format("YYYY"),
            month:moment(new Date()).local().format("MM"),
            payment_method:'008',
            coin:'PEN',
            observation:'',
            exchange_rate:'1.00',
            total:'0.00',
            state:'1',
        },
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
            code:'',
            date:'',
            payment_method:'',
            observation:'',
            coin:'',
            exchange_rate:'',
            total:'',
        },
        validate: false,
        
      }
    },
    mounted() {
        this.GetCorrelative();
        this.GetExchangeRate();
    },
    methods: {
        GetCorrelative,
        Validate,
        AddManagementExpense,
        GetExchangeRate,
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

function GetExchangeRate() {
    let me = this;
    let url = this.url_base + "data-manager/get-exchange-rate/"+me.expense.date;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.expense.exchange_rate = response.data.result.venta;
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function GetCorrelative() {
    let me = this;
    let url = this.url_base + "data-manager/get-correlative-by-module/ManagementExpense"
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
           me.expense.code = response.data.result.number
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function AddManagementExpense() {

    let me = this;
    let url = this.url_base + "management-expenses/add";
    this.expense.id_user = this.muser.id_user;
    let data = this.expense;
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 201) {
            Swal.fire({ icon: 'success', text: response.data.message, timer: 3000})
            me.$router.push({name: "ManagementExpenseList" });

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
    
    this.errors.description = this.expense.description.length == 0 ? 'Ingrese una descripción':'';
    this.errors.code = this.expense.code.length == 0 ? 'Ingrese un código':'';
    this.errors.year = this.expense.year.length == 0 ? 'Seleccione un año':'';
    this.errors.month = this.expense.month.length == 0 ? 'Seleccione un mes':'';
    this.errors.payment_method = this.expense.payment_method.length == 0 ? 'Seleccione un medio de pago':'';
    this.errors.exchange_rate = this.expense.exchange_rate.length == 0 ? 'Ingrese un tipo de cambio':'';
    this.errors.total = this.expense.total.length == 0 ? 'Ingrese un monto':'';


    if (this.errors.description.length > 0) this.validate = true;
    if (this.errors.code.length > 0) this.validate = true;
    if (this.errors.year.length > 0) this.validate = true;
    if (this.errors.month.length > 0) this.validate = true;
    if (this.errors.payment_method.length > 0) this.validate = true;
    if (this.errors.exchange_rate.length > 0) this.validate = true;
    if (this.errors.total.length > 0) this.validate = true;

    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de registrar el egreso?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.AddManagementExpense();
      }
    });
}
</script>