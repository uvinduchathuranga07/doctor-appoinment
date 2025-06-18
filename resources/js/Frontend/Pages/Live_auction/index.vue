<template>
    <AppLayout>

        <Banner />

        <Filter />

        <AuctionResults />

    </AppLayout>
</template>

<script>
// import $ from 'jquery';
import AppLayout from '@@/Layouts/AppLayout.vue';
import Banner from './partials/Banner.vue';
import Filter from './partials/Filter.vue';
import AuctionResults from './partials/AuctionResult.vue'


export default {
    props:{
        requestQuery:Object,
        auctionDates:Array,
        manufactures:Array,
        models:Array,
        years:Array,
        chassisNumbers:Array,
        engineCapacity:Array,
        colorQuery:Array,
        vehiclesList:Array,
        Condition:Array,
        PriceQuery:Array,
        Mileage:Array,
        
    },
    components: {
        AppLayout,
        Banner,
        Filter,
        AuctionResults
    },
    mounted(){
        $(document).ready(function() {
      $("html, body").animate({ scrollTop: 0 }, "fastest");
      return false;
    });
    }
}
</script>

<style scoped>
</style>