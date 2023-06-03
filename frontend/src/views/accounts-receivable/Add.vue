<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Cuentas por Cobrar | Nuevo</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/cuentas-por-cobrar/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">
              
                <b-row class="justify-content-center">

                    <b-col md="6">
                        <b-form-group :description="errors.id_client">
                            <label class="form-label bv-no-focus-ring col-form-label pt-0" for="id_client">Cliente: <b-badge @click="ModalNewClientShow" variant="primary">Nuevo</b-badge></label>
                            <Select2  v-model="account_receivable.id_client" placeholder="Seleccione un cliente"  :options="clients" :settings="settings" />
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Doc. Referencia">
                            <b-form-input size="sm" v-model="account_receivable.reference"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Fecha Emisión" :description="errors.broadcast_date">
                            <b-form-input type="date" size="sm" v-model="account_receivable.broadcast_date"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Fecha Vencimiento" :description="errors.expirate_date">
                            <b-form-input type="date" size="sm" v-model="account_receivable.expirate_date"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Observación">
                            <b-form-input size="sm" v-model="account_receivable.observation"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Moneda" :description="errors.coin">
                            <b-form-select size="sm" :options="coin" v-model="account_receivable.coin"></b-form-select>
                        </b-form-group> 
                    </b-col>
           
                    <b-col md="2">
                        <b-form-group label="Tipo de Cambio" :description="errors.exchange_rate">
                            <b-form-input class="text-end" size="sm" v-model="account_receivable.exchange_rate"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Total" :description="errors.total">
                            <b-form-input type="number" step="any" class="text-end" size="sm" v-model="account_receivable.total"></b-form-input>
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
    <ModalNewClient  />
  <!-- <Keypress key-event="keyup" :key-code="115" @success="Validate" /> -->
</template>

<script>

const axios = require("axios").default;
const Swal = require("sweetalert2");
const je = require("json-encrypt");
var moment = require("moment");



import Select2 from 'vue3-select2-component';

import LoadingComponent from '@/views/pages/Loading'
import ModalNewClient from '@/views/components/ModalNewClient'

import { computed } from 'vue'
import { useStore } from 'vuex'


export default {
    name: 'UserAdd',
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
        ModalNewClient,
        Select2,
    },
    data() {
      return {
        isLoading:false,
        module:'AccountReceivable',
        role:'Add',
        account_receivable:{
            id_account_receivable:'',
            id_client:'1',
            reference:'',
            observation:'',
            broadcast_date:moment(new Date()).local().format("YYYY-MM-DD"),
            expirate_date:moment(new Date()).local().format("YYYY-MM-DD"),
            coin:'USD',
            exchange_rate:'',
            total:'0.00',
            state:'1',
        },
        coin:[
            {text:'USD',value:'USD',},
            {text:'PEN', value:'PEN',},
        ],
        state:[
            {value:1,text:'Activo'},
            {value:0,text:'Inactivo'},
        ],
        clients:[{id:1,text:'Clientes Varios'}],
        settings: {
            ajax: {
                url: this.url_base + "clients/search-select",
                method: 'POST',
                dataType: "json",
                headers: {token:this.muser.api_token, module:'AccountReceivable', role:'Add'},
                data: params => {
                    return {
                        search: params.term,
                    };
                },
                processResults: (data) => {
                    return {
                        results: data,
                    };
                }
            }
        },
        
        errors:{
            id_client:'',
            reference:'',
            broadcast_date:'',
            expirate_date:'',
            coin:'',
            exchange_rate:'',
            total:'',
        },
        validate: false,
        
      }
    },
    mounted() {
        this.GetExchangeRate();
    },
    methods: {
        Validate,
        AddAccountReceivable,
        ModalNewClientShow,
        SearchClients,
        SelectClient,
        GetExchangeRate,
     
    },
    setup() {
        const store = useStore()
        const user = window.localStorage.getItem("user");
        
        return {
            url_base: computed(() => store.state.url_base),
            ip_address: computed(() => store.state.ip_address),
            muser: JSON.parse(JSON.parse(je.decrypt(user))),
            
        }
    },
    
}



function GetExchangeRate() {
    let me = this;
    let url = this.url_base + "data-manager/get-exchange-rate/"+me.account_receivable.broadcast_date;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.account_receivable.exchange_rate = response.data.result.venta;
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function SelectClient() {
    this.clients [ {id:11, text:'Roberto carlos -'}];
    this.client = 11;
}

function SearchClients(search) {
   let me = this;
    let url = this.url_base + "clients/search-select/" + search;
    if (search !== "") {
      loading(true);
      axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
      }).then(function (response) {
            me.clients = response.data.result;
            loading(false);
      })
    }
}

function ModalNewClientShow() {
    this.emitter.emit('ModalNewClientShow')
}

function AddAccountReceivable() {
    let me = this;
    let url = this.url_base + "accounts-receivable/add";
    this.account_receivable.id_user = this.muser.id_user;
    let data = this.account_receivable;
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 201) {
            Swal.fire({ icon: 'success', text: response.data.message, timer: 3000})
            me.$router.push({name: "AccountReceivableList" });
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
    this.errors.id_client = this.account_receivable.id_client.length == 0 ? 'Seleccione un cliente':'';
    this.errors.broadcast_date = this.account_receivable.broadcast_date.length == 0 ? 'Seleccione un cliente':'';
    this.errors.expirate_date = this.account_receivable.expirate_date.length == 0 ? 'Seleccione un cliente':'';
    this.errors.coin = this.account_receivable.coin.length == 0 ? 'Seleccione un cliente':'';
    this.errors.exchange_rate = this.account_receivable.exchange_rate.length == 0 ? 'Seleccione un cliente':'';
    this.errors.total = this.account_receivable.total.length == 0 ? 'Seleccione un cliente':'';
  
    if (this.errors.id_client.length > 0) this.validate = true;
    if (this.errors.broadcast_date.length > 0) this.validate = true;
    if (this.errors.expirate_date.length > 0) this.validate = true;
    if (this.errors.coin.length > 0) this.validate = true;
    if (this.errors.exchange_rate.length > 0) this.validate = true;
    if (this.errors.total.length > 0) this.validate = true;
   

    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de registrar la cuenta por cobrar?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.AddAccountReceivable();
      }
    });
}

function SendAudit(data) {
    let me = this;
    let url = this.url_base + "audit/add";


    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 201) {
            Swal.fire({ icon: 'success', text: response.data.message, timer: 3000})
            me.$router.push({name: "AccountReceivableList" });
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
</script>