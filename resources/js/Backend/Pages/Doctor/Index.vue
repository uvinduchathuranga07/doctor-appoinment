<template>
  <AppLayout>
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <h5>Manage Doctors</h5>
        <Link :href="route('doctor.create')" class="btn btn-main ">
          <i class="bx bx-plus"></i> Create</Link>
      </div>
      <div class="card-body">
        <data-table
          ref="datatable"
          :url="route('doctor.getdata')"
          :columns="columns"
          :columnDefs="columnDefs"
        >
          <template #header>
            <tr>
              <th><input type="checkbox" /></th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Specialization</th>
              <th>Action</th>
            </tr>
          </template>
        </data-table>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";

export default {
  components: { AppLayout, Link, DataTable },
  data() {
    return {
      columns: [
        { data: "check", name: "check", orderable: false, searchable: false },
        { data: "name", name: "name" },
        { data: "email", name: "email" },
        { data: "phone", name: "phone" },
        { data: "specialization", name: "specialization" },
        { data: "action", name: "action" },
      ],
      columnDefs: [],
    };
  },
  mounted() {
    $("#mytable tbody").on("click", ".action_edit", (e) => {
      const id = $(e.target).data("item-id");
      this.$inertia.visit(route("doctor.edit", id));
    });
  },
};
</script>
