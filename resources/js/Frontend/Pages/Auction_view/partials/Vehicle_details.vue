<template>
    <section class="container">
        <div class="row vehicle_details" style="margin-bottom:10rem;">
            <div class="col-md-12">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="(image, index) in $page.props.vImages" :key="index"
                            style="cursor: zoom-in;">

                            <img class="myImg" :src="image" style="width: 100%;" alt="">

                        </div>
                    </div>
                    <div class="swiper-button-next text-white"></div>
                    <div class="swiper-button-prev text-white"></div>
                </div>


            </div>
        </div>
        <div id="myModal" class="modal">
            <div class="position-relative modal-content">
                <span
                    class="close position-absolute bg-danger text-center d-flex justify-content-center align-items-center">&times;</span>
                <div class="swiper mySwiperModal">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="(image, index) in $page.props.vImages" :key="index"
                            style="height:700px;">
                            <img :src="image" style="width: 100%;" class="" alt="">
                        </div>
                    </div>
                    <div class="swiper-button-next text-white bg-dark"></div>
                    <div class="swiper-button-prev text-white bg-dark"></div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

export default {
    components: {
        Link
    },
    data() {
        return {}
    },
    mounted() {

        var swiper = new Swiper(".mySwiper", {
            loop: "true",
            slidesPerView: 4,
            centeredSlides: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
                480: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 25,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });
        // var modal = document.getElementById("myModal");
        // var img = document.getElementById("myImg");
        // var modalImg = document.getElementById("img01");
        // var images = document.querySelectorAll(".myImg");

        // images.forEach(function (img) {
        //     img.addEventListener('click', function () {
        //         modal.style.display = "block";
        //         modalImg.src = this.src;
        //         captionText.innerHTML = this.alt;
        //     });
        // });

        // var span = document.getElementsByClassName("close")[0];

        // span.onclick = function () {
        //     modal.style.display = "none";
        // }
        // window.onclick = function (event) {
        //     if (event.target == modal) {
        //         modal.style.display = "none";
        //     }
        // };
        // Initialize the main swiper
        // Initialize the main swiper

        // const mainSwiper = new Swiper(".mySwiperMain", {
        //     navigation: {
        //         nextEl: ".swiper-button-next",
        //         prevEl: ".swiper-button-prev",
        //     },
        //     loop: true,
        // });
        

        const modalSwiper = new Swiper(".mySwiperModal", {
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            loop: true,
        });

        function openModal(index) {
            const modal = document.getElementById("myModal");
            modal.style.display = "block";

       
            modalSwiper.slideTo(index);  
        }

        document.querySelector(".close").addEventListener('click', function () {
            document.getElementById("myModal").style.display = "none";
        });

        document.querySelectorAll('.myImg').forEach((img, index) => {
            img.addEventListener('click', function () {
                openModal(index);
            });
        });

    }
}
</script>

<style scoped>
.swiper {
    width: 100%;
    height: 100%;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 1;
    min-height: 200px;
    max-height: auto;
}

.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
    background-color: black;

}

.modal {
    display: none;
    /* Hidden by default */
    position: fixed;
    /* Stay in place */
    z-index: 9999;
    /* Sit on top */
    padding-bottom: 150px;
    /* Location of the box */
    left: 0;
    top: 0;
    width: 100%;
    /* Full width */
    height: 100%;
    /* Full height */
    overflow: auto;
    /* Enable scroll if needed */
    background-color: rgb(0, 0, 0);
    /* Fallback color */
    background-color: rgba(0, 0, 0, 0.9);
    /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
    top: 15%;
    margin: auto;
    display: block;
    width: 100%;
    max-width: 700px;
    /* height: 80%; */
    /* object-fit:contain; */
    border: 0;

}


/* Add Animation - Zoom in the Modal */
.modal-content,
#caption {
    animation-name: zoom;
    animation-duration: 0.6s;
}

@keyframes zoom {
    from {
        transform: scale(0)
    }

    to {
        transform: scale(1)
    }
}

/* The Close Button */
.close {
    position: absolute;
    /* top: 20%; */
    right: 0%;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
    z-index: 99;
    width: 30px;
    height: 30px;
    /* border-top-right-radius: 0.5rem; */
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px) {
    .modal-content {
        width: 95%;
    }

    /* .close{
        top: 20%;
    right: 4%; 
    } */
}
</style>