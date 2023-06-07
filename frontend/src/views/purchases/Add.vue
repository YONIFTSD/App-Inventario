<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo de Compras | Nuevo</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/compras/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">

                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Comprobante" :description="errors.type_invoice">
                            <b-form-select size="sm" v-model="purchase.type_invoice" :options="type_invoice"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Serie" :description="errors.serie">
                            <b-form-input class="text-center" size="sm" v-model="purchase.serie"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Numero" :description="errors.number">
                            <b-form-input class="text-center" size="sm" v-model="purchase.number"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Fecha Emisión" :description="errors.broadcast_date">
                            <b-form-input type="date" class="text-center" size="sm" v-model="purchase.broadcast_date"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Moneda" :description="errors.coin">
                            <b-form-select size="sm" v-model="purchase.coin" :options="coin"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Tipo de Operación" :description="errors.type_operation">
                            <b-form-select size="sm" v-model="purchase.type_operation" :options="type_operation"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Proveedor" :description="errors.id_provider">
                            <b-form-select size="sm" v-model="purchase.id_provider" :options="providers"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Observación">
                            <b-form-input size="sm"  v-model="purchase.observation"></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row class="justify-content-center">
                    <b-col md="2">
                        <b-form-group>
                            <b-button type="button" @click="ShowModalProducts" class="form-control" size="sm" variant="primary"><font-awesome-icon icon="fa-solid fa-floppy-disk" /> Productos</b-button>
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
  <ModalProducts />
</template>

<script>

const axios = require("axios").default;
const Swal = require("sweetalert2");
const je = require("json-encrypt");
var moment = require("moment");

import LoadingComponent from '@/views/pages/Loading'
import { computed } from 'vue'
import { useStore } from 'vuex'
import ModalProducts from '@/views/purchases/components/ModalProducts'
export default {
    name: 'UserAdd',
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
        ModalProducts,
    },
    data() {
      return {
        isLoading:false,
        module:'Purchase',
        role:'Add',
        purchase:{
            id_purchase: '',
            id_provider: '',
            type_invoice: '01',
            serie: '',
            number: '',
            broadcast_date: moment(new Date()).local().format("YYYY-MM-DD"),
            coin: 'PEN',
            type_operation: '02',
            observation: '',
            taxed_operation: '',
            exonerated_operation: '',
            unaffected_operation: '',
            igv: '',
            total: '',
            state: '1',
        },
        type_invoice:[
            {value:'NV',text:'Nota de Venta'},
            {value:'03',text:'Boleta de Venta'},
            {value:'01',text:'Factura'},
            {value:'ns',text:'Nota de Salida'},
        ],
        coin:[
            {value:'PEN',text:'Soles'},
            {value:'USD',text:'Dólares'},
        ],
        type_operation:[
            {value:'02',text:'Compra Nacional'},
            {value:'03',text:'Bonificación'},
            {value:'02',text:'Importación'},
            {value:'02',text:'Ajuste Por Diferencia de Inventario'},
        ],
        providers: [],
        errors:{
            id_provider:'',
            type_invoice:'',
            serie:'',
            number:'',
            broadcast_date:'',
            coin:'',
            type_operation:'',
        },
        validate: false,

      }
    },
    mounted() {

    },
    methods: {
        ListBusiness,
        GetCorrelative,
        ShowModalProducts,
        Validate,
        AddIncome,
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
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function GetCorrelative() {
    let me = this;
    let url = this.url_base + "data-manager/get-correlative-by-module/Income"
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
           me.purchase.code = response.data.result.number
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function ShowModalProducts() {
    this.emitter.emit('ShowModalProducts')
}


function AddIncome() {

    let me = this;
    let url = this.url_base + "incomes/add";
    this.purchase.id_user = this.muser.id_user;
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
            me.$router.push({name: "IncomeList" });
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

    this.errors.id_business = this.purchase.id_business.length == 0 ? 'Seleccione un gasto':'';
    this.errors.code = this.purchase.code.length == 0 ? 'Ingrese un código':'';
    this.errors.year = this.purchase.year.length == 0 ? 'Seleccione un año':'';
    this.errors.month = this.purchase.month.length == 0 ? 'Seleccione un mes':'';
    this.errors.total_pen = this.purchase.total_pen.length == 0 ? 'Ingrese un monto':'';
    this.errors.total_usd = this.purchase.total_usd.length == 0 ? 'Ingrese un monto':'';


    if (this.errors.id_business.length > 0) this.validate = true;
    if (this.errors.code.length > 0) this.validate = true;
    if (this.errors.year.length > 0) this.validate = true;
    if (this.errors.month.length > 0) this.validate = true;
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
        this.AddIncome();
      }
    });
}
</script>
