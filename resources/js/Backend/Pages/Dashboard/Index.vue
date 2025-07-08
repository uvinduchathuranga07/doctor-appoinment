<template>
  <AppLayout>
    <div class="container-fluid">
      <!-- Top summary widgets -->
      <div class="row">
        <div
          class="col-xxl-4 col-md-6 xl-50 mb-4"
          v-for="(card, idx) in summaryCards"
          :key="idx"
        >
          <div class="card o-hidden widget-cards">
            <div :class="card.boxClass + ' card-body'">
              <div class="d-flex media static-top-widget align-items-center">
                <div
                  :class="`icons-widgets ${card.iconBox} p-3 rounded-circle me-5`"
                >
                  <div class="align-self-center text-center text-white">
                    <i :data-feather="card.icon" :class="card.iconClass"></i>
                  </div>
                </div>
                <div class="media-body media-doller">
                  <span class="m-0">{{ card.label }}</span>
                  <h3 class="mb-0">
                    <span class="counter">{{ card.count }}</span>
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts row -->
      <div class="row">
        <!-- Appointments chart -->
        <div class="col-lg-6 mb-4">
          <div class="card">
            <div class="card-header">Appointments This Week</div>
            <div class="card-body">
              <canvas ref="appointChart"></canvas>
            </div>
          </div>
        </div>

        <!-- Prescriptions chart -->
        <div class="col-lg-6 mb-4">
          <div class="card">
            <div class="card-header">Prescriptions Issued</div>
            <div class="card-body">
              <canvas ref="prescriptionChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional info row -->
      <div class="row">
        <div class="col-md-4 mb-4" v-for="(info, i) in extraInfo" :key="i">
          <div class="card text-center">
            <div class="card-body">
              <h5>{{ info.label }}</h5>
              <h2>{{ info.value }}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { Chart, registerables } from 'chart.js';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

// register all Chart.js components
Chart.register(...registerables);

export default {
  components: { AppLayout, Link },
  data() {
    return {
      // remove Vehicles, only three summary cards
      summaryCards: [
        {
          label: 'Customers',
          count: 120,
          icon: 'users',
          iconBox: 'bg-warning',
          iconClass: 'font-primary',
          boxClass: 'primary-box',
        },
        {
          label: 'Inquiries',
          count: 45,
          icon: 'git-pull-request',
          iconBox: 'bg-primary',
          iconClass: 'font-primary',
          boxClass: 'primary-box',
        },
        {
          label: 'Prescriptions',
          count: 30,
          icon: 'message-square',
          iconBox: 'bg-black',
          iconClass: 'font-primary',
          boxClass: 'primary-box',
        },
      ],
      appointmentData: [
        { day: 'Mon', count: 12 },
        { day: 'Tue', count: 15 },
        { day: 'Wed', count: 8 },
        { day: 'Thu', count: 20 },
        { day: 'Fri', count: 18 },
        { day: 'Sat', count: 10 },
        { day: 'Sun', count: 5 },
      ],
      prescriptionData: [
        { day: 'Mon', count: 30 },
        { day: 'Tue', count: 25 },
        { day: 'Wed', count: 28 },
        { day: 'Thu', count: 35 },
        { day: 'Fri', count: 32 },
        { day: 'Sat', count: 22 },
        { day: 'Sun', count: 18 },
      ],
      extraInfo: [
        { label: 'Active Pharmacies', value: 2 },
        { label: 'Doctors On Duty', value: 8 },
        { label: 'Pending Prescriptions', value: 14 },
      ],
    };
  },
  mounted() {
    if (window.feather) window.feather.replace();

    // Appointments Bar Chart
    const ctxA = this.$refs.appointChart.getContext('2d');
    new Chart(ctxA, {
      type: 'bar',
      data: {
        labels: this.appointmentData.map((d) => d.day),
        datasets: [
          {
            label: 'Appointments',
            data: this.appointmentData.map((d) => d.count),
          },
        ],
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { x: { grid: { display: false } }, y: { beginAtZero: true } },
      },
    });

    // Prescriptions Line Chart
    const ctxP = this.$refs.prescriptionChart.getContext('2d');
    new Chart(ctxP, {
      type: 'line',
      data: {
        labels: this.prescriptionData.map((d) => d.day),
        datasets: [
          {
            label: 'Prescriptions',
            data: this.prescriptionData.map((d) => d.count),
            fill: false,
            tension: 0.4,
            borderWidth: 2,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { x: { grid: { display: false } }, y: { beginAtZero: true } },
      },
    });
  },
};
</script>
