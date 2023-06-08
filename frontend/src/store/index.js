import { createStore } from 'vuex'
const axios = require('axios').default

export default createStore({
  state: {
    url_base: 'http://localhost:8000/',
    sidebarVisible: true,
    sidebarUnfoldable: true,

    purchase_detail: [],
    purchase_total: {
      taxed_operation: parseFloat(0).toFixed(2),
      exonerated_operation: parseFloat(0).toFixed(2),
      unaffected_operation: parseFloat(0).toFixed(2),
      igv: parseFloat(0).toFixed(2),
      total: parseFloat(0).toFixed(2),
    },
    sale_detail: [],
    sale_total: {
      taxed_operation: parseFloat(0).toFixed(2),
      exonerated_operation: parseFloat(0).toFixed(2),
      unaffected_operation: parseFloat(0).toFixed(2),
      igv: parseFloat(0).toFixed(2),
      total: parseFloat(0).toFixed(2),
    },
  },
  mutations: {
    toggleSidebar(state) {
      state.sidebarVisible = !state.sidebarVisible
    },
    toggleUnfoldable(state) {
      state.sidebarUnfoldable = !state.sidebarUnfoldable
    },
    updateSidebarVisible(state, payload) {
      state.sidebarVisible = payload.value
    },
    //compras
    AddPurchaseDetail(state, product){
      state.purchase_detail.push( product);
    },
    DeletePurchaseDetail(state, index){
      state.purchase_detail.splice(index, 1);
    },
    UpdateTotalPurchaseDetail(state, total){
      state.purchase_total = total;
    },
    ResetPurchaseDetail(state){
      state.purchase_total = {
        taxed_operation: parseFloat(0).toFixed(2),
        exonerated_operation: parseFloat(0).toFixed(2),
        unaffected_operation: parseFloat(0).toFixed(2),
        igv: parseFloat(0).toFixed(2),
        total: parseFloat(0).toFixed(2),
      };
      state.purchase_detail = [];
    },
    //ventas
    AddSaleDetail(state, product){
      state.sale_detail.push( product);
    },
    DeleteSaleDetail(state, index){
      state.sale_detail.splice(index, 1);
    },
    UpdateTotalSaleDetail(state, total){
      state.sale_total = total;
    },
    ResetSaleDetail(state){
      state.sale_total = {
        taxed_operation: parseFloat(0).toFixed(2),
        exonerated_operation: parseFloat(0).toFixed(2),
        unaffected_operation: parseFloat(0).toFixed(2),
        igv: parseFloat(0).toFixed(2),
        total: parseFloat(0).toFixed(2),
      };
      state.sale_detail = [];
    },
  },
  actions: {
    //compras
    LoadAddPurchaseDetail(context, product) {
      let validate = true
      let detail = context.state.purchase_detail
      for (let index = 0; index < detail.length; index++) {
        if (detail[index].id_product == product.id_product) {
          detail[index].quantity = parseFloat(detail[index].quantity) + parseFloat(product.quantity);
          detail[index].quantity = parseFloat(detail[index].quantity).toFixed(2);
          detail[index].total_price = parseFloat(detail[index].quantity) * parseFloat(detail[index].unit_price);
          detail[index].unit_price = parseFloat(detail[index].unit_price).toFixed(2);
          detail[index].total_price = parseFloat(detail[index].total_price).toFixed(2);
          validate = false
          break;
        }
      }
      if (validate) {
        context.commit('AddPurchaseDetail', product)
      }

      context.dispatch('LoadTotalPurchaseDetail');
    },
    LoadUpdatePurchaseDetail(context, index) {
      let detail = context.state.purchase_detail
      detail[index].quantity = detail[index].quantity.length == 0 ? 0 : detail[index].quantity;
      detail[index].unit_price = detail[index].unit_price.length == 0 ? 0 : detail[index].unit_price;

      detail[index].quantity = parseFloat(detail[index].quantity);
      detail[index].unit_price = parseFloat(detail[index].unit_price);
      detail[index].total_price = parseFloat(detail[index].quantity) * parseFloat(detail[index].unit_price);

      detail[index].quantity = parseFloat(detail[index].quantity).toFixed(2);
      detail[index].unit_price = parseFloat(detail[index].unit_price).toFixed(2);
      detail[index].total_price = parseFloat(detail[index].total_price).toFixed(2);
      context.dispatch('LoadTotalPurchaseDetail');

    },
    LoadDeletePurchaseDetail(context, index) {
      context.commit('DeletePurchaseDetail', index)
      context.dispatch('LoadTotalPurchaseDetail');
    },
    LoadTotalPurchaseDetail(context) {
      let detail = context.state.purchase_detail
      let purchase_total = {
        taxed_operation: parseFloat(0),
        exonerated_operation: parseFloat(0),
        unaffected_operation: parseFloat(0),
        igv: parseFloat(0),
        total: parseFloat(0),
      };

      for (let index = 0; index < detail.length; index++) {
        const product = detail[index];
        if (product.igv == "10") {
          purchase_total.taxed_operation += parseFloat(product.total_price);
        }
        if (product.igv == "20") {
          purchase_total.exonerated_operation += parseFloat(product.total_price);
        }
        if (product.igv == "30") {
          purchase_total.unaffected_operation += parseFloat(product.total_price);
        }
      }

      purchase_total.total = (purchase_total.taxed_operation + purchase_total.exonerated_operation + purchase_total.unaffected_operation);
      purchase_total.igv = purchase_total.taxed_operation - (purchase_total.taxed_operation / 1.18);
      purchase_total.taxed_operation = purchase_total.taxed_operation - purchase_total.igv;

      purchase_total.taxed_operation = parseFloat(purchase_total.taxed_operation).toFixed(2);
      purchase_total.exonerated_operation = parseFloat(purchase_total.exonerated_operation).toFixed(2);
      purchase_total.unaffected_operation = parseFloat(purchase_total.unaffected_operation).toFixed(2);
      purchase_total.igv = parseFloat(purchase_total.igv).toFixed(2);
      purchase_total.total = parseFloat(purchase_total.total).toFixed(2);
      context.commit('UpdateTotalPurchaseDetail', purchase_total)

    },
    LoadResetPurchase(context) {
      context.commit('ResetPurchaseDetail')
    },


    //ventas
    LoadAddSaleDetail(context, product) {
      let validate = true
      let detail = context.state.sale_detail
      for (let index = 0; index < detail.length; index++) {
        if (detail[index].id_product == product.id_product) {
          detail[index].quantity = parseFloat(detail[index].quantity) + parseFloat(product.quantity);
          detail[index].quantity = parseFloat(detail[index].quantity).toFixed(2);
          detail[index].total_price = parseFloat(detail[index].quantity) * parseFloat(detail[index].unit_price);
          detail[index].unit_price = parseFloat(detail[index].unit_price).toFixed(2);
          detail[index].total_price = parseFloat(detail[index].total_price).toFixed(2);
          validate = false
          break;
        }
      }
      if (validate) {
        context.commit('AddSaleDetail', product)
      }

      context.dispatch('LoadTotalSaleDetail');
    },
    LoadUpdateSaleDetail(context, index) {
      let detail = context.state.sale_detail
      detail[index].quantity = detail[index].quantity.length == 0 ? 0 : detail[index].quantity;
      detail[index].unit_price = detail[index].unit_price.length == 0 ? 0 : detail[index].unit_price;

      detail[index].quantity = parseFloat(detail[index].quantity);
      detail[index].unit_price = parseFloat(detail[index].unit_price);
      detail[index].total_price = parseFloat(detail[index].quantity) * parseFloat(detail[index].unit_price);

      detail[index].quantity = parseFloat(detail[index].quantity).toFixed(2);
      detail[index].unit_price = parseFloat(detail[index].unit_price).toFixed(2);
      detail[index].total_price = parseFloat(detail[index].total_price).toFixed(2);
      context.dispatch('LoadTotalSaleDetail');

    },
    LoadDeleteSaleDetail(context, index) {
      context.commit('DeleteSaleDetail', index)
      context.dispatch('LoadTotalSaleDetail');
    },
    LoadTotalSaleDetail(context) {
      let detail = context.state.sale_detail
      let sale_detail = {
        taxed_operation: parseFloat(0),
        exonerated_operation: parseFloat(0),
        unaffected_operation: parseFloat(0),
        igv: parseFloat(0),
        total: parseFloat(0),
      };

      for (let index = 0; index < detail.length; index++) {
        const product = detail[index];
        if (product.igv == "10") {
          sale_detail.taxed_operation += parseFloat(product.total_price);
        }
        if (product.igv == "20") {
          sale_detail.exonerated_operation += parseFloat(product.total_price);
        }
        if (product.igv == "30") {
          sale_detail.unaffected_operation += parseFloat(product.total_price);
        }
      }

      sale_detail.total = (sale_detail.taxed_operation + sale_detail.exonerated_operation + sale_detail.unaffected_operation);
      sale_detail.igv = sale_detail.taxed_operation - (sale_detail.taxed_operation / 1.18);
      sale_detail.taxed_operation = sale_detail.taxed_operation - sale_detail.igv;

      sale_detail.taxed_operation = parseFloat(sale_detail.taxed_operation).toFixed(2);
      sale_detail.exonerated_operation = parseFloat(sale_detail.exonerated_operation).toFixed(2);
      sale_detail.unaffected_operation = parseFloat(sale_detail.unaffected_operation).toFixed(2);
      sale_detail.igv = parseFloat(sale_detail.igv).toFixed(2);
      sale_detail.total = parseFloat(sale_detail.total).toFixed(2);
      context.commit('UpdateTotalSaleDetail', sale_detail)

    },
    LoadResetSale(context) {
      context.commit('ResetSaleDetail')
    },


  },
  modules: {},
})
