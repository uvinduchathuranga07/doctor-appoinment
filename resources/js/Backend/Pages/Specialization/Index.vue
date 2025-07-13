<template>
  <AppLayout>
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <h5>Manage Specializations</h5>
        <Link :href="route('specialization.create')" class="btn btn-main">
          <i class="bx bx-plus"></i> Create
        </Link>
      </div>
      <div class="card-body">
        <data-table
          ref="datatable"
          :url="route('specialization.getdata')"
          :columns="columns"
          :columnDefs="columnDefs"
        >
          <template #header>
            <tr>
              <th><input type="checkbox" /></th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </template>
        </data-table>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3'
import DataTable from '@/Components/DataTable.vue'
import axios from 'axios'

export default {
  components: { AppLayout, Link, DataTable },
  data() {
    return {
      columns: [
        { data: 'check', name: 'check', orderable: false, searchable: false },
        { data: 'name', name: 'name' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
      ],
      columnDefs: [],
    }
  },
  mounted() {
    // Edit button
    $('#mytable tbody').on('click', '.action_edit', (e) => {
      const id = $(e.target).data('item-id')
      this.$inertia.visit(route('specialization.edit', id))
    })

    // Delete button
    $('#mytable tbody').on('click', '.action_delete', (e) => {
      const id = $(e.target).data('item-id')
      if (confirm('Are you sure you want to delete this specialization?')) {
        axios
          .delete(route('specialization.destroy'), { data: { id } })
          .then(() => this.$refs.datatable.reload())
          .catch((err) => console.error(err))
      }
    })
  },
}
</script>
