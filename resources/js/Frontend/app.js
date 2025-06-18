import './bootstrap';

import { createApp, h } from 'vue';
import {createHead} from '@unhead/vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { ZiggyVue } from 'ziggy';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { VueRecaptchaPlugin } from 'vue-recaptcha'


const appName = window.document.getElementsByTagName('title')[0]?.innerText || '';
const head = createHead();
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({
            render: () => h(app, props),
            methods: {
                getUser() {
                    return this.$page.props.logged_customer;
                },
                stringToSlug(str) {
                    return str
                    .toLowerCase()                // Convert the string to lowercase
                    .trim()                        // Remove whitespace from both ends
                    .replace(/[^\w\s-]/g, '')      // Remove all non-word characters (except for hyphens and spaces)
                    .replace(/\s+/g, '-')          // Replace spaces with hyphens
                    .replace(/--+/g, '-')          // Replace multiple hyphens with a single hyphen
                    .replace(/^-+|-+$/g, '');      // Remove hyphens from the start and end of the string
                
                },
                getQueryParam(param) {
                    const urlParams = new URLSearchParams(window.location.search);
                    return urlParams.get(param);
                },
                hasPermission(str) {
                    if (this.$page.props.permission == undefined) {
                        return false;
                    }
                    if (this.$page.props.permission[str] != undefined) {
                        return this.$page.props.permission[str];
                    } else {
                        return false;
                    }
                },
                showMessage(icon, title, text) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener("mouseenter", Swal.stopTimer);
                            toast.addEventListener("mouseleave", Swal.resumeTimer);
                        },
                    });
                    Toast.fire({
                        icon: icon,
                        title: title,
                        text: text,
                    });
                },
                showConfirmDialog(icon, title, text, confirmButtonText, cancelButtonText, callBackFn) {
                    const swalButons = Swal.mixin({
                        customClass: {
                          confirmButton: "btn btn-success btn-sm mx-1",
                          cancelButton: "btn btn-danger btn-sm mx-1",
                        },
                        buttonsStyling: false,
                      });
                      swalButons
                      .fire({
                        title: title,
                        text: text,
                        icon: icon,
                        showCancelButton: true,
                        confirmButtonText: confirmButtonText,
                        cancelButtonText: cancelButtonText,
                        reverseButtons: true,
                      }).then((res) => {
                        if (res.isConfirmed) {
                            callBackFn();
                        }
                      });
                },
            },
        })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(head)
            .use(VueRecaptchaPlugin, {
                v2SiteKey:props.initialPage.props.recaptcha_site_key,
                v3SiteKey: 'YOUR_V3_SITEKEY_HERE',
            })
            // .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
