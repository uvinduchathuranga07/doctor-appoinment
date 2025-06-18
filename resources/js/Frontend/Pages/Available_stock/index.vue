<template>
    <AppLayout>

        <Banner />

        <StockFilter />

        <!-- <StockTable /> -->

    </AppLayout>
</template>

<script>
// import $ from 'jquery';
import AppLayout from '@@/Layouts/AppLayout.vue';
import Banner from './partials/Banner.vue';
import StockFilter from './partials/StockFilter.vue';
import StockTable from './partials/StockTable.vue';

export default {
    components: {
        AppLayout,
        Banner,
        StockFilter,
        StockTable
    },
    mounted() {
        console.log(this.$root.getQueryParam('brand'))

        $(document).ready(function () {
            $("html, body").animate({ scrollTop: 0 }, "fastest");
            return false;
        });
    }
}
</script>

<style></style>