<template>
    <AppLayout>

        <Banner />

        <Slider :testimonials="testimonials" />
    </AppLayout>
</template>

<script>
// import $ from 'jquery';
import AppLayout from '@@/Layouts/AppLayout.vue';
import Banner from '../Testimonials/partials/Banner.vue';
import Slider from './partials/Slider.vue';
Slider


export default {
    components: {
        AppLayout,
        Banner,
        Slider
    },
    props:{
        testimonials:Object
    },
    mounted() {
        $(document).ready(function () {
            $("html, body").animate({ scrollTop: 0 }, "fastest");
            return false;
        });
    }
}
</script>

<style></style>