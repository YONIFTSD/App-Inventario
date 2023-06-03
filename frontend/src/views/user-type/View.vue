<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Tipo de Usuario | Ver</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/tipos-de-usuario/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form>
              
                <b-row class="justify-content-center">
                    <b-col md="10">
                        <b-form-group label="Nombre" :description="errors.name">
                            <b-form-input disabled size="sm" v-model="user_type.name"></b-form-input>
                        </b-form-group> 
                    </b-col>
                    <b-col md="2">
                        <b-form-group label="Estado">
                            <b-form-select disabled size="sm" v-model="user_type.state" :options="state"></b-form-select>
                        </b-form-group> 
                    </b-col>
                </b-row>            
                <b-row class="justify-content-start">
                    <b-col class="mb-2" md="3" v-for="(item, it) in zone_privileges" :key="it">
                        <b-card :header="item.name"  :footer="item.group" >
                            <b-form-checkbox disabled v-for="(privilege, it1) in item.privileges" :key="it1" 
                                v-model="privilege.state" switch>
                            {{privilege.name}}
                            </b-form-checkbox>
                        </b-card>
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
import { computed } from 'vue'
import { useStore } from 'vuex'
import LoadingComponent from '@/views/pages/Loading'
export default {
    name: 'UserAdd',
    props: ["id_user_type"],
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'UserType',
        role:2,
        state:[
            {value:1,text:'Activo'},
            {value:0,text:'Inactivo'},
        ],
        user_type:{
            id_user_type:'',
            name:'',
            state:'1',
            zone_privileges:[],
        },
        zone_privileges:[],
        errors:{
            name:'',
        },
        validate: false,
        
      }
    },
    mounted() {
        this.ViewUserType();
    },
    methods: {
        ViewUserType,
       
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



function ViewUserType() {
    let me = this;
    let id_user_type = je.decrypt(me.id_user_type);
    let url = this.url_base + "user-type/view/"+id_user_type;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.user_type.id_user_type = response.data.result.user_type.id_user_type;
            me.user_type.name = response.data.result.user_type.name;
            me.user_type.state = response.data.result.user_type.state;
            me.zone_privileges = response.data.result.zone_privileges;
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}


</script>