<template>
    <AppLayout>
        <div class="row">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h5>Customers</h5>
                    <p>Manage Customers.</p>
                </div>
                <hr />
                <div class="alert alert-primary" v-if="form.id && form.enrolled_affiliate == 1 && !form.enrolled_affiliate_id">
                    <div class="d-flex align-items-center justify-content-between">
                    <div class="h5 text-primary mb-0">Enroll to Affiliate Program.</div>
                    <button class="btn btn-primary" @click="enrollAffilate(form.id)">Enroll</button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="formAccountSettings" @submit.prevent="submit">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label"
                                    >Name</label
                                >
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    v-model="form.name"
                                />
                                <div class="text-danger">
                                    {{ form.errors.name }}
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label"
                                    >Email</label
                                >
                                <input
                                    class="form-control"
                                    type="email"
                                    id="email"
                                    name="email"
                                    v-model="form.email"
                                />
                                <div class="text-danger">
                                    {{ form.errors.email }}
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label"
                                    >Phone</label
                                >
                                <input
                                    class="form-control"
                                    type="number"
                                    id="phone"
                                    name="phone"
                                    v-model="form.phone"
                                />
                                <div class="text-danger">
                                    {{ form.errors.phone }}
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label"
                                    >Address</label
                                >
                                <input
                                    class="form-control"
                                    type="text"
                                    id="address"
                                    name="address"
                                    v-model="form.address"
                                />
                                <div class="text-danger">
                                    {{ form.errors.address }}
                                </div>
                            </div>

                            <!-- Conditionally render password fields -->
                            <div v-if="customer">
                                <div class="mb-3 col-md-6">
                                    <label
                                        for="current_password"
                                        class="form-label"
                                        >Current Password</label
                                    >
                                    <input
                                        class="form-control"
                                        type="password"
                                        id="current_password"
                                        name="current_password"
                                        v-model="form.current_password"
                                    />
                                    <div class="text-danger">
                                        {{ form.errors.current_password }}
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="new_password" class="form-label"
                                        >New Password</label
                                    >
                                    <input
                                        class="form-control"
                                        type="password"
                                        id="new_password"
                                        name="new_password"
                                        v-model="form.new_password"
                                    />
                                    <div class="text-danger">
                                        {{ form.errors.new_password }}
                                    </div>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label
                                        for="confirm_new_password"
                                        class="form-label"
                                        >Confirm New Password</label
                                    >
                                    <input
                                        class="form-control"
                                        type="password"
                                        id="confirm_new_password"
                                        name="confirm_new_password"
                                        v-model="form.confirm_new_password"
                                    />
                                    <div class="text-danger">
                                        {{ form.errors.confirm_new_password }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-12" v-else>
                                <div class="row">
                                    <!-- Fields for creating a new customer -->
                                    <div class="mb-3 col-md-6">
                                        <label for="password" class="form-label"
                                            >Password</label
                                        >
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="password"
                                            name="password"
                                            v-model="form.password"
                                        />
                                        <div class="text-danger">
                                            {{ form.errors.password }}
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label
                                            for="confirm_password"
                                            class="form-label"
                                            >Confirm Password</label
                                        >
                                        <input
                                            class="form-control"
                                            type="password"
                                            id="confirm_password"
                                            name="confirm_password"
                                            v-model="form.confirm_password"
                                        />
                                        <div class="text-danger">
                                            {{ form.errors.confirm_password }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <SelectInputComponentVue
                                id="status"
                                label="Status"
                                :error="form.errors.status"
                                :options="[
                                    {
                                        id: '1',
                                        name: 'Active',
                                    },
                                    {
                                        id: '0',
                                        name: 'Inactive',
                                    },
                                ]"
                                v-model="form.status"
                            />

                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label"></label>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label
                                    for="profile_image"
                                    class="form-label me-3"
                                    >Profile Image</label
                                >
                                <br />
                                <FileInputComponent
                                    :isRequired="false"
                                    id="profile_image"
                                    :prvImage="Profile_Image"
                                    v-model="form.profile_image"
                                />
                                <div class="text-danger">
                                    {{ form.errors.profile_image }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <button
                                type="submit"
                                class="btn btn-main me-2"
                                :disabled="form.processing"
                            >
                                {{ customer ? "Update" : "Save" }}
                            </button>
                            <Link
                                class="btn btn-outline-danger"
                                :href="route('customer.index')"
                                >Cancel</Link
                            >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import FileInputComponent from "@/Components/FileInputComponent.vue";
import SelectInputComponentVue from "../../Components/SelectInputComponent.vue";

// import SuspendedUserAlert from "./Partials/SuspendedUserAlert.vue";

export default {
    components: {
        Link,
        AppLayout,
        FileInputComponent,
        // SuspendedUserAlert,
        SelectInputComponentVue,
    },

    props: {
        errors: Object,
        allRoles: Object,
        backendUser: Object,
        branches: Array,
        service_types: Object,
        vehicle_types: Object,
        customer: Object,
    },

    data() {
        return {
            form: useForm({
                id: "",
                name: "",
                status: "",
                email: "",
                phone: "",
                address: "",
                password: "",
                confirm_password: "",
                current_password: "", // For current password
                new_password: "", // For new password
                confirm_new_password: "", // For confirming new password
                profile_image: "",
            }),
            // password: useForm({
            //   id: "",
            //   confirm_password: "",
            //   password: "",
            //   password_confirmation: "",
            // }),
        };
    },
    mounted() {
        let self = this;

        if (this.customer) {
            this.form.id = this.customer.id;
            this.form.name = this.customer.name;
            this.form.status = this.customer.status;
            this.form.email = this.customer.email;
            this.form.address = this.customer.address;
            this.form.phone = this.customer.phone;
            this.form.enrolled_affiliate = this.customer.enrolled_affiliate;
            this.form.enrolled_affiliate_id = this.customer.enrolled_affiliate_id;
            this.form.password = "";
        }
        // $(".card-body").on("change", "#role", function (evt) {
        //   self.form.role = $(evt.target).val();
        // });
        // $(".card-body").on("change", "#branch", function (evt) {
        //   self.form.branch = $(evt.target).val();
        // });
    },
    computed: {
        Profile_Image() {
            return this.customer
                ? this.customer.media.length > 0
                    ? this.customer.media[0].original_url
                    : ""
                : "";
        },
    },
    methods: {
        enrollAffilate(id) {
            this.form.post(route('affilate-customer.enroll', {id}));
        },
        submit() {
            this.form.post(
                this.customer
                    ? route("customer.update")
                    : route("customer.store"),
                {
                    onSuccess: () => {
                        this.form.reset();
                        this.$root.showMessage(
                            "success",
                            '<span class="text-success">Success</span><br/>',
                            "A Record Was Created Successfully! "
                        );
                    },
                    onError: () => {
                        this.form.reset("password", "password_confirmation");
                        this.$root.showMessage(
                            "error",
                            '<span class="text-danger">Error</span><br>',
                            "Something went wrong! "
                        );
                    },
                }
            );
        },
    },
};
</script>
