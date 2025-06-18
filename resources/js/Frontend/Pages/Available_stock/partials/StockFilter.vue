<template>
  <div class="container-fluid mt-5 mb-5">
    <div class="row">
      <div class="col-lg-3 position-relative">
        <div class="p-3 filter-sidebar" :class="{ 'sticky-filter': isSticky }">
          <div class="card-body">
            <h3 class="mb-4">Filter Car</h3>
            <div class="d-flex flex-column">
              <input
                type="text"
                class="form-control rounded mb-2"
                placeholder="Search vehicles..."
                v-model="keyword"
              />
              <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-primary" @click="search">Search</button>
                <button class="btn btn-secondary" @click="clearSearch">Clear</button>
              </div>
            </div>
            <div class="accordion" id="accordionExample">
              <div class="accordion-item border-0 mb-2">
                <h2 class="accordion-header">
                  <button
                    class="accordion-button rounded"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseOne"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >TYPE</button>
                </h2>
                <div
                  id="collapseOne"
                  class="accordion-collapse collapse show"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    <Types />
                  </div>
                </div>
              </div>

              <div class="accordion-item border-0 mb-2">
                <h2 class="accordion-header">
                  <button
                    class="accordion-button collapsed rounded"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo"
                    aria-expanded="false"
                    aria-controls="collapseTwo"
                  >MANUFACTURER</button>
                </h2>
                <div
                  id="collapseTwo"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    <Manufactures />
                  </div>
                </div>
              </div>

              <div class="accordion-item border-0 mb-2">
                <h2 class="accordion-header">
                  <button
                    class="accordion-button collapsed rounded"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseThree"
                    aria-expanded="false"
                    aria-controls="collapseThree"
                  >MODEL</button>
                </h2>
                <div
                  id="collapseThree"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    <Models />
                  </div>
                </div>
              </div>

              <div class="accordion-item border-0 mb-2">
                <h2 class="accordion-header">
                  <button
                    class="accordion-button collapsed rounded"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseFour"
                    aria-expanded="false"
                    aria-controls="collapseFour"
                  >LHD/RHD</button>
                </h2>
                <div
                  id="collapseFour"
                  class="accordion-collapse collapse"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    <DriverType />
                  </div>
                </div>
              </div>
            </div>

            <!-- <button
              class="btn btn-blue-gradient btn-sm text-capitalize w-100 mt-3"
              @click="clearFilters"
            >Clear Filters</button>-->
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <!-- Sorting -->
          <select class="form-select w-auto ms-auto" v-model="sortBy" @change="applySort">
            <option value>Sort by</option>
            <option value="priceLowHigh">Price: Low to High</option>
            <option value="priceHighLow">Price: High to Low</option>
            <option value="newest">Newest Arrivals</option>
          </select>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
          <div class="col" v-for="vehicle in $page.props?.vehicles" :key="vehicle.id">
            <div class="card car-card h-100 position-relative">
              <span
                class="badge badge-corner"
                :class="vehicle.latest ? 'bg-success' : 'bg-primary'"
              >{{ vehicle.latest ? 'NEW ARRIVAL' : 'ON DEMAND' }}</span>

              <img
                :src="vehicle.media.find(item => item.custom_properties?.type === 'vehicle_main')?.original_url"
                class="card-img-top"
                :alt="vehicle.model + ' ' + vehicle.model"
                style="height: 200px; object-fit: cover;"
              />

              <div class="card-body d-flex flex-column">
                <small class="text-muted">chassis_no {{ vehicle.chassis_no }}</small>
                <h5 class="card-title">
                  {{ vehicle.year }} {{ vehicle?.manufacture?.title }} {{
                  vehicle?.vehicle_model?.title }}
                </h5>
                <p class="card-text">{{ vehicle.drive_type }}</p>
                <p class="card-text">{{ vehicle.seats }}-Seater</p>
                <div class="mt-auto">
                  <small class="text-muted">Minimum Down Payment:</small>
                  <p class="mb-0">${{ vehicle.initial_payment }}</p>
                </div>
                <br />

                <Link
                  class="btn btn-blue-gradient btn-sm text-capitalize mt-auto"
                  :href="route('product', {
                                    model: $root.stringToSlug(vehicle.manufacture.title),
                                    slug: ($root.stringToSlug(vehicle.manufacture.title) + '-' + $root.stringToSlug(vehicle.vehicle_model.title)),
                                    id: vehicle.id
                                })"
                >View More</Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import Types from "./models/Types.vue";
