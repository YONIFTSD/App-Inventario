<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Tipo de Ingreso | Ver</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/tipo-ingreso/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form>
              
                <b-row class="justify-content-center">
                    <b-col md="5">
                        <b-form-group label="Nombre" :description="errors.name">
                            <b-form-input disabled size="sm" v-model="type_income.name"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="7">
                        <b-form-group label="Nombre" :description="errors.description">
                            <b-form-input disabled size="sm" v-model="type_income.description"></b-form-input>
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
        role:'View',
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

</script>