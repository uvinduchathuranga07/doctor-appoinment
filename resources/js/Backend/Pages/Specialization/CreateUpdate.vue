<template>
  <AppLayout>
    <div class="card mb-4">
      <div class="card-header">
        <h5>{{ specialization ? 'Edit Specialization' : 'Create Specialization' }}</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label class="form-label">Name</label>
              <input
                type="text"
                class="form-control"
                v-model="form.name"
                placeholder="Enter specialization name"
              />
              <div class="text-danger">{{ form.errors.name }}</div>
            </div>
          </div>
          <button type="submit" class="btn btn-main me-2">
            Save
          </button>
          <Link
            class="btn btn-outline-danger"
            :href="route('specialization.index')"
          >
            Cancel
          </Link>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/inertia-vue3'

export default {
  components: { AppLayout, Link },
  props: {
    specialization: Object,
  },
  setup(props) {
    const form = useForm({
      id: props.specialization?.id || '',
      name: props.specialization?.name || '',
    })

    function submit() {
      if (props.specialization) {
        form.post(route('specialization.update'))
      } else {
        form.post(route('specialization.store'))
      }
    }

    return { form, submit }
  },
}
</script>
