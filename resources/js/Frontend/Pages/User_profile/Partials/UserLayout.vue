<template>
    <div class="container mobile-margin" style="margin-top: 190px">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm mb-5 bg-white border">
                    <div class="card-body">
                        <div class="text-center">
                            <label class="avatar text-center mt-3 position-relative" for="profile_image">
                            <img :src="$page.props.logged_customer?.media[0]?.original_url ? $page.props.logged_customer?.media[0]?.original_url : '/images/profile.png'" width="140" height="140"
                                class="rounded-circle" style="object-fit: cover" />

                            <div class="carousel-caption position-absolute">
                                <i class="fa fa-camera upload-button bg-light rounded-circle border p-2 text-black"></i>
                                <input class="file-upload d-none" type="file" id="profile_image" accept="image/*" />
                            </div>

                        </label>
                       
                        </div>
                        <h5 class="card-title text-center pt-4">
                            {{ $page.props.logged_customer.name }}
                        </h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary text-center">
                           {{ $page.props.logged_customer.email }}
                        </h6>
                        <div class="logout my-3 text-center px-3">
                            <Link class="btn bg-white rounded" :href="route('front.end.customer.logout')"><i
                                    class="fa-solid fa-arrow-right-from-bracket pe-2"></i>Logout</Link>
                        </div>
                        <div class="account-details pt-4">
                            <div class="nav nav-pills me-3 justify-content-center" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link active fs-6" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile"
                                    aria-selected="true">
                                    My Profile
                                </button>
                                <button class="nav-link fs-6" id="v-pills-password-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-password" type="button" role="tab"
                                    aria-controls="v-pills-password" aria-selected="false">
                                    Manage Password
                                </button>
                                <button class="nav-link fs-6" id="v-pills-messages-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-messages" type="button" role="tab"
                                    aria-controls="v-pills-messages" aria-selected="false">
                                    Inquies
                                </button>
                                <button class="nav-link fs-6" id="v-pills-affiliate-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-affiliate" type="button" role="tab"
                                    aria-controls="v-pills-affiliate" aria-selected="false">
                                    Affiliate
                                </button>
                                <!-- <button class="nav-link fs-6" id="v-pills-wishlist-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-wishlist" type="button" role="tab"
                                    aria-controls="v-pills-sedocumentsttings" aria-selected="false">
                                    Wishlist
                                </button> -->

                            </div>
                            <div class="card bg-white px-3 my-5">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                                        aria-labelledby="v-pills-profile-tab" tabindex="0">
                                        <Profile />
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-password" role="tabpanel"
                                        aria-labelledby="v-pills-password-tab" tabindex="0">
                                        <ManagePassword />
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                        aria-labelledby="v-pills-messages-tab" tabindex="0">
                                        <Orders />
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-affiliate" role="tabpanel"
                                        aria-labelledby="v-pills-affiliate-tab" tabindex="0">
                                        <Affiliate v-if="$page.props.logged_customer?.enrolled_affiliate == 1 && $page.props.logged_customer?.enrolled_affiliate_id" />
                                        <div class="m-auto text-center" style="max-width:400px" v-else-if="$page.props.logged_customer?.enrolled_affiliate == 1">
                                            <h3 style="color:#1e1eff;">Pending Affiliate Approval</h3>
                                            <br>
                                            <p style="color:#6d6d6d;">
                                                Thank you for applying to our affiliate program! Your request is currently under review. Once approved, you'll gain access to our affiliate programe.
                                            </p>
                                        </div>
                                        <div class="m-auto text-center" v-else>
                                            <button @click="enrollAffiliate" class="btn btn-primary">Enroll to affiliate program.</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// import $ from 'jquery';
import Profile from "../Modals/Profile.vue";
import ManagePassword from '../Modals/ManagePassword.vue';
import Orders from '../Modals/Orders.vue';
import Wishlist from '../Modals/Wishlist.vue';
import { Link } from "@inertiajs/inertia-vue3";
import Affiliate from "../Modals/Affiliate.vue";

export default {
    components: {
        Profile,
        ManagePassword,
        Orders,
        Wishlist,
        Link,
        Affiliate
    },
    props:{
        
    },
//     computed: {
//     Profile_Image() {
//       return this.logged_customer ? this.logged_customer.media.length > 0 ? this.logged_customer.media[0].original_url: "" : "";
//     },
//   },
    mounted() {
        $(document).ready(function () {
            $("html, body").animate({ scrollTop: 0 }, "fastest");
            return false;
        });
        // $(document).ready(function () {


        //     var readURL = function (input) {
        //         if (input.files && input.files[0]) {
        //             var reader = new FileReader();

        //             reader.onload = function (e) {
        //                 $('.profile-pic').attr('src', e.target.result);
        //             }

        //             reader.readAsDataURL(input.files[0]);
        //         }
        //     }


        //     $(".file-upload").on('change', function () {
        //         readURL(this);
        //     });

        //     $(".upload-button").on('click', function () {
        //         $(".file-upload").click();
        //     });
        // });

    },
    methods:{
        enrollAffiliate() {
            this.$inertia.post(route('frontend.enroll-affiliate'));
        }
    }
};
</script>

<style scoped>
.nav-pills .active {
    background-color: #01aef0;
    color: rgb(255, 255, 255) !important;
    box-shadow: 0px 0px 2px 0px;
}

.nav-pills .nav-link {
    color: black;
}

.file-upload {
    display: none;
}

/* .p-image {
   
    top: 71%;
    right: 45%; 
    color: #666666;
    transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
} */
.carousel-caption{
    top:100px;

}
.p-image:hover {
    transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
}

.upload-button {
    font-size: 1.2em;
}

.upload-button:hover {
    transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    color: #999;
}

@media (max-width:767px) {
    .mobile-margin {
        margin-top: 110px !important;
    }

    .p-image {
        right: 30%;
    }
}
</style>
