<template>
    <div class="container mt-5">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="images/step1.jpg" class="w-100" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="images/step2.jpg" class="w-100" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="images/step3.jpg" class="w-100" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="images/step4.jpg" class="w-100" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="images/step5.jpg" class="w-100" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="images/step6.jpg" class="w-100" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="images/step7.jpg" class="w-100" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="images/step8.jpg" class="w-100" alt="">
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <!-- <div class="swiper-pagination"></div> -->
        </div>
    </div>
</template>

<script>
export default {

    mounted() {
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 4,
            spaceBetween: 30,

            //   pagination: {
            //     el: ".swiper-pagination",
            //     clickable: true,
            //   },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                480: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });
    }
}
</script>

<style scoped>
.swiper-slide {
    opacity: 1;
}
</style>