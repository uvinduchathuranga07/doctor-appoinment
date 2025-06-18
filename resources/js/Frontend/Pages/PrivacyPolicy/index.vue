<template>
 <AppLayout>

    <Banner />

    <Content />
 </AppLayout>
</template>

<script>
import AppLayout from '@@/Layouts/AppLayout.vue';
import Banner from './partials/Banner.vue';
import Content from './partials/Content.vue';

export default {
    components:{
        AppLayout,
        Banner,
        Content
    }
}
</script>

<style>

</style>