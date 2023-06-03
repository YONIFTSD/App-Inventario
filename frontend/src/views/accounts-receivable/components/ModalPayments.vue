<template>
  <CRow>
    <b-modal size="xl" hide-footer :title="title_modal" v-model="modal_payment">
      <CCard class="mb-4">
        <CCardBody>
          <b-form @submit="Validate">
            <b-row class="justify-content-center">

              <b-col md="2">
                <b-form-group label="Total de la Cuenta">
                  <b-form-input type="number" disabled step="any" class="text-end" size="sm" v-model="account_receivable.total"></b-form-input>
                </b-form-group>
              </b-col>

              <b-col md="2">
                <b-form-group label="Saldo Pendiente">
                  <b-form-input type="number" disabled step="any" class="text-end" size="sm" v-model="account_receivable.balance"></b-form-input>
                </b-form-group>
              </b-col>

              <b-col md="2">
                <b-form-group label="Medio de Pago">
                  <b-form-select size="sm" :options="payment_method" v-model="payment.payment_method" ></b-form-select>
                </b-form-group>
              </b-col>

              <b-col md="2">
                <b-form-group label="Fecha de Pago" :description="errors.payment_date">
                  <b-form-input type="date" class="text-center"  size="sm" v-model="payment.payment_date"></b-form-input>
                </b-form-group>
              </b-col>

              

              <b-col md="2">
                <b-form-group label="Total a Pagar" :description="errors.total">
                  <b-form-input type="number" step="any" class="text-end" size="sm" v-model="payment.total"></b-form-input>
                </b-form-group>
              </b-col>

              <b-col md="2">
                <b-form-group label=".">
                  <b-button class="form-control" size="sm" variant="primary" type="submit"><font-awesome-icon icon="fa-solid fa-floppy-disk" /> Guardar(F4)</b-button>
                </b-form-group>
              </b-col>
            </b-row>

            <b-row>
              <b-col md="12">
                    <div class="table-responsive table-data">
                        <table class="table table-hover table-striped table-bordered align-middle ">
                        <thead class="table-dark">
                            <tr>
                            <th width="3%" class="text-center text-white" >#</th>
                            <th width="10%" class="text-center text-white" >Fecha</th>
                            <th width="40%" class="text-center text-white" >Medio de Pago</th>
                            <th width="10%" class="text-center text-white" >Total</th>
                            <th width="10%" class="text-center text-white" >Estado</th>
                            <th width="10%" class="text-center text-white" >Usuario</th>
                            <th width="10%" class="text-center text-white" >Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, it) in data_table" :key="it">
                                <th class="text-center">{{ it + 1}}</th>
                                <td class="text-center">{{item.payment_date}}</td>
                                <td class="text-start">{{ NameMethodPayment(item.payment_method) }}</td>
                                <td class="text-end">{{item.total}}</td>
                                <td class="text-start">{{item.user}}</td>
                                <td class="text-center">
                                    <b-badge v-if="item.state == 1" variant="primary">Activo</b-badge>
                                    <b-badge v-if="item.state == 0" variant="danger">Anulado</b-badge>
                                </td>
                                <td class="text-center">
                                    <b-dropdown variant="dark" dark right size="sm" text="Acciones">
                                        <b-dropdown-item @click="PageView(item.id_account_receivable_payment)"><font-awesome-icon title="Ver" icon="fa-solid fa-eye" /> Ver</b-dropdown-item>
                                        <b-dropdown-item @click="ConfirmDelete(item.id_account_receivable_payment)"><font-awesome-icon title="Eliminar" icon="fa-solid fa-trash-can" /> Eliminar</b-dropdown-item>
                                    </b-dropdown>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </b-col> 
            </b-row>
        
          </b-form>
        </CCardBody>
      </CCard>
    </b-modal>
  </CRow>

  <LoadingComponent :is-visible="isLoading" />
</template>

<script>
const axios = require("axios").default;
const Swal = require("sweetalert2");
const je = require("json-encrypt");
var moment = require("moment");

import LoadingComponent from "@/views/pages/Loading";
import { computed } from "vue";
import { useStore } from "vuex";

import CodeToName from "@/assets/js/CodeToName";

