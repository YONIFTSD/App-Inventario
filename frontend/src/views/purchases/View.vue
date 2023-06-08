<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo de Compras | Ver</strong>
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
                            <b-form-select size="sm" disabled v-model="purchase.type_invoice" :options="type_invoice"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Serie" :description="errors.serie">
                            <b-form-input disabled class="text-center" size="sm" v-model="purchase.serie"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Numero" :description="errors.number">
                            <b-form-input disabled class="text-center" size="sm" v-model="purchase.number"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Fecha Emisión" :description="errors.broadcast_date">
                            <b-form-input disabled type="date" class="text-center" size="sm" v-model="purchase.broadcast_date"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Moneda" :description="errors.coin">
                            <b-form-select disabled size="sm" v-model="purchase.coin" :options="coin"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Tipo de Operación" :description="errors.type_operation">
                            <b-form-select disabled size="sm" v-model="purchase.type_operation" :options="type_operation"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Proveedor" :description="errors.id_provider">
                            <b-form-select disabled size="sm" v-model="purchase.id_provider" :options="providers"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="6">
                        <b-form-group label="Observación">
                            <b-form-input disabled size="sm"  v-model="purchase.observation"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="12">
                      <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered align-middle">
                          <thead>
                            <tr>
                              <th width="5%" class="text-center">#</th>
                              <th width="10%" class="text-center">Código</th>
                              <th width="35%" class="text-center">Nombre</th>
                              <th width="20%" class="text-center">Categoria</th>
                              <th width="10%" class="text-center">Cantidad</th>
                              <th width="10%" class="text-center">P. Unit</th>
                              <th width="10%" class="text-center">P. Total</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(item, it) in purchase.purchase_detail" :key="it">
                              <td class="text-center">{{ it + 1 }}</td>
                              <td class="text-center">{{ item.code }}</td>
                              <td class="text-left">{{ item.name }}</td>
                              <td class="text-left">{{ item.category_name }}</td>
                              <td class="text-end">{{ item.quantity }}</td>
                              <td class="text-end">{{ item.unit_price }}</td>
                              <td class="text-end">{{ item.total_price }}</td>

                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </b-col>

                    <b-col md="9"> </b-col>
                    <b-col md="3">
                      <table class="table table-hover table-striped table-bordered align-middle">
                        <thead>
                          <tr>
                            <th class="text-start">Ope. Gravadas:</th>
                            <th class="text-end">{{purchase_total.taxed_operation}}</th>
                          </tr>
                          <tr>
                            <th class="text-start">Ope. Exoneradas:</th>
                            <th class="text-end">{{purchase_total.exonerated_operation}}</th>
                          </tr>
                          <tr>
                            <th class="text-start">Ope. Inafectas:</th>
                            <th class="text-end">{{purchase_total.unaffected_operation}}</th>
                          </tr>
                          <tr>
                            <th class="text-start">IGV:</th>
                            <th class="text-end">{{purchase_total.igv}}</th>
                          </tr>
                          <tr>
                            <th class="text-start">Total:</th>
                            <th class="text-end">{{purchase_total.total}}</th>
                          </tr>
                        </thead>
                      </table>
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
import ModalProducts from '@/views/purchases/components/ModalProducts'
import PurchaseDetail from '@/views/purchases/components/PurchaseDetail'
export default {
    name: 'PurchaseEdit',
    props: ['id_purchase'],
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
        ModalProducts,
        PurchaseDetail,
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
            purchase_detail: [],
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
      this.LoadResetPurchase();
      this.ListProvider();
      this.ViewPurchase();
    },
    methods: {
        ViewPurchase,
        ListProvider,
        ShowModalProducts,
        Validate,
        EditPurchase,
        ...mapActions(["LoadResetPurchase"]),
        ...mapActions(["LoadAddPurchaseDetail"]),

    },
    setup() {
        const store = useStore()
        const user = window.localStorage.getItem("user");
        return {
            url_base: computed(() => store.state.url_base),
            purchase_detail: computed(() => store.state.purchase_detail),
            purchase_total: computed(() => store.state.purchase_total),

            muser: JSON.parse(JSON.parse(je.decrypt(user))),
        }
    },

}

