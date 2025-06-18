<template>
    <div class="container p-0">
        <div class="row">
            <div class="col-md-3" v-for="index in 4" :key="index">
                <div class="card mb-4 shadow-sm border">
                    <img src="https://autodirectstaging.quicksite.asia/wp-content/uploads/elementor/thumbs/bmw-i5-edrive40-review-27-qnlqnhn6sxvjcrnpabydbtd33dylma31n3gxsctqew.jpg"
                        class="object-fit-cover card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title text-black fw-semibold">BMW I5 EDRIVE 40</h5>
                        <p class="card-text"><span class="bg-black px-2 text-white">2024</span></p>
                        <p class="card-text">Automatic</p>
                        <p class="card-text">Electric</p>
                        <h5 class="card-title text-black fw-semibold">Rs. 31,500,000</h5>
                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {

        }
    }
}
</script>

<style>
@media (max-width: 767px) {
    .mobileResponsiveForPadding {
        padding-left: 2rem;
        padding-right: 2rem;
    }

    .responsivePadding {
        padding-left: 1.5rem;
    }

}
</style>