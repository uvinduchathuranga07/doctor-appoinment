<template>
  <AppLayout>
    <div class="card p-4">
      <div class="d-flex justify-content-between mb-3">
        <h4>Employees</h4>
        <Link :href="route('employee.create')" class="btn btn-main btn-sm">
          <i class="bx bx-plus"></i> Add Employee
        </Link>
      </div>

      <data-table
        ref="datatable"
        :url="route('employee.getdata')"
        :columns="columns"
        :columnDefs="columnDefs"
      >
        <template #header>
          <tr>
            <th><input type="checkbox" /></th>
            <th>Emp ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Birthday</th>
            <th>Blood Type</th>
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
        { data: "check", name: "check", orderable: false },
        { data: "emp_id", name: "emp_id" },
        { data: "name", name: "name" },
        { data: "age", name: "age" },
        { data: "gender", name: "gender" },
        { data: "birthday", name: "birthday" },
        { data: "blood_type", name: "blood_type" },
        { data: "action", name: "action", orderable: false },
      ],
      columnDefs: [],
    };
  },
  mounted() {
    $("#mytable tbody").on("click", ".action_edit", (e) => {
      const id = $(e.target).data("item-id");
      this.$inertia.visit(route("employee.edit", id));
    });
  },
};
</script>
