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
                                    <li class="breadcrumb-item active" aria-current="page">About Us</li>
                                </ol>
                            </nav>
                        </div>
                        <h1 class="sell-car-heading">About Us</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-relative py-5 bg-white upgrade-section mx-auto">
            <div class="upgrade-container">
                <div class="upgrade-text text-center">UPGRADE</div>
                <div class="image-container text-center mt-4">
                    <img src="/images/subpages/range  rover.png" alt="Modern car" class="car-image img-fluid">
                </div>
            </div>
        </div>

        <section class="last-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="row d-flex align-items-stretch">
                            <div class="col-md-6 d-flex flex-column justify-content-center">
                                <div>
                                    <h2 class="section-heading">Sell Your Car the Easy Way with Nexus Auto!</h2>
                                    <p class="section-text">Thinking of selling your car? Look no further than Nexus
                                        Auto! We provide a hassle-free platform to help you sell your vehicle quickly
                                        and conveniently.</p>
                                    <p class="section-text">Simply fill out the form below with your car’s details, and
                                        we’ll get started on finding the perfect buyer for you.</p>

                                </div>
                            </div>
                            <!-- Image Column -->
                            <div class="col-md-6 d-flex align-items-stretch">
                                <img src="/images/subpages/close-up-customer-with-business-person-car-dealership-scaled.jpg"
                                    alt="Car handover" class="img-fluid handover-image w-100 h-100">
                            </div>
                            <!-- Text Column -->



                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="last-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mx-auto">
                        <div class="row d-flex align-items-stretch">
                            <!-- Image Column -->
                            <div class="col-md-6 d-flex align-items-stretch">
                                <img src="/images/subpages/close-up-customer-with-business-person-car-dealership-scaled.jpg"
                                    alt="Car handover" class="img-fluid handover-image w-100 h-100">
                            </div>
                            <!-- Text Column -->
                            <div class="col-md-6 d-flex flex-column justify-content-center">
                                <div>
                                    <h2 class="section-heading">Sell Your Car the Easy Way with Nexus Auto!</h2>
                                    <p class="section-text">Thinking of selling your car? Look no further than Nexus
                                        Auto! We provide a hassle-free platform to help you sell your vehicle quickly
                                        and conveniently.</p>
                                    <p class="section-text">Simply fill out the form below with your car’s details, and
                                        we’ll get started on finding the perfect buyer for you.</p>


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
// import $ from 'jquery';
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

</style>