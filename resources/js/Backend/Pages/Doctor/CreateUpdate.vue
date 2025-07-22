<template>
  <AppLayout>
    <div class="card mb-4">
      <div class="card-header">
        <h5>{{ doctor ? "Edit Doctor" : "Create Doctor" }}</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label class="form-label">Name</label>
              <input class="form-control" v-model="form.name" />
              <div class="text-danger">{{ form.errors.name }}</div>
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label">Email</label>
              <input class="form-control" v-model="form.email" />
              <div class="text-danger">{{ form.errors.email }}</div>
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label">Phone</label>
              <input class="form-control" v-model="form.phone" />
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label">Specialization</label>
              <select class="form-control" v-model="form.specialization_id">
                <option disabled value="">Select Specialization</option>
                <option v-for="s in specializations" :key="s.id" :value="s.id">
                  {{ s.name }}
                </option>
              </select>
              <div class="text-danger">{{ form.errors.specialization_id }}</div>
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" v-model="form.password" />
              <div class="text-danger">{{ form.errors.password }}</div>
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label">Confirm Password</label>
              <input type="password" class="form-control" v-model="form.password_confirmation" />
              <div class="text-danger">{{ form.errors.password_confirmation }}</div>
            </div>
          </div>
          <div class="mb-3 col-md-6">
                  <label for="role" class="form-label">Role</label>
                  <select class="select2 form-control form-select" id="role" aria-label="Default select example"
                    v-model="form.role">
                    <option selected value="">-- Select --</option>
                    <option v-for="r in allRoles" :key="r.id" :value="r.id">
                      {{ r.name }}
                    </option>
                  </select>
                  <div class="text-danger">
                    {{ form.errors.role }}
                  </div>
          </div>
          <button type="submit" class="btn btn-main me-2">Save</button>
          <Link class="btn btn-outline-danger" :href="route('doctor.index')">Cancel</Link>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

export default {
  components: { AppLayout, Link },
  props: {
    doctor: Object,
    specializations: Array,
    allRoles: Object,
  },
  data() {
    return {
      form: useForm({
        id: this.doctor?.id || "",
        name: this.doctor?.name || "",
        email: this.doctor?.email || "",
        phone: this.doctor?.phone || "",
        role: this.doctor?.role_id || "",
        specialization_id: this.doctor?.specialization_id || "",
        password: "",
        password_confirmation: "",
      }),
    };
  },
  methods: {
    submit() {
      this.form.post(
        this.doctor ? route("doctor.update") : route("doctor.store")
      );
    },
  },
};
</script>
