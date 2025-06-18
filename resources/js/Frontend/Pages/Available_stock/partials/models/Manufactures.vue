<template>
    <div>

    <div class="form-check my-3" v-for="manufacture in $page.props.manufacturers" :key="manufacture.id">
        <input class="form-check-input" type="checkbox" :value="manufacture.id" v-model="form.brand" @change="onCheckVehicleBrand" :id="'check_manu_'+manufacture.id">
        <label class="form-check-label text-uppercase" :for="'check_manu_'+manufacture.id">
            {{ manufacture?.title??'' }} <img
                :src="manufacture?.media?.length > 0 ? manufacture?.media[0].original_url:''"
                height="20" class="ps-2" alt="">
        </label>
    </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
           form:{brand:[]}
        }
    },
    mounted(){
        this.setFormData();
    },
    methods:{
    onCheckVehicleBrand(evt) {
        const query = this.$page.props.requestQuery??{};
        this.$inertia.reload({method:"POST",data:{"_method":"GET",...query, brand:this.form.brand}, onSuccess:()=>{
            this.setFormData();
        }})
    },
    setFormData() {
        const query = this.$page.props.requestQuery??{};

        if(query.hasOwnProperty('brand')) {
            this.form.brand = typeof query.brand == 'object' ? query.brand : [query.brand]
        }
    }
}
}
</script>

<style scoped>
.form-check-input {
    box-shadow: none;
}
</style>