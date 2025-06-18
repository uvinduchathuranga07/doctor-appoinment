<template>
    <section class="mt-5">
        <div class="row border py-4 rounded shadow-sm">
            <div class="col-md-4">
                <select class="form-select mb-4" aria-label="Default select example" v-model="form.year"
                    @change="onChangeField">
                    <option value="0" selected>SELECT YEAR</option>
                    <option v-for="value in $page.props.statsYears" :key="value.YEAR" :value="value.YEAR">{{ value.YEAR
                        }}</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select mb-4" aria-label="Default select example" v-model="form.chassis_no"
                    @change="onChangeField">
                    <option value="0" selected>SELECT CHASSIS ID</option>
                    <option v-for="value in $page.props.statsChassis" :key="value.TAG0" :value="value.KUZOV">{{
                        value.KUZOV }}</option>
                </select>
            </div>
            <!-- <div class="col-md-4">
                <select class="form-select mb-4" aria-label="Default select example">
                    <option value="0" selected>SELECT AUCTION GRADE</option>
                    <option v-for="value in $page.props.statsChassis" :key="value.TAG0" :value="value.KUZOV">{{ value.KUZOV }}</option>
                </select>
            </div> -->
            <div class="col-md-4">
                <select class="form-select mb-4" aria-label="Default select example" v-model="form.rate" @change="onChangeField"> 
                    <option value="0" selected>SELECT CONDITION</option>
                    <option v-for="value in $page.props.statsConditions" :key="value.TAG0" :value="value.RATE">{{ value.RATE }}</option>
                </select>
            </div>
        </div>
        <section class="my-5">
            <div class="table-responsive">
                <table class="table table-striped border" style="font-size:13px; vertical-align:middle;">
                    <thead>
                        <tr style="vertical-align:baseline;">
                            <th class="bg-custom text-black" style="min-width:100px;">IMAGE</th>
                            <th class="bg-custom text-black" style="min-width:80px;">LOT NO</th>
                            <th class="bg-custom text-black" style="min-width:180px;">DATE AUCTION</th>
                            <th class="bg-custom text-black" style="min-width:130px;">YEAR - CHASSIS ID</th>
                            <th class="bg-custom text-black" style="min-width:180px;">ENGINE CAPACITY - EQUIP BOX</th>
                            <th class="bg-custom text-black" style="min-width:130px;">MILEAGE(KM)- CONDITION</th>
                            <th class="bg-custom text-black" style="min-width:70px;">START</th>
                            <th class="bg-custom text-black" style="min-width:70px;">SOLD FOR</th>
                            <th class="bg-custom text-black" style="min-width:80px;">STATUS</th>
                            <th class="bg-custom text-black" style="min-width:80px;">COLOR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="statItem in $page.props.vehicleStatsList" :key="statItem.ID">
                            <td>
                                <img :src="statItem.IMAGES"
                                    alt="" style="height:50px;">
                            </td>
                            <td class="text-danger fw-bold">
                               <Link class="text-danger"  :href="
                                route('auction.stat', {
                                    id: statItem.ID,
                                    model: $root.stringToSlug(
                                        statItem.MARKA_NAME
                                    ),
                                    slug:
                                        $root.stringToSlug(statItem.MARKA_NAME) +
                                        '-' +
                                        $root.stringToSlug(statItem.MODEL_NAME),
                                })
                            "> {{ statItem.LOT }}</Link>
                            </td>
                            <td>
                                {{ statItem.AUCTION_DATE }}
                                {{ statItem.AUCTION }}
                            </td>
                            <td>
                                {{ statItem.YEAR }} - {{ statItem.KUZOV }} {{ statItem.GRADE }}
                            </td>
                            <td>
                                {{ statItem.KPP }} {{ statItem.ENG_V }}CC - {{ statItem.EQUIP }}
                            </td>
                            <td>
                                {{ statItem.MILEAGE }}KM
                                <span class="text-danger fw-bold text-decoration-underline" type="button"
                                    data-bs-toggle="offcanvas" data-bs-target="#auction"
                                    aria-controls="offcanvasScrolling">{{ statItem.RATE }}</span>
                            </td>
                            <td>
                                {{ statItem.START }}¥
                            </td>
                            <td>{{ statItem.FINISH }}¥
                            </td>
                            <td>
                                <span :class="`${statusColorClass(statItem.STATUS)} p-1 rounded px-2`"> {{
                                    (statItem.STATUS == "" || !statItem.STATUS) ? '-' : statItem.STATUS }}</span>
                            </td>
                            <td>
                                {{ statItem.COLOR }}
                            </td>
                        </tr>
                        <tr class="text-center" v-if="this.$page.props.vehicleStatsList.length == 0">
                           <td colspan="10"> No results found..</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </section>
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="auction"
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
    </section>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components:{
        Link
    },

    data() {
        return {
            index: '',
            form: {
                manufacture: 0,
                model: 0,
                chassis_no: 0,
                year: 0,
                rate: 0,
                engine: 0,
                page: 1
            }
        }
    },
    mounted() {
        console.log(this.$page.props.details)
        this.form.manufacture = this.$page.props.details.MARKA_NAME;
        this.form.model = this.$page.props.details.MODEL_NAME;
        this.form.year = this.$page.props.details.YEAR;
        this.form.rate = this.$page.props.details.RATE;
        this.setQueryData();
        this.$inertia.reload({ method: "POST", data: { '_method': "GET", ...this.form, manufacture: this.$page.props.details.MARKA_NAME, model: this.$page.props.details.MODEL_NAME, rate: this.$page.props.details.RATE }, onSuccess: () => { this.setQueryData() } });
    },
    methods: {
        statusColorClass(status) {
            return status == 'SOLD' ? 'bg-danger text-white' : status == 'NOT SOLD' ? 'bg-success text-white' : 'text-dark';
        },
        resetFilter() {
            this.form = {
                manufacture: 0,
                model: 0,
                chassis_no: 0,
                year: 0,
                rate: 0,
                engine: 0,
                page: 1
            }
        },
        setQueryData() {
            this.form.manufacture = this.$page.props.requestQuery.manufacturer ?? this.$page.props.details.MARKA_NAME;
            this.form.model = this.$page.props.requestQuery.model ?? this.$page.props.details.MODEL_NAME;
            this.form.year = this.$page.props.requestQuery.year ?? this.$page.props.details.YEAR;
            this.form.chassis_no = this.$page.props.requestQuery.chassis_no ?? 0;
            this.form.engine = this.$page.props.requestQuery.engine ?? 0;
            this.form.rate = this.$page.props.requestQuery.rate ?? 0;
            this.form.page = this.$page.props.requestQuery.page ?? 0;
        },
        onChangeField(evt) {
            if (this.$page.props.requestQuery.year != this.form.year) {
                this.form.chassis_no = 0;
                this.form.rate = 0;
            }
            this.$inertia.reload({
                method: "POST",
                data: { "_method": "GET", ...this.form, },
                onSuccess: () => {
                    this.setQueryData()
                }
            });
        },
    }
}
</script>

<style scoped>
.form-select {
    box-shadow: none;
}

.bg-custom {
    background-color: aqua;
}
</style>