<template>
    <section class="container" style="margin-top:13rem; margin-bottom:5rem">
        <div class="row align-items-center">
            <div class="col-md-12 col-lg-6">
                <div class=" text-center w-100">
                    <h1 style="font-size:4rem; font-weight:700" class="about">{{ $page.props.details?.MARKA_NAME }} {{
                        $page.props.details?.MODEL_NAME }}
                        <br /><span class="px-3 text-white rounded"
                            style="background-color:#01aef0;">{{ $page.props.details.YEAR }}</span>
                    </h1>
                    <!-- <h5 style="font-weight:600">HOME/ LIVE AUCTION/ TOYOTA SIENTA</h5> -->
                    <table class="table table-striped mt-5 text-start">
                        <tbody>
                            <tr>
                                <th>
                                    VEHICLE</th>
                                <td>{{ $page.props.details.MARKA_NAME }} {{ $page.props.details.MODEL_NAME }}</td>
                            </tr>
                            <tr>
                                <th>LOT NO</th>
                                <td>{{ $page.props.details.LOT }}</td>
                            </tr>
                            <tr>
                                <th>DATE AUCTION</th>
                                <td>{{ $page.props.details.AUCTION_DATE }} {{ $page.props.details.AUCTION }} KCAA Minami
                                    Kyushu</td>
                            </tr>
                            <tr>
                                <th>YEAR CHASSIS ID</th>
                                <td>{{ $page.props.details.YEAR }} -
                                    {{ $page.props.details.KUZOV }}{{ $page.props.details.GRADE }}</td>
                            </tr>
                            <tr>
                                <th>AVERAGE PRICE</th>
                                <td>{{ $page.props.details.AVG_PRICE }} ¥</td>
                            </tr>
                        </tbody>
                    </table>
                    <p type="button" class="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="fa-regular fa-lightbulb pe-2 text-primary"></i> Auction Sheet Guide
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-center d-none d-lg-block w-100">
                    <img :src="$page.props.vImages.length > 0 ? $page.props.vImages[0] : ''" alt="" width="568">
                </div>
            </div>
        </div>
        <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="/images/auction-sheet.jpg" class="w-100" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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