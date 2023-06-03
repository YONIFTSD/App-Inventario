<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="12">
                    <strong>Modulo de Usuario | Listar</strong>
                </b-col>
            </b-row>
          
        </CCardHeader>
        <CCardBody>
            <b-row>
                <b-col md="8"></b-col>
                <b-col md="3">
                    <b-input-group>
                        <b-form-input @keyup="ListUser" size="sm" type="search" v-model="search" class="form-control" ></b-form-input>
                        <b-input-group-append>
                            <b-button size="sm" variant="primary" @click="ListUser">
                            <font-awesome-icon icon="fa-solid fa-magnifying-glass" />
                            </b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-col>
                <b-col v-if="Permission('UserAdd')" md="1">
                    <b-link class="btn btn-sm form-control btn-primary" :to="{ path: '/usuario/nuevo' }" append title="Nuevo" ><font-awesome-icon icon="fa-solid fa-file-circle-plus" /></b-link >
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
                            <th width="10%" class="text-center text-white" >Usuario</th>
                            <th width="35%" class="text-center text-white" >Nombres</th>
                            <th width="10%" class="text-center text-white" >Nivel</th>
                            <th width="30%" class="text-center text-white" >Email</th>
                            <th width="7%" class="text-center text-white" >Estado</th>
                            <th width="8%" class="text-center text-white" >Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, it) in data_table" :key="it">
                                <th class="text-center">{{ it + 1}}</th>
                                <td class="text-left">{{item.user}}</td>
                                <td class="text-left">{{item.name}}</td>
                                <td class="text-left">{{item.user_type_name}}</td>
                                <td class="text-left">{{item.email}}</td>
                                <td class="text-center">
                                    <b-badge v-if="item.state == 1" variant="success">Activo</b-badge>
                                    <b-badge v-if="item.state == 0" variant="danger">Inactivo</b-badge>
                                </td>
                                <td class="text-center">
                                    <b-dropdown variant="dark" dark right size="sm" text="Acciones">
                                        <b-dropdown-item v-if="Permission('UserEdit')" @click="PageEdit(item.id_user)"><font-awesome-icon title="Editar" icon="fa-solid fa-pen-to-square" /> Editar</b-dropdown-item>
                                        <b-dropdown-item v-if="Permission('UserView')" @click="PageView(item.id_user)"><font-awesome-icon title="Ver" icon="fa-solid fa-eye" /> Ver</b-dropdown-item>
                                        <b-dropdown-item v-if="Permission('UserDelete')" @click="ConfirmDelete(item.id_user)"><font-awesome-icon title="Eliminar" icon="fa-solid fa-trash-can" /> Eliminar</b-dropdown-item>
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
                    @click="ListUser"
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
import { computed } from 'vue'
import { useStore } from 'vuex'

import Permissions from "@/assets/js/Permissions";

export default {
    name: 'UserList',
    data() {
      return {
        module:'User',
        role:'List',
        search:'',
        data_table:[],

        rows: 0,
        perPage: 15,
        currentPage: 1,
        
      }
    },
    mounted() {
        this.ListUser();
    },
    methods: {
        ListUser,
        PageEdit,
        PageView,
        ConfirmDelete,
        Delete,
        Permission,
    },
    setup() {
        const store = useStore()
        const muser = window.localStorage.getItem("user");
        return {
            url_base: computed(() => store.state.url_base),
            muser: JSON.parse(JSON.parse(je.decrypt(muser))),
        }
    },
    
}

function ListUser() {
    let me = this;
    let search = this.search == "" ? "all" : this.search;
    let url = this.url_base + "user/list/" + search + "?page=" + this.currentPage;
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

function PageEdit(id_user) {
    this.$router.push({
        name: "UserEdit",
        params: { id_user: je.encrypt(id_user) },
    });
}

function PageView(id_user) {
    this.$router.push({
        name: "UserView",
        params: { id_user: je.encrypt(id_user) },
    });
}

function ConfirmDelete(id_user) {
    Swal.fire({
        title: "Esta seguro de eliminar el usuario?",
        text: "No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
        if (result.value) {
        this.Delete(id_user);
        }
    });
}

function Delete(id_user) {
    let me = this;
    let url = this.url_base + "user/delete/" + id_user;
    axios({
        method: "delete",
        url: url,
        headers: {token: this.muser.api_token,module: this.module,role: 'Delete'},
    }).then(function (response) {
      if (response.data.status == 200) {
        const index = me.data_table.map(item => item.id_user).indexOf(response.data.result.id_user);
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