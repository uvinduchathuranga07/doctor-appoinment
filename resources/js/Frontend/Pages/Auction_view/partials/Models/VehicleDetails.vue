<template>
    <div class="row mt-5">
        <div class="col-md-6 px-5">
            <div class="row">
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Vehicle</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span>{{ $page.props.details.MARKA_NAME }} {{ $page.props.details.MODEL_NAME }}</span>
                </div>
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Engine CC</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span>{{ $page.props.details.ENG_V }}CC</span>
                </div>
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Equip Box</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span>{{ $page.props.details.KPP }} {{ $page.props.details.EQUIP }}</span>
                </div>
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Mileage</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span>{{ $page.props.details.MILEAGE }} KM</span>
                </div>
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Start</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span>{{ $page.props.details.START }} ¥</span>
                </div>
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Vehicle ID</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span>{{ $page.props.details.ID }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-6 px-5">
            <div class="row">
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Year</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span>{{ $page.props.details.YEAR }}</span>
                </div>
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Ex Color</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span>{{ $page.props.details.COLOR }}</span>
                </div>
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Color</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span>{{ $page.props.details.COLOR }}</span>
                </div>
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Auction Condition</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span class="text-danger fw-bold" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasWithBothOptions2"
                        aria-controls="offcanvasWithBothOptions2">{{ $page.props.details.RATE }}</span>
                </div>
                <div class="col-4 mb-3 p-2">
                    <span class="fw-bold">Sold For</span>
                </div>
                <div class="col-8 mb-3 p-2">
                    <span>{{ $page.props.details.FINISH }} ¥</span>
                </div>
            </div>
        </div>
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions2"
            aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <!-- <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">The points of auction guide is as follows</h5> -->
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
            <h6 class="fw-bold">Exterior Auction Grade</h6>
            <table class="table table-striped mt-5 text-start" style="font-size:12px;">
                <thead>
                    <th class="fw-bold">Grade</th>
                    <th>Details</th>
                </thead>
                <tbody>
                    <tr>
                        <td>S</td>
                        <td>Brand New,</td>
                    </tr>
                    <tr>
                        <td>6-9</td>
                        <td>Like new in condition, under 5,000 Km</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Vehicle is like new. All parts are new. No repair needed on vehicle. Normally given to vehicles less than 3 years.</td>
                    </tr>
                    <tr>
                        <td>4.5</td>
                        <td>The condition of vehicle is good. Only few scratches or dents as in normal cars
                        </td>
                    </tr>
                    <tr>
                        <td>4 </td>
                        <td>The condition of vehicle is good. Only few scratches or dents as in normal cars</td>
                    </tr>
                    <tr>
                        <td>3.5 </td>
                        <td>Vehicle has few scratches or dents are visible. This grade is given to vehicle in average condition</td>
                    </tr>
                    <tr>
                        <td>3 </td>
                        <td>There are various scratches or dents. Some paints faults</td>
                    </tr>
                    <tr>
                        <td>2 </td>
                        <td>	Nonstandard car. Badly stained or modified car</td>
                    </tr>
                    <tr>
                        <td>1 </td>
                        <td>Inferior car or badly modified car</td>
                    </tr>
                    <tr>
                        <td>RA or R1 </td>
                        <td>The vehicle had been in a minor accident but repaired to an acceptable standard
                        </td>
                    </tr>
                    <tr>
                        <td>R or A </td>
                        <td>A vehicle which has been in an accident where some parts have been repaired or replaced.</td>
                    </tr>
                    <tr>
                        <td>*** </td>
                        <td>Bad Accident</td>
                    </tr> 
                   

                </tbody>
            </table>
            <h6 class="fw-bold mt-5">Interior Auction Grade</h6>
            <table class="table table-striped mt-5 text-start" style="font-size:12px;">
                <thead>
                    <th class="fw-bold">Grade</th>
                    <th>Details</th>
                </thead>
                <tbody>
                    <tr>
                        <td>A</td>
                        <td>Like new, no faults</td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td>Clean condition, slightly dirty</td>
                    </tr>
                    <tr>
                        <td>C</td>
                        <td>Clean but with cigarette burns</td>
                    </tr>
                    <tr>
                        <td>D</td>
                        <td>Dirty or stinky or big rips on seat
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.col-4 {
    background-color: #e7e7e7;
}

.col-8 {
    background-color: #f1f1f1;
}
</style>