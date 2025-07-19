<template>
  <AppLayout>
    <div class="card p-4">
      <h4>{{ prescription ? "Edit" : "Add" }} Prescription - {{ appointment.doctor.name }}</h4>

      <form @submit.prevent="submit">
        <input type="hidden" v-model="form.appointment_id" />

        <div class="mb-3">
          <label>Patient</label>
          <select class="form-control" v-model="form.patient_id">
            <option value="" disabled>Select Patient</option>
            <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
          </select>
          <div class="text-danger">{{ form.errors.patient_id }}</div>
        </div>

        <div class="mb-3">
          <label>Prescription Details (JSON format)</label>
          <textarea class="form-control" v-model="form.details" rows="4" placeholder='e.g. [{"med":"Paracetamol","dosage":"2x a day"}]'></textarea>
          <div class="text-danger">{{ form.errors.details }}</div>
        </div>

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

        <div class="mb-3">
          <label>Pharmacy Name</label>
          <input type="text" class="form-control" v-model="form.pharmacy_name" placeholder="Optional" />
          <div class="text-danger">{{ form.errors.pharmacy_name }}</div>
        </div>

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
  },
  data() {
    return {
      form: useForm({
        id: this.prescription?.id || "",
        appointment_id: this.appointment.id,
        patient_id: this.prescription?.patient_id || "",
        details: JSON.stringify(this.prescription?.details || []),
        status: this.prescription?.status || "pending",
        pharmacy_name: this.prescription?.pharmacy_name || "",
      }),
    };
  },
  methods: {
    submit() {
      try {
        // Parse JSON before sending
        this.form.details = JSON.parse(this.form.details);
      } catch (e) {
        this.$root.showMessage("error", "Error", "Invalid JSON in details.");
        return;
      }

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
