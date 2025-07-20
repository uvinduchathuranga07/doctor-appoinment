<template>
  <AppLayout>
    <div class="card p-4">
      <h4>Prescription View</h4>

      <div class="mb-3"><strong>Doctor:</strong> {{ prescription.appointment?.doctor?.name ?? '—' }}</div>
      <div class="mb-3"><strong>Patient:</strong> {{ prescription.patient?.name ?? '—' }}</div>
      <div class="mb-3"><strong>Date:</strong> {{ prescription.appointment?.appointment_date ?? '—' }}</div>
      <div class="mb-3"><strong>Status:</strong> {{ prescription.status }}</div>
      <div class="mb-3"><strong>Pharmacy:</strong> {{ prescription.pharmacy_name || '—' }}</div>

      <div class="mb-3">
  <strong>Details:</strong>
  <ul v-if="parsedDetails.length">
    <li v-for="(item, index) in parsedDetails" :key="index">
      {{ item.product_name }} x {{ item.quantity }}
    </li>
  </ul>
  <p v-else class="text-muted">No items</p>
</div>


      <Link :href="route('prescription.index')" class="btn btn-outline-secondary">Back to List</Link>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default {
  components: { AppLayout, Link },
 props: {
  prescription: Object,
  parsedDetails: Array
}
};
</script>
