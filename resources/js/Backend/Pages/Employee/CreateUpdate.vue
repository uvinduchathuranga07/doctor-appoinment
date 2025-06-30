<template>
  <AppLayout>
    <div class="card p-4">
      <h4>{{ employee ? "Edit" : "Add" }} Employee</h4>

      <form @submit.prevent="submit">
        <div class="mb-3">
          <label>Employee ID</label>
          <input type="text" class="form-control" v-model="form.emp_id" />
          <div class="text-danger">{{ form.errors.emp_id }}</div>
        </div>

        <div class="mb-3">
          <label>Name</label>
          <input type="text" class="form-control" v-model="form.name" />
          <div class="text-danger">{{ form.errors.name }}</div>
        </div>

        <div class="mb-3">
          <label>Age</label>
          <input type="number" class="form-control" v-model="form.age" />
        </div>

        <div class="mb-3">
          <label>Gender</label>
          <select class="form-control" v-model="form.gender">
            <option value="" disabled>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <div class="mb-3">
          <label>Birthday</label>
          <input type="date" class="form-control" v-model="form.birthday" />
        </div>

        <div class="mb-3">
          <label>Blood Type</label>
          <input type="text" class="form-control" v-model="form.blood_type" />
        </div>

        <button type="submit" class="btn btn-main me-2" :disabled="form.processing">
          {{ employee ? "Update" : "Save" }}
        </button>
        <Link :href="route('employee.index')" class="btn btn-outline-danger">Cancel</Link>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";

export default {
  components: { AppLayout, Link },
  props: {
    employee: Object,
  },
  data() {
    return {
      form: useForm({
        id: this.employee?.id || "",
        emp_id: this.employee?.emp_id || "",
        name: this.employee?.name || "",
        age: this.employee?.age || "",
        gender: this.employee?.gender || "",
        birthday: this.employee?.birthday || "",
        blood_type: this.employee?.blood_type || "",
      }),
    };
  },
  methods: {
    submit() {
      const routeName = this.employee ? "employee.update" : "employee.store";
      this.form.post(route(routeName));
    },
  },
};
</script>
