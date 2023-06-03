<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Liquidación Diaria Ingresos | Nuevo</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/liquidacion-diaria-ingresos/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
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
                        <b-form-group label="Empresa" :description="errors.id_business">
                            <b-form-select size="sm" v-model="income.id_business" :options="business"></b-form-select>
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
                        <b-form-group label="Estado">
                            <b-form-select size="sm" v-model="income.state" :options="state"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Contado - Total PEN" :description="errors.counted_total_pen">
                            <input  @change="ChangeTotal" type="number" class="text-end form-control form-control-sm" step="any" v-model="income.counted_total_pen">
                        </b-form-group> 
                    </b-col>
           
                    <b-col md="2">
                        <b-form-group label="Contado - Total USD" :description="errors.counted_total_usd">
                            <input @change="ChangeTotal" type="number" class="text-end form-control form-control-sm" step="any" v-model.lazy="income.counted_total_usd">
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Tarjeta - Total PEN" :description="errors.credit_total_pen">
                            <input @change="ChangeTotal" type="number" class="text-end form-control form-control-sm" step="any" v-model.lazy="income.credit_total_pen">
                        </b-form-group> 
                    </b-col>
           
                    <b-col md="2">
                        <b-form-group label="Tarjeta - Total USD" :description="errors.credit_total_usd">
                            <input @change="ChangeTotal" type="number" class="text-end form-control form-control-sm" step="any" v-model.lazy="income.credit_total_usd">
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Total PEN" :description="errors.total_pen">
                            <b-form-input type="number" disabled class="text-end" step="any" size="sm" v-model="income.total_pen"></b-form-input>
                        </b-form-group> 
                    </b-col>
           
                    <b-col md="2">
                        <b-form-group label="Total USD" :description="errors.total_usd">
                            <b-form-input type="number" disabled class="text-end" step="any" size="sm" v-model="income.total_usd"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    

                    <b-col md="12">
                        <b-form-group label="Observación">
                            <b-form-input size="sm"  v-model="income.observation"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    
                </b-row>
                
                <b-row class="justify-content-center">
                    <b-col md="2">
                        <b-form-group>
                            <b-button type="button" @click="GetDailySettlementIncomeBusiness" class="form-control" size="sm" variant="primary"><font-awesome-icon icon="fa-solid fa-floppy-disk" /> Obtener Ingresos</b-button>
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

