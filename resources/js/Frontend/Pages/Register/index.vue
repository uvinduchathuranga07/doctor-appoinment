<template>
  <!-- <AppLayout> -->
    <div class="container" mar>
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
              <h4 class="text-center fw-bold">Create Your Account!</h4>
            </div>
            <form
              class="row input-fields gy-4 px-3"
              id="formAccountSetting"
              @submit.prevent="submit"
            >
              <div class="col-12">
                <div class="input-group border">
                  <input
                    type="text"
                    class="form-control bg-light border-0 py-3 px-4"
                    placeholder="Full Name"
                    id="name"
                    v-model="form.name"
                  />
                </div>
              </div>
              <div class="col-12">
                <div class="input-group border">
                  <input
                    type="email"
                    class="form-control bg-light border-0 py-3 px-4"
                    id="email"
                    v-model="form.email"
                    placeholder="Email"
                  />
                </div>
                <!-- Display the error message if email already exists -->
                <div v-if="form.errors.email" class="text-danger mt-2">
                  {{ form.errors.email }}
                </div>
              </div>

              <div class="col-12">
                <div class="input-group border">
                  <input
                    type="text"
                    class="form-control bg-light border-0 py-3 px-4"
                    placeholder="Mobile Number"
                    id="phone"
                    v-model="form.phone"
                  />
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
                  <label class="input-group-text border-0 border-radius-custom" for="chk"
                      ><i
                        class="fa-regular fa-eye-slash pe-3" id="icon"
                        style="color: #6a3090"
                      ></i
                    ></label>
                    <input type="checkbox" class="d-none" id="chk">
                </div>
              </div>
              <div class="col-12">
                <div class="input-group border">
                  <input
                    type="password"
                    class="form-control bg-light border-0 py-3 px-4"
                    placeholder="Confirm Password"
                    id="confirm_password"
                    v-model="form.confirm_password"
                  />
                </div>
                <!-- Display password mismatch error -->
                <div v-if="passwordMismatch" class="text-danger mt-2">
                  Passwords do not match.
                </div>
              </div>

              <div class="col-12 mt-4">
                <button
                  class="btn btn-primary w-100 py-2 login-btn border-0"
                  type="submit"
                  style="background-color: #6a3090"
                  :disabled="form.processing"
                >
                  REGISTER
                </button>
              </div>
            </form>
            <div class="row px-4 mt-2">
              <div class="col-12 mt-2 text-center">
                <small>
                  Have an Account?
                  <Link style="color: #6a3090" :href="route('user.login')"
                    >Signup</Link
                  >
                </small>
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
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@@/Layouts/AppLayout.vue";

export default {
    components: {
        Link,
        AppLayout
        
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
        name: "",
        email: "",
        phone: "",
        password: "",
        confirm_password: "",
      }),
      passwordMismatch: false, // To track if passwords match
    };
  },

  methods: {
    submit() {
      // Check if passwords match
      if (this.form.password !== this.form.confirm_password) {
        this.passwordMismatch = true;
        return;
      } else {
        this.passwordMismatch = false;
      }

      // Proceed with form submission if passwords match
      this.form.post(route("front.end.customer.store"), {
        onSuccess: () => {
          this.form.reset();
          this.$root.showMessage(
            "success",
            '<span class="text-success">Success</span><br/>',
            "A Record Was Created Successfully!"
          );
        },
        onError: () => {
          if (this.form.errors.email) {
            this.$root.showMessage(
              "error",
              '<span class="text-danger">Error</span><br>',
              "The email has already been taken!"
            );
          }
          this.form.reset("password", "confirm_password");
        },
      });
    },
  },
};
</script>

<style scoped>
.form-control {
  box-shadow: none;
  border-radius: 18px;
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
   font-size:15px;
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