function ViewPurchase() {

    let me = this;
    let id_purchase = je.decrypt(me.id_purchase);
    let url = this.url_base + "purchases/view/"+id_purchase;
    me.isLoading = true;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.purchase.id_purchase = response.data.result.purchase.id_purchase;
            me.purchase.id_provider = response.data.result.purchase.id_provider;
            me.purchase.type_invoice = response.data.result.purchase.type_invoice;
            me.purchase.serie = response.data.result.purchase.serie;
            me.purchase.number = response.data.result.purchase.number;
            me.purchase.broadcast_date = response.data.result.purchase.broadcast_date;
            me.purchase.coin = response.data.result.purchase.coin;
            me.purchase.type_operation = response.data.result.purchase.type_operation;
            me.purchase.observation = response.data.result.purchase.observation;
            me.purchase.taxed_operation = response.data.result.purchase.taxed_operation;
            me.purchase.exonerated_operation = response.data.result.purchase.exonerated_operation;
            me.purchase.unaffected_operation = response.data.result.purchase.unaffected_operation;
            me.purchase.igv = response.data.result.purchase.igv;
            me.purchase.total = response.data.result.purchase.total;
            me.purchase.state = response.data.result.purchase.state;

            me.purchase.purchase_detail = response.data.result.purchase_detail;

        }
        me.isLoading = false;
    }).catch((error) => {
        console.log(error)
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}

function ListProvider() {
    let me = this;
    let url = this.url_base + "providers/list-active"
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        me.providers = [{value:'', text: '-- Seleccion un proveedor --'}];
        if (response.data.status == 200) {
           response.data.result.map((item) => {
            me.providers.push({value: item.id_provider, text: item.name+' - ' + item.document_number});
           });
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}


function ShowModalProducts() {
    this.emitter.emit('ShowModalProducts')
}

function EditPurchase() {

    let me = this;
    let url = this.url_base + "purchases/edit";
    this.purchase.id_user = this.muser.id_user;
    this.purchase.purchase_detail = this.purchase_detail;
    this.purchase.taxed_operation = this.purchase_total.taxed_operation;
    this.purchase.exonerated_operation = this.purchase_total.exonerated_operation;
    this.purchase.unaffected_operation = this.purchase_total.unaffected_operation;
    this.purchase.igv = this.purchase_total.igv;
    this.purchase.total = this.purchase_total.total;
    let data = this.purchase;
    me.isLoading = true;
    axios({
        method: "PUT",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            Swal.fire({ icon: 'success', text: response.data.message, timer: 3000})
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

    this.errors.id_provider = this.purchase.id_provider.length == 0 ? 'Seleccione un proveedor':'';
    this.errors.type_invoice = this.purchase.type_invoice.length == 0 ? 'Seleccione un comprobante':'';
    this.errors.serie = this.purchase.serie.length == 0 ? 'Ingrese una serie':'';
    this.errors.number = this.purchase.number.length == 0 ? 'Ingrese un numero':'';
    this.errors.broadcast_date = this.purchase.broadcast_date.length == 0 ? 'Ingrese una fecha':'';
    this.errors.type_operation = this.purchase.type_operation.length == 0 ? 'Ingrese un tipo de Operación':'';


    if (this.errors.id_provider.length > 0) this.validate = true;
    if (this.errors.type_invoice.length > 0) this.validate = true;
    if (this.errors.serie.length > 0) this.validate = true;
    if (this.errors.number.length > 0) this.validate = true;
    if (this.errors.broadcast_date.length > 0) this.validate = true;
    if (this.errors.type_operation.length > 0) this.validate = true;

    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de modificar la compra?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.EditPurchase();
      }
    });
}
</script>
