<template>
  <AppLayout>
    <div class="card p-4">
      <h4>{{ schedule ? "Edit" : "Create" }} Doctor Schedule</h4>
      <form @submit.prevent="submit">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Doctor</label>
            <select class="form-control" v-model="form.doctor_id">
              <option value="" disabled>Select Doctor</option>
              <option v-for="doc in doctors" :key="doc.id" :value="doc.id">
                {{ doc.name }}
              </option>
            </select>
            <div class="text-danger">{{ form.errors.doctor_id }}</div>
          </div>

          <div class="col-md-6 mb-3">
            <label>Day</label>
            <select class="form-control" v-model="form.day">
              <option disabled value="">Select Day</option>
              <option v-for="day in days" :key="day">{{ day }}</option>
            </select>
            <div class="text-danger">{{ form.errors.day }}</div>
          </div>

          <div class="col-md-6 mb-3">
            <label>Start Time</label>
            <input type="time" class="form-control" v-model="form.start_time" />
            <div class="text-danger">{{ form.errors.start_time }}</div>
          </div>

          <div class="col-md-6 mb-3">
            <label>End Time</label>
            <input type="time" class="form-control" v-model="form.end_time" />
            <div class="text-danger">{{ form.errors.end_time }}</div>
          </div>
        </div>

        <button class="btn btn-main me-2" type="submit">
          {{ schedule ? "Update" : "Save" }}
        </button>
        <Link :href="route('doctor-schedule.index')" class="btn btn-outline-danger">Cancel</Link>
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
    doctors: Array,
    schedule: Object,
  },
  data() {
    return {
      days: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
      form: useForm({
        id: this.schedule?.id || "",
        doctor_id: this.schedule?.doctor_id || "",
        day: this.schedule?.day || "",
        start_time: this.schedule?.start_time || "",
        end_time: this.schedule?.end_time || "",
      }),
    };
  },
  methods: {
    submit() {
      const routeName = this.schedule ? "doctor-schedule.update" : "doctor-schedule.store";
      this.form.post(route(routeName));
    },
  },
};
</script>
