<template>
  <AppLayout>
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <h5>Appointments</h5>
        <Link :href="route('appointments.book')" class="btn btn-main">
          <i class="bx bx-plus"></i> Book Appointment
        </Link>
      </div>
      <div class="card-body">
        <DataTable
          ref="datatable"
          :url="route('appointments.getdata')"
          :columns="columns"
          :columnDefs="[]"
        >
          <template #header>
            <tr>
              <th><input type="checkbox" /></th>
              <th>Doctor</th>
              <th>Patient</th>
              <th>Date</th>
              <th>Time</th>
              <th>Status</th>
              <th>Action</th>              <!-- new header -->
            </tr>
          </template>
        </DataTable>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import DataTable from '@/Components/DataTable.vue'
import { Link } from '@inertiajs/inertia-vue3'

export default {
  components: { AppLayout, DataTable, Link },
  setup() {
    const columns = [
      { data: 'check',   name: 'check',   orderable: false, searchable: false },
      { data: 'doctor',  name: 'doctor' },
      { data: 'patient', name: 'patient' },
      { data: 'date',    name: 'date' },
      { data: 'time',    name: 'time' },
      { data: 'status',  name: 'status' },
      {                            // new column definition
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      },
    ]

    onMounted(() => {
      // when server JSON includes an 'action' field with <a class="btn-prescribe" data-item-id="...">
      $('#mytable tbody')
        .on('click', '.btn-prescribe', (e) => {
          const id = $(e.currentTarget).data('item-id')
          // navigate to your prescription-create page:
          this.$inertia.visit(route('prescriptions.create', id))
        })
    })

    return { columns }
  },
}
</script>
