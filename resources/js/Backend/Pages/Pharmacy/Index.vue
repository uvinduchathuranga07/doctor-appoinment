<template>
  <AppLayout>
    <div class="card p-4">
      <div class="d-flex justify-content-between mb-3">
        <h4>Pharmacy Orders</h4>
      </div>

      <data-table
        ref="datatable"
        :url="route('pharmacy.getdata')"
        :columns="columns"
        :columnDefs="columnDefs"
      >
        <template #header>
          <tr>
            <th><input type="checkbox" /></th>
            <th>Patient</th>
            <th>Pharmacy</th>
            <th>Status</th>
            <th>Total</th>
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

export default {
  components: { AppLayout, DataTable },
  data() {
    return {
      columns: [
        { data: "check", name: "check", orderable: false, searchable: false },
        { data: "patient", name: "patient" },
        { data: "pharmacy", name: "pharmacy_name" },
        { data: "status", name: "status" },
        { data: "total", name: "total_price" },
        { data: "action", name: "action", orderable: false, searchable: false },
      ],
      columnDefs: [],
    };
  },
  mounted() {
    $("#mytable tbody").on("click", ".action_view", (e) => {
      const id = $(e.target).closest("a").data("item-id");
      this.$inertia.visit(`/pharmacy/order/${id}`); // adjust route as needed
    });
     $("#mytable tbody").on("click", ".action_view", (e) => {
    const id = $(e.currentTarget).data("id");
   this.$inertia.visit(route('pharmacy.view', id));

    });
  },
};
</script>
