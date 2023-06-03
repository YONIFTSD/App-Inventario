<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Proveedor | Editar</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/clientes/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">

                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Tipo Documento">
                            <b-form-select size="sm" :options="document_type" v-model="client.document_type"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Nro Documento">
                            <b-form-input size="sm" v-model="client.document_number"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="8">
                        <b-form-group label="Nombres" :description="errors.name">
                            <b-form-input size="sm" v-model="client.name"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="8">
                        <b-form-group label="Email">
                            <b-form-input type="email" size="sm" v-model="client.email"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Telefono">
                            <b-form-input size="sm" v-model="client.phone"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Estado">
                            <b-form-select size="sm" v-model="client.state" :options="state"></b-form-select>
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
    props: ['id_client'],
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'Client',
        role:'Edit',
        client:{
            id_client:'',
            document_type:'1',
            document_number:'',
            name:'',
            email:'',
            phone:'',
            state:'1',
        },
        state:[
            {value:1,text:'Activo'},
            {value:0,text:'Inactivo'},
        ],
        document_type:[
            {value:'1',text:'DNI'},
            {value:'6',text:'RUC'},
            {value:'0',text:'OTROS'},
        ],

        errors:{
            name:'',
        },
        validate: false,

      }
    },
    mounted() {
        this.ViewClient();
    },
    methods: {
        ViewClient,
        Validate,
        EditClient,
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

function ViewClient() {
    let me = this;
    let id_client = je.decrypt(me.id_client);
    let url = this.url_base + "clients/view/"+id_client;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.client.id_client = response.data.result.id_client;
            me.client.document_type = response.data.result.document_type;
            me.client.document_number = response.data.result.document_number;
            me.client.name = response.data.result.name;
            me.client.email = response.data.result.email;
            me.client.phone = response.data.result.phone;
            me.client.state = response.data.result.state;
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function EditClient() {

    let me = this;
    let url = this.url_base + "clients/edit";
    this.client.id_user = this.muser.id_user;
    let data = this.client;
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
        console.log(error)
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}

function Validate() {
    this.validate = false;

    this.errors.name = this.client.name.length == 0 ? 'Ingrese un nombre':'';

    if (this.errors.name.length > 0) this.validate = true;


    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de registrar el cliente?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.EditClient();
      }
    });
}
</script>
