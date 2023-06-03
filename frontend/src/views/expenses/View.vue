<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo de Egresos | Ver</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/egresos/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form>
              
                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Código" :description="errors.code">
                            <b-form-input disabled class="text-center" size="sm" v-model="expense.code"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="4">
                        <b-form-group label="Tipo de Gasto" :description="errors.id_type_expense">
                            <b-form-select disabled size="sm" v-model="expense.id_type_expense" :options="type_expense"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Año" :description="errors.year">
                            <b-form-select disabled size="sm" v-model="expense.year" :options="year"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Mes" :description="errors.month">
                            <b-form-select disabled size="sm" v-model="expense.month" :options="month"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Medio de Pago" :description="errors.payment_method">
                            <b-form-select disabled size="sm" v-model="expense.payment_method" :options="payment_method"></b-form-select>
                        </b-form-group> 
                    </b-col>

                   <b-col md="2">
                        <b-form-group label="Moneda" :description="errors.coin">
                            <b-form-select disabled size="sm" v-model="expense.coin" :options="coin"></b-form-select>
                        </b-form-group> 
                    </b-col>
                    
                    <b-col md="2">
                        <b-form-group label="Tipo Cambio" :description="errors.exchange_rate">
                            <b-form-input disabled type="number" class="text-end" step="any" size="sm" v-model="expense.exchange_rate"></b-form-input>
                        </b-form-group> 
                    </b-col>
           
                    <b-col md="2">
                        <b-form-group label="Total" :description="errors.total">
                            <b-form-input disabled type="number" class="text-end" step="any" size="sm" v-model="expense.total"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Observación">
                            <b-form-input disabled size="sm"  v-model="expense.observation"></b-form-input>
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
    props: ['id_expense'],
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'Expense',
        role:'View',
        expense:{
            id_expense:'',
            id_user:'',
            id_type_expense:'',
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
        type_expense:[],
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
            id_type_expense:'',
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
        this.ViewExpense();
        this.ListTypeExpenses();
    },
    methods: {
        ListTypeExpenses,
        ViewExpense,
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

function ListTypeExpenses() {
    let me = this;
    let url = this.url_base + "data-manager/type-expenses"
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        me.type_expense = [{value:'', text: '-- Seleccione una opción --'}];
        if (response.data.status == 200) {
           response.data.result.map((item) => {
            me.type_expense.push({value: item.id_type_expense, text: item.name});
           }); 
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function ViewExpense() {
    let me = this;
    let id_expense = je.decrypt(me.id_expense);
    let url = this.url_base + "expenses/view/"+ id_expense;
    me.isLoading = true;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.expense.id_expense = response.data.result.id_expense;
            me.expense.id_user = response.data.result.id_user;
            me.expense.id_type_expense = response.data.result.id_type_expense;
            me.expense.code = response.data.result.code;
            me.expense.date = response.data.result.date;
            me.expense.year = response.data.result.year;
            me.expense.month = response.data.result.month;
            me.expense.payment_method = response.data.result.payment_method;
            me.expense.coin = response.data.result.coin;
            me.expense.observation = response.data.result.observation;
            me.expense.exchange_rate = response.data.result.exchange_rate;
            me.expense.total = response.data.result.total;
            me.expense.state = response.data.result.state;
        }
        me.isLoading = false;
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}

</script>