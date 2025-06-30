<template>
  <AppLayout>
    <div class="card p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Doctor Schedules</h4>
        <Link :href="route('doctor-schedule.create')" class="btn btn-main btn-sm">
          <i class="bx bx-plus"></i> Create
        </Link>
      </div>
      <data-table
        ref="datatable"
        :url="route('doctor-schedule.getdata')"
        :columns="columns"
        :columnDefs="columnDefs"
      >
        <template #header>
          <tr>
            <th><input type="checkbox" /></th>
            <th>Doctor</th>
            <th>Day</th>
            <th>Start</th>
            <th>End</th>
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
  data() {
    return {
      columns: [
        { data: "check", name: "check" },
        { data: "doctor", name: "doctor" },
        { data: "day", name: "day" },
        { data: "start_time", name: "start_time" },
        { data: "end_time", name: "end_time" },
        { data: "action", name: "action" },
      ],
      columnDefs: [],
    };
  },
  mounted() {
    $("#mytable tbody").on("click", ".action_edit", (e) => {
      const id = $(e.target).data("item-id");
      this.$inertia.visit(route("doctor-schedule.edit", id));
    });
  },
};
</script>
