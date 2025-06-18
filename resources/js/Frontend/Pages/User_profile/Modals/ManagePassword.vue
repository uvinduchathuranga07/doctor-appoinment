<template>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border p-4">
                <form class="row g-3" @submit.prevent="submit">
                    <div class="col-md-12">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" v-model="form.current_password">
                        <div v-if="form.errors.current_password" class="text-danger">{{ form.errors.current_password }}</div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" v-model="form.password">
                        <div v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" v-model="form.password_confirmation">
                        <div v-if="form.errors.password_confirmation" class="text-danger">{{ form.errors.password_confirmation }}</div>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100 rounded-0 border-0" style="background-color: rgb(107, 51, 151);" :disabled="form.processing">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    data(){
        return {
           form:useForm({current_password:"",
            password:"",
            password_confirmation:""})
        }
    },
    methods:{
        submit(){
            this.form.post(route('profile.password.update'), {onSuccess:()=>{
                this.$root.showMessage(
          "success",
          '<span class="text-success">Success</span><br/>',
          "Password updated successfully!"
        );
        this.form.reset();
            },errorBag:'password-reset'})
        }
    }
}
</script>

<style scoped>
.form-control{
    box-shadow:none;
}
</style>