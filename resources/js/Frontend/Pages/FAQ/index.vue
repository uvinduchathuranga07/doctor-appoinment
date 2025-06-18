<template>
  <AppLayout>

    <Banner />

    <Faq />

  </AppLayout>
</template>

<script>
// import $ from 'jquery';
import AppLayout from '@@/Layouts/AppLayout.vue';
import Banner from '../FAQ/partials/Banner.vue';
import Faq from './partials/Faq.vue';


export default {
    components:{
        AppLayout,
        Banner,
        Faq
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