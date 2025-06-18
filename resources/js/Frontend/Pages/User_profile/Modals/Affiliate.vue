<template>
    <div class="table-responsive">
        <!--  -->
        <div class="row py-2 w-100 justify-content-center">
            <p class="text-center btn btn-primary text-white" style="width:180px"><a class="text-white" :href="`https://nikoba.page.link/affiliate?affiliate_id=${$page.props?.logged_customer?.enrolled_affiliate_id}`">Share My Link</a></p>
        </div>
        <div class="row pb-5 w-100 justify-content-center">
            <div class="col-md-3 ">
                <div
                    class="card align-items-center border border-1 border-secondary shadow-sm"
                >
                    <img
                        src="/images/icons/point.png"
                        class="card-img-top mt-3"
                        alt=""
                        style="width: 35px; height: 35px"
                    />
                    <div class="card-body">
                        <h6 class="text-center fw-semibold">Total points:{{ $page.props.affiliatePoints ?? 0 }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div
                    class="card align-items-center border border-1 border-secondary shadow-sm"
                >
                    <img
                        src="/images/icons/multiple-users-silhouette.png"
                        class="card-img-top mt-3"
                        alt=""
                        style="width: 35px; height: 35px"
                    />
                    <div class="card-body">
                        <h6 class="text-center fw-semibold">Total users:{{ $page.props.affilateUsers?.length  }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->

        <table
            class="table table-striped border"
            style="font-size: 13px; vertical-align: middle"
        >
            <thead>
                <tr style="vertical-align: baseline">
                    <th class="bg-custom text-white" style="min-width: 100px">
                        User
                    </th>
                    <th class="bg-custom text-white" style="min-width: 130px">
                        Joined At
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in $page.props.affilateUsers" :key="item.id">
                    <td>
                        <a href="#">{{ item.name }}</a>
                    </td>
                    <td>
                        {{ formatedDate(item.created_at) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import moment from "moment";

export default {
    methods: {
        formatedDate(date) {
            return moment(date).format("MMM DD, YYYY - h:mm A");
        },
    },
};
</script>

<style scoped>
.bg-custom {
    background-color: rgb(0, 2, 95);
    color: #fff;
}
</style>
