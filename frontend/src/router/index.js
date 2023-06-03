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
    path: '/liquidacion-diaria-egresos',
    redirect: '/liquidacion-diaria-egresos/listar',
    component: DefaultLayout,
    name: 'DailySettlementExpense',
    children: [
      {
        path: 'listar',
        name: 'DailySettlementExpenseList',
        component: () => import('@/views/daily-settlement-expenses/List'),
      },
      {
        path: 'nuevo',
        name: 'DailySettlementExpenseAdd',
        component: () => import('@/views/daily-settlement-expenses/Add'),
      },
      {
        path: 'editar/:id_expense',
        name: 'DailySettlementExpenseEdit',
        component: () => import('@/views/daily-settlement-expenses/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_expense',
        name: 'DailySettlementExpenseView',
        component: () => import('@/views/daily-settlement-expenses/View'),
        props: true,
      },
    ],
  },

  {
    path: '/liquidacion-diaria-ingresos',
    redirect: '/liquidacion-diaria-ingresos/listar',
    component: DefaultLayout,
    name: 'DailySettlementIncome',
    children: [
      {
        path: 'listar',
        name: 'DailySettlementIncomeList',
        component: () => import('@/views/daily-settlement-incomes/List'),
      },
      {
        path: 'nuevo',
        name: 'DailySettlementIncomeAdd',
        component: () => import('@/views/daily-settlement-incomes/Add'),
      },
      {
        path: 'editar/:id_income',
        name: 'DailySettlementIncomeEdit',
        component: () => import('@/views/daily-settlement-incomes/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_income',
        name: 'DailySettlementIncomeView',
        component: () => import('@/views/daily-settlement-incomes/View'),
        props: true,
      },
    ],
  },

  {
    path: '/tipo-gasto',
    redirect: '/tipo-gasto/listar',
    component: DefaultLayout,
    name: 'TypeExpense',
    children: [
      {
        path: 'listar',
        name: 'TypeExpenseList',
        component: () => import('@/views/type-expense/List'),
      },
      {
        path: 'nuevo',
        name: 'TypeExpenseAdd',
        component: () => import('@/views/type-expense/Add'),
      },
      {
        path: 'editar/:id_type_expense',
        name: 'TypeExpenseEdit',
        component: () => import('@/views/type-expense/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_type_expense',
        name: 'TypeExpenseView',
        component: () => import('@/views/type-expense/View'),
        props: true,
      },
    ],
  },

  {
    path: '/tipo-ingreso',
    redirect: '/tipo-ingreso/listar',
    component: DefaultLayout,
    name: 'TypeIncomeManagement',
    children: [
      {
        path: 'listar',
        name: 'TypeIncomeManagementList',
        component: () => import('@/views/type-income-management/List'),
      },
      {
        path: 'nuevo',
        name: 'TypeIncomeManagementAdd',
        component: () => import('@/views/type-income-management/Add'),
      },
      {
        path: 'editar/:id_type_income',
        name: 'TypeIncomeManagementEdit',
        component: () => import('@/views/type-income-management/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_type_income',
        name: 'TypeIncomeManagementView',
        component: () => import('@/views/type-income-management/View'),
        props: true,
      },
    ],
  },

  {
    path: '/egresos',
    redirect: '/egresos/listar',
    component: DefaultLayout,
    name: 'Expense',
    children: [
      {
        path: 'listar',
        name: 'ExpenseList',
        component: () => import('@/views/expenses/List'),
      },
      {
        path: 'nuevo',
        name: 'ExpenseAdd',
        component: () => import('@/views/expenses/Add'),
      },
      {
        path: 'editar/:id_expense',
        name: 'ExpenseEdit',
        component: () => import('@/views/expenses/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_expense',
        name: 'ExpenseView',
        component: () => import('@/views/expenses/View'),
        props: true,
      },
    ],
  },

  {
    path: '/ingresos',
    redirect: '/ingresos/listar',
    component: DefaultLayout,
    name: 'Income',
    children: [
      {
        path: 'listar',
        name: 'IncomeList',
        component: () => import('@/views/incomes/List'),
      },
      {
        path: 'nuevo',
        name: 'IncomeAdd',
        component: () => import('@/views/incomes/Add'),
      },
      {
        path: 'editar/:id_income',
        name: 'IncomeEdit',
        component: () => import('@/views/incomes/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_income',
        name: 'IncomeView',
        component: () => import('@/views/incomes/View'),
        props: true,
      },
    ],
  },

  {
    path: '/utilidad',
    redirect: '/utilidad/listar',
    component: DefaultLayout,
    name: 'Utility',
    children: [
      {
        path: 'listar',
        name: 'UtilityList',
        component: () => import('@/views/utilities/List'),
      },
      {
        path: 'nuevo',
        name: 'UtilityAdd',
        component: () => import('@/views/utilities/Add'),
      },
      {
        path: 'editar/:id_utility',
        name: 'UtilityEdit',
        component: () => import('@/views/utilities/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_utility',
        name: 'UtilityView',
        component: () => import('@/views/utilities/View'),
        props: true,
      },
    ],
  },

  {
    path: '/egreso-gerencial',
    redirect: '/egreso-gerencial/listar',
    component: DefaultLayout,
    name: 'ManagementExpense',
    children: [
      {
        path: 'listar',
        name: 'ManagementExpenseList',
        component: () => import('@/views/management-expenses/List'),
      },
      {
        path: 'nuevo',
        name: 'ManagementExpenseAdd',
        component: () => import('@/views/management-expenses/Add'),
      },
      {
        path: 'editar/:id_expense',
        name: 'ManagementExpenseEdit',
        component: () => import('@/views/management-expenses/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_expense',
        name: 'ManagementExpenseView',
        component: () => import('@/views/management-expenses/View'),
        props: true,
      },
    ],
  },

  {
    path: '/ingreso-gerencial',
    redirect: '/ingreso-gerencial/listar',
    component: DefaultLayout,
    name: 'ManagementIncome',
    children: [
      {
        path: 'listar',
        name: 'ManagementIncomeList',
        component: () => import('@/views/management-incomes/List'),
      },
      {
        path: 'nuevo',
        name: 'ManagementIncomeAdd',
        component: () => import('@/views/management-incomes/Add'),
      },
      {
        path: 'editar/:id_income',
        name: 'ManagementIncomeEdit',
        component: () => import('@/views/management-incomes/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_income',
        name: 'ManagementIncomeView',
        component: () => import('@/views/management-incomes/View'),
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
    path: '/cuentas-por-cobrar',
    redirect: '/cuentas-por-cobrar/listar',
    component: DefaultLayout,
    name: 'AccountReceivable',
    children: [
      {
        path: 'listar',
        name: 'AccountReceivableList',
        component: () => import('@/views/accounts-receivable/List'),
      },
      {
        path: 'nuevo',
        name: 'AccountReceivableAdd',
        component: () => import('@/views/accounts-receivable/Add'),
      },
      {
        path: 'editar/:id_account_receivable',
        name: 'AccountReceivableEdit',
        component: () => import('@/views/accounts-receivable/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_account_receivable',
        name: 'AccountReceivableView',
        component: () => import('@/views/accounts-receivable/View'),
        props: true,
      },
    ],
  },


  {
    path: '/egreso-cobros',
    redirect: '/egreso-cobros/listar',
    component: DefaultLayout,
    name: 'AccountReceivableExpense',
    children: [
      {
        path: 'listar',
        name: 'AccountReceivableExpenseList',
        component: () => import('@/views/accounts-receivable-expense/List'),
      },
      {
        path: 'nuevo',
        name: 'AccountReceivableExpenseAdd',
        component: () => import('@/views/accounts-receivable-expense/Add'),
      },
      {
        path: 'editar/:id_expense',
        name: 'AccountReceivableExpenseEdit',
        component: () => import('@/views/accounts-receivable-expense/Edit'),
        props: true,
      },
      {
        path: 'ver/:id_expense',
        name: 'AccountReceivableExpenseView',
        component: () => import('@/views/accounts-receivable-expense/View'),
        props: true,
      },
    ],
  },

  {
    path: '/reporte',
    redirect: '/report/utilidad',
    component: DefaultLayout,
    name: 'Report',
    children: [
      {
        path: 'utilidad-liquidacion-diaria',
        name: 'ReportUtilityDailySettlement',
        component: () => import('@/views/report/UtilityDailySettlement'),
      },
      {
        path: 'utilidad-gerencial',
        name: 'ReportUtilityManagement',
        component: () => import('@/views/report/UtilityManagement'),
      },
      {
        path: 'utilidad-gestion-cobros',
        name: 'ReportUtilityAccountReceivable',
        component: () => import('@/views/report/UtilityAccountReceivable'),
      },
      {
        path: 'utilidad',
        name: 'ReportUtility',
        component: () => import('@/views/report/Utility'),
      },

      {
        path: 'utilidad-mensual-liquidacion-diaria',
        name: 'ReportMonthUtilityDailySettlement',
        component: () => import('@/views/report/MonthUtilityDailySettlement'),
      },

      {
        path: 'utilidad-mensual-gerencial',
        name: 'ReportMonthUtilityManagement',
        component: () => import('@/views/report/MonthUtilityManagement'),
      },

      {
        path: 'utilidad-mensual-gestion-cobros',
        name: 'ReportMonthUtilityAccountReceivable',
        component: () => import('@/views/report/MonthUtilityAccountReceivable'),
      },

      {
        path: 'utilidad-mensual',
        name: 'ReportMonthUtility',
        component: () => import('@/views/report/MonthUtility'),
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
