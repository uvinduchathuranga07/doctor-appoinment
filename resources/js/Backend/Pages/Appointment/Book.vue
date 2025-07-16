<template>
  <AppLayout>
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <h5>Book Appointment</h5>
        <Link
          :href="route('appointments.list')"
          class="btn btn-outline-secondary"
        >
          <i class="bx bx-list-ul"></i> View Appointments
        </Link>
      </div>
      <div class="card-body">
        <form @submit.prevent="submit">
          <div class="row">
            <!-- Doctor -->
            <div class="mb-3 col-md-4">
              <label class="form-label">Doctor</label>
              <select
                class="form-control"
                v-model="form.doctor_id"
              >
                <option disabled value="">Select a doctor</option>
                <option
                  v-for="doc in doctors"
                  :key="doc.id"
                  :value="doc.id"
                >
                  {{ doc.name }} ({{ doc.specialization?.name }})
                </option>
              </select>
              <div class="text-danger">{{ form.errors.doctor_id }}</div>
            </div>

            <!-- Date -->
            <div class="mb-3 col-md-4">
              <label class="form-label">Date</label>
              <input
                type="date"
                class="form-control"
                v-model="form.appointment_date"
              />
              <div class="text-danger">{{ form.errors.appointment_date }}</div>
            </div>

            <!-- Slots -->
            <div class="mb-3 col-md-4">
              <label class="form-label">Available Slots</label>
              <div v-if="loading" class="py-2">Loading…</div>
              <div v-else-if="slots.length">
                <div class="btn-group flex-wrap" role="group">
                  <button
                    v-for="slot in slots"
                    :key="slot"
                    type="button"
                    class="btn"
                    :class="{
                      'btn-primary': form.start_time === slot,
                      'btn-outline-primary': form.start_time !== slot
                    }"
                    @click="selectSlot(slot)"
                  >
                    {{ slot }}
                  </button>
                </div>
              </div>
              <div v-else class="py-2 text-muted">
                No slots available
              </div>
              <div class="text-danger">{{ form.errors.start_time }}</div>
            </div>
          </div>

          <button type="submit" class="btn btn-main">Book</button>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { ref, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, Link } from '@inertiajs/inertia-vue3'
import axios from 'axios'

export default {
  components: { AppLayout, Link },
  props: { doctors: Array },
  setup(props) {
    const form = useForm({
      doctor_id: '',
      appointment_date: '',
      start_time: '',
    })
    const slots = ref([])
    const loading = ref(false)
    // Use the globally-available Ziggy helper:
    const route = window.route

    // Reload slots on doctor or date change
    const fetchSlots = async () => {
      if (!form.doctor_id || !form.appointment_date) {
        slots.value = []
        return
      }
      loading.value = true
      try {
        const response = await axios.get(
          route('appointments.getAvailableSlots', form.doctor_id),
          { params: { date: form.appointment_date } }
        )
        slots.value = Array.isArray(response.data)
          ? response.data
          : response.data.slots || []
      } catch {
        slots.value = []
      } finally {
        loading.value = false
      }
    }

    watch(
      () => [form.doctor_id, form.appointment_date],
      fetchSlots
    )

    const selectSlot = (slot) => {
      form.start_time = slot
    }

    const submit = () => {
      form.post(route('appointments.store'))
    }

    return {
      form,
      slots,
      loading,
      selectSlot,
      submit,
      route,
      doctors: props.doctors,
    }
  },
}
</script>
