<template>
    <section class="container-fluid mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4 mb-3 text-center">
                <button class="rounded-0 border-0 bg-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"
                    style="font-size:14px;"><i class="fa-regular fa-lightbulb pe-2 text-primary"></i> How to read
                    auction sheet</button>
            </div>
            <div class="col-md-10">
                <ul class="nav nav-pills justify-content-center align-items-center" id="myTab" role="tablist">
                    <li class="nav-item bg-light" role="presentation">
                        <button class="nav-link active rounded-0 fs-6" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                            aria-selected="true">VEHICLE DETAILS</button>
                    </li>
                    <li class="nav-item bg-light" role="presentation">
                        <button class="nav-link rounded-0 fs-6" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                            aria-selected="false">STATISTIC DETAILS</button>
                    </li>
                    <li class="nav-item bg-light" role="presentation">
                        <button class="nav-link rounded-0 fs-6" id="contact-tab" data-bs-toggle="tab"
                            data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane"
                            aria-selected="false">CONTACT US</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                        tabindex="0">

                        <VehicleDetails />

                    </div>
                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                        tabindex="0">

                        <StatDetails />

                    </div>
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                        tabindex="0">

                        <ContactUs />

                    </div>
                </div>
            </div>
        </div>
    </section>

    <Offcanvas />
</template>

<script>
import Offcanvas from './Models/Offcanvas.vue';
import VehicleDetails from './Models/VehicleDetails.vue';
import StatDetails from './Models/StatDetails.vue';
import ContactUs from './Models/ContactUs.vue';

export default {
    components: {
        Offcanvas,
        VehicleDetails,
        StatDetails,
        ContactUs
    }

}
</script>

<style scoped>
.nav-link {
    color: black;
    font-weight: 700;
}
</style>