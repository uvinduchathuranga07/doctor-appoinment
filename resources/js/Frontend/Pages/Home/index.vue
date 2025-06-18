<template>
  <AppLayout>

    <TopBanner :vehicles="vehicles" :manufactures="manufactures"  :models="models"   :selectedManufacturer="$page.props.selectedManufacturer"  :selectedModel="$page.props.selectedModel" 
    />
    <FirstSection />
    <SecondSection  :vehicles="vehicles" :manufactures="manufactures"   :models="models" />
    <ThirdSection />

  </AppLayout>
</template>

<script>

import AppLayout from '@@/Layouts/AppLayout.vue';
import TopBanner from './partials/TopBanner.vue';
import FirstSection from './partials/firstSection.vue';
import SecondSection from './partials/secondSection.vue';
import ThirdSection from './partials/thirdSection.vue';


export default {
  components: {
    AppLayout,
    TopBanner,
    FirstSection,
    SecondSection,
    ThirdSection,
  },
  props: {
    vehicles: {
      type: Array,
      default: () => []
    },

    manufactures: { type: Array, 
      default: () => [], 
    },
    models: {
      type: Array,
      default: () => []
    },
    vehicle_types: Object,
    category_manufactures: Object,
    years: Array,
    minMileage: null | Number,
    maxMileage: null | Number,
    featuredVehicles: Object,
    in_stock: Object,
    latest_cars: Object,
    live_auction_vehicles_list: Object,
    reviews: Array,

    requestQuery: Object,
    auctionDates: Array,
    manufactures: Array,
    models: Array,
    years: Array,
    chassisNumbers: Array,
    engineCapacity: Array,
    colorQuery: Array,
    vehiclesList: Array,
  },
  mounted() {

  }
}
</script>

<style></style>
