<template>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol :md="8">
          <CCardGroup>
            <CCard class="text-white">
              <CCardBody class="text-center">
                <div>
                  <img :src="url_base + 'img/logo.png'" class="img-fluid" />
                </div>
              </CCardBody>
            </CCard>

            <CCard class="p-4">
              <CCardBody>

              <form >
                  <h1>Login</h1>
                  <p class="text-medium-emphasis">Iniciar sesión en su cuenta</p>

                  <div class="form-floating mb-3">
                    <input type="email" v-model="email" placeholder="name@example.com" class="form-control form-control-sm" id="floatingInput">
                    <label for="floatingInput">Email</label>
                  </div>
                  <div class="form-floating">
                    <input type="password" v-model="password" class="form-control form-control-sm" placeholder="Password" id="floatingPassword">
                    <label for="floatingPassword">Password</label>
                  </div>

                  <div class="form-group mt-3">
                      <button type="button" @click="Login" class="form-control btn btn-primary">Ingresar</button>
                  </div>
              </form>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>

    <LoadingComponent :is-visible="isLoading" />
  </div>
</template>

<script>
import { mapState } from "vuex";
const axios = require("axios").default;
const Swal = require("sweetalert2");
const je = require("json-encrypt");

import LoadingComponent from "./Loading.vue";

export default {
  name: "Login",
  components: {
    LoadingComponent,
  },
  data() {
    return {
      email: "",
      password: "",
      isLoading: false,
    };
  },
  methods: {
    Login,
  },
  computed: mapState(["url_base"]),
};

function Login() {
  let me = this;
  let url = this.url_base + "login";
  let data = {
    email: this.email,
    password: this.password,
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

        let user = je.encrypt(JSON.stringify(response.data.result.user));
        let user_permissions = je.encrypt(JSON.stringify(response.data.result.userPermissions));

        window.localStorage.setItem("user", user);
        window.localStorage.setItem("user_permissions", user_permissions);
        Swal.fire({
          icon: "success",
          title: response.data.message,
          showConfirmButton: false,
          timer: 3000,
        });
        me.$router.push({ name: "DailySettlementIncomeList" });

      setTimeout(function(){
          me.$router.go(0)
      }, 2000);



      } else {
        // console.log('No logeado');
        Swal.fire({
          icon: "error",
          title: response.data.message,
          showConfirmButton: false,
          timer: 1500,
        });
      }
      me.isLoading = false;
    })
    .catch((error) => {
      console.log(error);
      me.isLoading = false;
      Swal.fire({
        icon: "error",
        text: "A ocurrido un error, intentelo mas tarde.",
        timer: 3000,
      });
    });
}
</script>
