<template>
  <AppLayout>
    <div class="card p-4">
      <h4>{{ prescription ? "Edit" : "Add" }} Prescription - {{ schedule.doctor.name }} ({{ schedule.day }})</h4>

      <form @submit.prevent="submit">
        <input type="hidden" v-model="form.doctor_schedule_id" />

        <div class="mb-3">
          <label>Patient</label>
          <select class="form-control" v-model="form.patient_id">
            <option value="" disabled>Select Patient</option>
            <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
          </select>
          <div class="text-danger">{{ form.errors.patient_id }}</div>
        </div>

        <div class="mb-3">
          <label>Prescription Details</label>
          <textarea class="form-control" v-model="form.details" rows="4"></textarea>
          <div class="text-danger">{{ form.errors.details }}</div>
        </div>

        <button type="submit" class="btn btn-main me-2" :disabled="form.processing">
          {{ prescription ? "Update" : "Save" }}
        </button>
        <Link :href="route('prescription.index', schedule.id)" class="btn btn-outline-danger">Cancel</Link>
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
    schedule: Object,
    patients: Array,
    prescription: Object,
  },
  data() {
    return {
      form: useForm({
        id: this.prescription?.id || "",
        doctor_schedule_id: this.schedule.id,
        patient_id: this.prescription?.patient_id || "",
        details: this.prescription?.details || "",
      }),
    };
  },
  methods: {
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
