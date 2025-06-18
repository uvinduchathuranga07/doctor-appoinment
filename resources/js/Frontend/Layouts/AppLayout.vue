<template>
  
    <Topnavigationbar style="top: 0;"/>
    
    <slot />
    

    <Footer />

</template>
<script setup>
import { useRecaptchaProvider } from 'vue-recaptcha'
useRecaptchaProvider()

</script>

<script>
import Topnavigationbar from './partials/Topnavigationbar.vue';
import Footer from './partials/Footer.vue';


export default {
    components:{
        Topnavigationbar,
        Footer
    }
}
</script>

<style>

</style>