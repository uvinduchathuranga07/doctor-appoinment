<template>
  <div class="container1">
    <!-- Featured Vehicles Section -->
    <div class="header1">
      <h2>Featured Vehicles</h2>
      <p>Discover our selection of premium electric vehicles</p>
    </div>

    <div class="featured-cars">
      <!-- Use the computed property `featuredVehicles` -->
      <div v-for="car in featuredVehicles" :key="car.id" class="vehicle-card">
        <div class="vehicle-card__image-wrapper">
          <img
            class="vehicle-card__image"
            :src="car.media.find(item => item.custom_properties?.type === 'vehicle_main')?.original_url"
            :alt="car.name"
          />
        </div>
        <div class="vehicle-card__content">
          <div class="vehicle-card__price-container">
            <div class="vehicle-card__monthly-price">
              From
              <strong>${{ car.monthly_price }}</strong> Per Month (Inc. VAT)
            </div>
            <div class="vehicle-card__initial-payment">
              Initial Payment
              <strong>${{ car.initial_payment }}</strong>
            </div>
          </div>

          <div class="car-details">
            <h2 class="car-name">{{ car.vehicle_model?.title }}</h2>
            <p
              class="vehicle-card__monthly-price"
              :class="availabilityColor(car.availability)"
            >{{ car.availability }}</p>
          </div>

          <div class="vehicle-card__specs-grid">
            <div class="vehicle-card__spec-item">
              <i class="fas fa-user-friends me-1"></i>
              <span>{{ car.seats }} Seats</span>
            </div>

            <div class="vehicle-card__spec-item">
              <i class="fas fa-clock me-1"></i>
              <span>{{ car.transmission }}</span>
            </div>

            <div class="vehicle-card__spec-item">
              <i class="fas fa-door-open me-1"></i>
              <span>{{ car.doors }} Doors</span>
            </div>

            <div class="vehicle-card__spec-item">
              <i class="fas fa-road me-1"></i>
              <span>{{ car.mileage }} miles</span>
            </div>
          </div>
          <Link
            class="vehicle-card__cta-button btn btn-outline-danger btn-sm text-capitalize mt-auto"
            :href="route('product', {
              model: $root.stringToSlug(car.manufacture.title),
              slug: ($root.stringToSlug(car.manufacture.title) + '-' + $root.stringToSlug(car.vehicle_model.title)),
              id: car.id
            })"
          >View More Details</Link>
        </div>
      </div>
    </div>

    <!-- New Arrivals Section -->
    <div class="vehicle-showcase__section-header" style="margin-top: 4rem;">
      <h2>New Arrivals</h2>
      <p>Explore our latest additions to the fleet</p>
    </div>

    <div class="vehicle-showcase__grid">
      <!-- Use the computed property `newArrivals` -->
      <div v-for="car in newArrivals" :key="car.id" class="vehicle-card">
        <div class="vehicle-card__image-wrapper">
          <img class="vehicle-card__image" :src="car.media.find(item => item.custom_properties?.type === 'vehicle_main')?.original_url" :alt="car.name" />
        </div>
        <div class="vehicle-card__content">
          <div class="vehicle-card__price-container">
            <div class="vehicle-card__monthly-price">
              From
              <strong>${{ car.monthly_price }}</strong> Per Month (Inc. VAT)
            </div>
            <div class="vehicle-card__initial-payment">
              Initial Payment
              <strong>${{ car.initial_payment }}</strong>
            </div>
          </div>

          <div class="car-details">
            <h2 class="car-name">{{ car.vehicle_model?.title }}</h2>

            <p class="car-model" :class="availabilityColor(car.availability)">{{ car.availability }}</p>
          </div>
          <div class="vehicle-card__specs-grid">
            <div class="vehicle-card__spec">
              <i class="fas fa-user-friends me-1"></i>
              <span>{{ car.seats }} Seats</span>
            </div>

            <div class="vehicle-card__spec">
              <i class="fas fa-clock me-1"></i>
              <span>{{ car.transmission }}</span>
            </div>

            <div class="vehicle-card__spec">
              <i class="fas fa-door-open me-1"></i>
              <span>{{ car.doors }} Doors</span>
            </div>

            <div class="vehicle-card__spec">
              <i class="fas fa-road me-1"></i>
              <span>{{ car.mileage }} miles</span>
            </div>
          </div>
          <Link
            class="vehicle-card__cta-button btn btn-outline-danger btn-sm text-capitalize mt-auto"
            :href="route('product', {
              model: $root.stringToSlug(car.manufacture.title),
              slug: ($root.stringToSlug(car.manufacture.title) + '-' + $root.stringToSlug(car.vehicle_model.title)),
              id: car.id
            })"
          >View More Details</Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link
  },
  name: "LeaseCar",

  props: {
    vehicles: {
      type: Array,
      default: () => []
    },
    manufactures: {
      type: Array,
      default: () => []
    },
    models: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      activeTab: ""
    };
  },
  computed: {
    featuredVehicles() {
      return this.vehicles.filter(v => v.featured === 1);
    },
    newArrivals() {
      return this.vehicles.filter(v => v.latest === 1);
    },
    activemanufactures() {
      const found = this.manufactures.find(c => c.title === this.activeTab);
      return found || null;
    },
    filteredVehicles() {
      if (!this.activemanufactures) {
        return [];
      }
      return this.vehicles.filter(
        vehicle => vehicle.manufacture_id === this.activemanufactures.id
      );
    }
  },
  methods: {
    availabilityColor(status) {
      switch (status) {
        case "Available":
          return "availability-available";
        case "Arriving":
          return "availability-arriving";
        case "Sold":
          return "availability-sold";
        default:
          return "";
      }
    },
   
    setActiveTab(title) {
      this.activeTab = title;
    }
  }
};
</script>
<style scoped>
.availability-available {
  color: green;
}

.availability-arriving {
  color: orange;
}

.availability-sold {
  color: red;
}

.car-details {
  margin-bottom: -10%;
}
.car-name {
  font-size: 1.25rem;
  font-weight: bold;
  color: #111827;
  margin-bottom: 0.25rem;
  font-family: "ClashDisplay-300", sans-serif;
}
</style>
