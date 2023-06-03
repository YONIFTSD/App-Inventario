<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo de Usuario | Nuevo</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/usuario/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">
              
                <b-row class="justify-content-center">
                    <b-col md="6">
                        <b-form-group label="Nombres" :description="errors.name">
                            <b-form-input size="sm" v-model="user.name"></b-form-input>
                        </b-form-group> 
                    </b-col>
                </b-row>
                <b-row class="justify-content-center">
                    <b-col md="6">
                        <b-form-group label="Tipo de Usuario" :description="errors.id_user_type">
                            <b-form-select size="sm" :options="user_type" v-model="user.id_user_type"></b-form-select>
                        </b-form-group> 
                    </b-col>
                </b-row>
                <b-row class="justify-content-center">
                    <b-col md="6">
                        <b-form-group label="Email" :description="errors.email">
                            <b-form-input size="sm" type="email" v-model="user.email"></b-form-input>
                        </b-form-group> 
                    </b-col>
                </b-row>
                <b-row class="justify-content-center">
                    <b-col md="3">
                        <b-form-group label="Contraseña" :description="errors.password">
                            <b-form-input size="sm" type="password" v-model="user.password"></b-form-input>
                        </b-form-group> 
                    </b-col>
                    
                    <b-col md="3">
                        <b-form-group label="Usuario" :description="errors.user">
                            <b-form-input size="sm" v-model="user.user"></b-form-input>
                        </b-form-group> 
                    </b-col>
                </b-row>
                <b-row class="justify-content-center">
                    <b-col md="3">
                        <b-form-group label="Telefono">
                            <b-form-input size="sm" v-model="user.phone"></b-form-input>
                        </b-form-group> 
                    </b-col>
                    <b-col md="3">
                        <b-form-group label="Estado">
                            <b-form-select size="sm" v-model="user.state" :options="state"></b-form-select>
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
import { computed } from 'vue'
import { useStore } from 'vuex'
import LoadingComponent from '@/views/pages/Loading'
export default {
    name: 'UserAdd',
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'User',
        role:'Add',
        user_type:[],
        establishment:[],
        state:[
            {value:1,text:'Activo'},
            {value:0,text:'Inactivo'},
        ],
        user:{
            id_user:'',
            id_user_type:'',
            establishment:[],
            name:'',
            last_name:'',
            user:'',
            email:'',
            password:'',
            phone:'',
            state:'1',
        },
        user_type:[],
        errors:{
            establishment:'',
            id_user_type:'',
            name:'',
            user:'',
            email:'',
            password:'',
        },
        validate: false,
        
      }
    },
    mounted() {
        this.ListUserType();
    },
    methods: {
        Validate,
        AddUser,
        ListUserType,
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

function ListUserType() {
    let me = this;
    let url = this.url_base + "user-type/list-actives"
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
         me.user_type = [{value: '', text: '-- Seleccione un tipo de usuario --'}];
        if (response.data.status == 200) {
            for (let index = 0; index < response.data.result.length; index++) {
                const element = response.data.result[index];
                me.user_type.push({value: element.id_user_type, text: element.name});
            }
            
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function AddUser() {
    let me = this;
    let url = this.url_base + "user/add"
    let data = this.user;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 201) {
            me.user.id_user = '';
            me.user.id_user_type = '';
            me.user.name = '';
            me.user.last_name = '';
            me.user.user = '';
            me.user.email = '';
            me.user.password = '';
            me.user.phone = '';
            me.user.state = '1';
            Swal.fire({ icon: 'success', text: response.data.message, timer: 3000})
            me.$router.push({name: "UserList" });

        }else{
            Swal.fire({ icon: 'error', text: response.data.message, timer: 3000})
        }
    }).catch((error) => {
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function Validate() {
    this.validate = false;
   
    this.errors.name = this.user.name.length == 0 ? 'Ingrese un nombre':'';
    this.errors.user = this.user.user.length == 0 ? 'Ingrese un usuario':'';
    this.errors.id_user_type = this.user.id_user_type.length == 0 ? 'Seleccione un tipo de usuario':'';
    this.errors.email = this.user.email.length == 0 ? 'Ingrese un email':'';
    this.errors.password = this.user.password.length == 0 ? 'Ingrese una contraseña':'';


    if (this.errors.name.length > 0) this.validate = true;
    if (this.errors.user.length > 0) this.validate = true;
    if (this.errors.id_user_type.length > 0) this.validate = true;
    if (this.errors.email.length > 0) this.validate = true;
    if (this.errors.password.length > 0) this.validate = true;

    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de registrar el usuario?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.AddUser();
      }
    });
}
</script>