<template>
  <CSidebar
    position="fixed"
    :unfoldable="sidebarUnfoldable"
    :visible="sidebarVisible"

  >
  <!-- @visible-change="(event) => $store.commit({type: 'updateSidebarVisible', value: event,})" -->
    <CSidebarBrand>
      <img :src="url_base + 'img/logo-lg.png'" class="img-fluid" />
      <!-- <CIcon
        custom-class-name="sidebar-brand-full"
        :icon="logoNegative"
        :height="35"
      /> -->
      <!-- <CIcon
        custom-class-name="sidebar-brand-narrow"
        :icon="sygnet"
        :height="35"
      /> -->
    </CSidebarBrand>
    <AppSidebarNav />
    <CSidebarToggler
      class="d-none d-lg-flex"
      @click="$store.commit('toggleUnfoldable')"
    />
  </CSidebar>
</template>

<script>
import { mapState } from "vuex";
import { computed } from 'vue'
import { useStore } from 'vuex'
import { AppSidebarNav } from './AppSidebarNav'
import { logoNegative } from '@/assets/brand/logo-negative'
import { sygnet } from '@/assets/brand/sygnet'
import { mapActions } from 'vuex'
export default {
  name: 'AppSidebar',
  components: {
    AppSidebarNav,
  },
    mounted() {

  },
  methods:{

  },
  setup() {
    const store = useStore()
    return {
      logoNegative,
      sygnet,
      sidebarUnfoldable: computed(() => store.state.sidebarUnfoldable),
      sidebarVisible: computed(() => store.state.sidebarVisible),
    }
  },
  computed: mapState(["url_base"]),
}




</script>
