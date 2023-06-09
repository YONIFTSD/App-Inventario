<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
            <b-row>
                <b-col md="12">
                    <strong>Modulo Kardex</strong>
                </b-col>
            </b-row>

        </CCardHeader>
        <CCardBody>
            <b-row class="justify-content-center">
                  <b-col md="5">
                      <b-form-group label="Producto" :description="errors.id_product">
                          <b-form-select size="sm" :options="products" v-model="kardex.id_product"></b-form-select>
                      </b-form-group>
                  </b-col>
                  <b-col md="2">
                      <b-form-group label="Hasta" :description="errors.to">
                          <b-form-input class="text-center" size="sm" v-model="kardex.to" type="date"></b-form-input>
                      </b-form-group>
                  </b-col>

                <b-col md="2">
                    <b-form-group label=".">
                       <b-button @click="GetMovementByProduct" size="sm" class="form-control" type="button" variant="primary">Buscar</b-button>
                    </b-form-group>
                </b-col>
                <b-col md="12">
                    <br>
                </b-col>

                <b-col md="12">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered align-middle ">
                        <thead>
                            <tr>
                              <th  class="text-center" width="40%" colspan="4">Documento de traslado, comprobante de pago, documento interno o similar</th>
                              <th  class="text-center" width="6%" rowspan="2">Tipo Operación</th>
                              <th  class="text-center" width="18%" colspan="3">Entrada</th>
                              <th  class="text-center" width="18%" colspan="3">Salida</th>
                              <th  class="text-center" width="18%" colspan="3">S. Final</th>
                            </tr>
                            <tr>
                              <th class="text-center" >Fecha</th>
                              <th class="text-center" >Tipo</th>
                              <th class="text-center" >Serie</th>
                              <th class="text-center" >Numero</th>
                              <th class="text-center" >Cant.</th>
                              <th class="text-center" >C. Unit.</th>
                              <th class="text-center" >C. Total</th>
                              <th class="text-center" >Cant.</th>
                              <th class="text-center" >C. Unit.</th>
                              <th class="text-center" >C. Total</th>
                              <th class="text-center" >Cant.</th>
                              <th class="text-center" >C. Unit.</th>
                              <th class="text-center" >C. Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, it) in movement" :key="it">
                                <td class="text-center">{{item.broadcast_date}}</td>
                                <td class="text-center">{{item.type_invoice}}</td>
                                <td class="text-center">{{item.serie}}</td>
                                <td class="text-center">{{item.number}}</td>
                                <td class="text-center">{{item.type_operation}}</td>
                                <td class="text-end">{{item.input_quantity}}</td>
                                <td class="text-end">{{item.input_unit_price}}</td>
                                <td class="text-end">{{item.input_total_price}}</td>
                                <td class="text-end">{{item.output_quantity}}</td>
                                <td class="text-end">{{item.output_unit_price}}</td>
                                <td class="text-end">{{item.output_total_price}}</td>
                                <td class="text-end">{{item.balance_quantity}}</td>
                                <td class="text-end">{{item.balance_unit_price}}</td>
                                <td class="text-end">{{item.balance_total_price}}</td>

                            </tr>
                        </tbody>
                        </table>
                    </div>
                </b-col>


            </b-row>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
const axios = require("axios").default;
const Swal = require("sweetalert2");
const je = require("json-encrypt");
var moment = require("moment");
import { computed } from 'vue'
import { useStore } from 'vuex'


import CodeToName from "@/assets/js/CodeToName";
import Permissions from "@/assets/js/Permissions";

export default {
    name: 'ProductList',
    data() {
      return {
        module:'Kardex',
        role:'List',
        to:moment(new Date()).local().format("YYYY-MM-DD"),
        from:moment().subtract(30, 'days').local().format("YYYY-MM-DD"),
        search:'',
        data_table:[],
        products:[],
        movement:[],
        kardex:{
          id_product:'',
          to:moment(new Date()).local().format("YYYY-MM-DD"),
        },
        errors:{
          id_product:'',
        },

        rows: 0,
        perPage: 15,
        currentPage: 1,

      }
    },
    mounted() {
      this.ListProducts();
    },
    methods: {
        GetMovementByProduct,
        ListProducts,
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


function GetMovementByProduct() {
    let me = this;
    let url = this.url_base + "kardex/get-movement-by-product/" + this.kardex.id_product + "/" + this.kardex.to;
    axios({
        method: "GET",
        url: url,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.movement = response.data.result;
        }
        })
    .catch((error) => {
    Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

function ListProducts() {
    let me = this;
    let url = this.url_base + "products/list-actives";
    axios({
        method: "get",
        url: url,
        headers: {token: this.muser.api_token,module: this.module,role: 'Delete'},
    }).then(function (response) {
      if (response.data.status == 200) {
        me.products = [{value:'',text:'- Seleccione un producto -'}];
        response.data.result.forEach(element => {
          me.products.push({ value:element.id_product,text: element.name+' - '+ element.code })
        });

      }
    }).catch((error) => {
      Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
    });
}

</script>
