<template>
  <section class="hero">
    <div class="hero-content">
      <h1 class="hero-title">Find Your Perfect Car</h1>
      <p class="hero-subtitle">Browse through our extensive collection of premium vehicles</p>

      <div class="search-panel">
        <form id="car-search-form" class="search-form" @submit.prevent="searchCars">
          <div class="search-grid">

            <div class="search-field">
              <label for="make">Make</label>
              <select id="make" v-model="selectedManufacturer" @change="onChangeManufacturer">
                <option value="">Select Make</option>
                <option v-for="manu in manufactures" :key="manu.id" :value="manu.id">
                  {{ manu.title }}
                </option>
              </select>
            </div>

            <div class="search-field">
              <label for="model">Model</label>
              <select id="model" v-model="selectedModel" :disabled="!selectedManufacturer" @change="onChangeModel">
                <option value="">Select Model</option>
                <option v-for="mod in models" :key="mod.id" :value="mod.id">
                  {{ mod.title }}
                </option>
              </select>
            </div>

            <div class="search-field">
              <label for="steering">LHD / RHD</label>
              <select id="steering" v-model="selectedSteering">
                <option value="">Select</option>
                <option value="Left Side Driving">Left Hand Drive (LHD)</option>
                <option value="Right Side Driving">Right Hand Drive (RHD)</option>
              </select>
            </div>

            <!-- Search Button -->
            <button type="submit" class="search-button">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
              </svg>
              Search Cars
            </button>
          </div>
        </form>
      </div>

      <!-- Advanced Search Container -->
      <section class="search-container">
        <div class="search-box">
          <div class="search-field">
            <div class="search-input-group">
              <input type="text" id="advancedSearchInput" placeholder="Search make, model, or any keyword..."
                class="search-text-input" v-model="SearchKeyword" />
              <svg class="search-icon-svg" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <line x1="21" y1="21" x2="16.65" y2="16.65" />
              </svg>
            </div>
          </div>
          <button class="search-submit-btn" @click="executeAdvancedSearch">
            <svg class="search-btn-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8" />
              <line x1="21" y1="21" x2="16.65" y2="16.65" />
            </svg>
            Search
          </button>
        </div>
      </section>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    manufactures: {
      type: Array,
      default: () => [],
    },
    models: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {

      selectedManufacturer: "",
      selectedModel: "",
      selectedSteering: "",
      SearchKeyword: "",
    };
  },
  methods: {
    onChangeManufacturer() {
      if (!this.selectedManufacturer) {
        return;
      }
      this.$inertia.reload({
        method: 'POST',
        data: {
          '_method': 'GET',
          brand: this.selectedManufacturer,
        },
      
      });
    },

    onChangeModel() {
      if (!this.selectedModel) {
        return;
      }
      this.$inertia.reload({
        method: 'POST',
        data: {
          '_method': 'GET',
          brand: this.selectedManufacturer,
          model: this.selectedModel,
        },
     
      });
    },

    searchCars() {
    
      this.$inertia.visit(this.route("available"), {
        method: 'POST',
        data: {
          '_method': 'GET',
          brand: this.selectedManufacturer,
          model: this.selectedModel,
          drive_type: this.selectedSteering,
        },
       
      });
    },

    executeAdvancedSearch(){
      this.$inertia.visit(this.route("available"), {
        method: 'POST',
        data: {
          '_method': 'GET',
          keyword: this.SearchKeyword,
        
        },
       
      });
    }

  },
};
</script>

<style scoped></style>
