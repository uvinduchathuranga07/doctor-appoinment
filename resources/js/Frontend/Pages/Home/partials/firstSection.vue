<template>
  <div class="counter-section">
    <div class="counter-item">
      <div class="counter-number" data-count="80">0+</div>
      <div class="counter-label">Markets</div>
      <div class="counter-underline"></div>
    </div>

    <div class="counter-item">
      <div class="counter-number" data-count="200">0+</div>
      <div class="counter-label">Units Sold</div>
      <div class="counter-underline"></div>
    </div>

    <div class="counter-item">
      <div class="counter-number" data-count="35">0+</div>
      <div class="counter-label">Years in Business</div>
      <div class="counter-underline"></div>
    </div>
  </div>
</template>
 
 <script>
export default {
  mounted() {
    this.initCounterAnimation();
  },
  methods: {
    initCounterAnimation() {
      const counters = document.querySelectorAll(".counter-number");
      const speed = 20; // Animation speed - lower is faster

      counters.forEach(counter => {
        const target = parseInt(counter.getAttribute("data-count"));
        const formatter = new Intl.NumberFormat("en-US");
        let count = 0;

        // Handle special case for large numbers
        const increment = target > 1000 ? Math.ceil(target / (speed / 10)) : 1;

        const updateCount = () => {
          count += increment;

          // Make sure we don't exceed the target
          if (count < target) {
            if (target === 200000) {
              counter.innerText = formatter.format(count) + "+";
            } else {
              counter.innerText = count + "+";
            }

            setTimeout(updateCount, 1);
          } else {
            if (target === 200000) {
              counter.innerText = formatter.format(target) + "+";
            } else {
              counter.innerText = target + "+";
            }
          }
        };

        // Start the animation
        updateCount();
      });

      // Trigger animation when section is in view
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            // Animation already triggered by mounted
            observer.unobserve(entry.target);
          }
        });
      });

      observer.observe(document.querySelector(".counter-section"));
    }
  }
};
</script>
 
 <style scoped>
</style>
 