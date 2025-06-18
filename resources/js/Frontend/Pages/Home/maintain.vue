<template>
  <div class="coming-soon dark">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">

        <img src="/images/nexus-logo.png" alt="Company Logo" class="logo" />
      </div>
      <div class="col-12">

        <h1>We're Coming Soon</h1>
        <p>Our website is under construction. Stay tuned!</p>
      </div>
      <div class="col-12">
        <div v-if="showCountdown" class="countdown">
          <div v-for="(value, key) in countdown" :key="key" class="time-box">
            <span class="value">{{ value }}</span>
            <span class="label">{{ key }}</span>
          </div>
        </div>
      </div>


      <!-- <button class="toggle-mode" @click="darkMode = !darkMode">Toggle Mode</button> -->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      darkMode: true,
      email: "",
      showCountdown: true,
      countdown: { days: 0, hours: 0, minutes: 0, seconds: 0 },
      launchDate: new Date(new Date().getTime() + 7 * 24 * 60 * 60 * 1000) // 7 days from now
    };
  },
  mounted() {
    this.updateCountdown();
    setInterval(this.updateCountdown, 1000);
  },
  methods: {
    updateCountdown() {
      const now = new Date().getTime();
      const distance = this.launchDate - now;
      if (distance < 0) {
        this.showCountdown = false;
        return;
      }
      this.countdown = {
        days: Math.floor(distance / (1000 * 60 * 60 * 24)),
        hours: Math.floor(
          (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        ),
        minutes: Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
        seconds: Math.floor((distance % (1000 * 60)) / 1000)
      };
    },
    subscribe() {
      alert(`Thanks for subscribing, ${this.email}!`);
      this.email = "";
    }
  }
};
</script>

<style scoped>
.coming-soon {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  text-align: center;
  transition: background 0.3s;
}

.light {
  background: #f5f5f5;
  color: #333;
}

.dark {
  background: #222;
  color: #fff;
}

.content {
  max-width: 500px;
}

.logo {
  max-width: 150px;
  margin-bottom: 20px;
}

.countdown {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin: 20px 0;
}

.time-box {
  display: flex;
  flex-direction: column;
  align-items: center;
  background: rgba(0, 0, 0, 0.1);
  padding: 10px;
  border-radius: 5px;
}

.value {
  font-size: 24px;
  font-weight: bold;
}

.label {
  font-size: 12px;
}

.subscribe {
  margin-top: 20px;
}

input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-right: 10px;
}

button {
  padding: 10px;
  background: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.toggle-mode {
  margin-top: 20px;
  background: #333;
}
</style>