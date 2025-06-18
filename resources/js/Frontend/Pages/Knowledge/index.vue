<template>
    <AppLayout>

        <Banner />

        <FeatureSection />

        <Text />

        <VideoSection />

        <AuctionSheetGuide />

    </AppLayout>
</template>

<script>
import AppLayout from '@@/Layouts/AppLayout.vue';
import Banner from './partials/Banner.vue';
import FeatureSection from './partials/feature-section.vue';
import Text from './partials/text.vue';
import VideoSection from './partials/video-section.vue';
import AuctionSheetGuide from './partials/auction-sheet-guide.vue';


export default {
    components: {
        AppLayout,
        Banner,
        FeatureSection,
        Text,
        VideoSection,
        AuctionSheetGuide
    }
}
</script>

<style>

</style>