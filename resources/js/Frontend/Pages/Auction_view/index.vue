<template>
    <AppLayout>
        <Banner />

        <VehicleDetails />
        
        <Details />

        
        
    </AppLayout>
  
</template>

<script>
// import $ from 'jquery';
import AppLayout from '@@/Layouts/AppLayout.vue';
import Banner from './partials/Banner.vue';
import VehicleDetails from './partials/Vehicle_details.vue';
import Details from './partials/Details.vue';

export default {
    components:{
        AppLayout,
        Banner,
        VehicleDetails,
        Details
    },
    props:{
        details:Object,
        vImages:Array,
        statsYears:Array,
        statsChassis:Array,
        statsConditions:Array,
        requestQuery:Object,
        vehicleStatsList:Array
    },
    mounted(){
        $(document).ready(function() {
      $("html, body").animate({ scrollTop: 0 }, "fastest");
      return false;
    });
    }
}
</script>

<style></style>