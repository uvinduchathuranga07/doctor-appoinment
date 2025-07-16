<template>
  <AppLayout>
    <div class="card mb-4">
      <div class="card-header">
        <h5>{{ campaign ? 'Edit Campaign' : 'Create Campaign' }}</h5>
      </div>
      <div class="card-body">
        <form @submit.prevent="submit" enctype="multipart/form-data">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label class="form-label">Name</label>
              <input class="form-control" v-model="form.name" />
              <div class="text-danger">{{ form.errors.name }}</div>
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label">Date</label>
              <input type="date" class="form-control" v-model="form.date" />
              <div class="text-danger">{{ form.errors.date }}</div>
            </div>
            <div class="mb-3 col-12">
              <label class="form-label">Details</label>
              <textarea class="form-control" v-model="form.details"></textarea>
              <div class="text-danger">{{ form.errors.details }}</div>
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label">Photo</label>
              <input type="file" class="form-control" @change="handleFile" />
              <div class="text-danger">{{ form.errors.image }}</div>
              <div v-if="preview" class="mt-2">
                <img :src="preview" class="img-thumbnail" style="max-width: 150px;" />
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-main me-2">Save</button>
          <Link class="btn btn-outline-danger" :href="route('campaign.index')">
            Cancel
          </Link>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { ref } from 'vue'                    // ← add this
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/inertia-vue3'

export default {
  components: { AppLayout, Link },
  props: { campaign: Object },
  setup(props) {
    const form = useForm({
      id: props.campaign?.id || '',
      name: props.campaign?.name || '',
      date: props.campaign?.date || '',
      details: props.campaign?.details || '',
      image: null,
    })

    const preview = ref(
      props.campaign?.photopath ? '/' + props.campaign.photopath : null
    )

    function handleFile(e) {
      form.image = e.target.files[0]
      preview.value = URL.createObjectURL(form.image)
    }

    function submit() {
      form.post(
        props.campaign
          ? route('campaign.update')
          : route('campaign.store'),
        { preserveState: true }
      )
    }

    return { form, preview, handleFile, submit }
  },
}
</script>
