<template>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <SideNavBar />
            <!-- Layout container -->
            <div class="layout-page">
                <TopNavBar :theme="theme" @toggle-theme="toggleTheme" />
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-fluid flex-grow-1 container-p-y">
                        <slot />
                    </div>
                </div>
            </div>
            <!-- / Layout container -->
        </div>
    </div>
    <!-- / Layout wrapper -->
</template>

<script>
import TopNavBar from "@/Layouts/Partials/TopNavBar.vue";
import SideNavBar from "@/Layouts/Partials/SideNavBar.vue";
import FooterBar from "@/Layouts/Partials/FooterBar.vue";

export default {
    components: {
        TopNavBar,
        SideNavBar,
        FooterBar,
    },
    data() {
        return {
            theme: localStorage.getItem("theme") === "dark" ? "dark" : "light",
        };
    },
    mounted() {
        // Apply theme first to avoid flash
        this.applyTheme();

        // Existing initializations
        feather.replace();
        $( document ).ready(function() {
       //    responsive sidebar
       var $window = $(window);
    var widthwindow = $window.width();
    (function($) {
      "use strict";
      if (widthwindow <= 991) {
        $toggle_nav_top.addClass("open");
        $nav.addClass("open");
      }
    })(jQuery);
    $(window).resize(function() {
      var widthwindaw = $window.width();
      if (widthwindaw + 17 <= 991) {
        $toggle_nav_top.addClass("open");
        $nav.addClass("open");
      } else {
        $toggle_nav_top.removeClass("open");
        $nav.removeClass("open");
      }
    });
});
        
        $(document).ready(function () {
            // Default
            if ($(".select2").length) {
                $(".select2").each(function () {
                    var $this = $(this);
                    $this
                        .wrap('<div class="position-relative"></div>')
                        .select2({
                            placeholder: "-- Select --",
                            dropdownParent: $this.parent(),
                        });
                });
            }

            const selectPicker = $(".selectpicker");
            if (selectPicker.length) {
                selectPicker.selectpicker();
            }
        });
        const popoverTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="popover"]')
        );
        const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            // added { html: true, sanitize: false } option to render button in content area of popover
            return new bootstrap.Popover(popoverTriggerEl, {
                html: false,
                sanitize: false,
            });
        });

        $("body").on("hidden.bs.modal", ".modal", function () {
            console.log("ssss");
            if ($("body").hasClass("modal-open")) {
                $("body").removeClass("modal-open").attr("style", "");
            }
        });

        // handle side menu bar
        $("body").on("click", ".layout-menu-toggle", function () {
            $("#layout-menu").toggleClass("left-menu-open");
            $("#layout-page").toggleClass("layout-page-menu-open");
        });

        $(".menu-link.menu-toggle").on("click", function (e) {
            let parentEl = $(this).parent();
            $(parentEl).toggleClass("open active", 300);
        });
        
    },
    methods: {
        applyTheme() {
            const isDark = this.theme === "dark";
            const html = document.documentElement;
            html.classList.toggle("theme-dark", isDark);
            html.classList.toggle("theme-light", !isDark);
        },
        toggleTheme() {
            this.theme = this.theme === "dark" ? "light" : "dark";
            localStorage.setItem("theme", this.theme);
            this.applyTheme();
        },
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id,
                },
                {
                    preserveState: false,
                }
            );
        },

        logout() {
            console.log("logout");
            // this.$inertia.post(route("logout"));
        },
    },
};
</script>

<style src="../../../../public/css/backend/dark-theme.css"></style>