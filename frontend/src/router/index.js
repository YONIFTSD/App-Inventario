import { h, resolveComponent } from 'vue'
import { createRouter, createWebHashHistory } from 'vue-router'
const je = require("json-encrypt");
import DefaultLayout from '@/layouts/DefaultLayout'

const routes = [
  {
    path: '/',
    name: 'Login',
    component: () => import('@/views/pages/Login'),
  },
  {
    path: '/inicio',
    name: 'Home',
    component: DefaultLayout,
    redirect: '/dashboard',
    children: [
      {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('@/views/Dashboard.vue'),
        // beforeEnter : guardMyroute,
      },
    ],
  },
  {
    path: '/pages',
    redirect: '/pages/404',
    name: 'Pages',
    component: {
      render() {
        return h(resolveComponent('router-view'))
      },
    },
    children: [
      {
        path: '404',
        name: 'Page404',
        component: () => import('@/views/pages/Page404'),
      },
      {
        path: '500',
        name: 'Page500',
        component: () => import('@/views/pages/Page500'),
      },
      {
        path: 'register',
        name: 'Register',
        component: () => import('@/views/pages/Register'),
      },
    ],
  },


  {
    path: '/usuario',
    redirect: '/usuario/listar',
    component: DefaultLayout,
    name: 'User',
    children: [
      {
        path: 'listar',
        name: 'UserList',
        component: () => import('@/views/user/List'),
      },
      {
        path: 'nuevo',
        name: 'UserAdd',
        component: () => import('@/views/user/Add'),
      },
      {
        path: 'editar/:id_user',
        name: 'UserEdit',
        component: () => import('@/views/user/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_user',
        name: 'UserView',
        component: () => import('@/views/user/View'),
        props: true,
      },
    ],
  },

  {
    path: '/tipos-de-usuario',
    redirect: '/tipos-de-usuario/listar',
    component: DefaultLayout,
    name: 'UserType',
    children: [
      {
        path: 'listar',
        name: 'UserTypeList',
        component: () => import('@/views/user-type/List'),
      },
      {
        path: 'nuevo',
        name: 'UserTypeAdd',
        component: () => import('@/views/user-type/Add'),
      },
      {
        path: 'editar/:id_user_type',
        name: 'UserTypeEdit',
        component: () => import('@/views/user-type/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_user_type',
        name: 'UserTypeView',
        component: () => import('@/views/user-type/View'),
        props: true,
      },
    ],
  },

  {
    path: '/clientes',
    redirect: '/clientes/listar',
    component: DefaultLayout,
    name: 'Client',
    children: [
      {
        path: 'listar',
        name: 'ClientList',
        component: () => import('@/views/clients/List'),
      },
      {
        path: 'nuevo',
        name: 'ClientAdd',
        component: () => import('@/views/clients/Add'),
      },
      {
        path: 'editar/:id_client',
        name: 'ClientEdit',
        component: () => import('@/views/clients/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_client',
        name: 'ClientView',
        component: () => import('@/views/clients/View'),
        props: true,
      },
    ],
  },


   {
    path: '/proveedores',
    redirect: '/proveedores/listar',
    component: DefaultLayout,
    name: 'Provider',
    children: [
      {
        path: 'listar',
        name: 'ProviderList',
        component: () => import('@/views/providers/List'),
      },
      {
        path: 'nuevo',
        name: 'ProviderAdd',
        component: () => import('@/views/providers/Add'),
      },
      {
        path: 'editar/:id_provider',
        name: 'ProviderEdit',
        component: () => import('@/views/providers/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_provider',
        name: 'ProviderView',
        component: () => import('@/views/providers/View'),
        props: true,
      },
    ],
  },



  {
    path: '/productos',
    redirect: '/productos/listar',
    component: DefaultLayout,
    name: 'Product',
    children: [
      {
        path: 'listar',
        name: 'ProductList',
        component: () => import('@/views/products/List'),
      },
      {
        path: 'nuevo',
        name: 'ProductAdd',
        component: () => import('@/views/products/Add'),
      },
      {
        path: 'editar/:id_product',
        name: 'ProductEdit',
        component: () => import('@/views/products/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_product',
        name: 'ProductView',
        component: () => import('@/views/products/View'),
        props: true,
      },
    ],
  },


  {
    path: '/categorias',
    redirect: '/categorias/listar',
    component: DefaultLayout,
    name: 'Category',
    children: [
      {
        path: 'listar',
        name: 'CategoryList',
        component: () => import('@/views/categories/List'),
      },
      {
        path: 'nuevo',
        name: 'CategoryAdd',
        component: () => import('@/views/categories/Add'),
      },
      {
        path: 'editar/:id_category',
        name: 'CategoryEdit',
        component: () => import('@/views/categories/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_category',
        name: 'CategoryView',
        component: () => import('@/views/categories/View'),
        props: true,
      },
    ],
  },


  {
    path: '/compras',
    redirect: '/compras/listar',
    component: DefaultLayout,
    name: 'Purchase',
    children: [
      {
        path: 'listar',
        name: 'PurchaseList',
        component: () => import('@/views/purchases/List'),
      },
      {
        path: 'nuevo',
        name: 'PurchaseAdd',
        component: () => import('@/views/purchases/Add'),
      },
      {
        path: 'editar/:id_purchase',
        name: 'PurchaseEdit',
        component: () => import('@/views/purchases/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_purchase',
        name: 'PurchaseView',
        component: () => import('@/views/purchases/View'),
        props: true,
      },
    ],
  },





]

const router = createRouter({
  history: createWebHashHistory(process.env.BASE_URL),
  routes,
  scrollBehavior() {
    // always scroll to top
    return { top: 0 }
  },
})


export default router
