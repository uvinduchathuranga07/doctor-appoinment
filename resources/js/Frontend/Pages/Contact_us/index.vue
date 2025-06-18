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
                  <li class="breadcrumb-item active" aria-current="page">Contact</li>
                </ol>
              </nav>
            </div>
            <h1 class="sell-car-heading">Contact</h1>
          </div>
        </div>
      </div>
    </div>
    <section class="contact-form">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-lg-6">
            <form @submit.prevent="submitForm">
              <div class="mb-3">
                <label class="form-label">NAME</label>
                <input v-model="form.name" type="text" class="form-control" placeholder="Your name" />
                <div v-if="errors.name" class="text-danger">{{ errors.name }}</div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">EMAIL</label>
                    <input
                      v-model="form.email"
                      type="email"
                      class="form-control"
                      placeholder="email@domain.com"
                    />
                    <div v-if="errors.email" class="text-danger">{{ errors.email }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">PHONE</label>
                    <input
                      v-model="form.phone"
                      type="tel"
                      class="form-control"
                      placeholder="Phone number"
                    />
                    <div v-if="errors.phone" class="text-danger">{{ errors.phone }}</div>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">ENQUIRY</label>
                <textarea
                  v-model="form.enquiry"
                  class="form-control"
                  rows="4"
                  placeholder="Your enquiry"
                ></textarea>
                <div v-if="errors.enquiry" class="text-danger">{{ errors.enquiry }}</div>
              </div>
              <button type="submit" class="btn btn-send" :disabled="loading">
                <span v-if="loading">
                  <span
                    class="spinner-border spinner-border-sm me-2"
                    role="status"
                    aria-hidden="true"
                  ></span>
                  Sending....
                </span>
                <span v-else>Send</span>
              </button>
            </form>
          </div>
          <div class="col-lg-5 mt-4 mt-lg-0">
            <div class="map-container">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29886849.232887283!2d16.36962890625003!3d25.18008780899067!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f66c44a5cdc0b%3A0x6b6b6966cdec4c29!2s11th%20St%20-%20Dubai%20-%20United%20Arab%20Emirates!5e1!3m2!1sen!2slk!4v1740130662126!5m2!1sen!2slk"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="sales-support">
      <div class="container">
        <h2 class="support-heading">Sales Support</h2>
        <div class="row">
          <div class="col-md-4 col-sm-6">
            <div class="support-card">
              <div class="support-icon">
                <svg
                  width="24"
                  height="24"
                  id="fi_18875351"
                  enable-background="new 0 0 24 24"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="m12 12c2.8 0 5-2.2 5-5s-2.2-5-5-5-5 2.2-5 5 2.2 5 5 5zm9.3 8.8c-1.3-5.1-6.5-8.3-11.6-7-3.4.9-6.1 3.5-7 7-.1.5.2 1.1.8 1.2h.2 16.6c.6 0 1-.4 1-1 0-.1 0-.2 0-.2z"
                    fill="rgb(0,0,0)"
                  />
                </svg>
              </div>
              <h3 class="name">Hameed</h3>
              <div class="email">hameed@nexusauto.ae</div>
              <div class="phone">+971 54 355 5509</div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="support-card">
              <div class="support-icon">
                <svg
                  width="24"
                  height="24"
                  id="fi_18875351"
                  enable-background="new 0 0 24 24"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="m12 12c2.8 0 5-2.2 5-5s-2.2-5-5-5-5 2.2-5 5 2.2 5 5 5zm9.3 8.8c-1.3-5.1-6.5-8.3-11.6-7-3.4.9-6.1 3.5-7 7-.1.5.2 1.1.8 1.2h.2 16.6c.6 0 1-.4 1-1 0-.1 0-.2 0-.2z"
                    fill="rgb(0,0,0)"
                  />
                </svg>
              </div>
              <h3 class="name">Hameed</h3>
              <div class="email">hameed@nexusauto.ae</div>
              <div class="phone">+971 54 355 5509</div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="support-card">
              <div class="support-icon">
                <svg
                  width="24"
                  height="24"
                  id="fi_18875351"
                  enable-background="new 0 0 24 24"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="m12 12c2.8 0 5-2.2 5-5s-2.2-5-5-5-5 2.2-5 5 2.2 5 5 5zm9.3 8.8c-1.3-5.1-6.5-8.3-11.6-7-3.4.9-6.1 3.5-7 7-.1.5.2 1.1.8 1.2h.2 16.6c.6 0 1-.4 1-1 0-.1 0-.2 0-.2z"
                    fill="rgb(0,0,0)"
                  />
                </svg>
              </div>
              <h3 class="name">Hameed</h3>
              <div class="email">hameed@nexusauto.ae</div>
              <div class="phone">+971 54 355 5509</div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="support-card">
              <div class="support-icon">
                <svg
                  width="24"
                  height="24"
                  id="fi_18875351"
                  enable-background="new 0 0 24 24"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="m12 12c2.8 0 5-2.2 5-5s-2.2-5-5-5-5 2.2-5 5 2.2 5 5 5zm9.3 8.8c-1.3-5.1-6.5-8.3-11.6-7-3.4.9-6.1 3.5-7 7-.1.5.2 1.1.8 1.2h.2 16.6c.6 0 1-.4 1-1 0-.1 0-.2 0-.2z"
                    fill="rgb(0,0,0)"
                  />
                </svg>
              </div>
              <h3 class="name">Hameed</h3>
              <div class="email">hameed@nexusauto.ae</div>
              <div class="phone">+971 54 355 5509</div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="support-card">
              <div class="support-icon">
                <svg
                  width="24"
                  height="24"
                  id="fi_18875351"
                  enable-background="new 0 0 24 24"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="m12 12c2.8 0 5-2.2 5-5s-2.2-5-5-5-5 2.2-5 5 2.2 5 5 5zm9.3 8.8c-1.3-5.1-6.5-8.3-11.6-7-3.4.9-6.1 3.5-7 7-.1.5.2 1.1.8 1.2h.2 16.6c.6 0 1-.4 1-1 0-.1 0-.2 0-.2z"
                    fill="rgb(0,0,0)"
                  />
                </svg>
              </div>
              <h3 class="name">Hameed</h3>
              <div class="email">hameed@nexusauto.ae</div>
              <div class="phone">+971 54 355 5509</div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="support-card">
              <div class="support-icon">
                <svg
                  width="24"
                  height="24"
                  id="fi_18875351"
                  enable-background="new 0 0 24 24"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="m12 12c2.8 0 5-2.2 5-5s-2.2-5-5-5-5 2.2-5 5 2.2 5 5 5zm9.3 8.8c-1.3-5.1-6.5-8.3-11.6-7-3.4.9-6.1 3.5-7 7-.1.5.2 1.1.8 1.2h.2 16.6c.6 0 1-.4 1-1 0-.1 0-.2 0-.2z"
                    fill="rgb(0,0,0)"
                  />
                </svg>
              </div>
              <h3 class="name">Hameed</h3>
              <div class="email">hameed@nexusauto.ae</div>
              <div class="phone">+971 54 355 5509</div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="join-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-12">
            <h2 class="join-heading">Join with Us</h2>
          </div>
          <div class="col-12 col-lg-8 col-md-12">
            <div class="">
              <div class="row">
                <div class="col-12 col-md-6 mb-4">
                  <div class="contact-info-item">
                    <div class="icon-wrapper">
                      <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                        />
                      </svg>
                    </div>
                    <div class="contact-info-text">
                      +971 54 355 5509
                      <br />+971 54 355 5509
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                  <div class="contact-info-item">
                    <div class="icon-wrapper">
                      <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                      </svg>
                    </div>
                    <div
                      class="contact-info-text"
                    >157, Dubai Auto Zone (DAZ) Ras Al khor, Dubai, UAE</div>
                  </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                  <div class="contact-info-item">
                    <div class="icon-wrapper">
                      <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                        />
                        <polyline points="22,6 12,13 2,6" />
                      </svg>
                    </div>
                    <div class="contact-info-text">
                      hameed@nexusauto.ae
                      <br />nexusauto24@gmail.com
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                  <div class="contact-info-item">
                    <div class="icon-wrapper">
                      <svg
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <circle cx="12" cy="12" r="10" />
                        <line x1="2" y1="12" x2="22" y2="12" />
                        <path
                          d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"
                        />
                      </svg>
                    </div>

                    <div class="contact-info-text">nexusauto.ae</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script>
import AppLayout from "@@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import Swal from "sweetalert2";

export default {
  components: {
    AppLayout
  },
  data() {
    return {
      form: {
        name: "",
        email: "",
        phone: "",
        enquiry: ""
      },
      errors: {},
      successMessage: null,
      loading: false
    };
  },
  mounted() {
    if (this.$page.props.flash.success) {
      this.successMessage = this.$page.props.flash.success;
    }
  },
  methods: {
    submitForm() {
      this.loading = true; // Start loading

      Inertia.post(this.route("contacts.store"), this.form, {
        onError: errors => {
          this.errors = errors;
          this.loading = false;
        },
        onSuccess: () => {
          this.form.name = "";
          this.form.email = "";
          this.form.phone = "";
          this.form.enquiry = "";

          this.errors = {};
          this.loading = false;

          Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: "Success!",
            text: "Thank you for contacting us. We will get back to you soon.",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
          });
        }
      });
    }
  }
};
</script>

<style></style>
