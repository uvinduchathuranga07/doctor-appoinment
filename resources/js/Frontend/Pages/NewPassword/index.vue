<template>

    <div class="container">
        <div class="row justify-content-center align-items-center py-5" style="min-height:100vh">
            <div class="col-md-5 px-4">
                <div class="card bg-white shadow-sm border rounded-5">
                    <div class="card-body mb-4">
                        <div class="header text-center py-4">
                            <Link :href="route('index')">
                            <img src="/images/main-logo (1).png" class="pb-3" alt="">
                            </Link>
                            <h4 class="text-center fw-bold">Reset Your Password</h4>
                        </div>
                        <form class="row input-fields gy-4 px-3" @submit.prevent="submit">
                            <div class="col-12">
                                <div class="alert alert-danger py-2" v-if="$page.props?.flash?.error">{{$page.props?.flash?.error  }}</div>
                                <div class="input-group border mb-4">
                                    <input type="email" class="form-control bg-light border-0 py-3 px-4"
                                        placeholder="Email" v-model="form.email">
                                </div>
                                <div class="input-group border mb-4">
                                    <input type="password" class="form-control bg-light border-0 py-3 px-4"
                                        placeholder="New Password" v-model="form.password">
                                </div>
                                <div class="input-group border">
                                    <input type="password" class="form-control bg-light border-0 py-3 px-4"
                                        placeholder="Confirm Password" v-model="form.password_confirmation">
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button class="btn btn-primary w-100 py-2 login-btn border-0" type="submit" style="background-color:#6a3090">RESET PASSWORD</button>
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
    props:{
        token:String
    },
    data(){
        return {
            form:useForm({
                token:this.token,
                email:"",
            password:"",
            password_confirmation:""})
        }
    },
    methods:{
        submit(){
            this.form.post(route('forget-password-link.store'))
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