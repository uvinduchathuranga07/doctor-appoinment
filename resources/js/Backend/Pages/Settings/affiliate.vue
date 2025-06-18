<template>
    <div>

        <Head title="General Settings" />
        <AppLayout>
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>General Settings</h5>
                            <p>Configure general site settings.</p>
                        </div>
                        <div class="card-body">
                            <form id="formAccountSettings" @submit.prevent="submit">
                                <div class="row pt-3 border-top">
                                    <div class="mb-3 col-md-6">
                                        <label for="affilate_point_value" class="form-label">Affiliate Points
                                            Value</label>
                                        <input class="form-control" type="text" id="affilate_point_value"
                                            name="affilate_point_value" v-model="form.affilate_point_value" />
                                        <div class="text-danger">{{ form.errors.affilate_point_value }}</div>
                                        <div></div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="redeem_point_value" class="form-label">Redeem Point Value</label>
                                        <input class="form-control" type="text" id="redeem_point_value"
                                            name="redeem_point_value" v-model="form.redeem_point_value" />
                                        <div class="text-danger">{{ form.errors.redeem_point_value }}</div>
                                    </div>
                                </div>
                                <div class="mt-2" v-if="$root.hasPermission('system-setting.edit')">
                                    <button type="submit" class="btn btn-main me-2"
                                        :disabled="form.processing">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    </div>
</template>

<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import FileInputComponentVue from "../../Components/FileInputComponent.vue";
import SelectInputComponent from "../../Components/SelectInputComponent.vue";

export default {
    components: {
        Head,
        AppLayout,
        FileInputComponentVue,
        SelectInputComponent
    },
    props: {
        settings: Object,
        years: Object,
        manufactures: Object,
        models: Object
    },
    data() {
        return {
            form: useForm({

                affilate_point_value: 0,
                redeem_point_value: 0,
            })
        };
    },
    mounted() {
        console.log("");
        if (this.settings) {
            (this.form.affilate_point_value = this.settings.affilate_point_value),
                (this.form.redeem_point_value = this.settings.redeem_point_value);

        }
    },
    methods: {
        submit() {
            this.form.post(route("settings.affiliate-pages.update"), {
                preserveScroll: true,
                onSuccess: () => {
                    this.$root.showMessage(
                        "success",
                        '<span class="text-success">Success</span><br/>',
                        "Settings Updated Successfully! "
                    );
                }
            });
        }
    },
    computed: {

    }
};
</script>

<style></style>