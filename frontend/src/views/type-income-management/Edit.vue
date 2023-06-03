<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Tipo de Ingreso | Editar</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/tipo-ingreso/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">
              
                <b-row class="justify-content-center">

                    <b-col md="5">
                        <b-form-group label="Nombre" :description="errors.name">
                            <b-form-input size="sm" v-model="type_income.name"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="7">
                        <b-form-group label="Descripción" :description="errors.description">
                            <b-form-input size="sm" v-model="type_income.description"></b-form-input>
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
    props: ['id_type_income'],
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'TypeIncomeManagement',
        role:'Edit',
        type_income:{
            id_type_income:'',
            name:'',
            description:'',
            state:'1',
        },
        errors:{
            id_type_income:'',
            name:'',
            description:'',
        },
        validate: false,
        
      }
    },
    mounted() {
        this.ViewTypeIncome();
    },
    methods: {
        ViewTypeIncome,
        Validate,
        EditTypeIncome,
   
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

function ViewTypeIncome() {
    let me = this;
    let id_type_income = je.decrypt(me.id_type_income);
    let url = this.url_base + "type-income/view/"+ id_type_income;
    me.isLoading = true;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.type_income.id_type_income = response.data.result.id_type_income;
            me.type_income.name = response.data.result.name;
            me.type_income.description = response.data.result.description;
            me.type_income.state = response.data.result.state;
        }
        me.isLoading = false;
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}

function EditTypeIncome() {
    let me = this;
    let url = this.url_base + "type-income/edit";
    this.type_income.id_user = this.muser.id_user;
    let data = this.type_income;
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
    
    this.errors.name = this.type_income.name.length == 0 ? 'Ingrese un código':'';

    if (this.errors.name.length > 0) this.validate = true;


    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de modificar el tipo de ingreso?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.EditTypeIncome();
      }
    });
}
</script>