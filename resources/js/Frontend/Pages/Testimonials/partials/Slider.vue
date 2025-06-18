<template>
    <section class="container my-5">

        <div v-for="testimonial in testimonials" :key="testimonial.index" v-if="testimonials">
            <div class="h5 my-5 text-center fw-bold">-{{ testimonial.name }}-</div>
            <div class="row">
                <div class="col-md-12">
                    <div class="swiper mySwiper py-3 px-3">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide rounded">
                                <img :src="testimonial.media[0].original_url"
                                    class="w-100 h-100 swiper-test-img rounded shadow" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="testimonials text-center py-5" v-else>
            <h2>No Testimonials</h2>
        </div>
    </section>
</template>

<script>
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
export default {
    components: {

    },
    props: {
        testimonials: Object
    },
    mounted() {
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 2,
            spaceBetween: 20,

            breakpoints: {
                0: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                764: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },

            },

        });
    }

}
</script>

<style scoped>
.swiper {
    width: 100%;
    height: 100%;

}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 1;

}

.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;

}
</style>