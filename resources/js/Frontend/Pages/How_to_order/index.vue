<template>
    <AppLayout>

        <Banner />

        <StepSection />

        <StepGuide :site_url="site_url" />

    </AppLayout>
</template>

<script>
import AppLayout from '@@/Layouts/AppLayout.vue';
import Banner from './partials/Banner.vue';
import StepSection from './partials/Step-Section.vue';
import StepGuide from './partials/Step-Guide.vue';


export default {
    components: {
        AppLayout,
        Banner,
        StepSection,
        StepGuide
    },
    props:{
        site_url:Object
    }
}
</script>

<style></style>