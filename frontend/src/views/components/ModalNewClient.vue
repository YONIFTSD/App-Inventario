<template>
  <CRow>
    <b-modal id="modalPopover" hide-footer title="Nuevo Cliente" v-model="modal_client">
        <CCard class="mb-4">
            <CCardBody>
                <b-form @submit="Validate">
                
                    <b-row class="justify-content-center">

                        <b-col md="6">
                            <b-form-group label="Tipo Documento">
                                <b-form-select size="sm" :options="document_type" v-model="client.document_type"></b-form-select>
                            </b-form-group> 
                        </b-col>

                        <b-col md="6">
                            <b-form-group label="Nro Documento">
                                <b-form-input size="sm" v-model="client.document_number"></b-form-input>
                            </b-form-group> 
                        </b-col>

                        <b-col md="12">
                            <b-form-group label="Nombres" :description="errors.name">
                                <b-form-input size="sm" v-model="client.name"></b-form-input>
                            </b-form-group> 
                        </b-col>

                        <b-col md="8">
                            <b-form-group label="Email">
                                <b-form-input type="email" size="sm" v-model="client.email"></b-form-input>
                            </b-form-group> 
                        </b-col>
            
                        <b-col md="4">
                            <b-form-group label="Telefono">
                                <b-form-input size="sm" v-model="client.phone"></b-form-input>
                            </b-form-group> 
                        </b-col>

                  
                    </b-row>
                    
                    <b-row class="justify-content-center">
                        <b-col md="5">
                            <b-form-group>
                                <b-button class="form-control" size="sm" variant="primary" type="submit"><font-awesome-icon icon="fa-solid fa-floppy-disk" /> Guardar (F4)</b-button>
                            </b-form-group> 
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

import LoadingComponent from '@/views/pages/Loading'
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
    name: 'UserAdd',
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        modal_client: false, 
        isLoading:false,
        module:'Client',
        role:'Add',
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
        this.emitter.on('ModalNewClientShow', () => {
            this.client.id_client = '';
            this.client.document_type = '1';
            this.client.document_number = '';
            this.client.name = '';
            this.client.email = '';
            this.client.phone = '';
            this.client.state = '1';
            this.modal_client = true;
        })
      
    },
    
    methods: {
        Validate,
        AddClient,
      
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

function AddClient() {

    let me = this;
    let url = this.url_base + "clients/add";
    this.client.id_user = this.muser.id_user;
    let data = this.client;
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 201) {
            Swal.fire({ icon: 'success', text: response.data.message, timer: 3000})
            me.modal_client = false;
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
        this.AddClient();
      }
    });
}
</script>