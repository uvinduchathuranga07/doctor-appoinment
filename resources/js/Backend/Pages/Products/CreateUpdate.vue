<template>
    <AppLayout>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h5>{{ product ? 'Update Product' : 'Create Product' }}</h5>
                        <p>Fill in product details and usage instructions.</p>
                    </div>
                    <hr />
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="row">
                                <!-- Product Info -->
                                <InputComponent label="Name" id="name" v-model="form.name" :error="form.errors.name" :isRequired="true" />
                                <InputComponent label="Stock Count" id="stock_count" type="number" v-model="form.stock_count" :error="form.errors.stock_count" />
                                <InputComponent label="Price" id="Price" type="number" v-model="form.price" :error="form.errors.price" />

                                <TextAreaComponent label="Details" id="details" v-model="form.details" :error="form.errors.details" />

                                <div class="mb-3 col-md-6">
                                    <label for="photopath" class="form-label me-3">
                                        Product Image
                                        <span class="ps-2 text-muted">(Optional)</span>
                                    </label>
                                    <FileInputComponent id="photopath" :prvImage="Image" v-model="form.photopath" :isRequired="false" />
                                    <div class="text-danger">{{ form.errors.photopath }}</div>
                                </div>

                                <!-- Howyouse Info -->
                                <TextAreaComponent label="Dosage Instructions" id="dosage_instructions" v-model="form.dosage_instructions" :error="form.errors.dosage_instructions" />
                                <TextAreaComponent label="Side Effects" id="side_effects" v-model="form.side_effects" :error="form.errors.side_effects" />
                                <TextAreaComponent label="Precaution" id="precaution" v-model="form.precaution" :error="form.errors.precaution" />
                                <TextAreaComponent label="Interaction" id="interaction" v-model="form.interaction" :error="form.errors.interaction" />
                                <TextAreaComponent label="Storage" id="storage" v-model="form.storage" :error="form.errors.storage" />
                                <TextAreaComponent label="Brand Names" id="brand_names" v-model="form.brand_names" :error="form.errors.brand_names" />
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-main me-2" :disabled="form.processing">
                                    {{ product ? "Update" : "Save" }}
                                </button>
                                <Link class="btn btn-outline-danger" :href="route('product.index')">Cancel</Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import InputComponent from "@/Components/InputComponent.vue";
import TextAreaComponent from "@/Components/TextAreaComponent.vue";
import FileInputComponent from "@/Components/FileInputComponent.vue";

export default {
    components: {
        Link,
        AppLayout,
        InputComponent,
        TextAreaComponent,
        FileInputComponent
    },

    props: {
        product: Object
    },

    data() {
        return {
            form: useForm({
                id: "",
                name: "",
                details: "",
                photopath: "",
                stock_count: "",
                price: "",
                dosage_instructions: "",
                side_effects: "",
                precaution: "",
                interaction: "",
                storage: "",
                brand_names: ""
            })
        };
    },

    mounted() {
        if (this.product) {
            this.form.id = this.product.id;
            this.form.name = this.product.name;
            this.form.details = this.product.details;
            this.form.photopath = this.product.photopath;
            this.form.stock_count = this.product.stock_count;
            this.form.price = this.product.price ;
            this.form.dosage_instructions = this.product.howyouse?.dosage_instructions ?? "";
            this.form.side_effects = this.product.howyouse?.side_effects ?? "";
            this.form.precaution = this.product.howyouse?.precaution ?? "";
            this.form.interaction = this.product.howyouse?.interaction ?? "";
            this.form.storage = this.product.howyouse?.storage ?? "";
            this.form.brand_names = this.product.howyouse?.brand_names ?? "";
        }
    },

    computed: {
        Image() {
            return this.product?.photopath
                ? this.product.photopath.startsWith("http")
                    ? this.product.photopath
                    : `/storage/${this.product.photopath}`
                : "";
        }
    },

    methods: {
        submit() {
            const routeName = this.product ? "product.update" : "product.store";

            this.form.post(route(routeName), {
                onSuccess: () => {
                    this.form.reset();
                    this.$root.showMessage(
                        "success",
                        '<span class="text-success">Success</span><br/>',
                        `Product ${this.product ? "updated" : "created"} successfully!`
                    );
                },
                onError: () => {
                    this.$root.showMessage(
                        "error",
                        '<span class="text-danger">Error</span><br>',
                        "Something went wrong!"
                    );
                }
            });
        }
    }
};
</script>
