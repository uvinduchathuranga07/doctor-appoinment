<template>
  <AppLayout>
    <div class="card p-4">
      <div class="d-flex justify-content-between mb-3">
        <h4>Prescriptions for {{ schedule.doctor.name }} - {{ schedule.day }}</h4>
        <Link :href="route('prescription.create', schedule.id)" class="btn btn-main btn-sm">
          <i class="bx bx-plus"></i> Add Prescription
        </Link>
      </div>

      <data-table
        ref="datatable"
        :url="route('prescription.getdata', schedule.id)"
        :columns="columns"
        :columnDefs="columnDefs"
      >
        <template #header>
          <tr>
            <th><input type="checkbox" /></th>
            <th>Patient</th>
            <th>Details</th>
            <th>Date</th>
            <th>Action</th>
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
  components: { AppLayout, DataTable, Link },
  props: {
    schedule: Object,
  },
  data() {
    return {
      columns: [
        { data: "check", name: "check", orderable: false, searchable: false },
        { data: "patient", name: "patient" },
        { data: "details", name: "details" },
        { data: "created_at", name: "created_at" },
        { data: "action", name: "action", orderable: false },
      ],
      columnDefs: [],
    };
  },
  mounted() {
    $("#mytable tbody").on("click", ".action_edit", (e) => {
      const id = $(e.target).data("item-id");
      this.$inertia.visit(route("prescription.edit", [this.schedule.id, id]));
    });
  },
};
</script>
