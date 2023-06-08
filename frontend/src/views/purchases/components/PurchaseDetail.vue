<template>
  <div class="table-responsive">
    <table class="table table-hover table-striped table-bordered align-middle">
      <thead>
        <tr>
          <th width="5%" class="text-center">#</th>
          <th width="10%" class="text-center">Código</th>
          <th width="40%" class="text-center">Nombre</th>
          <th width="20%" class="text-center">Categoria</th>
          <th width="10%" class="text-center">Cantidad</th>
          <th width="10%" class="text-center">P. Unit</th>
          <th width="7%" class="text-center">P. Total</th>
          <th width="5%" class="text-center"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, it) in purchase_detail" :key="it">
          <td class="text-center">{{ it + 1 }}</td>
          <td class="text-center">{{ item.code }}</td>
          <td class="text-left">{{ item.name }}</td>
          <td class="text-left">{{ item.category_name }}</td>
          <td class="text-center">
            <input @change="UpdateProduct(it)" class="form-control text-end form-control-sm" type="number" step="any"  v-model="item.quantity" >
          </td>
          <td class="text-center">
            <input @change="UpdateProduct(it)" class="form-control text-end form-control-sm" type="number" step="any"  v-model="item.unit_price" >
          </td>
          <td class="text-center">
            {{ item.total_price }}
          </td>
          <td class="text-center">
            <b-button type="button" @click="DeleteProduct(it)" size="sm" variant="danger"
              ><font-awesome-icon title="Agregar" icon="fa-solid fa-trash" />
            </b-button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
const axios = require("axios").default;
const Swal = require("sweetalert2");
const je = require("json-encrypt");
var moment = require("moment");

import LoadingComponent from "@/views/pages/Loading";
import { computed } from "vue";
import { useStore } from "vuex";
import { mapActions } from "vuex";
export default {
  name: "UserAdd",
  components: {
    Keypress: () => import("vue-keypress"),
    LoadingComponent,
  },
  data() {
    return {
      modal_products: false,
      isLoading: false,
      module: "Purchase",
      role: "Add",
      search: "",
      products: [],
    };
  },
  mounted() {
  },

  methods: {
    UpdateProduct,
    DeleteProduct,
    ...mapActions(["LoadUpdatePurchaseDetail"]),
    ...mapActions(["LoadDeletePurchaseDetail"]),
  },
  setup() {
    const store = useStore();
    const user = window.localStorage.getItem("user");
    return {
      url_base: computed(() => store.state.url_base),
      purchase_detail: computed(() => store.state.purchase_detail),
      muser: JSON.parse(JSON.parse(je.decrypt(user))),
    };
  },
};

function UpdateProduct(index) {
  this.LoadUpdatePurchaseDetail(index);
}

function DeleteProduct(index) {
  this.LoadDeletePurchaseDetail(index);
}


</script>