export default {
  name: "UserAdd",
  components: {
    Keypress: () => import("vue-keypress"),
    LoadingComponent,
  },
  data() {
    return {
      modal_payment: false,
      isLoading: false,
      module: "AccountReceivable",
      title_modal: "",
      role: 'List',
      account_receivable:{
        id_account_receivable:"",
        reference:"",
        coin:"",
        total:"",
        total_paid:"",
        balance:"",
      },
      payment: {
        id_account_receivable_payment: "",
        id_account_receivable: "",
        reference: "",
        payment_method: "008",
        payment_date: moment(new Date()).local().format("YYYY-MM-DD"),
        total: "0.00",
        state: "1",
      },
      data_table: [],
      state: [
        { value: 1, text: "Activo" },
        { value: 0, text: "Inactivo" },
      ],
          payment_method: [
          {value :"001", text :'DEPÓSITO EN CUENTA'},
          {value :"003", text :'TRANSFERENCIA DE FONDOS'},
          {value :"004", text :'ORDEN DE PAGO'},
          {value :"005", text :'TARJETA DE DÉBITO'},
          {value :"006", text :'TARJETA DE CRÉDITO'},
          {value :"007", text :'CHEQUES'},
          {value :"008", text :'EFECTIVO'},
      ],
      

      errors: {
        name: "",
      },
      validate: false,
    };
  },
  mounted() {
    this.emitter.on("ModalPaymentsShow", (id_account_receivable) => {
      this.account_receivable.id_account_receivable = id_account_receivable;
      this.payment.id_account_receivable_payment = "";
      this.payment.id_account_receivable = id_account_receivable;
      this.payment.id_user = "";
      this.payment.reference = "";
      this.payment.payment_method = "008";
      this.payment.payment_date = moment(new Date()).local().format("YYYY-MM-DD"),
      this.payment.total = "0.00";
      this.payment.state = "1";
      this.modal_payment = true;

      this.ViewAccountReceivable();
      this.ListPayment();
    });
  },

  methods: {
    Validate,
    AddPayment,
    EditPayment,
    ViewAccountReceivable,
    ListPayment,
    NameMethodPayment,

    PageView,
    ConfirmDelete,
    Delete,
  },
  setup() {
    const store = useStore();
    const user = window.localStorage.getItem("user");
    return {
      url_base: computed(() => store.state.url_base),
      muser: JSON.parse(JSON.parse(je.decrypt(user))),
    };
  },
};

function NameMethodPayment(code) {
  return CodeToName.NameMethodPayment(code);
}

