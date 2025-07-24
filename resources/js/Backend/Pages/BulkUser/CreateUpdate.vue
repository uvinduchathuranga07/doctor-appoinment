<template>
  <AppLayout>
    <div class="row">
      <!-- Employees CSV upload -->
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            <h5>Bulk Employee Upload</h5>
          </div>
          <div class="card-body">
            <form @submit.prevent="submitEmployees" enctype="multipart/form-data">
              <FileInputComponent
                id="employee_csv"
                label="Employee CSV File"
                accept=".csv"
                v-model="employeeForm.csv"
                :error="employeeForm.errors.csv"
              />
              <div class="mt-3">
                <button
                  type="submit"
                  class="btn btn-main"
                  :disabled="employeeForm.processing"
                >
                  Save Employees
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Doctors document upload -->
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-header">
            <h5>Bulk Doctor Documents</h5>
          </div>
          <div class="card-body">
            <form @submit.prevent="submitDoctors" enctype="multipart/form-data">
              <FileInputComponent
                id="doctor_doc"
                label="Doctor Document"
                accept=".pdf,.doc,.docx"
                v-model="doctorForm.document"
                :error="doctorForm.errors.document"
              />
              <div class="mt-3">
                <button
                  type="submit"
                  class="btn btn-main"
                  :disabled="doctorForm.processing"
                >
                  Submit Doctors
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import FileInputComponent from '@/Components/FileInputComponent.vue'

export default {
  components: {
    AppLayout,
    FileInputComponent,
  },

  data() {
    return {
      employeeForm: useForm({
        csv: null,
      }),
      doctorForm: useForm({
        document: null,
      }),
    }
  },

  methods: {
    submitEmployees() {

    },

    submitDoctors() {
   
    },
  },
}
</script>
