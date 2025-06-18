<template>
  <div>
    <Head title="General Settings" />
    <AppLayout>
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header">
              <h5>General Settings</h5>
              <p>Configure general site settings.</p>
            </div>
            <div class="card-body">
              <form id="formAccountSettings" @submit.prevent="submit">
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label for="app_name" class="form-label">App Name</label>
                    <input
                      class="form-control"
                      type="text"
                      id="app_name"
                      name="app_name"
                      v-model="form.app_name"
                    />
                    <div class="text-danger">{{ form.errors.app_name }}</div>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="app_description" class="form-label">App Description</label>
                    <input
                      class="form-control"
                      type="text"
                      name="app_description"
                      id="app_description"
                      v-model="form.app_description"
                    />
                    <div class="text-danger">{{ form.errors.app_description }}</div>
                  </div>
                  <div class="mb-3 col-md-6 d-flex align-items-center">
                    <label for="email" class="form-label me-3">App Favicon</label>
                    <FileInputComponentVue
                      id="app_favicon"
                      :prvImage="appFavicon"
                      v-model="form.app_favicon"
                    />
                    <div class="text-danger">{{ form.errors.app_favicon }}</div>
                  </div>
                  <div class="mb-3 col-md-6 d-flex align-items-center">
                    <label for="email" class="form-label me-3">App Logo</label>
                    <FileInputComponentVue
                      id="app_logo"
                      :prvImage="appLogo"
                      v-model="form.app_logo"
                    />
                    <div class="text-danger">{{ form.errors.app_logo }}</div>
                  </div>
                </div>
                <!-- <div class="row pt-3 border-top">
                  <div class="col-md-6">
                    <SelectInputComponent
                      class="w-100"
                      name="manufactures"
                      id="manufactures"
                      label="Featured Manufactures"
                      v-model="form.manufactures"
                      :options="manufactures"
                      :isMultiple="true"
                      :isRequired="false"
                    />
                    <div class="text-danger">{{ form.errors.manufactures }}</div>
                  </div>
                  <div class="col-md-6">
                    <SelectInputComponent
                      class="w-100"
                      name="models"
                      id="models"
                      label="Featured Models"
                      v-model="form.models"
                      :options="models"
                      :isMultiple="true"
                      :isRequired="false"
                    />
                    <div class="text-danger">{{ form.errors.models }}</div>
                  </div>
                  <div class="col-md-3">
                    <SelectInputComponent
                      class="w-100"
                      name="year_from"
                      id="year_from"
                      label="Year From"
                      v-model="form.year_from"
                      :options="years"
                      :isRequired="false"
                    />
                    <div class="text-danger">{{ form.errors.year_from }}</div>
                  </div>
                  <div class="col-md-3">
                    <SelectInputComponent
                      class="w-100"
                      name="year_to"
                      id="year_to"
                      label="Year to"
                      v-model="form.year_to"
                      :options="years"
                      :isRequired="false"
                    />
                    <div class="text-danger">{{ form.errors.year_to }}</div>
                  </div>
                </div> -->
                <!-- <div class="row pt-3 border-top">
                  <div class="mb-3 col-md-6">
                    <label for="affilate_point_value" class="form-label">Affiliate Points Value</label>
                    <input
                      class="form-control"
                      type="text"
                      id="affilate_point_value"
                      name="affilate_point_value"
                      v-model="form.affilate_point_value"
                    />
                    <div class="text-danger">{{ form.errors.affilate_point_value }}</div>
                    <div></div>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="redeem_point_value" class="form-label">Redeem Point Value</label>
                    <input
                      class="form-control"
                      type="text"
                      id="redeem_point_value"
                      name="redeem_point_value"
                      v-model="form.redeem_point_value"
                    />
                    <div class="text-danger">{{ form.errors.redeem_point_value }}</div>
                  </div>
                </div> -->
                <div class="mt-2" v-if="$root.hasPermission('system-setting.edit')">
                  <button type="submit" class="btn btn-main me-2" :disabled="form.processing">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  </div>
</template>

<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import FileInputComponentVue from "../../Components/FileInputComponent.vue";
import SelectInputComponent from "../../Components/SelectInputComponent.vue";

export default {
  components: {
    Head,
    AppLayout,
    FileInputComponentVue,
    SelectInputComponent
  },
  props: {
    settings: Object,
    years: Object,
    manufactures: Object,
    models: Object
  },
  data() {
    return {
      form: useForm({
        app_name: "",
        app_description: "",
        app_favicon: "",
        app_logo: "",
        manufactures: [],
        models: [],
        year_from: "",
        year_to: "",
        affilate_point_value:0,
        redeem_point_value:0,
      })
    };
  },
  mounted() {
    console.log("");
    if (this.settings) {
      // this.settings.map((s) => {
      //   this.form[s.key] = s.value;
      // });

      // reset image fields
      (this.form.manufactures = JSON.parse(this.settings.manufactures)),
        (this.form.models = JSON.parse(this.settings.models)),
        (this.form.year_from = this.settings.year_from),
        (this.form.year_to = this.settings.year_to),
        (this.form.app_name = this.settings.app_name),
        (this.form.app_description = this.settings.app_description),
        (this.form.affilate_point_value = this.settings.affilate_point_value),
        (this.form.redeem_point_value = this.settings.redeem_point_value),
        (this.form.app_favicon = ""),
        (this.form.app_logo = "");
    }
  },
  methods: {
    submit() {
      this.form.post(route("settings.general.update"), {
        preserveScroll: true,
        onSuccess: () => {
          this.$root.showMessage(
            "success",
            '<span class="text-success">Success</span><br/>',
            "Settings Updated Successfully! "
          );
        }
      });
    }
  },
  computed: {
    appFavicon() {
      return this.settings.app_favicon;
    },
    appLogo() {
      return this.settings.app_logo;
    }
  }
};
</script>

<style>
</style>