function ViewAccountReceivable() {
    let me = this;
    let url = this.url_base + "accounts-receivable/view/"+this.account_receivable.id_account_receivable;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.account_receivable.id_account_receivable = response.data.result.id_account_receivable;
            me.account_receivable.id_client = response.data.result.id_client;
            me.account_receivable.reference = response.data.result.reference;
            me.account_receivable.observation = response.data.result.observation;
            me.account_receivable.broadcast_date = response.data.result.broadcast_date;
            me.account_receivable.expirate_date = response.data.result.expirate_date;
            me.account_receivable.coin = response.data.result.coin;
            me.account_receivable.exchange_rate = response.data.result.exchange_rate;
            me.account_receivable.total = response.data.result.total;
            me.account_receivable.balance = response.data.result.balance;
            me.account_receivable.state = response.data.result.state;
            me.payment.total = response.data.result.balance;
            me.title_modal = "Pagos de la Cuenta: "+response.data.result.name.toUpperCase() + " | " + (response.data.result.coin == "PEN" ? "NUEVOS SOLES" : "DOLARES AMERICANOS");
        }
    }).catch((error) => {
        console.log(error);
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function AddPayment() {
  let me = this;
  let url = this.url_base + "accounts-receivable-payment/add";
  this.payment.id_user = this.muser.id_user;
  let data = this.payment;
  me.isLoading = true;
  axios({
    method: "POST",
    url: url,
    data: data,
    headers: { token: this.muser.api_token, module: this.module, role: this.role },
  })
    .then(function (response) {
      if (response.data.status == 201) {
        
        me.payment.id_account_receivable_payment = "";
        me.payment.id_user = "";
        me.payment.reference = "";
        me.payment.payment_method = "008";
        me.payment.payment_date = moment(new Date()).local().format("YYYY-MM-DD"),
        me.payment.total = "0.00";
        me.payment.state = "1";
        me.ListPayment();
        me.ViewAccountReceivable();
        me.emitter.emit('ListAccountReceivable')
        Swal.fire({ icon: "success", text: response.data.message, timer: 3000 });
      } else {
        Swal.fire({ icon: "error", text: response.data.message, timer: 3000 });
      }
      me.isLoading = false;
    })
    .catch((error) => {
      console.log(error);
      Swal.fire({ icon: "error", text: "A ocurrido un error", timer: 3000 });
      me.isLoading = false;
    });
}

function EditPayment() {
  let me = this;
  let url = this.url_base + "accounts-receivable-payment/edit";
  this.payment.id_user = this.muser.id_user;
  let data = this.payment;
  me.isLoading = true;
  axios({
    method: "PUT",
    url: url,
    data: data,
    headers: { token: this.muser.api_token, module: this.module, role: this.role },
  })
    .then(function (response) {
      if (response.data.status == 200) {
        
        me.payment.id_account_receivable_payment = "";
        me.payment.id_user = "";
        me.payment.reference = "";
        me.payment.payment_method = "008";
        me.payment.payment_date = moment(new Date()).local().format("YYYY-MM-DD"),
        me.payment.state = "1";
        me.ListPayment();
        me.ViewAccountReceivable();
        me.emitter.emit('ListAccountReceivable')
        Swal.fire({ icon: "success", text: response.data.message, timer: 3000 });
      } else {
        Swal.fire({ icon: "error", text: response.data.message, timer: 3000 });
      }
      me.isLoading = false;
    })
    .catch((error) => {
      console.log(error);
      Swal.fire({ icon: "error", text: "A ocurrido un error", timer: 3000 });
      me.isLoading = false;
    });
}



function Validate() {
  this.validate = false;

  this.errors.id_account_receivable = this.payment.id_account_receivable.length == 0 ? "Ingrese una cuenta por cobrar" : "";
  this.errors.payment_date = this.payment.payment_date.length == 0 ? "Seleccione una fecha" : "";
  this.errors.total = this.payment.total.length == 0 || parseFloat(this.payment.total) <= 0 ? "Ingrese un total a cobrar" : "";

  if (this.errors.id_account_receivable.length > 0) this.validate = true;
  if (this.errors.payment_date.length > 0) this.validate = true;
  if (this.errors.total.length > 0) this.validate = true;

  if (this.validate) {
    Swal.fire({
      icon: "warning",
      text: "Verifique que campos necesarios esten llenados",
      timer: 2000,
    });
    return false;
  }

  if (this.payment.id_account_receivable_payment != "") {
    Swal.fire({
      title: "Esta seguro de modificar el pago?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.EditPayment();
      }
    });

  } else {
    Swal.fire({
      title: "Esta seguro de registrar el pago?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.AddPayment();
      }
    });
  }

  
}

function ListPayment() {
    let me = this;
    let url = this.url_base + "accounts-receivable-payment/list/" + this.account_receivable.id_account_receivable;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.data_table = response.data.result;
        } else {
            Swal.fire({ icon: 'error', text: response.data.message, timer: 3000,})
        }
        })
    .catch((error) => {
    Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function ConfirmDelete(id_account_receivable_payment) {
    Swal.fire({
        title: "Esta seguro de eliminar el pago?",
        text: "No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
        if (result.value) {
        this.Delete(id_account_receivable_payment);
        }
    });
}

function Delete(id_account_receivable_payment) {
    let me = this;
    let url = this.url_base + "accounts-receivable-payment/delete/" + id_account_receivable_payment;
    axios({
        method: "delete",
        url: url,
        headers: {token: this.muser.api_token,module: this.module,role: this.role},
    }).then(function (response) {
      if (response.data.status == 200) {
        const index = me.data_table.map(item => item.id_account_receivable_payment).indexOf(response.data.result.id_account_receivable_payment);
        me.data_table.splice(index, 1);
        me.ViewAccountReceivable();
        me.emitter.emit('ListAccountReceivable')
        Swal.fire({ icon: 'success', text: response.data.message, timer: 3000,})
      } else {
        Swal.fire({ icon: 'error', text: response.data.message, timer: 3000,})
      }
    }).catch((error) => {
      Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}


function PageView(id_account_receivable_payment) {
    let me = this;
    let url = this.url_base + "accounts-receivable-payment/view/"+id_account_receivable_payment;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.payment.id_account_receivable_payment = response.data.result.id_account_receivable_payment;
            me.payment.id_account_receivable = response.data.result.id_account_receivable;
            me.payment.id_user = response.data.result.id_user;
            me.payment.reference = response.data.result.reference;
            me.payment.payment_method = response.data.result.payment_method;
            me.payment.expirate_date = response.data.result.expirate_date;
            me.payment.total = response.data.result.total;
            me.payment.state = response.data.result.state;
        }
    }).catch((error) => {
        console.log(error);
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

</script>
