<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="12">
                    <strong>Modulo de Egresos | Listar</strong>
                </b-col>
            </b-row>
          
        </CCardHeader>
        <CCardBody>
            <b-row>
                <b-col md="4"></b-col>
                <b-col md="2">
                    <b-form-group label="Desde">
                        <b-form-input @change="ListExpense" type="date" class="text-center" :max="to" size="sm" v-model="from"></b-form-input>
                    </b-form-group> 
                </b-col>
                <b-col md="2">
                    <b-form-group label="Hasta">
                        <b-form-input @change="ListExpense" type="date" class="text-center" :min="from" size="sm" v-model="to"></b-form-input>
                    </b-form-group> 
                </b-col>
                <b-col md="3">
                    <b-form-group label=".">
                        <b-input-group>
                        <b-form-input @keyup="ListExpense" size="sm" type="search" v-model="search" class="form-control" ></b-form-input>
                        <b-input-group-append>
                            <b-button size="sm" variant="primary" @click="ListExpense">
                            <font-awesome-icon icon="fa-solid fa-magnifying-glass" />
                            </b-button>
                        </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col md="1">
                    <b-form-group v-if="Permission('ExpenseAdd')" label=".">
                        <b-link class="btn btn-sm form-control btn-primary" :to="{ path: '/egresos/nuevo' }" append title="Nuevo" ><font-awesome-icon icon="fa-solid fa-file-circle-plus" /></b-link >
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
                            <th width="8%" class="text-center text-white" >Mes</th>
                            <th width="7%" class="text-center text-white" >Código</th>
                            <th width="30%" class="text-center text-white" >Descripción</th>
                            <th width="15%" class="text-center text-white" >M. Pago</th>
                            <th width="5%" class="text-center text-white" >Moneda</th>
                            <th width="7%" class="text-center text-white" >Total</th>
                            <th width="7%" class="text-center text-white" >Usuario</th>
                            <th width="7%" class="text-center text-white" >Estado</th>
                            <th width="8%" class="text-center text-white" >Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, it) in data_table" :key="it">
                                <th class="text-center">{{ it + 1}}</th>
                                <td class="text-start">{{item.year + " - " +NameMonth(item.month)}}</td>
                                <td class="text-start">{{item.code}}</td>
                                <td class="text-start">{{item.type_expense_name}}</td>
                                <td class="text-start">{{ NameMethodPayment(item.payment_method) }}</td>
                                <td class="text-start">{{item.coin}}</td>
                                <td class="text-end">{{item.total}}</td>
                                <td class="text-start">{{item.user}}</td>
                                <td class="text-center">
                                    <b-badge v-if="item.state == 1" variant="success">Activo</b-badge>
                                    <b-badge v-if="item.state == 0" variant="danger">Inactivo</b-badge>
                                </td>
                                <td class="text-center">
                                    <b-dropdown variant="dark" dark right size="sm" text="Acciones">
                                        <b-dropdown-item v-if="Permission('ExpenseEdit')" @click="PageEdit(item.id_expense)"><font-awesome-icon title="Editar" icon="fa-solid fa-pen-to-square" /> Editar</b-dropdown-item>
                                        <b-dropdown-item v-if="Permission('ExpenseView')" @click="PageView(item.id_expense)"><font-awesome-icon title="Ver" icon="fa-solid fa-eye" /> Ver</b-dropdown-item>
                                        <b-dropdown-item v-if="Permission('ExpenseDelete')" @click="ConfirmDelete(item.id_expense)"><font-awesome-icon title="Eliminar" icon="fa-solid fa-trash-can" /> Eliminar</b-dropdown-item>
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
                    @click="ListExpense"
                    ></b-pagination>
                </b-col>     
            </b-row>
        </CCardBody>
      </CCard>
    </CCol>
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

export default {
    name: 'ExpenseList',
    data() {
      return {
        module:'Expense',
        role:'List',
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
        this.ListExpense();
    },
    methods: {
        ListExpense,
        PageEdit,
        PageView,
        ConfirmDelete,
        Delete,
        NameMethodPayment,
        NameMonth,
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

function NameMonth(code) {
  return CodeToName.NameMonth(code);
}

function NameMethodPayment(code) {
  return CodeToName.NameMethodPayment(code);
}

function ListExpense() {
    let me = this;
    let search = this.search == "" ? "all" : this.search;
    let url = this.url_base + "expenses/list/" + this.from+"/"+this.to +"/" + search + "?page=" + this.currentPage;
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

function PageEdit(id_expense) {
    this.$router.push({
        name: "ExpenseEdit",
        params: { id_expense: je.encrypt(id_expense) },
    });
}

function PageView(id_expense) {
    this.$router.push({
        name: "ExpenseView",
        params: { id_expense: je.encrypt(id_expense) },
    });
}

function ConfirmDelete(id_expense) {
    Swal.fire({
        title: "Esta seguro de eliminar el gasto?",
        text: "No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
        if (result.value) {
        this.Delete(id_expense);
        }
    });
}

function Delete(id_expense) {
    let me = this;
    let url = this.url_base + "expenses/delete/" + id_expense;
    axios({
        method: "delete",
        url: url,
        headers: {token: this.muser.api_token,module: this.module,role: 'Delete'},
    }).then(function (response) {
      if (response.data.status == 200) {
        const index = me.data_table.map(item => item.id_expense).indexOf(response.data.result.id_expense);
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