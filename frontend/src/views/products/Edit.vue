<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="10">
                    <strong>Modulo Producto | Editar</strong>
                </b-col>
                <b-col md="2">
                    <b-link :to="{ path: '/productos/listar' }" class="btn btn-sm form-control btn-primary" append title="Regresar" ><font-awesome-icon icon="fa-solid fa-circle-chevron-left" /> Regresar</b-link >
                </b-col>
            </b-row>
        </CCardHeader>
        <CCardBody>
            <b-form @submit="Validate">

                <b-row class="justify-content-center">

                    <b-col md="2">
                        <b-form-group label="Categoria" :description="errors.id_category">
                            <b-form-select size="sm" :options="categories" v-model="product.id_category"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Codigo" :description="errors.code">
                            <b-form-input size="sm" v-model="product.code"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="8">
                        <b-form-group label="Nombre" :description="errors.name">
                            <b-form-input size="sm" v-model="product.name"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Codigo Barras">
                            <b-form-input size="sm" v-model="product.barcode"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="IGV" :description="errors.igv">
                            <b-form-select size="sm" :options="igv" v-model="product.igv"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Unidad de Medida" :description="errors.unit_measure">
                            <b-form-select size="sm" :options="unit_measure" v-model="product.unit_measure"></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Precio Compra" :description="errors.purchase_price">
                            <b-form-input  type="number" step="any" class="text-end" size="sm" v-model="product.purchase_price"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Precio Venta" :description="errors.sale_price">
                            <b-form-input type="number" step="any" class="text-end" size="sm" v-model="product.sale_price"></b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col md="2">
                        <b-form-group label="Estado">
                            <b-form-select size="sm" v-model="product.state" :options="state"></b-form-select>
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
    props : ['id_product'],
    components: {
        LoadingComponent,
    },
    data() {
      return {
        isLoading:false,
        module:'Product',
        role:'Edit',
        product:{
            id_product:'',
            id_category:'',
            code:'',
            name:'',
            barcode:'',
            igv:'',
            unit_measure:'',
            purchase_price:'',
            sale_price:'',
            state:'1',
        },
        state:[
            {value:1,text:'Activo'},
            {value:0,text:'Inactivo'},
        ],
        categories:[],
        igv:[
          {value: '', text:'- Seleccione una opción -'},
          {value: '10', text:'Gravado'},
          {value: '20', text:'Exonerado'},
          {value: '30', text:'Inafecto'},
        ],
        unit_measure:[
            {value: '', text:'- Seleccione una opción -'},
            {value: '1', text:'Unidad'},
            {value: '2', text:'Kilogramos'},
            {value: '3', text:'Gramo'},
            {value: '4', text:'Litro'},
        ],
        errors:{
            id_category:'',
            code:'',
            name:'',
            igv:'',
            unit_measure:'',
            purchase_price:'',
            sale_price:'',
        },
        validate: false,

      }
    },
    mounted() {
      this.ListCategories();
      this.ViewProduct();
    },
    methods: {
        ViewProduct,
        Validate,
        EditProduct,
        ListCategories,
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
function ListCategories() {

    let me = this;
    let url = this.url_base + "categories/list-active";
    me.isLoading = true;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        me.categories = [{value:'', text:'- Seleccione una opcion -'}];
        if (response.data.status == 200) {
            response.data.result.forEach(element => {
              me.categories.push({value: element.id_category, text: element.name})
            });
        }
        me.isLoading = false;
    }).catch((error) => {
        console.log(error)
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}

function ViewProduct() {

    let me = this;
    let id_product = je.decrypt(me.id_product);
    let url = this.url_base + "products/view/"+id_product;
    me.isLoading = true;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.product.id_product = response.data.result.id_product;
            me.product.id_category = response.data.result.id_category;
            me.product.code = response.data.result.code;
            me.product.name = response.data.result.name;
            me.product.barcode = response.data.result.barcode;
            me.product.igv = response.data.result.igv;
            me.product.unit_measure = response.data.result.unit_measure;
            me.product.purchase_price = response.data.result.purchase_price;
            me.product.sale_price = response.data.result.sale_price;
            me.product.state = response.data.result.state;
        }
        me.isLoading = false;
    }).catch((error) => {
        console.log(error)
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}

function EditProduct() {

    let me = this;
    let url = this.url_base + "products/edit";
    this.product.id_user = this.muser.id_user;
    let data = this.product;
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

    this.errors.id_category = this.product.id_category.length == 0 ? 'Seleccione una categoria':'';
    this.errors.code = this.product.code.length == 0 ? 'Ingrese un codigo':'';
    this.errors.name = this.product.name.length == 0 ? 'Ingrese un nombre':'';
    this.errors.igv = this.product.igv.length == 0 ? 'Ingrese un igv':'';
    this.errors.unit_measure = this.product.unit_measure.length == 0 ? 'Seleccione una opción':'';
    this.errors.purchase_price = this.product.purchase_price.length == 0 ? 'Ingrese un precio':'';
    this.errors.sale_price = this.product.sale_price.length == 0 ? 'Ingrese un precio':'';

    if (this.errors.id_category.length > 0) this.validate = true;
    if (this.errors.code.length > 0) this.validate = true;
    if (this.errors.name.length > 0) this.validate = true;
    if (this.errors.igv.length > 0) this.validate = true;
    if (this.errors.unit_measure.length > 0) this.validate = true;
    if (this.errors.purchase_price.length > 0) this.validate = true;
    if (this.errors.sale_price.length > 0) this.validate = true;


    if (this.validate) {
        Swal.fire({ icon: 'warning', text: 'Verifique que campos necesarios esten llenados', timer: 2000,});
        return false;
    }

     Swal.fire({
      title: "Esta seguro de modificar el producto?",
      text: "",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, Estoy de acuerdo!",
    }).then((result) => {
      if (result.value) {
        this.EditProduct();
      }
    });
}
</script>