export default {
    name: 'UserAdd',
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'DailySettlementIncome',
        role:'Add',
        income:{
            id_expense:'',
            id_user:'',
            id_business:'',
            code:'',
            date:moment(new Date()).local().format("YYYY-MM-DD"),
            year:moment(new Date()).local().format("YYYY"),
            month:moment(new Date()).local().format("MM"),
            observation:'',
            exchange_rate:'1.00',
            counted_total_pen:'0.00',
            counted_total_usd:'0.00',
            credit_total_pen:'0.00',
            credit_total_usd:'0.00',
            total_pen:'0.00',
            total_usd:'0.00',
            state:'1',
        },
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
            counted_total_pen:'',
            counted_total_usd:'',
            credit_total_pen:'',
            credit_total_usd:'',
            total_pen:'',
            total_usd:'',
        },
        validate: false,
        
      }
    },
    mounted() {
        this.GetCorrelative();
        this.ListBusiness();
    },
    methods: {
        ListBusiness,
        GetCorrelative,
        GetDailySettlementIncomeBusiness,
        Validate,
        AddDailySettlementIncome,
        ChangeTotal,
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

function ChangeTotal() {
 
    this.income.counted_total_pen = this.income.counted_total_pen.length == 0 ? 0 : this.income.counted_total_pen;
    this.income.counted_total_usd = this.income.counted_total_usd.length == 0 ? 0 : this.income.counted_total_usd;
    this.income.credit_total_pen = this.income.credit_total_pen.length == 0 ? 0 : this.income.credit_total_pen;
    this.income.credit_total_usd = this.income.credit_total_usd.length == 0 ? 0 : this.income.credit_total_usd;


    this.income.total_pen = parseFloat(this.income.counted_total_pen) + parseFloat(this.income.credit_total_pen);
    this.income.total_usd = parseFloat(this.income.counted_total_usd) + parseFloat(this.income.credit_total_usd);

   this.income.counted_total_pen = parseFloat(this.income.counted_total_pen).toFixed(2);
   this.income.counted_total_usd = parseFloat(this.income.counted_total_usd).toFixed(2);
   this.income.credit_total_pen = parseFloat(this.income.credit_total_pen).toFixed(2);
   this.income.credit_total_usd = parseFloat(this.income.credit_total_usd).toFixed(2);
   this.income.total_pen = parseFloat(this.income.total_pen).toFixed(2);
   this.income.total_usd = parseFloat(this.income.total_usd).toFixed(2);

  
}

function ListBusiness() {
    let me = this;
    let url = this.url_base + "data-manager/list-business"
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        me.business = [{value:'', text: '-- Seleccione una opción --'}];
        if (response.data.status == 200) {
           response.data.result.map((item) => {
            me.business.push({value: item.id_business, text: item.name});
           }); 
        }
    }).catch((error) => {
        console.log(error)
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function GetCorrelative() {
    let me = this;
    let url = this.url_base + "data-manager/get-correlative-by-module/DailySettlementIncome"
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

function GetDailySettlementIncomeBusiness() {
    let me = this;
    let url = this.url_base + "daily-settlement-incomes/get-income-business";
    if (this.income.id_business.length == 0) {
        return false;
    }
    let data = {
        id_business: this.income.id_business,
        year: this.income.year,
        month: this.income.month,
    };
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
           me.income.counted_total_pen = response.data.result.counted_total_pen;
           me.income.counted_total_usd = response.data.result.counted_total_usd;

           me.income.credit_total_pen = response.data.result.credit_total_pen;
           me.income.credit_total_usd = response.data.result.credit_total_usd;

           me.income.total_pen = response.data.result.total_pen;
           me.income.total_usd = response.data.result.total_usd;
        }
        me.isLoading = false;
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}


function AddDailySettlementIncome() {

    let me = this;
    let url = this.url_base + "daily-settlement-incomes/add";
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
            me.$router.push({name: "DailySettlementIncomeList" });
        }else{
            Swal.fire({ icon: 'error', text: response.data.message, timer: 3000})
        }
        me.isLoading = false;
    }).catch((error) => {
        console.log(error)
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}

function Validate() {
    this.validate = false;
    
    this.errors.id_business = this.income.id_business.length == 0 ? 'Seleccione un gasto':'';
    this.errors.code = this.income.code.length == 0 ? 'Ingrese un código':'';
    this.errors.year = this.income.year.length == 0 ? 'Seleccione un año':'';
    this.errors.month = this.income.month.length == 0 ? 'Seleccione un mes':'';
    
    this.errors.counted_total_pen = this.income.counted_total_pen.length == 0 ? 'Ingrese un monto':'';
    this.errors.counted_total_usd = this.income.counted_total_usd.length == 0 ? 'Ingrese un monto':'';
    this.errors.credit_total_pen = this.income.credit_total_pen.length == 0 ? 'Ingrese un monto':'';
    this.errors.credit_total_usd = this.income.credit_total_usd.length == 0 ? 'Ingrese un monto':'';

    this.errors.total_pen = this.income.total_pen.length == 0 ? 'Ingrese un monto':'';
    this.errors.total_usd = this.income.total_usd.length == 0 ? 'Ingrese un monto':'';


    if (this.errors.id_business.length > 0) this.validate = true;
    if (this.errors.code.length > 0) this.validate = true;
    if (this.errors.year.length > 0) this.validate = true;
    if (this.errors.month.length > 0) this.validate = true;
    if (this.errors.counted_total_pen.length > 0) this.validate = true;
    if (this.errors.counted_total_usd.length > 0) this.validate = true;
    if (this.errors.credit_total_pen.length > 0) this.validate = true;
    if (this.errors.credit_total_usd.length > 0) this.validate = true;
    if (this.errors.total_pen.length > 0) this.validate = true;
    if (this.errors.total_usd.length > 0) this.validate = true;

    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de registrar el ingreso?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.AddDailySettlementIncome();
      }
    });
}
</script>