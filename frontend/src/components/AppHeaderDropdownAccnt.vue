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
export default {
  name: 'AppHeaderDropdownAccnt',
  setup() {
    return {
      avatar: avatar,
      itemsCount: 42,
    }
  },
  methods : {
    Logout,
  }
}

function Logout() {
  Swal.fire({
      icon: "success",
      title: "Se ha cerrado la session",
      showConfirmButton: false,
      timer: 1500,
    });
  window.localStorage.clear()
  this.$router.push({ name: "Login"})
 
  // setTimeout(this.$router.go(), 2000);
}
</script>
