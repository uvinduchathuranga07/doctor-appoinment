<template>
    <section class="container mt-5">
        <form class="row g-3" @submit.prevent="submitEnquiry">
            <div class="col-md-6">
                <input type="text" class="form-control rounded-0" v-model="form.vehicle_name" disabled>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Your Name" v-model="form.name">
            </div>
            <div class="col-6">
                <input type="email" class="form-control" placeholder="Your Email" v-model="form.email">
            </div>
            <div class="col-6">
                <input type="text" class="form-control" placeholder="Your Mobile Number" v-model="form.mobile">
            </div>
            <div class="col-12">
                <select class="form-select" aria-label="Default select example" v-model="form.purchase_time">
                    <option value="" selected>When Are You Hoping To Purchase ?</option>
                    <option value="Immediately">Immediately</option>
                    <option value="Next Week">Next Week</option>
                    <option value="Two Weeks">Two Weeks</option>
                    <option value="One Month">One Month</option>
                    <option value="Not Sure">Not Sure</option>
                </select>
            </div>
            <div class="col-12">
                <select class="form-select" aria-label="Default select example" v-model="form.payment_method">
                    <option value="" selected>Payment Method</option>
                    <option value="Full Lease">Full Lease</option>
                    <option value="Half Lease">Half Lease</option>
                    <option value="Cash">Cash</option>
                    <option value="Loan">Loan</option>
                    <option value="Half Loan">Half Loan</option>
                </select>
            </div>
            <div class="col-12">
                <div class="input-group">
                    <textarea class="form-control" aria-label="With textarea" placeholder="Your Address"
                        v-model="form.address"></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="input-group">
                    <textarea class="form-control" aria-label="With textarea" placeholder="Your Message" rows="3"
                        v-model="form.message"></textarea>
                </div>
            </div>
            <Checkbox as="div" v-model="form.capchaResponse" />
            <div :class="capchaVerifyStyles">{{ form.capchaResponse ? 'Verified' : 'Please click the captcha' }}</div>

            <br />
            <div class="col-12">
                <button type="reset" class="btn btn-dark rounded-0 mx-1">RESET</button>
                <button type="submit" class="btn btn-primary rounded-0 mx-1">SUBMIT ENQUIRY</button>
            </div>
        </form>
    </section>
</template>

<script>

import { useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import { Checkbox } from 'vue-recaptcha';

export default {

    components: {
        Checkbox
    },
    data() {
        return {
            form: useForm({
                vehicle_name: this.$page.props.vehicle.manufacture.title + " " + this.$page.props.vehicle.vehicle_model.title + " " + this.$page.props.vehicle.ex_color.name,
                vehicle_url: route('product', { model: this.$root.stringToSlug(this.$page.props.vehicle.manufacture.title), slug: this.$root.stringToSlug(this.$page.props.vehicle.manufacture.title) + '-' + this.$root.stringToSlug(this.$page.props.vehicle.vehicle_model.title), id: this.$page.props.vehicle.id }),
                vehicle_id: this.$page.props.vehicle.id,
                stock_type: "local",
                name: "",
                email: "",
                mobile: "",
                purchase_time: "",
                payment_method: "",
                address: "",
                message: "",
                capchaResponse: null
            })
        }
    },
    methods: {
        submitEnquiry() {
            if (this.form.capchaResponse) {
                this.form.post(route('submit-inquiry'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        console.log('sved'),
                            this.form.reset('name', 'email', 'mobile', 'purchase_time', 'payment_method', 'address', 'message'),
                            Swal.fire({

                                icon: "success",
                                title: "Inquiry Submitted Successfully",
                                showConfirmButton: false,
                                timer: 1500
                            });
                    },
                    onError: () => {
                        console.log('error'),
                            Swal.fire({

                                icon: "error",
                                title: "Somthing went wrong! Please try again later",
                                showConfirmButton: false,
                                timer: 1500
                            });
                    }
                })
            }
        }
    },
    computed: {
        capchaVerifyStyles() {
            return this.form.capchaResponse ? 'text-success' : 'text-danger';
        }
    }
}
</script>

<style scoped>
.form-control,
.form-select {
    box-shadow: none !important;
}
</style>