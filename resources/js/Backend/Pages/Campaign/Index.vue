<template>
  <AppLayout>
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <h5>Manage Campaigns</h5>
        <Link :href="route('campaign.create')" class="btn btn-main">
          <i class="bx bx-plus"></i> Create
        </Link>
      </div>
      <div class="card-body">
        <DataTable
          ref="datatable"
          :url="route('campaign.getdata')"
          :columns="columns"
          :columnDefs="columnDefs"
        >
          <template #header>
            <tr>
              <th><input type="checkbox"/></th>
              <th>Name</th>
              <th>Date</th>
              <th>Details</th>
              <th>Photo</th>
              <th>Action</th>
            </tr>
          </template>
        </DataTable>
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
        { data: 'date', name: 'date' },
        { data: 'details', name: 'details' },
        { data: 'photopath', name: 'photopath', orderable: false, searchable: false },
        { data: 'action', name: 'action', orderable: false, searchable: false },
      ],
      columnDefs: [],
    }
  },
  mounted() {
    $('#mytable tbody')
      .on('click', '.action_edit', (e) => {
        const id = $(e.target).data('item-id')
        this.$inertia.visit(route('campaign.edit', id))
      })
      .on('click', '.action_delete', (e) => {
        const id = $(e.target).data('item-id')
        if (confirm('Delete this campaign?')) {
          axios.delete(route('campaign.destroy'), { data: { id } })
            .then(() => this.$refs.datatable.reload())
            .catch(console.error)
        }
      })
  },
}
</script>