<template>
    <section class="container">
        <div class="row mb-5">
            <div class="col-md-6 px-5">
                <div class="row">
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Vehicle</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.manufacture?.title }} {{ $page.props.vehicle?.vehicle_model?.title
                            }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Type</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.vehicle_type?.title }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Fuel</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.FuelTypeString }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Vehicle Doors</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.doors }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Transmission</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.TransmissionString }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Chassis ID</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.chassis_no }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Engine CC</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.engine_capacity }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Auction Grade</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.auction_grade }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Mileage</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.mileage }}KM</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 px-5">
                <div class="row">
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Make</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.manufacture?.title }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Condition</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.condition }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Vehicle Seats</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.seats }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Ex Color</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.ex_color.name }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">In Color</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.in_color.name }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Passengers</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.passengers }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Drive Type</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.drive_type }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Year</span>
                    </div>
                    <div class="col-8 mb-3 p-2">
                        <span>{{ $page.props.vehicle?.year }}</span>
                    </div>
                    <div class="col-4 mb-3 p-2">
                        <span class="fw-bold">Availability</span>
                    </div>
                    <div
                        :class="`col-8 mb-3 p-2 ${$page.props.vehicle?.availability == 0 ? 'bg-success text-white' : $page.props.vehicle?.availability == 1 ? 'bg-info' : 'bg-danger text-white'}`">
                        <span>{{ $page.props.vehicle?.AvailabilityString }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 px-5">
                <div class="row">
                    <div class="col-2 mb-3 p-2" style="width:15.77777777%;background-color:#e7e7e7;">
                        <span class="fw-bold">Description</span>
                    </div>
                    <div class="col-8 mb-3 p-2" style="width: 84.22222223%;">
                        <span v-html="$page.props.vehicle?.editorContent"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <ul class="nav nav-pills justify-content-center align-items-center" id="myTab" role="tablist">
                    <li class="nav-item bg-light" role="presentation">
                        <button class="nav-link active rounded-0 fs-6" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                            aria-selected="false">FEATURES</button>
                    </li>
                    <li class="nav-item bg-light" role="presentation">
                        <button class="nav-link rounded-0 fs-6" id="contact-tab" data-bs-toggle="tab"
                            data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane"
                            aria-selected="false">CONTACT US</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel"
                        aria-labelledby="profile-tab" tabindex="0">
                        <section class="container mt-5">
                            <div>
                                <!-- <li v-for="feature in $page.props.features" :key="feature.id"> {{ feature.name ?? '' }}
                                </li> -->
                               <div class="row">
                                <div class="col-6 col-md-2 text-center" v-for="feature in $page.props.features" :key="feature.id">
                                    <p class="px-2 py-2 rounded-5 border fw-semibold"> {{ feature.name ?? '' }} </p>
                                </div>
                               </div>
                            </div>
                        </section>
                    </div>
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                        tabindex="0">

                        <ContactUs />

                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import ContactUs from './ContactUs.vue';
export default {
    components: {
        ContactUs
    },
    data() {
        return {}
    },
    mounted() {
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".mySwiper2", {
            loop: true,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiper,
            },
        });
    }
}
</script>

<style scoped>
.col-4 {
    background-color: #e7e7e7;
}

.col-8 {
    background-color: #f1f1f1;
}
</style>