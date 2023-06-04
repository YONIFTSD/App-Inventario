<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Proveedor | Ver</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/proveedores/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form>

                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Tipo Documento">
                            <b-form-select disabled size="sm" :options="document_type" v-model="provider.document_type"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Nro Documento">
                            <b-form-input disabled size="sm" v-model="provider.document_number"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="8">
                        <b-form-group label="Nombres">
                            <b-form-input disabled size="sm" v-model="provider.name"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="8">
                        <b-form-group label="Email">
                            <b-form-input disabled type="email" size="sm" v-model="provider.email"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Telefono">
                            <b-form-input disabled size="sm" v-model="provider.phone"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Estado">
                            <b-form-select disabled size="sm" v-model="provider.state" :options="state"></b-form-select>
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
    props: ['id_provider'],
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'Provider',
        role:'View',
        provider:{
            id_provider:'',
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
        this.ViewProvider();
    },
    methods: {
        ViewProvider,
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

function ViewProvider() {
    let me = this;
    let id_provider = je.decrypt(me.id_provider);
    let url = this.url_base + "providers/view/"+id_provider;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.provider.id_provider = response.data.result.id_provider;
            me.provider.document_type = response.data.result.document_type;
            me.provider.document_number = response.data.result.document_number;
            me.provider.name = response.data.result.name;
            me.provider.email = response.data.result.email;
            me.provider.phone = response.data.result.phone;
            me.provider.state = response.data.result.state;
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

</script>
