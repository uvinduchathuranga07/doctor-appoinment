<template>
  <AppLayout>
    <div class="card p-4">
      <h4>{{ prescription ? "Edit" : "Add" }} Prescription - {{ appointment.doctor.name }}</h4>

      <form @submit.prevent="submit">
        <input type="hidden" v-model="form.appointment_id" />

        <!-- Patient -->
        <div class="mb-3">
          <label>Patient</label>
          <select class="form-control" v-model="form.patient_id">
            <option value="" disabled>Select Patient</option>
            <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
          </select>
          <div class="text-danger">{{ form.errors.patient_id }}</div>
        </div>

        <!-- Prescription Details as Table -->
        <div class="mb-3">
          <label>Prescription Items</label>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th width="50">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in form.details" :key="index">
                <td>
                  <select class="form-control" v-model="item.product_id">
                    <option disabled value="">Select Product</option>
                    <option v-for="product in products" :key="product.id" :value="product.id">
                      {{ product.name }}
                    </option>
                  </select>
                </td>
                <td>
                  <input type="number" min="1" class="form-control" v-model="item.quantity" />
                </td>
                <td class="text-center">
                  <button type="button" class="btn btn-sm btn-danger" @click="removeRow(index)" v-if="form.details.length > 2">
                    <i class="bx bx-trash"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="text-danger">{{ form.errors.details }}</div>
          <button type="button" class="btn btn-sm btn-outline-primary" @click="addRow">
            <i class="bx bx-plus"></i> Add Item
          </button>
        </div>

        <!-- Status -->
        <div class="mb-3">
          <label>Status</label>
          <select class="form-control" v-model="form.status">
            <option disabled value="">Select Status</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
          </select>
          <div class="text-danger">{{ form.errors.status }}</div>
        </div>

        <!-- Pharmacy Name -->
        <div class="mb-3">
          <label>Pharmacy Name</label>
          <input type="text" class="form-control" v-model="form.pharmacy_name" placeholder="Optional" />
          <div class="text-danger">{{ form.errors.pharmacy_name }}</div>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-main me-2" :disabled="form.processing">
          {{ prescription ? "Update" : "Save" }}
        </button>
        <Link :href="route('prescription.index', appointment.id)" class="btn btn-outline-danger">Cancel</Link>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";

export default {
  components: { AppLayout, Link },
  props: {
    appointment: Object,
    patients: Array,
    prescription: Object,
    products: Array, // 👈 pass this from controller
  },
  data() {
    return {
      form: useForm({
        id: this.prescription?.id || "",
        appointment_id: this.appointment.id,
        patient_id: this.prescription?.patient_id || "",
        details: this.prescription?.details?.length
          ? this.prescription.details
          : [
              { product_id: "", quantity: 1 },
              { product_id: "", quantity: 1 },
            ],
        status: this.prescription?.status || "pending",
        pharmacy_name: this.prescription?.pharmacy_name || "",
      }),
    };
  },
  methods: {
    addRow() {
      this.form.details.push({ product_id: "", quantity: 1 });
    },
    removeRow(index) {
      this.form.details.splice(index, 1);
    },
    submit() {
      const routeName = this.prescription ? "prescription.update" : "prescription.store";
      this.form.post(route(routeName), {
        onSuccess: () => {
          this.$root.showMessage("success", "Success", "Prescription saved successfully.");
        },
        onError: () => {
          this.$root.showMessage("error", "Error", "Failed to save prescription.");
        },
      });
    },
  },
};
</script>
