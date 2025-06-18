<template>
    <div>
      <div
        class="form-check my-3"
        v-for="model in $page.props.models"
        :key="model.id"
      >
        <input
          class="form-check-input"
          type="checkbox"
          :value="model.id"
          v-model="form.model"
          @change="onCheckVehicleModel"
          :id="'check_v_model_' + model.id"
        />
        <label class="form-check-label" :for="'check_v_model_' + model.id">
          {{ model.title }}
        </label>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          model: []
        }
      };
    },
    mounted() {
      this.setFormData();
    },
    methods: {
      onCheckVehicleModel() {
        const query = this.$page.props.requestQuery ?? {};
        this.$inertia.reload({
          method: "POST",
          data: { "_method": "GET", ...query, model: this.form.model },
          onSuccess: () => {
            this.setFormData();
          }
        });
      },
      setFormData() {
        const query = this.$page.props.requestQuery ?? {};
        if (query.hasOwnProperty("model")) {
          this.form.model = Array.isArray(query.model)
            ? query.model
            : [query.model];
        }
      }
    }
  };
  </script>
  