<template>
  <AppLayout>
    <div id="carouselExample" class="carousel slide">
      <div class="carousel-inner">
        <div class="carousel-item d-block custom_slide_height">
          <img
            src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7"
            style="object-fit: cover;"
            class="d-block w-100 swiperImg custom_slide_height"
            alt="..."
          />
          <div class="overlay"></div>
          <div class="container hero-content-about mt-3">
            <div class="breadcrumb-wrapper">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="#">Home</a>
                  </li>
                  <li class="breadcrumb-item" aria-current="page">Find a Car</li>
                  <li
                    class="breadcrumb-item active"
                    aria-current="page"
                  >{{ $page.props.vehicle?.manufacture?.title }}</li>
                </ol>
              </nav>
            </div>
            <h1 class="sell-car-heading">{{ $page.props.vehicle?.manufacture?.title }}</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container main-container section">
      <!-- Car Details -->
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="car-title d-flex justify-content-between align-items-start">
            <div>
              <h1 class="mb-0 text-start">{{ $page.props.vehicle?.manufacture?.title }}</h1>
              <p class="text-muted text-start">
                {{ $page.props.vehicle?.manufacture?.title }} {{ $page.props.vehicle?.vehicle_model?.title
                }} {{ $page.props.vehicle?.vehicle_type?.title }}
              </p>
            </div>

            <div class="price-tag">
              <small>Minimum Down Payment:</small>
              <h2 class="mb-0">${{ $page.props.vehicle?.initial_payment.toLocaleString() }}</h2>
            </div>
          </div>

          <div class="mb-4">
            <div class="mb-4">
              <swiper
                :style="{
          '--swiper-navigation-color': '#fff',
          '--swiper-pagination-color': '#fff',
        }"
                ref="mainSwiper"
                :loop="true"
                :spaceBetween="1"
                :slidesPerView="1"
                :navigation="true"
                :freeMode="true"
                :thumbs="{ swiper: thumbsSwiper }"
                :modules="modules"
                class="mySwiper2"
              >
                <swiper-slide v-for="(main, index) in mainImages" :key="index">
                  <img :src="main.original_url" :alt="main.alt" class="main-image rounded" />
                </swiper-slide>
                <!-- Add other swiper slides for main images here -->
              </swiper>
            </div>
            <div class="thumbnails-container">
              <swiper
                ref="thumbsSwiper"
                @swiper="setThumbsSwiper"
                :loop="true"
                :spaceBetween="10"
               :slidesPerView="4"
                :freeMode="true"
                :grabCursor="true"
                :draggable="true"
                :watchSlidesProgress="true"
                :watchSlidesVisibility="true"
                :modules="modules"
                class="mySwiper"
              >
                <swiper-slide v-for="(thumb, index) in thumbnailImages" :key="index">
                  <img
                    :src="thumb.original_url"
                    :alt="thumb.alt"
                    class="thumbnail"
                    :class="{ active: currentThumbIndex === index }"
                    @click="setMainImage(index)"
                  />
                </swiper-slide>
              </swiper>
            </div>
          </div>
          <!-- Request a Quote Button -->
          <div class="text-center mb-4">
            <button
              class="btn btn-outline-secondary"
              data-bs-toggle="modal"
              data-bs-target="#quoteModal"
            >REQUEST A QUOTE</button>
          </div>

          <!-- <div class="car-specs mt-4">
                    <p class="text-muted">Transmission: 9G-TRONIC automatic transmission.</p>
          </div>-->

          <!-- Features Accordion -->
          <div class="accordion mt-4 section pb-4" id="carFeatures">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button
                  class="accordion-button"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#exteriorFeatures"
                >Vehicle Features</button>
              </h2>
              <div
                id="exteriorFeatures"
                class="accordion-collapse collapse show"
                data-bs-parent="#carFeatures"
              >
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li>• Fuel - {{ $page.props.vehicle?.FuelTypeString }}</li>
                    <li>• Vehicle Doors - {{ $page.props.vehicle?.doors }} Doors</li>
                    <li>• Transmission - {{ $page.props.vehicle?.TransmissionString }}</li>
                    <li>• Chassis ID - {{ $page.props.vehicle?.chassis_no }}</li>
                    <li>• Engine CC - {{ $page.props.vehicle?.engine_capacity }}</li>
                    <li>• Mileage - {{ $page.props.vehicle?.mileage }}</li>
                    <li>• Condition - {{ $page.props.vehicle?.condition }}</li>
                    <li>• Vehicle Seats - {{ $page.props.vehicle?.seats }} Seats</li>
                    <li>• Ex Color - {{ $page.props.vehicle?.ex_color.name }}</li>
                    <li>• In Color - {{ $page.props.vehicle?.in_color.name }}</li>
                    <li>• Drive Type - {{ $page.props.vehicle?.drive_type }}</li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#interiorFeatures"
                >Description</button>
              </h2>
              <div
                id="interiorFeatures"
                class="accordion-collapse collapse"
                data-bs-parent="#carFeatures"
              >
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li v-html="$page.props.vehicle?.editorContent"></li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- <div class="accordion-item">
              <h2 class="accordion-header">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#safetyFeatures"
                >Safety and Assistance Systems</button>
              </h2>
              <div
                id="safetyFeatures"
                class="accordion-collapse collapse"
                data-bs-parent="#carFeatures"
              >
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li>• Active Brake Assist</li>
                    <li>• Blind Spot Assist</li>
                    <li>• 360° camera</li>
                    <li>• ATTENTION ASSIST</li>
                  </ul>
                </div>
              </div>
            </div>-->

            <!-- New Accordion Item: Performance -->
            <!-- <div class="accordion-item">
              <h2 class="accordion-header">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#performanceFeatures"
                >Performance</button>
              </h2>
              <div
                id="performanceFeatures"
                class="accordion-collapse collapse"
                data-bs-parent="#carFeatures"
              >
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li>• 3.0L inline-6 turbo engine</li>
                    <li>• 362 horsepower</li>
                    <li>• 0-60 mph in 5.5 seconds</li>
                    <li>• 9G-TRONIC automatic transmission</li>
                  </ul>
                </div>
              </div>
            </div>-->

            <!-- New Accordion Item: Convenience Features -->
            <!-- <div class="accordion-item">
              <h2 class="accordion-header">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#convenienceFeatures"
                >Convenience Features</button>
              </h2>
              <div
                id="convenienceFeatures"
                class="accordion-collapse collapse"
                data-bs-parent="#carFeatures"
              >
                <div class="accordion-body">
                  <ul class="list-unstyled">
                    <li>• Keyless-Go</li>
                    <li>• Wireless charging</li>
                    <li>• Hands-free access</li>
                    <li>• Power liftgate</li>
                  </ul>
                </div>
              </div>
            </div>-->
          </div>

          <!-- Similar Cars -->
          <div class="row justify-content-center mt-4 section" v-if="randomVehicles">
            <div class="col-lg-12">
              <h3 class="mb-4 text-center">You might also be interested</h3>
              <div class="row">
                <div
                  class="col-md-4 mb-4"
                  v-for="(randomVehicle, index) in randomVehicles"
                  :key="index"
                >
                  <div class="card">
                    <img
                      :src="randomVehicle.media.find(item => item.custom_properties?.type === 'vehicle_main')?.original_url"
                      class="card-img-top"
                      alt="Car 6"
                    />
                    <div class="card-body">
                      <h5 class="card-title">
                        {{ randomVehicle?.manufacture?.title }} {{
                        randomVehicle?.vehicle_model?.title }}
                      </h5>
                      <div class="d-flex flex-column justify-content-between align-items-start">
                        <div>
                          <small class="text-muted">Minimum Down Payment:</small>
                          <p class="mb-0">${{ randomVehicle.initial_payment.toLocaleString() }}</p>
                        </div>
                        <Link
                          :href="route('product', {
                                    model: $root.stringToSlug(randomVehicle.manufacture.title),
                                    slug: ($root.stringToSlug(randomVehicle.manufacture.title) + '-' + $root.stringToSlug(randomVehicle.vehicle_model.title)),
                                    id: randomVehicle.id
                                })"
                          class="btn btn-outline-secondary mt-2"
                        >VIEW MORE</Link>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="quoteModal"
      tabindex="-1"
      aria-labelledby="quoteModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="quoteModalLabel">Request a Quote</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="row g-3" @submit.prevent="submitEnquiry">
              <div class="col-md-6">
                <input
                  type="text"
                  class="form-control rounded-0"
                  v-model="form.vehicle_name"
                  disabled
                />
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Your Name" v-model="form.name" />
              </div>
              <div class="col-6">
                <input
                  type="email"
                  class="form-control"
                  placeholder="Your Email"
                  v-model="form.email"
                />
              </div>
              <div class="col-6">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Your Mobile Number"
                  v-model="form.mobile"
                />
              </div>
              <div class="col-12">
                <select
                  class="form-select"
                  aria-label="Default select example"
                  v-model="form.purchase_time"
                >
                  <option value selected>When Are You Hoping To Purchase ?</option>
                  <option value="Immediately">Immediately</option>
                  <option value="Next Week">Next Week</option>
                  <option value="Two Weeks">Two Weeks</option>
                  <option value="One Month">One Month</option>
                  <option value="Not Sure">Not Sure</option>
                </select>
              </div>
              <div class="col-12">
                <select
                  class="form-select"
                  aria-label="Default select example"
                  v-model="form.payment_method"
                >
                  <option value selected>Payment Method</option>
                  <option value="Full Lease">Full Lease</option>
                  <option value="Half Lease">Half Lease</option>
                  <option value="Cash">Cash</option>
                  <option value="Loan">Loan</option>
                  <option value="Half Loan">Half Loan</option>
                </select>
              </div>
              <div class="col-12">
                <div class="input-group">
                  <textarea
                    class="form-control"
                    aria-label="With textarea"
                    placeholder="Your Address"
                    v-model="form.address"
                  ></textarea>
                </div>
              </div>
              <div class="col-12">
                <div class="input-group">
                  <textarea
                    class="form-control"
                    aria-label="With textarea"
                    placeholder="Your Message"
                    rows="3"
                    v-model="form.message"
                  ></textarea>
                </div>
              </div>
              <br />
              <div class="col-12 d-flex justify-content-end gap-2">
              <button type="reset" class="btn btn-secondary">Reset</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import Swal from "sweetalert2";
