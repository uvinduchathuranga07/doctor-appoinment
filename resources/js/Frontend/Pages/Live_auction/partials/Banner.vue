<template>
  <div class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item d-block custom_slide_height">
                <img src="https://img.freepik.com/premium-photo/judge-with-judge-gavel-red-toy-car_220873-12932.jpg?w=740"
                    class="d-block w-100 swiperImg custom_slide_height" alt="...">
                <div class="carousel-caption custom_caption_position" style="top: 40%;">
                    <div class="caption">
                        <div class="p-4">
                            <h1 class="main-topic-banner" style="font-size:3.5rem; font-weight:700">LIVE AUCTION IN JAPAN</h1>
                            <h5 style="font-weight:600">NIKOBA.COM</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.custom_slide_height{
  height: 47vh !important;
}

@media (max-width: 768px){
    .main-topic-banner{
        font-size: 2rem !important;
    }
    .custom_caption_position{
        top: 25% !important;
    }
}
</style>