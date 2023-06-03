/* eslint-disable */
const je = require("json-encrypt");
let user_permissions = window.localStorage.getItem("user_permissions") == null ? []: JSON.parse(JSON.parse(je.decrypt(window.localStorage.getItem("user_permissions"))));


let menu = []
menu.push({
    component: 'CNavItem',
    name: 'Inicio',
    to: '/dashboard',
    icon: 'cil-speedometer',
})

if(user_permissions.indexOf('DailySettlementExpenseList') > -1 || user_permissions.indexOf('DailySettlementIncomeList') > -1
|| user_permissions.indexOf('ReportUtilityDailySettlementMonthList') > -1 ){

  let item = [];
  if (user_permissions.indexOf('DailySettlementIncomeList') > -1) {
    item.push({ component: 'CNavItem', name: 'Ingresos', to: '/liquidacion-diaria-ingresos/listar'});
  }
  if (user_permissions.indexOf('DailySettlementExpenseList') > -1) {
    item.push({component: 'CNavItem',name: 'Egresos',to: '/liquidacion-diaria-egresos/listar'});
  }
  if (user_permissions.indexOf('ReportUtilityDailySettlementMonthList') > -1) {
    item.push({component: 'CNavItem', name: 'R. Gastos - L. D.', to: '/reporte/utilidad-mensual-liquidacion-diaria'});
  }

  menu.push({
      component: 'CNavGroup',
      name: 'Liquidación Diaria',
      to: '/liquidacion-diaria',
      icon: 'cil-star',
      items: item,
  })

}


if(user_permissions.indexOf('ManagementExpenseList') > -1 || user_permissions.indexOf('ManagementIncomeList') > -1
|| user_permissions.indexOf('ReportUtilityManagementMonthList') > -1 || user_permissions.indexOf('ReportUtilityManagementList') > -1 ){


  let item = [];
  if (user_permissions.indexOf('ManagementExpenseList') > -1) {
    item.push({component: 'CNavItem', name: 'Ingresos', to: '/ingreso-gerencial/listar'});
  }
  if (user_permissions.indexOf('ManagementIncomeList') > -1) {
    item.push({component: 'CNavItem',name: 'Egresos', to: '/egreso-gerencial/listar'});
  }
  if (user_permissions.indexOf('ReportUtilityManagementMonthList') > -1) {
    item.push({component: 'CNavItem',name: 'R. Gastos Externos',to: '/reporte/utilidad-mensual-gerencial' });
  }
  if (user_permissions.indexOf('ReportUtilityManagementList') > -1) {
    item.push({component: 'CNavItem',name: 'R. Gastos Acumulado',to: '/reporte/utilidad-gerencial'});
  }

  menu.push({
      component: 'CNavGroup',
      name: 'Gastos Externos',
      to: '/gerencia',
      icon: 'cil-star',
      items: item,
  })
}


if(user_permissions.indexOf('AccountReceivableList') > -1 || user_permissions.indexOf('AccountReceivableExpenseList') > -1
|| user_permissions.indexOf('ReportUtilityAccountReceivableMonthList') > -1 || user_permissions.indexOf('ReportUtilityAccountReceivableList') > -1 ){

  let item = [];
  if (user_permissions.indexOf('AccountReceivableList') > -1) {
    item.push({component: 'CNavItem', name: 'Cuentas Por Cobrar', to: '/cuentas-por-cobrar/listar' });
  }
  if (user_permissions.indexOf('AccountReceivableExpenseList') > -1) {
    item.push({component: 'CNavItem', name: 'Egresos',  to: '/egreso-cobros/listar'});
  }
  if (user_permissions.indexOf('ReportUtilityAccountReceivableMonthList') > -1) {
    item.push({component: 'CNavItem', name: 'Reporte de Gastos USD', to: '/reporte/utilidad-mensual-gestion-cobros'});
  }
  if (user_permissions.indexOf('ReportUtilityAccountReceivableList') > -1) {
    item.push({component: 'CNavItem', name: 'Reporte Acumulado USD',to: '/reporte/utilidad-gestion-cobros', });
  }
  menu.push( {
    component: 'CNavGroup',
    name: 'Gestion de Cobros USD',
    to: '/cuentas-por-cobrar',
    icon: 'cil-star',
    items: item,
})
}


if(user_permissions.indexOf('IncomeList') > -1 || user_permissions.indexOf('ExpenseList') > -1
|| user_permissions.indexOf('ReportUtilityMonthList') > -1 || user_permissions.indexOf('ReportUtilityList') > -1 ){

  let item = [];
  if (user_permissions.indexOf('IncomeList') > -1) {
    item.push({component: 'CNavItem',name: 'Ingresos',to: '/ingresos/listar', });
  }
  if (user_permissions.indexOf('ExpenseList') > -1) {
    item.push({component: 'CNavItem', name: 'Egresos', to: '/egresos/listar', });
  }
  if (user_permissions.indexOf('ReportUtilityMonthList') > -1) {
    item.push({component: 'CNavItem',name: 'Reporte Utilidad - Mensual', to: '/reporte/utilidad-mensual',});
  }
  if (user_permissions.indexOf('ReportUtilityList') > -1) {
    item.push({component: 'CNavItem', name: 'Reporte Utilidad Acumulado',to: '/reporte/utilidad', });
  }
  menu.push({
      component: 'CNavGroup',
      name: 'Gestión de Utilidades',
      to: '/utilidad',
      icon: 'cil-star',
      items: item,
  })

}

if(user_permissions.indexOf('ClientList') > -1
|| user_permissions.indexOf('ProviderList') > -1 ){
  let item = [];
  if (user_permissions.indexOf('ClientList') > -1) {
    item.push({component: 'CNavItem', name: 'Clientes', to: '/clientes/listar',});
  }
  if (user_permissions.indexOf('ProviderList') > -1) {
    item.push({component: 'CNavItem',name: 'Proveedores',to: '/proveedores/listar', });
  }
  menu.push(
    {
      component: 'CNavGroup',
      name: 'Entidad',
      to: '/utilidad',
      icon: 'cil-star',
      items: item,
    }
  )

}

if(user_permissions.indexOf('UserList') > -1 || user_permissions.indexOf('UserTypeList') > -1
|| user_permissions.indexOf('TypeExpenseList') > -1 || user_permissions.indexOf('ClientList') > -1
|| user_permissions.indexOf('TypeIncomeManagementList') > -1 ){
  let item = [];
  if (user_permissions.indexOf('UserList') > -1) {
    item.push({component: 'CNavItem',name: 'Usuarios',to: '/usuario/listar',});
  }
  if (user_permissions.indexOf('UserTypeList') > -1) {
    item.push({component: 'CNavItem',name: 'Tipos de Usuarios',to: '/tipos-de-usuario/listar', });
  }
  if (user_permissions.indexOf('ClientList') > -1) {
    item.push({component: 'CNavItem', name: 'Clientes', to: '/clientes/listar',});
  }
  if (user_permissions.indexOf('TypeExpenseList') > -1) {
    item.push({component: 'CNavItem',name: 'Tipo de Gastos',to: '/tipo-gasto/listar', });
  }

  if (user_permissions.indexOf('TypeIncomeManagementList') > -1) {
    item.push({component: 'CNavItem', name: 'Tipo de Ingresos',to: '/tipo-ingreso/listar',});
  }
  menu.push(
    {
      component: 'CNavGroup',
      name: 'Mantenimiento',
      to: '/utilidad',
      icon: 'cil-star',
      items: item,
    }
  )

}
export default menu