import AppLayout from "@@/Layouts/AppLayout.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/thumbs";
import { Mousewheel, FreeMode, Navigation, Thumbs } from "swiper/modules";

export default {
  components: {
    AppLayout,
    Swiper,
    SwiperSlide,
    Link
  },
  props: {
    vehicle: Object,
    randomVehicles: Object
  },
  data() {
    return {
      form: useForm({
        vehicle_name:
          this.$page.props.vehicle.manufacture.title +
          " " +
          this.$page.props.vehicle.vehicle_model.title +
          " " +
          this.$page.props.vehicle.ex_color.name,
        vehicle_url: route("product", {
          model: this.$root.stringToSlug(
            this.$page.props.vehicle.manufacture.title
          ),
          slug:
            this.$root.stringToSlug(
              this.$page.props.vehicle.manufacture.title
            ) +
            "-" +
            this.$root.stringToSlug(
              this.$page.props.vehicle.vehicle_model.title
            ),
          id: this.$page.props.vehicle.id
        }),
        vehicle_id: this.$page.props.vehicle.id,
        stock_type: "local",
        name: "",
        email: "",
        mobile: "",
        purchase_time: "",
        payment_method: "",
        address: "",
        message: ""
      }),
      mainImages: this.vehicle.media.filter(
        image => image.custom_properties?.type === "vehicle_gallery"
      ),
      thumbnailImages: this.vehicle.media.filter(
        image => image.custom_properties?.type === "vehicle_gallery"
      ),
      currentThumbIndex: 0
    };
  },
  setup() {
    return {
      modules: [Mousewheel, FreeMode, Thumbs, Navigation]
    };
  },
  mounted() {
    // Ensure thumbsSwiper is available when the component is mounted
    console.log(this.$refs.thumbsSwiper); // Make sure the thumbsSwiper ref is accessible
  },
  methods: {
    setMainImage(index) {
      this.currentThumbIndex = index;
      this.$nextTick(() => {
        const swiper = this.$refs.mainSwiper.$el.swiper;
        if (this.$refs.mainSwiper.$el.swiper) {
          console.log(swiper);
          this.$refs.mainSwiper.$el.swiper.slideTo(index); // Ensure thumbnail swiper slides to selected image
        }
      });
    },

    submitEnquiry() {
      this.form.post(route("submit-inquiry"), {
        preserveScroll: true,
        onSuccess: () => {
          console.log("sved"),
            this.form.reset(
              "name",
              "email",
              "mobile",
              "purchase_time",
              "payment_method",
              "address",
              "message"
            ),
            Swal.fire({
              icon: "success",
              title: "Inquiry Submitted Successfully",
              showConfirmButton: false,
              timer: 1500
            });
        },
        onError: () => {
          console.log("error"),
            Swal.fire({
              icon: "error",
              title: "Somthing went wrong! Please try again later",
              showConfirmButton: false,
              timer: 1500
            });
        }
      });
    }
  }
};
</script>


<style scoped>
.thumbnails-container .swiper-slide {
  display: flex;
  justify-content: center;
}
/* Ensure that images cover the container */
.main-image {
  width: 100%;
  height: 50vh; /* Default to 50% of the viewport height */
  min-height: 300px; /* Ensures it’s not too small */
  max-height: 550px; /* Prevents it from being too large */
  object-fit: cover;
}


/* For the thumbnail images */
.thumbnail {
  width: 100%;
  object-fit: cover;
  cursor: pointer;
}

.thumbnail.active {
  border: 2px solid #fff; /* Highlight active thumbnail */
}
</style>