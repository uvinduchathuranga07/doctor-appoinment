<template>
  <nav class="mainNavBar w-100 shadow  p-0" style="z-index: 1001;">
    <div class="min-h-screen">
    <header class="sticky-header">
      <nav class="container">
        <div class="nav-wrapper">
          <!-- Logo -->
          <div class="logo">
            <img src="/images/nexus-logo.png" alt="">
          </div>

          <!-- Desktop Menu -->
          <div class="desktop-menu">
            <ul class="menu-items m-0">
              <li><Link :href="route('index')">HOME</Link></li>
              <li><Link :href="route('about')">ABOUT US</Link></li>
              <li><Link :href="route('available')">FIND A CAR</Link></li>
              <li><Link :href="route('our_deleveries')">OUR DELIVERIES</Link></li>
              <li><Link :href="route('contact')">CONTACT</Link></li>
              <li><Link :href="route('careers')">CAREERS</Link></li>

            </ul>
          </div>

          <!-- Mobile Menu Button -->
          <button class="mobile-menu-button"  @click="toggleMobileMenu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
          <button class="contact-us-button px-4 py-3">CONTACT</button>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="mobile-menu">
          <ul>
            <li><Link :href="route('index')" @click="closeMobileMenu">HOME</Link></li>
            <li><Link :href="route('about')"  @click="closeMobileMenu">ABOUT US</Link></li>
            <li><Link :href="route('available')"  @click="closeMobileMenu">FIND A CAR</Link></li>
 
            <li><Link :href="route('our_deleveries')" @click="closeMobileMenu">OUR DELIVERIES</Link></li>
            <li><Link :href="route('contact')" @click="closeMobileMenu">CONTACT</Link></li>
            <li><Link :href="route('careers')" @click="closeMobileMenu">CAREERS</Link></li>
          </ul>
        </div>
      </nav>
    </header>
      <!-- Main Content -->

</div>
  </nav>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';


export default {
  components: {

    Link
  },
  data() {
    return {
      index: 0
    }
  },
  methods: {
    toggleMobileMenu() {
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenu.classList.toggle('show');
      
      // Add overflow hidden to body when menu is open
      document.body.style.overflow = mobileMenu.classList.contains('show') ? 'hidden' : '';
    },
    closeMobileMenu() {
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenu.classList.remove('show');
      document.body.style.overflow = ''; // Reset overflow when menu is closed
    }
  }
}
</script>

<style>
.linkHovernew {
  background-color: #0d6efd;
  color: white;
}

.linkHovernew:focus {
  background-color: #0d6efd;
  color: white;
}

.linkHovernew:hover {
  background-color: #5896f4;
  color: white;
}

.linkHovernew i {
  color: #0d6efd;
}

@media (max-width:1367px) {
  .linkHoverSeconRow {
    font-size: 12px !important;
  }
}
</style>
