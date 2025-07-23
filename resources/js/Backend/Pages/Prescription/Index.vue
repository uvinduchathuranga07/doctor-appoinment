<template>
  <AppLayout>
    <div class="card p-4">
      <div class="d-flex justify-content-between mb-3">
        <h4>All Prescriptions</h4>
        <Link :href="route('appointments.list')" class="btn btn-dark">
          <i class="bx bx-calendar"></i> Appointment List
        </Link>
      </div>

      <data-table
        ref="datatable"
        :url="route('prescription.getdata')"
        :columns="columns"
        :columnDefs="columnDefs"
      >
        <template #header>
          <tr>
            <th>#</th>
            <th>Patient</th>
            <th>Status</th>
            <th class="text-center">Action</th>
          </tr>
        </template>
      </data-table>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    AppLayout,
    DataTable,
    Link,
  },
  data() {
    return {
      columns: [
        { data: "id", name: "id" },
        { data: "patient", name: "patient" },
        { data: "status", name: "status" },
        { data: "action", name: "action", orderable: false, searchable: false },
      ],
      columnDefs: [
        { className: "text-center", targets: [0, 3] },
      ],
    };
  },
};
</script>
