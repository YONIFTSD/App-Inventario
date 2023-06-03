<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="12">
                    <strong>Modulo de Ingresos Gerenciales | Listar</strong>
                </b-col>
            </b-row>
          
        </CCardHeader>
        <CCardBody>
            <b-row>
                <b-col md="4"></b-col>
                <b-col md="2">
                    <b-form-group label="Desde">
                        <b-form-input @change="ListManagementIncome" type="date" class="text-center" :max="to" size="sm" v-model="from"></b-form-input>
                    </b-form-group> 
                </b-col>
                <b-col md="2">
                    <b-form-group label="Hasta">
                        <b-form-input @change="ListManagementIncome" type="date" class="text-center" :min="from" size="sm" v-model="to"></b-form-input>
                    </b-form-group> 
                </b-col>
                <b-col md="3">
                    <b-form-group label=".">
                        <b-input-group>
                        <b-form-input @keyup="ListManagementIncome" size="sm" type="search" v-model="search" class="form-control" ></b-form-input>
                        <b-input-group-append>
                            <b-button size="sm" variant="primary" @click="ListManagementIncome">
                            <font-awesome-icon icon="fa-solid fa-magnifying-glass" />
                            </b-button>
                        </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>
                <b-col md="1">
                    <b-form-group v-if="Permission('ManagementIncomeAdd')" label=".">
                        <b-link class="btn btn-sm form-control btn-primary" :to="{ path: '/ingreso-gerencial/nuevo' }" append title="Nuevo" ><font-awesome-icon icon="fa-solid fa-file-circle-plus" /></b-link >
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
                            <th width="7%" class="text-center text-white" >Total PEN</th>
                            <th width="7%" class="text-center text-white" >Total USD</th>
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
                                <td class="text-start">{{item.description}}</td>
                                <td class="text-start">{{ NameMethodPayment(item.payment_method) }}</td>
                                <td class="text-end">{{item.total_pen}}</td>
                                <td class="text-end">{{item.total_usd}}</td>
                                <td class="text-start">{{item.user}}</td>
                                <td class="text-center">
                                    <b-badge v-if="item.state == 1" variant="success">Activo</b-badge>
                                    <b-badge v-if="item.state == 0" variant="danger">Inactivo</b-badge>
                                </td>
                                <td class="text-center">
                                    <b-dropdown variant="dark" dark right size="sm" text="Acciones">
                                        <b-dropdown-item v-if="Permission('ManagementIncomeEdit')" @click="PageEdit(item.id_income)"><font-awesome-icon title="Editar" icon="fa-solid fa-pen-to-square" /> Editar</b-dropdown-item>
                                        <b-dropdown-item v-if="Permission('ManagementIncomeView')" @click="PageView(item.id_income)"><font-awesome-icon title="Ver" icon="fa-solid fa-eye" /> Ver</b-dropdown-item>
                                        <b-dropdown-item v-if="Permission('ManagementIncomeDelete')" @click="ConfirmDelete(item.id_income)"><font-awesome-icon title="Eliminar" icon="fa-solid fa-trash-can" /> Eliminar</b-dropdown-item>
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
                    @click="ListManagementIncome"
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
    name: 'ManagementIncomeList',
    data() {
      return {
        module:'ManagementIncome',
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
        this.ListManagementIncome();
    },
    methods: {
        ListManagementIncome,
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

function ListManagementIncome() {
    let me = this;
    let search = this.search == "" ? "all" : this.search;
    let url = this.url_base + "management-incomes/list/" + this.from+"/"+this.to +"/" + search + "?page=" + this.currentPage;
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

function PageEdit(id_income) {
    this.$router.push({
        name: "ManagementIncomeEdit",
        params: { id_income: je.encrypt(id_income) },
    });
}

function PageView(id_income) {
    this.$router.push({
        name: "ManagementIncomeView",
        params: { id_income: je.encrypt(id_income) },
    });
}

function ConfirmDelete(id_income) {
    Swal.fire({
        title: "Esta seguro de eliminar el ingreso gerencial?",
        text: "No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
        if (result.value) {
        this.Delete(id_income);
        }
    });
}

function Delete(id_income) {
    let me = this;
    let url = this.url_base + "management-incomes/delete/" + id_income;
    axios({
        method: "delete",
        url: url,
        headers: {token: this.muser.api_token,module: this.module,role: 'Delete'},
    }).then(function (response) {
      if (response.data.status == 200) {
        const index = me.data_table.map(item => item.id_income).indexOf(response.data.result.id_income);
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