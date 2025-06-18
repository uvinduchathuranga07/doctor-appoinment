<template>
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
                                    <li class="breadcrumb-item active" aria-current="page">Find a car</li>
                                </ol>
                            </nav>
                        </div>
                        <h1 class="sell-car-heading">Find a car</h1>
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
}
</style>