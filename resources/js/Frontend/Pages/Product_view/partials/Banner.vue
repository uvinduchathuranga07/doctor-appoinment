<template>
    <section class="container fixedheight" style="margin-top:13rem; margin-bottom:12rem">
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-6">
                <div class=" text-center w-100">
                    <h1 style="font-size:4rem; font-weight:700" class="about">{{ $page.props.vehicle?.manufacture?.title }} {{ $page.props.vehicle?.vehicle_model?.title }}<br/><span
                            class="px-3 text-white rounded" style="background-color:#01aef0;">{{ $page.props.vehicle?.year }}</span></h1>
                    <!-- <h5 style="font-weight:600">HOME/ AVAILABLE STOCK IN SRI LANKA / TOYOTA SIENTA</h5> -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="imageCar text-center d-none d-lg-block w-100">
                    <img :src="$page.props.vehicle?.media.length> 0? $page.props.vehicle?.media[0]?.original_url:''"
                        alt="" width="568">
                </div>
            </div> 
        </div>
    </section>
</template>
<script>
export default {

}
</script>

<style scoped>

</style>