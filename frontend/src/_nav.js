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

if(user_permissions.indexOf('ClientList') > -1 || user_permissions.indexOf('ProviderList') > -1 ){
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
      to: '/clientes',
      icon: 'cil-star',
      items: item,
    }
  )

}


if(user_permissions.indexOf('ProductList') > -1 || user_permissions.indexOf('CategoryList') > -1){
  let item = [];
  if (user_permissions.indexOf('ProductList') > -1) {
    item.push({component: 'CNavItem', name: 'Productos', to: '/productos/listar',});
  }
  if (user_permissions.indexOf('CategoryList') > -1) {
    item.push({component: 'CNavItem', name: 'Categoria', to: '/categorias/listar',});
  }
  menu.push(
    {
      component: 'CNavGroup',
      name: 'Productos',
      to: '/productos',
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
