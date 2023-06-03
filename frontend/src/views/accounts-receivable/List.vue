<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="12">
                    <strong>Modulo Cuentas Por Cobrar | Listar</strong>
                </b-col>
            </b-row>
          
        </CCardHeader>
        <CCardBody>
            <b-row>
                <b-col md="6"></b-col>
                <b-col md="2">
                    <b-form-group label="Estado">
                        <b-form-select @change="ListAccountReceivable" :options="states" size="sm" v-model="state"></b-form-select>
                    </b-form-group> 
                </b-col>
                <!-- <b-col md="2">
                    <b-form-group label="Desde">
                        <b-form-input @change="ListAccountReceivable" type="date" class="text-center" :max="to" size="sm" v-model="from"></b-form-input>
                    </b-form-group> 
                </b-col>
                <b-col md="2">
                    <b-form-group label="Hasta">
                        <b-form-input @change="ListAccountReceivable" type="date" class="text-center" :min="from" size="sm" v-model="to"></b-form-input>
                    </b-form-group> 
                </b-col> -->
                <b-col md="3">
                    <b-form-group label=".">
                        <b-input-group>
                        <b-form-input @keyup="ListAccountReceivable" size="sm" type="search" v-model="search" class="form-control" ></b-form-input>
                        <b-input-group-append>
                            <b-button size="sm" variant="primary" @click="ListAccountReceivable">
                            <font-awesome-icon icon="fa-solid fa-magnifying-glass" />
                            </b-button>
                        </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col md="1">
                    <b-form-group label="." v-if="Permission('AccountReceivableAdd')">
                        <b-link class="btn btn-sm form-control btn-primary" :to="{ path: '/cuentas-por-cobrar/nuevo' }" append title="Nuevo" ><font-awesome-icon icon="fa-solid fa-file-circle-plus" /></b-link >
                    </b-form-group>
                </b-col>

                <b-col md="12">
                    <br>
                </b-col>

                <b-col md="12">
                    <div class="table-responsive table-data">
                        <table class="table table-hover table-striped table-bordered align-middle ">
                        <thead class="table-dark">
                            <tr>
                            <th width="3%" class="text-center text-white" >#</th>
                            <th width="8%" class="text-center text-white" >Referencia</th>
                            <th width="40%" class="text-center text-white" >Cliente</th>
                            <th width="8%" class="text-center text-white" >Fecha Emision</th>
                            <th width="8%" class="text-center text-white" >Fecha Vcto</th>
                            <th width="7%" class="text-center text-white" >Moneda</th>
                            <th width="8%" class="text-center text-white" >Total</th>
                            <th width="8%" class="text-center text-white" >Saldo</th>
                            <th width="7%" class="text-center text-white" >Estado</th>
                            <th width="8%" class="text-center text-white" >Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, it) in data_table" :key="it">
                                <th class="text-center">{{ it + 1}}</th>
                                <td class="text-left">{{item.reference}}</td>
                                <td class="text-start">{{item.name + (item.document_number.length == 0 ? "" : " - "+item.document_number)}}</td>
                                <td class="text-center">{{item.broadcast_date}}</td>
                                <td class="text-center">{{item.expirate_date}}</td>
                                <td class="text-center">{{item.coin}}</td>
                                <td class="text-end">{{item.total}}</td>
                                <td class="text-end">{{item.balance}}</td>
                                <td class="text-center">
                                    <b-badge v-if="item.state == 2" variant="success">Cancelado</b-badge>
                                    <b-badge v-if="item.state == 1" variant="primary">Pendiente</b-badge>
                                    <b-badge v-if="item.state == 0" variant="danger">Anulado</b-badge>
                                </td>
                                <td class="text-center">
                                    <b-dropdown variant="dark" dark right size="sm" text="Acciones">
                                        <b-dropdown-item v-if="Permission('AccountReceivableEdit')" @click="ModalPaymentsShow(item.id_account_receivable)"><font-awesome-icon title="Editar" icon="fa-solid fa-pen-to-square" /> Pagos</b-dropdown-item>
                                        <b-dropdown-item v-if="Permission('AccountReceivableEdit')" @click="PageEdit(item.id_account_receivable)"><font-awesome-icon title="Editar" icon="fa-solid fa-pen-to-square" /> Editar</b-dropdown-item>
                                        <b-dropdown-item v-if="Permission('AccountReceivableView')" @click="PageView(item.id_account_receivable)"><font-awesome-icon title="Ver" icon="fa-solid fa-eye" /> Ver</b-dropdown-item>
                                        <b-dropdown-item v-if="Permission('AccountReceivableDelete')" @click="ConfirmDelete(item.id_account_receivable)"><font-awesome-icon title="Eliminar" icon="fa-solid fa-trash-can" /> Eliminar</b-dropdown-item>
                                    </b-dropdown>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </b-col>  

                <b-col md="12">
                    <b-pagination first-text="Primero" prev-text="Anterior" next-text="Siguiente" last-text="Último" align="center"
                    v-model="currentPage"
                    :total-rows="rows"
                    :per-page="perPage"
                    @click="ListAccountReceivable"
                    ></b-pagination>
                </b-col>     
            </b-row>
        </CCardBody>
      </CCard>
    </CCol>

    <ModalPayments/>
  </CRow>