import Manufactures from "./models/Manufactures.vue";
import Models from "./models/Models.vue";
import DriverType from "./models/DriverType.vue";

export default {
  components: {
    Types,
    Manufactures,
    Models,
    DriverType,
    Link
  },
  name: "AvailableStockIndex",

  data() {
    return {
      isSticky: false,
      sortBy: this.$page.props.requestQuery.sortby || "",
      keyword: this.$page.props.requestQuery.keyword || "",

      index: 2,
      form: {
        min_mileage: 0,
        max_mileage: 0
      }
    };
  },
  mounted() {
    window.addEventListener("scroll", this.handleScroll);
    this.setMileage();
  },
  beforeUnmount() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  computed: {
    displayMinMileage: function() {
      const minValue = this.$page.props.minMileage ?? 0;
      const maxValue = this.$page.props.maxMileage ?? 0;

      if (minValue == maxValue) {
        return 0;
      }

      return this.$page.props.minMileage ?? 0;
    },

    displayMaxMileage: function() {
      return this.$page.props.maxMileage ?? 0;
    }
  },

  methods: {
    handleScroll() {
      const scrollY = window.scrollY;
      const offsetTop = this.$refs.filterSidebar?.offsetTop || 0;

      this.isSticky = scrollY > offsetTop;
    },
    search() {
      this.$inertia.reload({
        method: "POST",
        data: {
          _method: "GET",
          keyword: this.keyword // Send keyword for search
        }
      });
    },
    clearSearch() {
      this.keyword = ""; // Reset the input
      this.$inertia.reload({
        method: "POST",
        data: {
          _method: "GET"
        }
      });
    },
    setMileage() {
      this.form.min_mileage = this.$page.props.minMileage ?? 0;
      if (this.$page.props.minMileage == this.$page.props.maxMileage) {
        this.form.min_mileage = 0;
      }
      this.form.max_mileage = this.$page.props.maxMileage ?? 0;
    },
    onChangeMileage(evt) {
      const query = this.$page.props.requestQuery ?? {};
      this.$inertia.reload({
        method: "POST",
        data: {
          _method: "GET",
          ...query,
          min_mileage: this.form.min_mileage,
          max_mileage: this.form.max_mileage
        },
        onFinish: () => {}
      });
    },
    applySort() {
      this.$inertia.reload({
        method: "POST",
        data: {
          _method: "GET",
          sortBy: this.sortBy
        },
        onFinish: () => {}
      });
    }
  }
};
</script>

<style scoped>
.btn-blue-gradient {
  /* Gradient background: left to right */
  background: linear-gradient(to right, #001845, #0050ef);
  color: #fff;
  border: none;
  border-radius: 10px;
  /* adjust as needed */
  padding: 0.5rem 1rem;
  /* adjust as needed */
  font-size: 18px;
  /* <--- Increase font size here */
  transition: background 0.3s ease-in-out;
}

.btn-blue-gradient:hover {
  background: linear-gradient(to right, #001030, #0040c0);
  color: #fff;
}

.badge-corner {
  position: absolute;
  top: 10px;
  left: 10px;
  padding: 0.5em;
  font-size: 0.75em;
}

.car-card {
  overflow: hidden;
  border: 1px solid #eaeaea;
  transition: transform 0.3s;
}

.car-card:hover {
  transform: translateY(-5px);
}

.btn-outline-secondary {
  font-weight: 600;
}

/* Example background color for the accordion headers */
.bg-color-1 {
  background-color: #e4f7ff;
}

/* Customize the sidebar card if desired */
.filter-sidebar {
  /* Additional styling here, e.g.: */
  border: 1px solid #eaeaea;
}

.sticky-filter {
  position: sticky;
  top: 70px;
  z-index: 10;
}
</style>