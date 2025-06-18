<template>
   <div class="table-responsive">
                <table class="table table-striped border" style="font-size:13px; vertical-align:middle;">
                    <thead>
                        <tr style="vertical-align:baseline;">
                            <th class="bg-custom text-white" style="min-width:100px;">Vehicle ID</th>
                            <th class="bg-custom text-white" style="min-width:80px;">Purchase Time</th>
                            <th class="bg-custom text-white" style="min-width:180px;">Payment Method</th>
                            <th class="bg-custom text-white" style="min-width:130px;">Created At</th>
                            <th class="bg-custom text-white" style="min-width:180px;">Status</th>
                            <th class="bg-custom text-white" style="min-width:180px;">Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in $page.props.inquires" :key="item.id">
                            <td>
                                <a :href="item.url" target="_blank">{{ item.vehicle_id }}</a>
                            </td>
                            <td>
                                {{ item.purchase_time }}
                            </td>
                            <td>
                                {{ item.payment_method }}
                            </td>
                            <td>
                                {{formatedDate(item.created_at) }}
                            </td>
                            <td class="text-capitalize">
                               {{ item.status }}
                            </td>
                            <td>
                                {{ item.message }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
</template>

<script>
import moment from 'moment';

export default {
    methods:{
        formatedDate(date){
            return moment(date).format('MMM DD, YYYY - h:mm A')
        }
    }
}
</script>

<style scoped>
.bg-custom{
    background-color: rgb(0, 2, 95);
    color: #fff;
}
</style>