</template>

<script>
const axios = require("axios").default;
const Swal = require("sweetalert2");
const je = require("json-encrypt");
var moment = require("moment");
import { computed } from 'vue'
import { useStore } from 'vuex'


import CodeToName from "@/assets/js/CodeToName";
import Permissions from "@/assets/js/Permissions";
import ModalPayments from '@/views/accounts-receivable/components/ModalPayments'

export default {
    name: 'ExpenseList',
    components: {
        ModalPayments,
    },
    data() {
      return {
        module:'AccountReceivable',
        role:'List',
        states:[
            {value:"all",text:'Todos'},
            {value:1,text:'Pendiente'},
            {value:2,text:'Cancelado'},
        ],
        state:"1",
        to:moment(new Date()).local().format("YYYY-MM-DD"),
        from:moment().subtract(30, 'days').local().format("YYYY-MM-DD"),
        search:'',
        data_table:[],

        rows: 0,
        perPage: 15,
        currentPage: 1,
        
      }
    },
    mounted() {

        this.emitter.on("ListAccountReceivable", () => {
            this.ListAccountReceivable();
        });
        this.ListAccountReceivable();
    },
    methods: {
        ListAccountReceivable,
        PageEdit,
        PageView,
        ConfirmDelete,
        Delete,
        NameDocumentType,
        ModalPaymentsShow,
        Permission,
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

function ModalPaymentsShow(id_account_receivable) {
    this.emitter.emit('ModalPaymentsShow',id_account_receivable)
}
function NameDocumentType(code) {
    return CodeToName.NameDocumentType(code);
}

function ListAccountReceivable() {
    let me = this;
    let search = this.search == "" ? "all" : this.search;
    let url = this.url_base + "accounts-receivable/list/" +this.state +"/" + search + "?page=" + this.currentPage;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.rows = response.data.result.total;
            me.data_table = response.data.result.data;
        } else {
            Swal.fire({ icon: 'error', text: response.data.message, timer: 3000,})
        }
        })
    .catch((error) => {
    Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function PageEdit(id_account_receivable) {
    this.$router.push({
        name: "AccountReceivableEdit",
        params: { id_account_receivable: je.encrypt(id_account_receivable) },
    });
}

function PageView(id_account_receivable) {
    this.$router.push({
        name: "AccountReceivableView",
        params: { id_account_receivable: je.encrypt(id_account_receivable) },
    });
}

function ConfirmDelete(id_account_receivable) {
    Swal.fire({
        title: "Esta seguro de eliminar la cuenta por pagar?",
        text: "No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
        if (result.value) {
        this.Delete(id_account_receivable);
        }
    });
}

function Delete(id_account_receivable) {
    let me = this;
    let url = this.url_base + "accounts-receivable/delete/" + id_account_receivable;
    axios({
        method: "delete",
        url: url,
        headers: {token: this.muser.api_token,module: this.module,role: 'Delete'},
    }).then(function (response) {
      if (response.data.status == 200) {
        const index = me.data_table.map(item => item.id_account_receivable).indexOf(response.data.result.id_account_receivable);
        me.data_table.splice(index, 1);
        Swal.fire({ icon: 'success', text: response.data.message, timer: 3000,})
      } else {
        Swal.fire({ icon: 'error', text: response.data.message, timer: 3000,})
      }
    }).catch((error) => {
      Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function Permission(Module) {
    return Permissions.Permission(Module);
}
</script>