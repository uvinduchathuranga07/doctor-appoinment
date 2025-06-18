<template>
    <section class="container addPadding">

        <div class="position-relative" style="background-color:#F1F0F0">
            <div class="row justify-content-center rounded align-items-center my-4 py-3 px-3 filter-search mx-0">
                <div class="col-md-3 mb-3 mobile-padding">
                    <label for="make-select" class="fw-medium">Make</label>
                    <SelectInputComponent id="manufacture" v-model="form.manufacturer" placeholder="SELECT MAKE"
                        @change="onChangeField"
                        :options="$page.props.manufactures?.map((m) => { return { id: m.MARKA_NAME, name: m.MARKA_NAME } })" />

                </div>
                <div class="col-md-3 mb-3 mobile-padding">
                    <label for="model-select" class="fw-medium">Model</label>
                    <SelectInputComponent id="model" v-model="form.model" placeholder="SELECT MODEL"
                        @change="onChangeField"
                        :options="$page.props.models?.map((m) => { return { id: m.MODEL_NAME, name: m.MODEL_NAME } })" />

                </div>
                <div class="col-md-3 mb-3 mobile-padding">
                    <label for="days" class="fw-medium">Select Year</label>
                    <div class="row align-items-center">
                        <div class="col-6">
                            <SelectInputComponent id="year_from" v-model="form.year_from" placeholder="FROM"
                                @change="onChangeField"
                                :options="$page.props.years?.map((m) => { return { id: m.YEAR, name: m.YEAR } })" />

                        </div>
                        <div class="col-6">
                            <SelectInputComponent id="year_to" v-model="form.year_to" placeholder="TO"
                                @change="onChangeField"
                                :options="$page.props.years?.map((m) => { return { id: m.YEAR, name: m.YEAR } })" />

                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mobile-padding">
                    <label for="chassis" class="fw-medium">Chassis ID</label>
                    <SelectInputComponent id="chassis" v-model="form.chassis" placeholder="SELECT CHASSIS ID"
                        @change="onChangeField"
                        :options="$page.props.chassisNumbers?.map((m) => { return { id: m.KUZOV, name: m.KUZOV } })" />

                </div>

                <div class="col-md-3 mb-3 mobile-padding">
                    <label for="engine" class="fw-medium">Engine CC</label>
                    <SelectInputComponent id="engine" v-model="form.engine" placeholder="SELECT ENGINE CC"
                        @change="onChangeField"
                        :options="$page.props.engineCapacity?.map((m) => { return { id: m.ENG_V, name: m.ENG_V } })" />

                </div>
                <div class="col-md-3 mb-3 mobile-padding">
                    <label for="engine" class="fw-medium">Auction Grade</label>
                    <SelectInputComponent id="grade" v-model="form.grade" placeholder="SELECT AUCTION GRADE"
                        @change="onChangeField"
                        :options="$page.props.Condition?.map((m) => { return { id: m.RATE, name: m.RATE } })" />

                </div>
                <div class="col-md-3 mb-3 mobile-padding">
                    <label for="days" class="fw-medium">Lot No</label>
                    <input class="form-control form-select-sm" type="text" placeholder="ENTER LOT NO"
                        v-model="form.lot_no">
                </div>
                <div class="col-md-3 mb-3 mobile-padding" v-if="this.advance_search">
                    <label for="days" class="fw-medium">Auction Available Days</label>
                    <SelectInputComponent id="available_days" v-model="form.available_days"
                        placeholder="SELECT AUCTION DATE" @change="onChangeField"
                        :options="$page.props.auctionDates?.map((m) => { return { id: m.AUCTION_DATE, name: m.AUCTION_DATE } })" />

                </div>
                <div class="col-md-3 mb-3 mobile-padding" v-if="this.advance_search">
                    <label for="days" class="fw-medium">Color</label>
                    <SelectInputComponent id="colors" v-model="form.color" placeholder="SELECT COLOR"
                        @change="onChangeField"
                        :options="$page.props.colorQuery?.map((m) => { return { id: m.COLOR, name: m.COLOR } })" />

                </div>
                <div class="col-md-3 mb-3 mobile-padding" v-if="this.advance_search">
                    <label class="fw-medium">Mileage</label>
                    <div class="row align-items-center">
                        <div class="col-6">
                            <SelectInputComponent id="mileage_from" v-model="form.mileage_from" placeholder="FROM"
                                @change="onChangeField"
                                :options="$page.props.Mileage?.map((m) => { return { id: m.MILEAGE, name: m.MILEAGE } })" />

                        </div>
                        <div class="col-6">
                            <SelectInputComponent id="mileage_to" v-model="form.mileage_to" placeholder="TO"
                                @change="onChangeField"
                                :options="$page.props.Mileage?.map((m) => { return { id: m.MILEAGE, name: m.MILEAGE } })" />

                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mobile-padding" v-if="this.advance_search">
                    <label for="days" class="fw-medium">Start Price</label>
                    <SelectInputComponent id="price" v-model="form.start_price" placeholder="SELECT START PRICE"
                        @change="onChangeField"
                        :options="$page.props.PriceQuery?.map((m) => { return { id: m.AVG_PRICE, name: m.AVG_PRICE } })" />

                </div>
                <div class="col-md-3 text-center">
                    <p type="button" class=" rounded-0 mb-0 w-100 advace-btn" @click.prevent="advanceFilter">{{
                        advance_search ? 'Hide advance search' : 'Advance search'
                        }}<i :class="['fa-solid', advance_search ? 'fa-angles-up' : 'fa-angles-down', 'ps-2']"></i></p>
                </div>
            </div>
            <div class="row mx-3 pb-3 justify-content-center">
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary btn-sm rounded-0 w-100 fw-semibold bg-dark mb-2"
                        @click.prevent="resetFilter">RESET</button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-primary btn-sm rounded-0 w-100 fw-semibold mb-2"
                        @click.prevent="filterData">SEARCH</button>
                </div>
            </div>
            <div class="position-absolute d-flex justify-content-center align-items-center h-100 w-100 top-0"
                style="background-color: #f1f0f091;" v-if="loading">
                <div class="position-relative">
                    <div class="position-absolute d-flex justify-content-center align-items-center h-100 w-100 top-0">
                        <div class="spin text-center py-3 shadow-sm">
                            <div class="spinner-border text-black" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mb-0 mt-1" style="font-size: 14px;">Please Wait..</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="load_container border mt-4 py-4" style="background-color:#F1F0F0">
            <div class="load-3 text-center py-5 my-3 px-3">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </div> -->

    </section>
