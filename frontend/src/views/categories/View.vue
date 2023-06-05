<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Categoria | Ver</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/categorias/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form>

                <b-row class="justify-content-center">

                  <b-col md="10">
                        <b-form-group label="Nombre">
                            <b-form-input size="sm" disabled v-model="category.name"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Estado">
                            <b-form-select size="sm" disabled v-model="category.state" :options="state"></b-form-select>
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
    props: ['id_category'],
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'Category',
        role:'View',
        category:{
            id_category:'',
            name:'',
            state:'1',
        },
        state:[
            {value:1,text:'Activo'},
            {value:0,text:'Inactivo'},
        ],
        errors:{
            name:'',
        },
        validate: false,

      }
    },
    mounted() {
        this.ViewCategory();
    },
    methods: {
        ViewCategory,
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

function ViewCategory() {
    let me = this;
    let id_category = je.decrypt(me.id_category);
    let url = this.url_base + "categories/view/"+id_category;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.category.id_category = response.data.result.id_category;
            me.category.name = response.data.result.name;
            me.category.state = response.data.result.state;
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

</script>
