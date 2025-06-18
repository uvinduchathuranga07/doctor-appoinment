<template>
  <!-- <AppLayout> -->
    <div class="container">
    <div
      class="row justify-content-center align-items-center py-5"
      style="min-height: 100vh"
    >
      <div class="col-md-5 px-4">
        <div class="card bg-white shadow-sm border rounded-5">
          <div class="card-body mb-4">
            <div class="header text-center py-4">
              <img
                src="/images/main-logo (1).png"
                class="pb-3"
                alt=""
              />
              <h4 class="text-center fw-bold">Sign In To Your Account</h4>
            </div>
         
              <!-- Error Message -->
              <div v-if="form.errors.username || form.errors.password" class="alert alert-danger text-center">
                Incorrect email or password.
              </div>
  
              <form
              class="row input-fields gy-4 px-3"
              id="formAccountSetting"
              @submit.prevent="submit"
            >
              <div class="row input-fields gy-4 px-3">
                <div class="col-12">
                  <div class="input-group border">
                    <input
                      type="text"
                      class="form-control bg-light border-0 py-3 px-4"
                      placeholder="Username"
                      id="username"
                      v-model="form.username"
                    />
                    <span class="input-group-text border-0"
                      ><i
                        class="fa-solid fa-user pe-3"
                        style="color: #6a3090"
                      ></i
                    ></span>
                  </div>
                </div>
                <div class="col-12">
                  <div class="input-group border">
                    <input
                      type="password"
                      class="form-control bg-light border-0 py-3 px-4"
                      placeholder="Password"
                      id="password"
                      v-model="form.password"
                    />
                    <label type="button" class="input-group-text border-0 border-radius-custom" for="chk"
                      ><i
                        class="fa-regular fa-eye-slash pe-3" id="icon"
                        style="color: #6a3090"
                      ></i
                    ></label>
                    <input type="checkbox" class="d-none" id="chk">
                    
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      value=""
                      id="flexCheckDefault"
                    />
                    <label class="form-check-label" for="flexCheckDefault">
                      <small> Remember Me</small>
                    </label>
                  </div>
                </div>
                <div class="col-6 text-end">
                  <Link
                    style="font-size: small; color: #6a3090"
                    :href="route('forgotpassword')"
                    >Forgot Password</Link
                  >
                </div>
                <div class="col-12 mt-4">
                  <button
                    class="btn btn-primary w-100 py-2 login-btn border-0"
                    style="background-color: #6a3090"
                    type="submit"
                    :disabled="form.processing"
                  >
                    LOGIN
                  </button>
                </div>
              </div>
              </form>


                <div class="row px-4 mt-2">
                  <div class="col-12 mt-2">
                    <small>
                      No Account yet?
                      <Link style="color: #6a3090" :href="route('register')"
                        >Register</Link
                      >
                    </small>
                  </div>
                  <div class="col-12 text-center">
                    <p class="py-3 pt-4">Or Sign Up using</p>
                  </div>
                  <div class="col-12 justify-content-center d-flex">
                    <a :href="route('social.oauth', 'google')">
                    <div class="google px-3" type="button">
                      <img src="/images/icons/search (1).png" width="35" alt="" />
                    </div>
                    </a>
                    <a :href="route('social.oauth', 'facebook')">
                    <div class="facebook px-3" type="button">
                      <img
                        src="/images/icons/facebook (1).png"
                        width="35"
                        alt=""
                      />
                    </div>
                  </a>
                  </div>
                  <div class="col-12 mt-4 text-center">
                    <Link class="text-decoration-underline" :href="route('index')"><small>Back to Home Page</small></Link>
                  </div>
                </div>
             
            </div>
          </div>
        </div>
      </div>
    </div>
  <!-- </AppLayout> -->
 
  </template>
  


<script>
import AppLayout from '@@/Layouts/AppLayout.vue';
import { Link, useForm } from "@inertiajs/inertia-vue3";
import FileInputComponent from "@/Components/FileInputComponent.vue";
// import SelectInputComponentVue from '../../Components/SelectInputComponent.vue';

// import SuspendedUserAlert from "./Partials/SuspendedUserAlert.vue";

export default {
    components: {
        AppLayout,
        Link,
        FileInputComponent,
    },
    mounted(){
        const pwd = document.getElementById("password");
        const chk = document.getElementById("chk");
        const icon = document.getElementById("icon");

        chk.onchange = function(e){
           if(chk.checked){
            pwd.type = "text";
            icon.classList.add("fa-eye");
            icon.classList.remove("fa-eye-slash");
           }else{
            pwd.type = "password";
            icon.classList.add("fa-eye-slash");
           }
        };
    },


  props: {
    errors: Object,
    allRoles: Object,
  },

  data() {
    return {
      form: useForm({
        id: "",
        username: "",
        password: "",
      }),
    };
  },

  methods: {
  submit() {
    this.form.post(route("front.end.customer.login"), {
      onSuccess: () => {
        this.form.reset();
        this.$root.showMessage(
          "success",
          '<span class="text-success">Success</span><br/>',
          "Logging Successful!"
        );
      },
      onError: () => {
        // Show error message for incorrect email or password
        this.form.reset("password");
      },
    });
  },
},

};
</script>


<style scoped>
.form-control {
  box-shadow: none;
  border-top-left-radius: 18px;
  border-bottom-left-radius: 18px;
}

.input-group-text {
  border-top-right-radius: 18px;
  border-bottom-right-radius: 18px;
}

.input-group {
  border-radius: 18px;
}
.form-check-input {
  box-shadow: none;
}
.login-btn {
  border-radius: 18px;
}
.login-btn{
        border-radius: 18px;
}
.border-radius-custom{
    border-top-right-radius: 18px !important;
    border-bottom-right-radius: 18px !important;
}
.fa-eye-slash{
   font-size:15px
}

@media (max-width:1400px){
    .form-control{
        padding-bottom: 0.5rem !important;
        padding-top: 0.5rem !important;
    }
    .input-fields{
        padding-right:1rem !important;
        padding-left: 1rem !important;
    }
   
}
</style>