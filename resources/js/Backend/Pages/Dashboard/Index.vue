<template>
  <AppLayout>
    <div class="container-fluid">
                <div class="row">
                    <div class="col-xxl-3 col-md-6 xl-50 mb-4">
                        <div class="card o-hidden widget-cards">
                            <div class="warning-box card-body">
                                <div
                                    class="d-flex media static-top-widget align-items-center"
                                >
                                    <div class="icons-widgets bg-success p-3 rounded-circle me-5">
                                        <div
                                            class="align-self-center text-center text-white"
                                        >
                                            <i
                                                data-feather="box"
                                                class="font-warning"
                                              
                                            ></i>
                                        </div>
                                    </div>
                                    <div class="media-body media-doller">
                                        <span class="m-0">Vehicles</span>
                                        <h3 class="mb-0">
                                             <span class="counter">{{ vehicle_count }}</span
                                            >
                                            <!-- <small> This Month</small> -->
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6 xl-50 mb-4">
                        <div class="card o-hidden widget-cards">
                            <div class="primary-box card-body">
                                <div
                                    class="d-flex media static-top-widget align-items-center"
                                >
                                    <div class="icons-widgets bg-warning p-3 rounded-circle me-5">
                                        <div
                                            class="align-self-center text-center text-white"
                                        >
                                            <i
                                                data-feather="users"
                                                class="font-primary"
                                            ></i>
                                        </div>
                                    </div>
                                    <div class="media-body media-doller">
                                        <span class="m-0">Customers</span>
                                        <h3 class="mb-0">
                                             <span class="counter">{{ customer_count }}</span
                                            >
                                            <!-- <small> This Month</small> -->
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6 xl-50 mb-4">
                        <div class="card o-hidden widget-cards">
                            <div class="primary-box card-body">
                                <div
                                    class="d-flex media static-top-widget align-items-center"
                                >
                                    <div class="icons-widgets  bg-primary p-3 rounded-circle me-5">
                                        <div
                                            class="align-self-center text-center text-white"
                                        >
                                            <i
                                                data-feather="git-pull-request"
                                                class="font-primary"
                                            ></i>
                                        </div>
                                    </div>
                                    <div class="media-body media-doller">
                                        <span class="m-0">Inquiries</span>
                                        <h3 class="mb-0">
                                           <small>{{ inquiry_count }}</small>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6 xl-50 mb-4">
                        <div class="card o-hidden widget-cards">
                            <div class="primary-box card-body">
                                <div
                                    class="d-flex media static-top-widget align-items-center"
                                >
                                    <div class="icons-widgets bg-black p-3 rounded-circle me-5">
                                        <div
                                            class="align-self-center text-center text-white"
                                        >
                                            <i
                                                data-feather="message-square"
                                                class="font-primary"
                                            ></i>
                                        </div>
                                    </div>
                                    <div class="media-body media-doller">
                                        <span class="m-0">Testimonials</span>
                                        <h3 class="mb-0">
                                            <span class="counter">{{ testimonial_count }}</span
                                            >
                                            <!-- <small> This Month</small> -->
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  </AppLayout>
</template>
<script>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import DataTable from "@/Components/DataTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";

export default {
  components: {
    AppLayout,
    Link
  },
  props: {
    vehicle_count:Object,
    customer_count:Object,
    inquiry_count:Object,
    testimonial_count:Object,

  },
  data() {
    return {};
  },
  mounted() {}
};
</script>