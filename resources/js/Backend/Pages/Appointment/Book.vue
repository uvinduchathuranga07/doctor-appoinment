<template>
  <AppLayout>
    <div class="card p-4">
      <h4>Book Appointment</h4>

      <form @submit.prevent="submit">
        <div class="mb-3">
          <label>Doctor</label>
          <select v-model="form.doctor_id" class="form-control" @change="fetchSlots">
            <option value="">Select Doctor</option>
            <option v-for="doctor in doctors" :key="doctor.id" :value="doctor.id">
              {{ doctor.name }} ({{ doctor.specialization?.name }})
            </option>
          </select>
          <div class="text-danger">{{ form.errors.doctor_id }}</div>
        </div>

        <div class="mb-3">
          <label>Date</label>
          <input type="date" v-model="form.appointment_date" class="form-control" @change="fetchSlots" />
          <div class="text-danger">{{ form.errors.appointment_date }}</div>
        </div>

        <div class="mb-3" >
          <label>Time Slot</label>
          <select v-model="form.start_time" class="form-control">
            <option value="">Select Time</option>
            <option v-for="slot in availableSlots" :key="slot" :value="slot">{{ slot }}</option>
          </select>
          <div class="text-danger">{{ form.errors.start_time }}</div>
        </div>

        <button type="submit" class="btn btn-main mt-3" :disabled="form.processing">
          Book Appointment
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";

export default {
  props: {
    doctors: Array,
  },
  components: {
    AppLayout,
  },
  data() {
    return {
      availableSlots: [],
      form: useForm({
        doctor_id: "",
        appointment_date: "",
        start_time: "",
      }),
    };
  },
  methods: {
    fetchSlots() {
      if (this.form.doctor_id && this.form.appointment_date) {
        axios
          .get(route("appointments.getAvailableSlots", this.form.doctor_id), {
            params: { date: this.form.appointment_date },
          })
          .then((res) => {
            this.availableSlots = res.data;
          });
      }
    },
    submit() {
      this.form.post(route("appointments.store"));
    },
  },
};
</script>
