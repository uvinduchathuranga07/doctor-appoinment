<template>
    <div>
      <div
        class="form-check my-3"
        v-for="(type, index) in driverTypes"
        :key="index"
      >
        <input
          class="form-check-input"
          type="checkbox"
          :value="type"
          v-model="form.drive_type"
          @change="onCheckDriverType"
          :id="'check_drive_type_' + index"
        />
        <label
          class="form-check-label"
          :for="'check_drive_type_' + index"
        >
          {{ type }}
        </label>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        driverTypes: ['Right Side Driving', 'Left Side Driving'],
  
        form: {
          drive_type: []
        }
      };
    },
    mounted() {
      this.setFormData();
    },
    methods: {
      onCheckDriverType(evt) {
        const query = this.$page.props.requestQuery ?? {};
  
        this.$inertia.reload({
          method: 'POST',
          data: {
            '_method': 'GET',
            ...query,
            drive_type: this.form.drive_type
          },
          onSuccess: () => {
            this.setFormData();
          }
        });
      },
      setFormData() {
        const query = this.$page.props.requestQuery ?? {};
  
        if (query.hasOwnProperty('drive_type')) {
          this.form.drive_type = Array.isArray(query.drive_type)
            ? query.drive_type
            : [query.drive_type];
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .form-check-input {
    box-shadow: none;
  }
  </style>
  