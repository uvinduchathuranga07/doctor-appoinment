<template>
    <section class="container mobileResponsiveForPadding my-5">
        <div
            v-if="
                !$page.props.vehiclesList ||
                $page.props.vehiclesList.length <= 0
            "
        >
            <div class="text-center">
                <div>
                    <img
                        src="/images/car-front-in-magnifier-glass.png"
                        width="100"
                        alt=""
                    />
                </div>
                <div class="h5 fw-bold text-secondary pt-3">
                    Please select your vehicle make.
                </div>
            </div>
        </div>
        <div
            class="row border rounded align-items-center my-5"
            style="background-color: #f1f0f0"
            v-for="vehicle in $page.props.vehiclesList"
            :key="vehicle.ID"
        >
            <div class="col-md-3 border-end py-3">
                <div>
                    <img
                        :src="getFirstImage(vehicle.IMAGES)"
                        class="w-100 h-100 rounded"
                        alt=""
                        style="object-fit: contain"
                    />
                </div>
            </div>
            <div class="col-md-9">
                <div class="row responsivePadding">
                    <div class="col-6">
                        <div class="h5 mt-3 mb-3 fw-bold">
                            {{ vehicle.MARKA_NAME }} {{ vehicle.MODEL_NAME }} :
                            {{ vehicle.YEAR }}
                        </div>
                    </div>
                    <div class="col-6 text-end pe-3 pt-3">
                        <Link
                            type="button"
                            class="btn btn-sm border bg-danger text-white fw-bold"
                            :href="
                                route('auction', {
                                    id: vehicle.ID,
                                    model: $root.stringToSlug(
                                        vehicle.MARKA_NAME
                                    ),
                                    slug:
                                        $root.stringToSlug(vehicle.MARKA_NAME) +
                                        '-' +
                                        stringToSlug(vehicle.MODEL_NAME),
                                })
                            "
                            v-if="$root.getUser()"
                            >More Details</Link
                        >
                        <Link
                            type="button"
                            class="btn btn-sm border bg-danger text-white fw-bold"
                            :href="route('user.login')"
                            v-if="!$root.getUser()"
                            >Login to view more details</Link
                        >
                    </div>
                    <div class="col-md-3 border-end my-2">
                        <div>
                            <small class="text-body-tertiary">Lot No</small>
                            <p class="fw-bold text-black">{{ vehicle.LOT }}</p>
                        </div>
                    </div>
                    <div class="col-md-3 border-end my-2">
                        <div>
                            <small class="text-body-tertiary"
                                >Auction Date</small
                            >
                            <p class="fw-bold text-black">
                                {{ vehicle.AUCTION_DATE }} :
                                {{ vehicle.AUCTION }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 border-end my-2">
                        <div>
                            <small class="text-body-tertiary"
                                >Year - Chassis ID</small
                            >
                            <p
                                class="fw-bold text-black"
                                style="word-wrap: break-word"
                            >
                                {{ vehicle.YEAR }} : {{ vehicle.KUZOV }} :
                                {{ vehicle.GRADE }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 border-end my-2">
                        <div>
                            <small class="text-body-tertiary"
                                >Engine Capacity - Equip Box</small
                            >
                            <p class="fw-bold text-black">
                                {{ vehicle.KPP }} : {{ vehicle.ENG_V }} CC
                                {{ vehicle.EQUIP }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 border-end my-2">
                        <div>
                            <small class="text-body-tertiary"
                                >Mileage (KM) - Condition</small
                            >
                            <p class="fw-bold text-black">
                                {{ vehicle.MILEAGE + "KM" }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 border-end my-2">
                        <div>
                            <small class="text-body-tertiary"
                                >Status - Colour</small
                            >
                            <p class="fw-bold text-black">
                                {{ vehicle.STATUS + "-" }} {{ vehicle.COLOR }}
                            </p>
                        </div>
                    </div>
                    <!-- <div class="col-md-3 border-end my-2">
                        <div>
                            <small class="text-body-tertiary">Average Price</small>
                            <p class="fw-bold text-black"> {{ vehicle.AVG_PRICE+'¥' }} </p>
                        </div>
                    </div> -->
                    <!-- <div class="col-md-3 border-end my-2">
                        <div>
                            <small class="text-body-tertiary">Sold For</small>
                            <p class="fw-bold text-danger"> {{ vehicle.FINISH+'¥' }} </p>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        <div v-if="$page.props.vehiclesList?.length > 0">
            <Pagination
                :total="parseInt($page.props.vehiclesListCount??'0')"
                :currentPage="parseInt($page.props?.requestQuery?.page ?? '1')"
                :lastPage="Math.ceil(($page.props.vehiclesListCount ?? 0) / 10)"
                :firstItem="(($page.props?.requestQuery?.page ?? 1)-1)*10"
                :lastItem="($page.props.vehiclesListCount ?? 0) - (($page.props.vehiclesListCount ?? 0)-($page.props?.requestQuery?.page ?? 1)*10)"
                @goto="gotoPage"
            />
        </div>
    </section>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import Pagination from "../../../components/Pagination.vue";

export default {
    components: {
        Link,
        Pagination,
    },
    data() {
        return {
            index: "",
        };
    },
    methods: {
        stringToSlug(str) {
            return str
                .toLowerCase() // Convert the string to lowercase
                .trim() // Remove whitespace from both ends
                .replace(/[^\w\s-]/g, "") // Remove all non-word characters (except for hyphens and spaces)
                .replace(/\s+/g, "-") // Replace spaces with hyphens
                .replace(/--+/g, "-") // Replace multiple hyphens with a single hyphen
                .replace(/^-+|-+$/g, ""); // Remove hyphens from the start and end of the string
        },
        getFirstImage(imgStr) {
            const strArray = imgStr.split("#");
            if (strArray.length > 0) {
                return strArray[0].replace("&h=50", "");
            } else {
                return "";
            }
        },
        gotoPage(page) {
            this.$inertia.reload({
                method: "POST",
                data: { ...this.$page.props?.requestQuery, page:page, '_method': 'GET' },
                onSuccess: () => {
                    this.loading = false;
                }
            });
        },
    },
};
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
