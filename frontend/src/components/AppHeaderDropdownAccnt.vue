<template>
  <CDropdown variant="nav-item">
    <CDropdownToggle placement="bottom-end" class="py-0" :caret="false">
      <CAvatar :src="avatar" size="md" />
    </CDropdownToggle>
    <CDropdownMenu class="pt-0">
      <CDropdownHeader component="h6" class="bg-light fw-semibold py-2">
        Cuenta
      </CDropdownHeader>
      <!-- <CDropdownItem>
        <CIcon icon="cil-envelope-open" /> Messages
        <CBadge color="success" class="ms-auto">{{ itemsCount }}</CBadge>
      </CDropdownItem>
      <CDropdownItem> <CIcon icon="cil-user" /> Profile </CDropdownItem> -->
      <CDropdownDivider />
      <CDropdownItem @click="Logout"> <CIcon icon="cil-lock-locked" /> Logout </CDropdownItem>
    </CDropdownMenu>
  </CDropdown>
</template>

<script>
import avatar from '@/assets/images/avatars/img.jpg'
const Swal = require("sweetalert2");
const axios = require("axios").default;
const je = require("json-encrypt");
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  name: 'AppHeaderDropdownAccnt',
  setup() {
    const store = useStore()
    const user = window.localStorage.getItem("user");
    return {
      avatar: avatar,
      itemsCount: 42,
      url_base: computed(() => store.state.url_base),
      muser: JSON.parse(JSON.parse(je.decrypt(user))),
    }
  },
  methods : {
    Logout,
  }
}

function Logout() {

  let me = this;
  let url = this.url_base + "logout";
  let data = {
    id_user: this.muser.id_user,
  };
  this.isLoading = true;

  axios({
    method: "POST",
    url: url,
    headers: {
      "Content-Type": "application/json",
    },
    data: data,
  })
    .then(function (response) {
      if (response.data.status == 200) {

        Swal.fire({
            icon: "success",
            title: "Se ha cerrado la session",
            showConfirmButton: false,
            timer: 1500,
          });
        window.localStorage.clear()
        me.$router.push({ name: "Login"})
        setTimeout(function(){
          me.$router.go(0)
      }, 1000);
      }
    });




  // setTimeout(this.$router.go(), 2000);
}
</script>
