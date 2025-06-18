<template>
  <AppLayout>
    <div id="carouselExample" class="carousel slide">
      <div class="carousel-inner">
        <div class="carousel-item d-block custom_slide_height">
          <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7" style="object-fit: cover;"
            class="d-block w-100 swiperImg custom_slide_height" alt="...">
          <div class="overlay"></div>
          <div class="container hero-content-about mt-3">
            <div class="breadcrumb-wrapper">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Our Deleveries</li>
                </ol>
              </nav>
            </div>
            <h1 class="sell-car-heading">Our Deleveries</h1>
          </div>
        </div>
      </div>
    </div>
    <section class="gallery-section">
    <div class="container">
      <h2 class="section-title">Deliveries</h2>

      <div class="gallery-container">
        <div class="gallery-layout">
          <!-- Main large image -->
          <div class="gallery-main gallery-image">
            <img src="/images/subpages/our delivery1.jpg" alt="Car Delivery" />
          </div>

          <!-- 4 smaller images grid -->
          <div class="gallery-grid">
            <div class="gallery-image">
              <img src="/images/subpages/our delivery2.jpg" alt="Car Delivery" />
            </div>
            <div class="gallery-image">
              <img src="/images/subpages/our delivery3.jpg" alt="Car Delivery" />
            </div>
            <div class="gallery-image">
              <img src="/images/subpages/our delivery4.jpg" alt="Car Delivery" />
            </div>
            <div class="gallery-image">
              <img src="/images/subpages/our delivery5.jpg" alt="Car Delivery" />
            </div>
          </div>
        </div>
      </div>

      <!-- Image Carousel -->
      <div class="carousel-section">
        <div class="carousel-images">
          <div class="carousel-item-image">
            <img src="/images/subpages/our delivery3.jpg" alt="Car Delivery" class="img-fluid" />
          </div>
          <div class="carousel-item-image">
            <img src="/images/subpages/our delivery1.jpg" alt="Car Delivery" class="img-fluid" />
          </div>
          <div class="carousel-item-image">
            <img src="/images/subpages/our delivery2.jpg" alt="Car Delivery" class="img-fluid" />
          </div>
          <div class="carousel-item-image">
            <img src="/images/subpages/our delivery3.jpg" alt="Car Delivery" class="img-fluid" />
          </div>
          <div class="carousel-item-image">
            <img src="/images/subpages/our delivery4.jpg" alt="Car Delivery" class="img-fluid" />
          </div>
          <div class="carousel-item-image">
            <img src="/images/subpages/our delivery5.jpg" alt="Car Delivery" class="img-fluid" />
          </div>
        </div>
      </div>
    </div>
  </section>


  </AppLayout>
</template>

<script>

import AppLayout from '@@/Layouts/AppLayout.vue';


export default {
  components: {
    AppLayout,

  },
  props: {

  },
  mounted() {

  }
}
</script>

<style scoped>
.section-title {
  font-family: "ClashDisplay-300", sans-serif;
  font-size: 32px;
  font-weight: 700;
  margin: 3rem 0 2rem;
  color: var(--nexus-dark-blue);
}

/* Gallery Section */
.gallery-section {
  padding: 3rem 0;
}
.gallery-container {
  margin-bottom: 3rem;
}

.gallery-layout {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto;
  grid-gap: 20px;
}

.gallery-main {
  grid-column: 1;
  grid-row: 1 / span 2;
  position: relative;
}

.gallery-grid {
  grid-column: 2;
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-gap: 20px;
}

.gallery-image {
  position: relative;
  overflow: hidden;
  border-radius: 8px;
  box-shadow: 0 6px 12px rgba(4, 36, 93, 0.15);
}

.gallery-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.4s ease;
}

.gallery-image:hover img {
  transform: scale(1.05);
}

.gallery-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;

  padding: 10px;
  text-align: center;
}

.gallery-overlay img {
  height: 20px;
  width: auto;
}

.carousel-section {
  width: 100%;
  max-width: 1320px; /* Match Bootstrap container width */
  margin: 0 auto;
  padding: 2rem 15px;
}

.carousel-images {
  display: flex;
  overflow-x: hidden; /* Hide scrollbar */
  gap: 20px;
  padding-bottom: 20px;
  position: relative;
}

.carousel-item-image {
  flex: 0 0 calc(20% - 16px);
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(4, 36, 93, 0.1);
  animation: scroll 25s linear infinite;
}
.carousel-item-image img {
  transition: transform 0.3s ease;
}

.carousel-item-image:hover img {
  transform: scale(1.05);
}

@keyframes scroll {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-100%);
  }
}

/* Hide scrollbar across browsers */
.carousel-images::-webkit-scrollbar {
  display: none;
}

.carousel-images {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

/* Updated Review Carousel Responsive Styles */
@media (max-width: 768px) {
  .carousel-item .row {
    flex-direction: column;
  }

  .carousel-item .col-md-4 {
    width: 100%;
    margin-bottom: 15px;
  }

  .carousel-item .col-md-4:not(:first-child) {
    display: none; /* Hide additional review cards on mobile */
  }

  .carousel-item-image {
    flex: 0 0 100%; /* Show one image at a time on mobile */
  }
}
</style>
