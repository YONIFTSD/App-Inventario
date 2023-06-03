<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Clientes | Ver</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/clientes/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form>
              
                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Tipo Documento">
                            <b-form-select disabled size="sm" :options="document_type" v-model="client.document_type"></b-form-select>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Nro Documento">
                            <b-form-input disabled size="sm" v-model="client.document_number"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="8">
                        <b-form-group label="Nombres">
                            <b-form-input disabled size="sm" v-model="client.name"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="8">
                        <b-form-group label="Email">
                            <b-form-input disabled type="email" size="sm" v-model="client.email"></b-form-input>
                        </b-form-group> 
                    </b-col>
           
                    <b-col md="2">
                        <b-form-group label="Telefono">
                            <b-form-input disabled size="sm" v-model="client.phone"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Estado">
                            <b-form-select disabled size="sm" v-model="client.state" :options="state"></b-form-select>
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
        role:'View',
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

</script>