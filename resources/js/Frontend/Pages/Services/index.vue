<template>
  <AppLayout>
    
    <Banner />

    <ServicesSection />

    <ServicesGrid />
    
  </AppLayout>
</template>

<script>
import AppLayout from '@@/Layouts/AppLayout.vue';
// import $ from 'jquery';
import Banner from './partials/Banner.vue';
import ServicesSection from './partials/ServicesSection.vue';
import ServicesGrid from './partials/SerivicesGrid.vue';


export default {
    components:{
        AppLayout,
        Banner,
        ServicesSection,
        ServicesGrid
    },
    mounted(){
        $(document).ready(function() {
      $("html, body").animate({ scrollTop: 0 }, "fastest");
      return false;
    });
    }
}
</script>

<style>

</style>