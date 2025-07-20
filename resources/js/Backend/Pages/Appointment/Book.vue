<template>
  <AppLayout>
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h5>Appointments</h5>
            <p>List of booked appointments</p>
          </div>
          <div class="card-body">
            <data-table ref="datatable" :url="route('appointments.getdata')" :columns="columns" :columnDefs="columnDefs">
              <template #header>
                <tr>
                  <th width="10%">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="form-check-input" id="selectAll" @click="selectAll($event)" />
                      <label class="form-check-label" for="selectAll"></label>
                    </div>
                  </th>
                  <th>Doctor</th>
                  <th>Patient</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </template>
            </data-table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import DataTable from '@/Components/DataTable.vue'
import { useForm } from '@inertiajs/inertia-vue3'

export default {
  components: { AppLayout, DataTable },
  data() {
    return {
      form: useForm({ id: '' }),
      selectedRows: [],
      columns: [
        { data: 'check', name: 'check', orderable: false, searchable: false },
        { data: 'doctor', name: 'doctor' },
        { data: 'patient', name: 'patient' },
        { data: 'date', name: 'date' },
        { data: 'time', name: 'time' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false },
      ],
      columnDefs: [{ className: 'text-center', targets: [] }],
    }
  },
  mounted() {
    const self = this
    $('#mytable tbody').on('click', 'tr .btn-prescribe', (evt) => {
      const id = $(evt.target).data('item-id')
      this.$inertia.visit(route('prescription.create', id))
    })
    $('#mytable tbody').on('click', '.item-check input[type=checkbox]', (evt) => {
      const val = $(evt.target).val()
      if ($(evt.target).prop('checked') && !self.selectedRows.includes(val)) {
        self.getSelectedItems(val)
      } else {
        self.removeUnselectedItem(val)
      }
    })
  },
  methods: {
    reloadTable() {
      this.$refs.datatable.reloadDatatable()
    },
    getSelectedItems(value) {
      this.selectedRows.push(value)
    },
    selectAll(evt) {
      const self = this
      if ($(evt.target).is(':checked')) {
        $('.item-check input[type=checkbox]').prop('checked', true)
        $('.item-check input[type=checkbox]:checked').each(function () {
          if (!self.selectedRows.includes(this.value)) {
            self.getSelectedItems(this.value)
          }
        })
      } else {
        $('.item-check input[type=checkbox]').prop('checked', false)
        $('.item-check input[type=checkbox]').each(function () {
          if (self.selectedRows.includes(this.value)) {
            self.removeUnselectedItem(this.value)
          }
        })
      }
    },
    removeUnselectedItem(value) {
      this.selectedRows = this.selectedRows.filter((val) => val !== value)
    },
  },
}
</script>
