<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Tipo de Gasto | Ver</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/tipo-gasto/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form>
              
                <b-row class="justify-content-center">
                    <b-col md="5">
                        <b-form-group label="Nombre" :description="errors.name">
                            <b-form-input disabled size="sm" v-model="type_expense.name"></b-form-input>
                        </b-form-group> 
                    </b-col>

                    <b-col md="7">
                        <b-form-group label="Nombre" :description="errors.description">
                            <b-form-input disabled size="sm" v-model="type_expense.description"></b-form-input>
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
    props: ['id_type_expense'],
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'TypeExpense',
        role:'View',
        type_expense:{
            id_type_expense:'',
            name:'',
            description:'',
            state:'1',
        },
        errors:{
            id_type_expense:'',
            name:'',
            description:'',
        },
        validate: false,
        
      }
    },
    mounted() {
        this.ViewTypeExpense();
    },
    methods: {
        ViewTypeExpense,
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

function ViewTypeExpense() {
    let me = this;
    let id_type_expense = je.decrypt(me.id_type_expense);
    let url = this.url_base + "type-expense/view/"+ id_type_expense;
    me.isLoading = true;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.type_expense.id_type_expense = response.data.result.id_type_expense;
            me.type_expense.name = response.data.result.name;
            me.type_expense.description = response.data.result.description;
            me.type_expense.state = response.data.result.state;
        }
        me.isLoading = false;
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}

</script>