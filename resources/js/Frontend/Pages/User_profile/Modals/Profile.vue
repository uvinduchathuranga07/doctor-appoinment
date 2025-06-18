<template>
    <div class="row g-3 justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border p-4">
                <form @submit.prevent="submit">
                <div class="row">
        <div class="col-md-12 mb-3">
            <label  class="form-label">Full Name</label>
            <input type="text" class="form-control" v-model="form.name">
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" v-model="form.email">
        </div>
        <!-- <div class="col-md-6">
            <label for="inputAddress" class="form-label">Address</label>
            <input type="text" class="form-control" id="inputAddress" v-model="form.address">
        </div> -->
        <div class="col-md-6">
            <label class="form-label">Mobile Number</label>
            <input type="text" class="form-control" v-model="form.phone">
        </div>
    
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-primary rounded-0 mt-2 border-0 w-100" style="background-color:#6b3397">Save Changes</button>
        </div>
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
        return{
            form:useForm({
                name:"",
                email:"",
                address:"",
                phone:"",
            }),
        }
    },
    mounted(){
        this.form.name = this.$page.props.logged_customer.name;
        this.form.email = this.$page.props.logged_customer.email;
        this.form.address = this.$page.props.logged_customer.address;
        this.form.phone = this.$page.props.logged_customer.phone;
    },
    methods:{
        submit() {
            this.form.post(route('profile.update'), {onSuccess:()=>{
                this.$root.showMessage(
          "success",
          '<span class="text-success">Success</span><br/>',
          "Profile updated successfully!"
        );
            }})
        }
    }
}
</script>

<style scoped>
.form-control{
    box-shadow: none;
}
</style>