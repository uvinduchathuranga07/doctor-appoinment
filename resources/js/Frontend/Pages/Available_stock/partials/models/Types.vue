<template>
    <div>

    <div class="form-check my-3" v-for="type in $page.props.vehicleTypes" :key="type.id">
        <input class="form-check-input" type="checkbox" :value="type.id" :id="'check_v_types_'+type.id" @change="onCheckVehicleType" v-model="form.type">
        <label class="form-check-label text-uppercase" :for="'check_v_types_'+type.id">
            {{ type?.title }} <img :src="type?.media?.length > 0 ? type?.media[0].original_url:''"
                 height="20" class="ps-2" alt="">
        </label>
    </div>
    </div>
</template>

<script>
export default {
data() {
    return {
        form:{type:[]}
    }
},
mounted() {
    this.setFormData();
},
methods:{
    onCheckVehicleType(evt) {
        const query = this.$page.props.requestQuery??{};
        this.$inertia.reload({method:"POST",data:{"_method":"GET",...query, type:this.form.type}, onSuccess:()=>{
            this.setFormData();
        }})
    },
    setFormData() {
        const query = this.$page.props.requestQuery??{};

        if(query.hasOwnProperty('type')) {
            this.form.type = typeof query.type == 'object' ? query.type : [query.type]
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