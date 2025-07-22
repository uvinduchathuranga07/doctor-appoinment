<template>
  <AppLayout>
    <div class="card p-4">
      <h4>Order Details</h4>

      <div class="mb-2"><strong>Patient:</strong> {{ order.prescription?.patient?.name ?? '—' }}</div>
      <div class="mb-2"><strong>Pharmacy:</strong> {{ order.pharmacy_name }}</div>
      <div class="mb-2"><strong>Status:</strong> {{ order.status }}</div>
      <div class="mb-2"><strong>Payment:</strong> {{ order.payment_status }}</div>

      <h5 class="mt-4">Products</h5>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Product</th>
            <th>Price (Rs.)</th>
            <th>Qty</th>
            <th>Total (Rs.)</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(p, index) in products" :key="index">
            <td>{{ p.name }}</td>
            <td>{{ p.price }}</td>
            <td>{{ p.quantity }}</td>
            <td>{{ p.total.toFixed(2) }}</td>
          </tr>
        </tbody>
      </table>

      <div class="text-end">
        <strong>Total Price: Rs. {{ order.total_price}}</strong>
      </div>

      <div class="mb-3">
  <label><strong>Update Status</strong></label>
  <div class="d-flex align-items-center gap-2">
    <select v-model="status" class="form-control" style="width: 200px;">
      <option disabled value="">Select status</option>
      <option value="completed">Completed</option>
      <option value="shipped">Shipped</option>
    </select>
    <button
      class="btn btn-main"
      @click="updateStatus"
      :disabled="!status || submitting"
    >
      {{ submitting ? 'Updating...' : 'Update' }}
    </button>
<!-- <button class="btn btn-outline-secondary mt-3" @click="$inertia.visit(route('pharmacy.index'))">
  Back
</button> -->

  </div>
</div>

     
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'

export default {
  components: { AppLayout, Link },
  props: {
    order: Object,
    products: Array,
  },
  data() {
    return {
      status: this.order.status || '',
      submitting: false,
    }
  },
  methods: {
    updateStatus() {
      if (!this.status) return

      this.submitting = true

      Inertia.post(route('pharmacy.status.update', this.order.id), { status: this.status }, {
        onFinish: () => (this.submitting = false),
        onSuccess: () => {
          this.$root.showMessage('success', 'Success', 'Status updated successfully.')
        },
        onError: () => {
          this.$root.showMessage('error', 'Error', 'Failed to update status.')
        }
      })
    },
  },
}
</script>

