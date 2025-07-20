<template>
  <AppLayout>
    <div class="card p-4">
      <h4 class="mb-4">Prescription Details</h4>

      <div class="mb-3">
        <strong>Doctor:</strong>
        {{ prescription.appointment?.doctor?.name || '—' }}
      </div>

      <div class="mb-3">
        <strong>Patient:</strong>
        {{ prescription.patient?.name || '—' }}
      </div>

      <div class="mb-3">
        <strong>Date:</strong>
        {{ prescription.appointment?.appointment_date || '—' }}
      </div>

      <div class="mb-3">
        <strong>Status:</strong>
        <span :class="{
          'text-success': prescription.status === 'completed',
          'text-danger': prescription.status === 'cancelled',
          'text-warning': prescription.status === 'pending'
        }">
          {{ prescription.status || '—' }}
        </span>
      </div>

      <div class="mb-3">
        <strong>Pharmacy:</strong>
        {{ prescription.pharmacy_name || '—' }}
      </div>

      <div class="mb-3">
        <strong>Prescription Items:</strong>
        <ul v-if="parsedDetails.length">
          <li v-for="(item, index) in parsedDetails" :key="index">
            {{ item.product_name }} × {{ item.quantity }}
          </li>
        </ul>
        <p v-else class="text-muted">No items</p>
      </div>

      <!-- Send to Pharmacy Section -->
      <div class="mt-4">
        <label>Select Pharmacy</label>
        <select v-model="pharmacyName" class="form-control mb-2">
          <option disabled value="">Select</option>
          <option value="pharmacy1">Pharmacy 1</option>
          <option value="pharmacy2">Pharmacy 2</option>
        </select>

        <button
          class="btn btn-main"
          @click="sendOrder"
          :disabled="sending || !pharmacyName"
        >
          {{ sending ? "Sending..." : "Send to Pharmacy" }}
        </button>
      </div>

      <Link
        :href="route('prescription.index')"
        class="btn btn-outline-secondary mt-3"
      >
        <i class="bx bx-arrow-back"></i> Back to List
      </Link>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import axios from 'axios';

export default {
  components: { AppLayout, Link },
  props: {
    prescription: Object,
    parsedDetails: Array,
  },
  data() {
    return {
      pharmacyName: '',
      sending: false,
    };
  },
  methods: {
    async sendOrder() {
      if (!this.pharmacyName) return;

      this.sending = true;
      try {
        this.$inertia.post(route('order.send'), {
          prescription_id: this.prescription.id,
          pharmacy_name: this.pharmacyName,
        });
        this.$root.showMessage(
          'success',
          'Order Sent',
          'Prescription sent to pharmacy successfully.'
        );
      } catch (e) {
        this.$root.showMessage(
          'error',
          'Error',
          'Failed to send prescription to pharmacy.'
        );
      } finally {
        this.sending = false;
      }
    },
  },
};
</script>
