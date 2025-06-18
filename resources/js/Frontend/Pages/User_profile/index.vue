<template>
<AppLayout>

    <UserLayout />


</AppLayout>
</template>

<script>
import AppLayout from '@@/Layouts/AppLayout.vue';
import UserLayout from './Partials/UserLayout.vue';


export default {
    components:{
        UserLayout,
        AppLayout
    }
   
}
</script>

<style>

</style>