<template>
  <div>
    <div
      :id="id + 'ImagePreview'"
      :class="'image-preview-box ' + parentCls"
      @click="triggerFileInput"
    >
      <img
        v-if="previewImage"
        :src="previewImage"
        style="width: 100%; height: 100%; object-fit: cover"
      />
      <img
        v-else
        src="/images/file-upload.png"
        style="width: 50px; height: 50px; object-fit: contain; opacity: 0.6"
      />
    </div>
    <input
      type="file"
      :id="id"
      class="form-control"
      style="display: none !important"
      @change="handleFileChange"
      :multiple="isMultiple"
      :required="isRequired"
    />
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      required: true,
    },
    prvImage: {
      type: String,
      default: "",
    },
    isMultiple: {
      type: Boolean,
      default: false,
    },
    parentCls: {
      type: String,
      default: "",
    },
    modelValue: {
      default: [],
    },
    isRequired: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      previewImage: this.prvImage || "", // Use existing image or empty
    };
  },
  watch: {
    prvImage(newVal) {
      this.previewImage = newVal; // Update preview when prop changes
    },
  },
  methods: {
    triggerFileInput() {
      document.getElementById(this.id).click();
    },
    handleFileChange(event) {
      const files = event.target.files;
      if (!files.length) return;

      const file = files[0];
      if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.previewImage = e.target.result;
        };
        reader.readAsDataURL(file);
      }

      // Emit file data for parent component
      this.$emit("update:modelValue", this.isMultiple ? files : file);
    },
  },
};
</script>

<style>
.image-preview-box {
  width: 80px;
  height: 80px;
  cursor: pointer;
  border: 2px dashed #d3d3d3;
  background-position: center center;
  background-size: cover;
  background-repeat: no-repeat;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
