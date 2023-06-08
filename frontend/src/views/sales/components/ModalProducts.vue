<template>
  <CRow>
    <b-modal id="modalPopover" hide-footer title="BuscarProducto" size="lg" v-model="modal_products">
        <CCard class="mb-4">
            <CCardBody>
                <b-form>

                    <b-row class="justify-content-center">
                        <b-col md="12">
                            <b-form-group>
                                <b-form-input @keyup="SearchProduct" placeholder="Ingrese el codigo o nombre del producto" size="sm" v-model="search"></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <div class="table-responsive">
                      <table class="table table-hover table-striped table-bordered align-middle">
                        <thead>
                          <tr>
                            <th width="10%" class="text-center">Código</th>
                            <th width="38%" class="text-center">Nombre</th>
                            <th width="20%" class="text-center">Categoria</th>
                            <th width="8%" class="text-center">Stock</th>
                            <th width="15%" class="text-center">Cantidad</th>
                            <th width="7%" class="text-center"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item, it) in products" :key="it">
                            <td class="text-center">{{ item.code }}</td>
                            <td class="text-left">{{ item.name }}</td>
                            <td class="text-left">{{ item.category_name }}</td>
                            <td class="text-end">{{ item.stock }}</td>
                            <td class="text-center">
                              <b-form-input size="sm" :ref="'mPDQuantity'+it" class="form-control text-end" type="number" step="any" v-model="item.quantity"></b-form-input>
                            </td>
                            <td class="text-center">
                              <b-button type="button" @click="AddProduct(it)" size="sm" variant="info"><font-awesome-icon title="Agregar" icon="fa-solid fa-plus" /> </b-button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
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
import { mapActions } from 'vuex'
export default {
    name: 'SaleAdd',
    components: {
        Keypress: () => import('vue-keypress'),
        LoadingComponent,
    },
    data() {
      return {
        modal_products: false,
        isLoading:false,
        module:'Sale',
        role:'Add',
        search:'',
        products:[],
      }
    },
    mounted() {
        this.emitter.on('ShowModalProducts', () => {
            this.modal_products = true;
        })

    },

    methods: {
        SearchProduct,
        AddProduct,
        ...mapActions([
          'LoadAddSaleDetail',
        ]),

    },
    setup() {
        const store = useStore()
        const user = window.localStorage.getItem("user");
        return {
            url_base: computed(() => store.state.url_base),
            sale_detail: computed(() => store.state.sale_detail),
            muser: JSON.parse(JSON.parse(je.decrypt(user))),
        }
    },



}

function AddProduct(index) {

    let product = this.products[index];
    product.quantity = product.quantity.length == 0 ? 0 : product.quantity;
    let data = {
      id_product: product.id_product,
      code: product.code,
      name: product.name,
      igv: product.igv,
      category_name: product.category_name,
      quantity: parseFloat(product.quantity).toFixed(2),
      unit_price: parseFloat(0).toFixed(2),
      total_price: parseFloat(0).toFixed(2),
    }
    this.LoadAddSaleDetail(data);
}

function SearchProduct() {
    let me = this;
    let url = this.url_base + "products/search";
    let data = {
      search: this.search
    };
    me.isLoading = true;
    axios({
        method: "POST",
        url: url,
        data: data,
        headers: {token:this.muser.api_token, module:this.module, role:this.role},
    }).then(function (response) {
        if (response.data.status == 200) {
            me.products = response.data.result;
        }
        me.isLoading = false;
    }).catch((error) => {
        console.log(error)
        Swal.fire({ icon: 'error', text: 'A ocurrido un error', timer: 3000,})
        me.isLoading = false;
    });
}
</script>
