<template>
  <!-- Menu -->

  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo justify-content-center">
      <a href="/admin" class="app-brand-link" style="justify-content: center">
        <span class="app-brand-logo demo" style="justify-content: center">
          <img :src="$page.props.app_logo ? $page.props.app_logo : '/assets/images/jpnauto3.png'" alt="" style="height: 100px; width: auto" />
        </span>
        <span class="app-brand-text demo menu-text fw-bolder ms-2"></span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
 <li class="menu-item" :class="{ active: addActiveClass(['dashboard']) }">
        <Link :href="route('dashboard')" class="menu-link">
          <i class="menu-icon tf-icons bx bx-tachometer"></i>
          <div data-i18n="Dashboard">Dashboard</div>
        </Link>
      </li>

      <!-- Inquiry -->
      <li class="menu-item" :class="{ active: addActiveClass(['inquiry.index', 'inquiry.getdata', 'inquiry.edit']) }"
          v-if="$root.hasPermission('inquiry.view')">
        <Link :href="route('inquiry.index')" class="menu-link">
          <i class="menu-icon tf-icons bx bx-question-mark"></i>
          <div data-i18n="Inquiry">Inquiry</div>
        </Link>
      </li>

      <!-- Doctors -->
      <li class="menu-item" :class="{ active: addActiveClass(['doctor.index','doctor.create','doctor.edit','doctor.getdata']) }"
          v-if="$root.hasPermission('doctor.view')">
        <Link :href="route('doctor.index')" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user-pin"></i>
          <div data-i18n="Doctors">Doctors</div>
        </Link>
      </li>

      <!-- Doctor Schedules -->
      <li class="menu-item" :class="{ active: addActiveClass(['doctor-schedule.index','doctor-schedule.create','doctor-schedule.edit','doctor-schedule.getdata']) }"
          v-if="$root.hasPermission('doctorshedule.view')">
        <Link :href="route('doctor-schedule.index')" class="menu-link">
          <i class="menu-icon tf-icons bx bx-calendar"></i>
          <div data-i18n="Doctor Schedules">Doctor Schedules</div>
        </Link>
      </li>

      <!-- Prescriptions -->
      <li class="menu-item"
          v-if="$root.hasPermission('prescription.view') && $page.props.scheduleId"
          :class="{ active: addActiveClass(['prescription.index','prescription.getdata','prescription.create','prescription.edit']) }">
        <Link :href="route('prescription.index', $page.props.scheduleId)" class="menu-link">
          <i class="menu-icon tf-icons bx bx-notepad"></i>
          <div data-i18n="Prescriptions">Prescriptions</div>
        </Link>
      </li>

      <!-- Customer (existing) -->
      <li class="menu-item" :class="{ active: addActiveClass(['customer.index','customer.create','customer.edit']) }"
          v-if="$root.hasPermission('customer.view') && !$page.props.branch">
        <Link :href="route('customer.index', { c: 'default' })" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Customer">Customer</div>
        </Link>
      </li>
  <li class="menu-item" :class="{ active: addActiveClass(['customer.index','customer.create','customer.edit']) }"
          v-if="$root.hasPermission('customer.view') && !$page.props.branch">
        <Link :href="route('customer.index', { c: 'default' })" class="menu-link">
          <i class="menu-icon tf-icons bx bx-book"></i>
          <div data-i18n="Customer">Reports</div>
        </Link>
      </li>
      

      <li class="menu-item" :class="{ active: addActiveClass(['customer.index','customer.create','customer.edit']) }"
          v-if="$root.hasPermission('customer.view') && !$page.props.branch">
        <Link :href="route('customer.index', { c: 'default' })" class="menu-link">
          <i class="menu-icon tf-icons bx bx-building"></i>
          <div data-i18n="Customer">Pharmacy</div>
        </Link>
      </li>
      <!-- Dashboards -->
      <!-- <li class="menu-item" v-bind:class="{ active: addActiveClass(['dashboard']) }">
        <Link :href="route('dashboard')" class="menu-link">
        <i class="menu-icon tf-icons bx bx-tachometer"></i>
        <div data-i18n="Dashboards">Dashboard</div>
        </Link>
      </li> -->
      <!-- Inquiry -->
     
      <!-- Media Library -->
      <!-- <li class="menu-item" v-bind:class="{ active: addActiveClass(['media.index']) }"
        v-if="$root.hasPermission('media.view') && !$page.props.branch">
        <Link :href="route('media.index', { c: 'default' })" class="menu-link">
        <i class="menu-icon tf-icons bx bx-photo-album"></i>
        <div data-i18n="Medai Library">Medai Library</div>
        </Link>
      </li> -->

    
         
          
         
    

        
        

      <!-- Customer-->
      <!-- <li class="menu-item" v-bind:class="{
        active: addActiveClass([
          'customer.index',
          'customer.create',
          'customer.edit'
        ])
      }" v-if="$root.hasPermission('customer.view') && !$page.props.branch">
        <Link :href="route('customer.index', { c: 'default' })" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>

        <div data-i18n="Customer">Customer</div>
        </Link>
      </li> -->
      <!-- Affiliate Config-->
      <!-- <li class="menu-item" v-bind:class="{
        active: addActiveClass([
          'settings.affiliate-pages',
        ])
      }" v-if="$root.hasPermission('system-setting.view') && !$page.props.branch">
        <Link :href="route('settings.affiliate-pages')" class="menu-link">
        <i class="menu-icon tf-icons bx bx-network-chart"></i>

        <div data-i18n="Affiliate Config">Affiliate Config</div>
        </Link>
      </li> -->
      <!-- Settings -->
      <li class="menu-item" v-bind:class="{
        'active open': addActiveClass([
          'settings.users',
          'settings.users.create',
          'settings.users.edit',
          'settings.roles',
          'settings.roles.create',
          'settings.roles.edit',
          'settings.roles.permissions',
          'settings.general',
          'settings.social-auth',
          'settings.mail',
          'payment-options.index',
          'currencies.index',
          'log.index',
        ]),
      }" v-if="!$page.props.branch && hasAnyPermission([
        'backend-user.view',
        'roles-permissions.view',
        'system-setting.view',
        'currencies.view'
      ])">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cog"></i>
          <div data-i18n="Settings">Settings</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item" v-bind:class="{
            active: addActiveClass([
              'settings.users',
              'settings.users.create',
              'settings.users.edit',
            ]),
          }" v-if="$root.hasPermission('backend-user.view')">
            <Link :href="route('settings.users')" class="menu-link">
            <div data-i18n="Backend Users">Backend Users</div>
            </Link>
          </li>
          <li class="menu-item" v-bind:class="{
            active: addActiveClass([
              'settings.roles',
              'settings.roles.create',
              'settings.roles.edit',
              'settings.roles.permissions',
            ]),
          }" v-if="$root.hasPermission('roles-permissions.view')">
            <Link :href="route('settings.roles')" class="menu-link">
            <div data-i18n="Roles & Permissions">Roles & Permissions</div>
            </Link>
          </li>
          <li class="menu-item" v-bind:class="{
            active: addActiveClass(['settings.general']),
          }" v-if="$root.hasPermission('system-setting.view')">
            <Link :href="route('settings.general')" class="menu-link">
            <div data-i18n="General Settings">General Settings</div>
            </Link>
          </li>
          <li class="menu-item" v-bind:class="{
            active: addActiveClass(['settings.social-auth']),
          }" v-if="$root.hasPermission('system-setting.view')">
            <Link :href="route('settings.social-auth')" class="menu-link">
            <div data-i18n="Social Auth Settings">Social Auth Settings</div>
            </Link>
          </li>
          <li class="menu-item" v-bind:class="{
            active: addActiveClass(['currencies.index']),
          }" v-if="$root.hasPermission('currencies.view')">
            <Link :href="route('currencies.index')" class="menu-link">
            <div data-i18n="Currencies">Currencies</div>
            </Link>
          </li>
          <li class="menu-item" v-bind:class="{
            active: addActiveClass(['settings.mail']),
          }" v-if="$root.hasPermission('system-setting.view')">
            <Link :href="route('settings.mail')" class="menu-link">
            <div data-i18n="Mail Settings">Mail Settings</div>
            </Link>
          </li>
        </ul>
      </li>



      <!-- Offers -->
    </ul>
  </aside>
  <!-- / Menu -->
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
  components: {
    Link,
  },
  data() {
    return {
      showingNavigationDropdown: false,
      expanded: true,
      collapsed: false,
      hidden: true,
      currentRoute: "",
    };
  },
  mounted() {
    new PerfectScrollbar(".menu-inner", {
      wheelPropagation: false,
      wheelSpeed: 0.5,
    });
  },
  methods: {
    addActiveClass(routes) {
      if (routes.includes(route().current())) {
        return true;
      } else {
        return false;
      }
    },
    hasAnyPermission(permissions) {
    return permissions.some(permission => this.$root.hasPermission(permission));
  }
  },
};
</script>

<style>
.rotate {
  transform: rotate(90deg);
}

.main-menu-content {
  max-height: 100vh;
  overflow-y: scroll;
  overflow-x: hidden;
}
</style>
