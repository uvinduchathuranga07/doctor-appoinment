<template>

    <div class="container">
        <div class="row justify-content-center align-items-center py-5" style="min-height:100vh">
            <div class="col-md-5 px-4">
                <div class="card bg-white shadow-sm border rounded-5">
                    <div class="card-body mb-4">
                        <div class="header text-center py-4">
                            <Link :href="route('index')">
                            <img src="https://www.nikoba.com/images/logos/main-logo.png" class="pb-3" alt="">
                            </Link>
                            <h4 class="text-center fw-bold">Forgot Password</h4>
                        </div>
                        <form class="row input-fields gy-4 px-3" @submit.prevent="submit">
                            <div class="col-12">
                                <div class="input-group border">
                                    <input type="email" class="form-control bg-light border-0 py-3 px-4"
                                        placeholder="Enter Your Email" v-model="form.email">
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button class="btn btn-primary w-100 py-2 login-btn border-0" type="submit" style="background-color:#6a3090">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { Link, useForm } from '@inertiajs/inertia-vue3';



export default {
    components: {
        Link
    },
    data(){
        return {
            form:useForm({
                email:""
            })
        }
    },
    methods:{
        submit(){
           this.form.post(route('forgotpassword.submit'), {onSuccess:()=>{
            this.$root.showMessage(
          "success",
          '<span class="text-success">Success</span><br/>',
          "Password reset link send successfully! Please Check your email."
        );
           }, onError:()=>{}})
        }
    }
}
</script>

<style scoped>
.form-control {
    box-shadow: none;
    border-radius: 18px;
}
.input-group {
    border-radius: 18px;
}
.form-check-input{
    box-shadow: none;
}
.login-btn{
        border-radius: 18px;
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