</template>

<script>
import SelectInputComponent from './SelectInputComponent.vue';


export default {
    components: {
        SelectInputComponent
    },
    data() {
        return {
            index: '',
            form: {
                available_days: 0,
                manufacturer: 0,
                model: 0,
                year_from: 0,
                year_to: 0,
                chassis: 0,
                engine: 0,
                color: "",
                lot_no: "",
                grade: 0,
                start_price: 0,
                mileage_from: 0,
                mileage_to: 0,
                search: false
            },
            loading: false,
            advance_search: false


            // https://nikoba.com/live-auction/?available_days=0&manufacturer=0&demo_model=0&undefined=0&undefined=0&demo_chassis=0&demo_engine=0&demo_color=0&lotNo=&available_days=0&page=1
        }
    },
    props: {
        reload: {
            type: Boolean,
            default: false
        },

    },
    computed: {
        auctionDateOptions() {
            return this.$page.props.auctionDates.map((value, index) => ({
                id: index,
                name: value?.AUCTION_DATE,
            }));
        },
    },
    mounted() {

        this.setQueryData();

        if (this.reload) {
            this.$inertia.reload({ data: { ...this.form, search: false }, onSuccess: () => { this.form.search = false } });

        }
        // console.log(this.form)

        $('#manufacture, #model, #year_from, #year_to, #grade, #chassis, #engine, #available_days, #colors, #mileage_from, #mileage_to, #price').on('select2:open', function () {
            setTimeout(function () {
                let searchField = document.querySelector('.select2-container--open .select2-search__field');
                if (searchField) {
                    searchField.focus();
                }
            }, 100);
        });



    },
    methods: {
        resetFilter() {
            this.form = {
                available_days: 0,
                manufacturer: 0,
                model: 0,
                year_from: 0,
                year_to: 0,
                chassis: 0,
                engine: 0,
                color: 0,
                lot_no: "",
                grade: 0,
                start_price: 0,
                mileage_from: 0,
                mileage_to: 0,
                search: false
            }
        },
        advanceFilter() {
            this.loading = true;
            if (this.advance_search == false) {
                this.advance_search = true;
                setTimeout(() => {
                    this.loading = false;
                }, 500);
            } else {
                this.advance_search = false;
                setTimeout(() => {
                    this.loading = false;
                }, 500);
            }
        },
        onChangeField(evt) {
            console.log('jdsfhsdj')
            if (this.$page.props.requestQuery.manufacturer != this.form.manufacturer) {
                this.form.model = 0;
                this.form.year_from = 0;
                this.form.year_to = 0;
                this.form.chassis = 0;
                this.form.engine = 0;
                this.form.color = 0;
                this.form.grade = 0;
                this.form.start_price = 0;
                this.mileage_from = 0;
                this.mileage_to = 0;
            }
            this.form.search = false
            this.loading = true;
            this.$inertia.reload({
                method: "POST",
                data: { ...this.form, '_method': 'GET' },
                onSuccess: () => {
                    this.setQueryData()
                    this.loading = false;
                }
            });
        },
        setQueryData() {
            this.form.available_days = this.$page.props.requestQuery.available_days ?? 0;
            this.form.manufacturer = this.$page.props.requestQuery.manufacturer ?? 0;
            this.form.model = this.$page.props.requestQuery.model ?? 0;
            this.form.year_from = this.$page.props.requestQuery.year_from ?? 0;
            this.form.year_to = this.$page.props.requestQuery.year_to ?? 0;
            this.form.chassis = this.$page.props.requestQuery.chassis ?? 0;
            this.form.engine = this.$page.props.requestQuery.engine ?? 0;
            this.form.color = this.$page.props.requestQuery.color ?? 0;
            this.form.lot_no = this.$page.props.requestQuery.lot_no ?? "";
            this.form.grade = this.$page.props.requestQuery.grade ?? 0;
            this.form.start_price = this.$page.props.requestQuery.start_price ?? 0;
            this.form.mileage_from = this.$page.props.requestQuery.mileage_from ?? 0;
            this.form.mileage_to = this.$page.props.requestQuery.mileage_to ?? 0;
            this.form.search = false;

        },
        filterData() {
            if (this.reload) {

                this.$inertia.reload({
                    methods: "POST",
                    data: { ...this.form, search: true, '_method': 'GET' },
                    onSuccess: () => {
                        this.setQueryData();
                        this.advance_search = true;

                    }
                });

            } else {
                this.$inertia.visit(route('live.auction'), {

                    data: { ...this.form, search: true, },
                    onSuccess: () => {
                        this.setQueryData();
                        this.advance_search = true;

                    }
                });

            }
        }
    }
}
</script>

<style scoped>
.padding-add {
    padding-top: 0.7rem;
    padding-bottom: 0.7rem;
}

.form-select:focus {
    box-shadow: none;
}

.form-control:focus {
    box-shadow: none;
}

.spin {
    min-width: 150px;
    background-color: #fff;
    border-radius: 12px;
}

.advace-btn {
    text-decoration: underline !important;
    color: green;
    font-size: 14px;
}

@media (max-width: 767px) {
    .addPadding {
        padding-left: 2rem;
        padding-right: 2rem;
    }

    .mobile-padding {
        margin-bottom: 1rem;
    }
}
</style>