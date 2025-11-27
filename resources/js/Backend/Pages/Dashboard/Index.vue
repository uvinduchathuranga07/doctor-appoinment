<template>
  <AppLayout>
    <div class="container-fluid">
      <!-- ERP KPIs -->
      <div class="row g-4 mb-4">
        <div
          class="col-xxl-3 col-lg-3 col-md-4 col-sm-6"
          v-for="(kpi, i) in kpis"
          :key="'kpi-' + i"
        >
          <div class="card h-100">
            <div class="card-body d-flex align-items-center">
              <div
                :class="['kpi-icon d-inline-flex align-items-center justify-content-center me-3', kpi.bg]"
              >
                <i :data-feather="kpi.icon" class="text-white"></i>
              </div>
              <div class="flex-grow-1">
                <small class="text-muted d-block">{{ kpi.label }}</small>
                <h4 class="mb-0">{{ kpi.value }}</h4>
                <small :class="['fw-semibold', kpi.delta >= 0 ? 'text-success' : 'text-danger']">
                  <i :class="kpi.delta >= 0 ? 'bx bx-up-arrow-alt' : 'bx bx-down-arrow-alt'"></i>
                  {{ Math.abs(kpi.delta) }}%
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Row: Revenue vs Expenses + Sales by Channel -->
      <div class="row">
        <div class="col-lg-8 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Revenue vs Expenses</h5>
              <small class="text-muted">Last 12 months</small>
            </div>
            <div class="card-body">
              <canvas ref="revExpChart" height="120"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Sales by Channel</h5>
              <small class="text-muted">This quarter</small>
            </div>
            <div class="card-body">
              <canvas ref="channelChart" height="220"></canvas>
              <div class="mt-3">
                <div
                  class="d-flex justify-content-between align-items-center py-1"
                  v-for="(c, idx) in salesByChannel"
                  :key="'channel-' + idx"
                >
                  <span class="d-flex align-items-center">
                    <span class="legend-dot rounded-circle me-2" :style="{ backgroundColor: palette[idx % palette.length] }"></span>
                    {{ c.name }}
                  </span>
                  <span class="fw-semibold">{{ asCurrency(c.value) }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Row: Recent Orders + Top Products -->
      <div class="row">
        <div class="col-lg-8 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Recent Orders</h5>
              <small class="text-muted">Last 10 orders</small>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th>Order #</th>
                      <th>Customer</th>
                      <th>Date</th>
                      <th>Total</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="o in recentOrders" :key="o.id">
                      <td class="fw-semibold">#{{ o.id }}</td>
                      <td>{{ o.customer }}</td>
                      <td>{{ o.date }}</td>
                      <td>{{ asCurrency(o.total) }}</td>
                      <td>
                        <span :class="['badge', statusClass(o.status)]">{{ o.status }}</span>
                      </td>
                    </tr>
                    <tr v-if="recentOrders.length === 0">
                      <td colspan="5" class="text-center text-muted py-4">No orders</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer text-end">
              <button class="btn btn-sm btn-outline-secondary">View all</button>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Top Products</h5>
              <small class="text-muted">By revenue</small>
            </div>
            <div class="card-body">
              <canvas ref="topProductsChart" height="220"></canvas>
              <ul class="list-unstyled mt-3 mb-0">
                <li
                  class="d-flex justify-content-between align-items-center py-1"
                  v-for="(p, idx) in topProducts"
                  :key="'prod-' + idx"
                >
                  <span class="text-truncate">{{ p.name }}</span>
                  <span class="fw-semibold">{{ asCurrency(p.revenue) }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Row: AR vs AP + Region Sales -->
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Accounts Receivable vs Payable</h5>
              <small class="text-muted">Last 6 months</small>
            </div>
            <div class="card-body">
              <canvas ref="arapChart" height="160"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Sales by Region</h5>
              <small class="text-muted">This year</small>
            </div>
            <div class="card-body">
              <canvas ref="regionChart" height="160"></canvas>
              <div class="mt-3 row g-2">
                <div class="col-6" v-for="(r, i) in salesByRegion" :key="'r-' + i">
                  <div class="d-flex justify-content-between align-items-center px-2 py-1 rounded border">
                    <span class="d-flex align-items-center">
                      <span class="legend-dot rounded-circle me-2" :style="{ backgroundColor: palette[i % palette.length] }"></span>
                      {{ r.name }}
                    </span>
                    <span class="fw-semibold">{{ asCurrency(r.value) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Row: Activity + Tasks -->
      <div class="row">
        <div class="col-lg-6 mb-4">
          <div class="card h-100">
            <div class="card-header">
              <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body">
              <ul class="timeline">
                <li v-for="(a, i) in activity" :key="'act-' + i" class="timeline-item">
                  <div class="timeline-point" :class="a.color"></div>
                  <div class="timeline-content">
                    <h6 class="mb-1">{{ a.title }}</h6>
                    <small class="text-muted d-block">{{ a.time }}</small>
                    <p class="mb-0">{{ a.desc }}</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Team Tasks</h5>
              <small class="text-muted">{{ openTasksCount }} open</small>
            </div>
            <div class="card-body">
              <ul class="list-group">
                <li
                  class="list-group-item d-flex align-items-center"
                  v-for="(t, i) in tasks"
                  :key="'task-' + i"
                >
                  <input class="form-check-input me-3" type="checkbox" v-model="t.done" />
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                      <span :class="{'text-decoration-line-through text-muted': t.done}">{{ t.title }}</span>
                      <span class="badge" :class="priorityClass(t.priority)">{{ t.priority }}</span>
                    </div>
                    <small class="text-muted">{{ t.assignee }} • Due {{ t.due }}</small>
                  </div>
                </li>
              </ul>
            </div>
            <div class="card-footer text-end">
              <button class="btn btn-sm btn-primary">Add task</button>
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

Chart.register(...registerables);

export default {
  components: { AppLayout },
  data() {
    return {
      // KPI cards (Purchase Orders removed)
      kpis: [
        { label: 'Total Revenue', value: 'Rs 482,190', delta: 12.5, icon: 'trending-up', bg: 'bg-primary' },
        { label: 'Expenses', value: 'Rs 309,420', delta: -3.2, icon: 'trending-down', bg: 'bg-danger' },
        { label: 'Net Profit', value: 'Rs 172,770', delta: 8.1, icon: 'pie-chart', bg: 'bg-success' },
        { label: 'Invoices Outstanding', value: 'Rs 61,400', delta: 2.4, icon: 'file-text', bg: 'bg-warning' },
        
      ],

      // Chart palettes
      palette: ['#6366F1', '#22C55E', '#F59E0B', '#EF4444', '#06B6D4', '#8B5CF6', '#10B981', '#F97316'],

      // Revenue vs Expenses
      months: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
      revenueSeries: [32000, 38000, 42000, 46000, 51000, 53000, 56000, 59000, 60000, 65000, 68000, 72000],
      expenseSeries: [22000, 26000, 28000, 31000, 34000, 35000, 36000, 39000, 41000, 43000, 45000, 48000],

      // Channel distribution
      salesByChannel: [
        { name: 'Online', value: 210000 },
        { name: 'Retail', value: 135000 },
        { name: 'Partners', value: 92000 },
        { name: 'Direct', value: 45000 },
      ],

      // Top products
      topProducts: [
        { name: 'Premium Care Plan', revenue: 82000 },
        { name: 'Wellness Kit', revenue: 64000 },
        { name: 'Consultation Package', revenue: 53000 },
        { name: 'Diagnostic Bundle', revenue: 42000 },
        { name: 'Supplement Pack', revenue: 35000 },
      ],

      // AR vs AP last 6 months
      months6: ['May','Jun','Jul','Aug','Sep','Oct'],
      arSeries: [38000, 36000, 42000, 40000, 45000, 47000],
      apSeries: [26000, 28000, 30000, 32000, 31000, 33000],

      // Region sales
      salesByRegion: [
        { name: 'North', value: 120000 },
        { name: 'South', value: 98000 },
        { name: 'East', value: 86000 },
        { name: 'West', value: 76000 },
        { name: 'Central', value: 54000 },
      ],

      // Activity timeline
      activity: [
        { title: 'Invoice INV-1042 paid', time: '2h ago', desc: 'Payment received via Stripe', color: 'point-success' },
        { title: 'New PO created', time: '5h ago', desc: 'PO-8871 created by Jane', color: 'point-info' },
        { title: 'Stock level low', time: '1d ago', desc: 'Supplement Pack below threshold', color: 'point-warning' },
        { title: 'Refund processed', time: '2d ago', desc: 'Order #4210 refunded', color: 'point-danger' },
      ],

      // Tasks array always initialized to avoid undefined in template
      tasks: [
        { title: 'Reconcile bank statement', assignee: 'Alex', due: 'Nov 30', priority: 'High', done: false },
        { title: 'Update price list', assignee: 'Sam', due: 'Dec 02', priority: 'Medium', done: false },
        { title: 'Review supplier contract', assignee: 'Priya', due: 'Dec 05', priority: 'Low', done: true },
        { title: 'Approve invoices', assignee: 'Jordan', due: 'Dec 01', priority: 'High', done: false },
      ],

      charts: {
        revExp: null,
        channel: null,
        topProducts: null,
        arap: null,
        region: null,
      },

      theme: this.isDark() ? 'dark' : 'light',
      observer: null,
    };
  },
  mounted() {
    if (window.feather) window.feather.replace();
    this.initCharts();

    this.observer = new MutationObserver(() => {
      const newTheme = this.isDark() ? 'dark' : 'light';
      if (newTheme !== this.theme) {
        this.theme = newTheme;
        this.updateChartThemes();
      }
    });
    this.observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
  },
  beforeUnmount() {
    this.destroyCharts();
    if (this.observer) this.observer.disconnect();
  },
  computed: {
    // Safely compute open tasks count; guards against tasks being null/undefined
    openTasksCount() {
      const list = Array.isArray(this.tasks) ? this.tasks : [];
      return list.filter(t => !t.done).length;
    },
    recentOrders() {
      return [
        { id: 1048, customer: 'Acme Corp', date: '2025-11-22', total: 5820, status: 'Paid' },
        { id: 1047, customer: 'HealthMax', date: '2025-11-22', total: 2180, status: 'Processing' },
        { id: 1046, customer: 'Wellbeing LLC', date: '2025-11-21', total: 7450, status: 'Pending' },
        { id: 1045, customer: 'ZenFit', date: '2025-11-21', total: 1290, status: 'Paid' },
        { id: 1044, customer: 'Care+ Partners', date: '2025-11-20', total: 3640, status: 'Overdue' },
        { id: 1043, customer: 'Lifeline', date: '2025-11-19', total: 4520, status: 'Paid' },
        { id: 1042, customer: 'OptiHealth', date: '2025-11-19', total: 2960, status: 'Pending' },
        { id: 1041, customer: 'WellCare', date: '2025-11-18', total: 1880, status: 'Processing' },
        { id: 1040, customer: 'GreenMed', date: '2025-11-18', total: 2190, status: 'Paid' },
        { id: 1039, customer: 'VitalWorks', date: '2025-11-17', total: 6990, status: 'Paid' },
      ];
    },
  },
  methods: {
    // Currency: display Sri Lankan Rupees with "Rs" prefix
    asCurrency(v) {
      const formatted = new Intl.NumberFormat(undefined, { style: 'currency', currency: 'LKR', maximumFractionDigits: 0 }).format(v);
      const digitsOnly = formatted.replace(/[^\d,.\s]/g, '').trim();
      return `Rs ${digitsOnly}`;
    },
    statusClass(s) {
      return {
        Paid: 'bg-success',
        Pending: 'bg-warning',
        Overdue: 'bg-danger',
        Processing: 'bg-info',
      }[s] || 'bg-secondary';
    },
    priorityClass(p) {
      return {
        High: 'bg-danger',
        Medium: 'bg-warning',
        Low: 'bg-secondary',
      }[p] || 'bg-secondary';
    },
    isDark() {
      return document.documentElement.classList.contains('theme-dark');
    },
    themeColors() {
      const dark = this.isDark();
      return {
        text: dark ? '#cbd5e1' : '#334155',
        grid: dark ? '#1f2937' : '#e5e7eb',
        border: dark ? '#374151' : '#e5e7eb',
        tooltipBg: dark ? 'rgba(17,24,39,0.95)' : 'rgba(255,255,255,0.95)',
        tooltipColor: dark ? '#e5e7eb' : '#111827',
      };
    },

    initCharts() {
      const c = this.themeColors();
      const ctxRevExp = this.$refs.revExpChart.getContext('2d');
      const ctxChannel = this.$refs.channelChart.getContext('2d');
      const ctxTop = this.$refs.topProductsChart.getContext('2d');
      const ctxARAP = this.$refs.arapChart.getContext('2d');
      const ctxRegion = this.$refs.regionChart.getContext('2d');

      this.charts.revExp = new Chart(ctxRevExp, {
        type: 'line',
        data: {
          labels: this.months,
          datasets: [
            {
              label: 'Revenue',
              data: this.revenueSeries,
              borderColor: this.palette[0],
              backgroundColor: this.hexToRgba(this.palette[0], 0.15),
              borderWidth: 2,
              tension: 0.35,
              fill: true,
            },
            {
              label: 'Expenses',
              data: this.expenseSeries,
              borderColor: this.palette[3],
              backgroundColor: this.hexToRgba(this.palette[3], 0.10),
              borderWidth: 2,
              tension: 0.35,
              fill: true,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: { labels: { color: c.text } },
            tooltip: {
              backgroundColor: c.tooltipBg,
              titleColor: c.tooltipColor,
              bodyColor: c.tooltipColor,
              borderColor: c.border,
              borderWidth: 1,
            },
          },
          scales: {
            x: { grid: { color: c.grid }, ticks: { color: c.text } },
            y: { grid: { color: c.grid }, ticks: { color: c.text }, beginAtZero: true },
          },
        },
      });

      this.charts.channel = new Chart(ctxChannel, {
        type: 'doughnut',
        data: {
          labels: this.salesByChannel.map(s => s.name),
          datasets: [
            {
              data: this.salesByChannel.map(s => s.value),
              backgroundColor: this.salesByChannel.map((_, i) => this.palette[i % this.palette.length]),
              borderColor: c.border,
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: c.tooltipBg,
              titleColor: c.tooltipColor,
              bodyColor: c.tooltipColor,
              borderColor: c.border,
              borderWidth: 1,
              callbacks: {
                label: ctx => `${ctx.label}: ${this.asCurrency(ctx.parsed)}`,
              },
            },
          },
          cutout: '60%',
        },
      });

      this.charts.topProducts = new Chart(ctxTop, {
        type: 'bar',
        data: {
          labels: this.topProducts.map(p => p.name),
          datasets: [
            {
              label: 'Revenue',
              data: this.topProducts.map(p => p.revenue),
              backgroundColor: this.hexToRgba(this.palette[1], 0.7),
              borderColor: this.palette[1],
              borderWidth: 1,
              borderRadius: 6,
            },
          ],
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          plugins: {
            legend: { display: false },
            tooltip: {
              backgroundColor: c.tooltipBg,
              titleColor: c.tooltipColor,
              bodyColor: c.tooltipColor,
              borderColor: c.border,
              borderWidth: 1,
              callbacks: {
                label: ctx => `${this.asCurrency(ctx.parsed.x)}`,
              },
            },
          },
          scales: {
            x: { grid: { color: c.grid }, ticks: { color: c.text }, beginAtZero: true },
            y: { grid: { display: false }, ticks: { color: c.text } },
          },
        },
      });

      this.charts.arap = new Chart(ctxARAP, {
        type: 'bar',
        data: {
          labels: this.months6,
          datasets: [
            { label: 'A/R', data: this.arSeries, backgroundColor: this.hexToRgba(this.palette[5], 0.8), borderRadius: 4 },
            { label: 'A/P', data: this.apSeries, backgroundColor: this.hexToRgba(this.palette[4], 0.8), borderRadius: 4 },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: { labels: { color: c.text } },
            tooltip: {
              backgroundColor: c.tooltipBg,
              titleColor: c.tooltipColor,
              bodyColor: c.tooltipColor,
              borderColor: c.border,
              borderWidth: 1,
              callbacks: {
                label: ctx => `${ctx.dataset.label}: ${this.asCurrency(ctx.parsed.y)}`,
              },
            },
          },
          scales: {
            x: { stacked: true, grid: { color: c.grid }, ticks: { color: c.text } },
            y: { stacked: true, grid: { color: c.grid }, ticks: { color: c.text }, beginAtZero: true },
          },
        },
      });

      this.charts.region = new Chart(ctxRegion, {
        type: 'polarArea',
        data: {
          labels: this.salesByRegion.map(r => r.name),
          datasets: [
            {
              data: this.salesByRegion.map(r => r.value),
              backgroundColor: this.salesByRegion.map((_, i) => this.hexToRgba(this.palette[i % this.palette.length], 0.8)),
              borderColor: c.border,
              borderWidth: 1,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: { labels: { color: c.text } },
            tooltip: {
              backgroundColor: c.tooltipBg,
              titleColor: c.tooltipColor,
              bodyColor: c.tooltipColor,
              borderColor: c.border,
              borderWidth: 1,
              callbacks: {
                label: ctx => `${ctx.label}: ${this.asCurrency(ctx.parsed)}`,
              },
            },
          },
          scales: {
            r: {
              grid: { color: c.grid },
              angleLines: { color: c.grid },
              pointLabels: { color: c.text },
              ticks: { color: c.text },
            },
          },
        },
      });
    },

    updateChartThemes() {
      const c = this.themeColors();
      const updateScales = (chart, axes = ['x', 'y']) => {
        if (!chart?.options?.scales) return;
        axes.forEach(ax => {
          if (chart.options.scales[ax]) {
            if (chart.options.scales[ax].grid) chart.options.scales[ax].grid.color = c.grid;
            if (chart.options.scales[ax].ticks) chart.options.scales[ax].ticks.color = c.text;
          }
        });
      };
      const updateTooltipLegend = (chart) => {
        if (chart.options.plugins?.legend?.labels) chart.options.plugins.legend.labels.color = c.text;
        if (chart.options.plugins?.tooltip) {
          chart.options.plugins.tooltip.backgroundColor = c.tooltipBg;
          chart.options.plugins.tooltip.titleColor = c.tooltipColor;
          chart.options.plugins.tooltip.bodyColor = c.tooltipColor;
          chart.options.plugins.tooltip.borderColor = c.border;
        }
      };

      const { revExp, channel, topProducts, arap, region } = this.charts;

      [revExp, topProducts, arap].forEach(ch => {
        if (!ch) return;
        updateScales(ch);
        updateTooltipLegend(ch);
        ch.update();
      });

      if (channel) {
        updateTooltipLegend(channel);
        channel.update();
      }

      if (region) {
        if (region.options.scales?.r) {
          region.options.scales.r.grid.color = c.grid;
          region.options.scales.r.angleLines.color = c.grid;
          region.options.scales.r.pointLabels.color = c.text;
          region.options.scales.r.ticks.color = c.text;
        }
        updateTooltipLegend(region);
        region.update();
      }
    },

    destroyCharts() {
      Object.keys(this.charts).forEach(k => {
        if (this.charts[k]) {
          this.charts[k].destroy();
          this.charts[k] = null;
        }
      });
    },

    hexToRgba(hex, alpha = 1) {
      const h = hex.replace('#', '');
      const bigint = parseInt(h, 16);
      const r = (bigint >> 16) & 255;
      const g = (bigint >> 8) & 255;
      const b = bigint & 255;
      return `rgba(${r}, ${g}, ${b}, ${alpha})`;
    },
  },
};
</script>

<style scoped>
/* Ensure icon container is a perfect circle */
.kpi-icon {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  flex: 0 0 48px; /* prevent stretching/shrinking */
}

/* Feather icon size inside circle */
.kpi-icon i {
  width: 22px;
  height: 22px;
}

/* Utility backgrounds (Bootstrap palette assumed) */
.bg-primary { background-color: #6366F1 !important; }
.bg-danger  { background-color: #EF4444 !important; }
.bg-success { background-color: #22C55E !important; }
.bg-warning { background-color: #F59E0B !important; }
.bg-dark    { background-color: #111827 !important; }
.bg-info    { background-color: #06B6D4 !important; }

.legend-dot {
  width: 10px;
  height: 10px;
  display: inline-block;
}

.timeline {
  list-style: none;
  margin: 0;
  padding: 0;
  position: relative;
}
.timeline::before {
  content: '';
  position: absolute;
  left: 10px;
  top: 0;
  bottom: 0;
  width: 2px;
  background: var(--timeline-line, #e5e7eb);
}
html.theme-dark .timeline::before {
  --timeline-line: #1f2937;
}
.timeline-item {
  position: relative;
  padding-left: 32px;
  margin-bottom: 16px;
}
.timeline-point {
  position: absolute;
  left: 3px;
  top: 4px;
  width: 14px;
  height: 14px;
  border-radius: 50%;
}
.point-success { background-color: #22C55E; }
.point-info    { background-color: #06B6D4; }
.point-warning { background-color: #F59E0B; }
.point-danger  { background-color: #EF4444; }
</style>