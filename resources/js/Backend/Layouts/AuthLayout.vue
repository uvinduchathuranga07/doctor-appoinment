<template>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <slot></slot>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    // Respect saved theme on auth pages too
    const saved = localStorage.getItem("theme");
    const isDark = saved === "dark";
    const html = document.documentElement;
    html.classList.toggle("theme-dark", isDark);
    html.classList.toggle("theme-light", !isDark);
  }
};
</script>


<style src="../../../../public/css/backend/dark-theme.css"></style>