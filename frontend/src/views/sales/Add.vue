<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo de Ventas | Nuevo</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/ventas/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">

                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Comprobante" :description="errors.type_invoice">
                            <select @change="GetSeries" class="form-control form-control-sm" v-model="sale.type_invoice">
                              <option v-for="(item, it) in type_invoice" :key="it" :value="item.value">{{ item.text}}</option>
                            </select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Serie" :description="errors.id_serie">
                            <select class="form-control form-control-sm" v-model="sale.id_serie">
                              <option v-for="(item, it) in series" :key="it" :value="item.value">{{ item.text}}</option>
                            </select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Numero" :description="errors.number">
                            <b-form-input disabled class="text-center" size="sm" v-model="sale.number"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Fecha Emisión" :description="errors.broadcast_date">
                            <b-form-input type="date" class="text-center" size="sm" v-model="sale.broadcast_date"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Moneda" :description="errors.coin">
                            <b-form-select size="sm" v-model="sale.coin" :options="coin"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Tipo de Operación" :description="errors.type_operation">
                            <b-form-select size="sm" v-model="sale.type_operation" :options="type_operation"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Cliente" :description="errors.id_client">
                            <b-form-select size="sm" v-model="sale.id_client" :options="clients"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Observación">
                            <b-form-input size="sm"  v-model="sale.observation"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="12">
                      <SaleDetail />
                    </b-col>

                    <b-col md="9"> </b-col>
                    <b-col md="3">
                      <table class="table table-hover table-striped table-bordered align-middle">
                        <thead>
                          <tr>
                            <th class="text-start">Ope. Gravadas:</th>
                            <th class="text-end">{{sale_total.taxed_operation}}</th>
                          </tr>
                          <tr>
                            <th class="text-start">Ope. Exoneradas:</th>
                            <th class="text-end">{{sale_total.exonerated_operation}}</th>
                          </tr>
                          <tr>
                            <th class="text-start">Ope. Inafectas:</th>
                            <th class="text-end">{{sale_total.unaffected_operation}}</th>
                          </tr>
                          <tr>
                            <th class="text-start">IGV:</th>
                            <th class="text-end">{{sale_total.igv}}</th>
                          </tr>
                          <tr>
                            <th class="text-start">Total:</th>
                            <th class="text-end">{{sale_total.total}}</th>
                          </tr>
                        </thead>
                      </table>
                    </b-col>
                </b-row>

                <b-row class="justify-content-center">
                    <b-col md="2">
                        <b-form-group>
                            <b-button type="button" @click="ShowModalProducts" class="form-control" size="sm" variant="warning"><font-awesome-icon icon="fa-solid fa-floppy-disk" /> Productos</b-button>
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
import { mapActions } from "vuex";
import ModalProducts from '@/views/sales/components/ModalProducts'
import SaleDetail from '@/views/sales/components/SaleDetail'
export default {
    name: 'SaleAdd',
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
        ModalProducts,
        SaleDetail,
    },
    data() {
      return {
        isLoading:false,
        module:'Sale',
        role:'Add',
        sale:{
            id_sale: '',
            id_user: '',
            id_client: '',
            id_serie: '',
            type_invoice: '03',
            serie: '',
            number: '',
            broadcast_date: moment(new Date()).local().format("YYYY-MM-DD"),
            coin: 'PEN',
            type_operation: '01',
            observation: '',
            taxed_operation: '',
            exonerated_operation: '',
            unaffected_operation: '',
            igv: '',
            total: '',
            state: '1',
            sale_detail: [],
        },
        type_invoice:[
            {value:'NV',text:'Nota de Venta'},
            {value:'03',text:'Boleta de Venta'},
            {value:'01',text:'Factura'},
        ],
        series:[],
        coin:[
            {value:'PEN',text:'Soles'},
            {value:'USD',text:'Dólares'},
        ],
        type_operation:[
            {value:'01',text:'Venta Nacional'},
        ],
        clients: [],
        errors:{
            id_serie:'',
            id_client:'',
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
      this.LoadResetSale();
      this.ListClient();
      this.GetSeries();
    },
    methods: {
        GetSeries,
        GetSeriesById,
        ListClient,
        ShowModalProducts,
        Validate,
        AddSale,
        ...mapActions(["LoadResetSale"]),

    },
    setup() {
        const store = useStore()
        const user = window.localStorage.getItem("user");
        return {
            url_base: computed(() => store.state.url_base),
            sale_detail: computed(() => store.state.sale_detail),
            sale_total: computed(() => store.state.sale_total),

            muser: JSON.parse(JSON.parse(je.decrypt(user))),
        }
    },

}

function GetSeries() {

    let type_invoice = this.sale.type_invoice;
    let me = this;
    let url = this.url_base + "data/get-series/"+type_invoice;
    me.series = [];
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
           response.data.result.map((item) => {
            me.series.push({value: item.id_serie, text: item.serie});
            me.sale.id_serie = item.id_serie;
           });
           me.GetSeriesById();
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function GetSeriesById() {
    let me = this;
    let url = this.url_base + "data/get-series-by-id/"+this.sale.id_serie;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
           me.sale.number = response.data.result.number ;
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function ListClient() {
    let me = this;
    let url = this.url_base + "clients/list-active"
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        me.clients = [{value:'', text: '-- Seleccion un cliente --'}];
        if (response.data.status == 200) {
           response.data.result.map((item) => {
            me.clients.push({value: item.id_client, text: item.name+' - ' + item.document_number});
           });
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}


function ShowModalProducts() {
    this.emitter.emit('ShowModalProducts')
}

function AddSale() {

    let me = this;
    let url = this.url_base + "sales/add";
    this.sale.id_user = this.muser.id_user;
    this.sale.sale_detail = this.sale_detail;
    this.sale.taxed_operation = this.sale_total.taxed_operation;
    this.sale.exonerated_operation = this.sale_total.exonerated_operation;
    this.sale.unaffected_operation = this.sale_total.unaffected_operation;
    this.sale.igv = this.sale_total.igv;
    this.sale.total = this.sale_total.total;
    let data = this.sale;
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 201) {
            Swal.fire({ icon: 'success', text: response.data.message, timer: 3000})
            me.LoadResetSale();
            me.$router.push({name: "SaleList" });
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

    this.errors.id_client = this.sale.id_client.length == 0 ? 'Seleccione un cliente':'';
    this.errors.type_invoice = this.sale.type_invoice.length == 0 ? 'Seleccione un comprobante':'';
    this.errors.id_serie = this.sale.id_serie.length == 0 ? 'Seleccione una serie':'';
    this.errors.number = this.sale.number.length == 0 ? 'Ingrese un numero':'';
    this.errors.broadcast_date = this.sale.broadcast_date.length == 0 ? 'Ingrese una fecha':'';
    this.errors.type_operation = this.sale.type_operation.length == 0 ? 'Ingrese un tipo de Operación':'';


    if (this.errors.id_client.length > 0) this.validate = true;
    if (this.errors.type_invoice.length > 0) this.validate = true;
    if (this.errors.id_serie.length > 0) this.validate = true;
    if (this.errors.number.length > 0) this.validate = true;
    if (this.errors.broadcast_date.length > 0) this.validate = true;
    if (this.errors.type_operation.length > 0) this.validate = true;

    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de registrar la venta?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.AddSale();
      }
    });
}
</script>
