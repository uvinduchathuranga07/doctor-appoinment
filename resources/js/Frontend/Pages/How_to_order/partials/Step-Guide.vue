<template>
    <div class="container mt-5 mb-5">
        <!-- <div class="row  border rounded-4 shadow-sm justify-content-center" style="background-color:#e7e7e7"> -->
        <div class="row rounded-4 shadow-sm justify-content-center">
            <div class="col-md-7 p-5"> 
                <h3 class="mb-5 text-center">PLEASE FOLLOW THESE STEPS</h3>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">Visit <a :href="site_url">{{ site_url }}</a></p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">Go to "Knowledge Centre" to know how to select excellent quality vehicles following
                        "Auction Sheet"</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">Go to "LIVE AUCTION"</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">Select your vehicle through "SEARCH" options</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">Use "ADVANCED SEARCH" options to refine your result.</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">Read the "Auction Sheet" by clicking on "How to read the auction sheet"</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">Before placing your bid see the Previous Sold Prices of same conditioned vehicles by
                        clicking on " Statistics by Model ". to get some understanding about auction selling prices of
                        your dream vehicle.</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">When your bid amount is the highest you will have a 100% chance to get the vehicle.
                    </p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">When there are more than one bid for the same vehicle and the sold price is less than
                        all the bids the vehicle is offered to the highest bidder.</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">Customer gets the bidding benefits when sold price is less than the bid amount.</p>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">Place your bid by making a refundable deposit through our Online Payment system.</p>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-car pe-3"></i>
                    <p class="m-0">Contact our Sales Staff for advice & further assistance.</p>
                </div>
            </div>
            <!-- <div class="col-md-5 pe-0">
                <img src="https://img.freepik.com/premium-photo/black-car-with-word-honda-back_1273914-32091.jpg?ga=GA1.1.279465070.1717392078&semt=ais_hybrid"
                    class="w-100 h-100 steps-image" alt="">
            </div> -->
        </div>
    </div>
</template>

<script>
export default {
        props:{
            site_url:Object
        }
}
</script>

<style scoped>

</style>