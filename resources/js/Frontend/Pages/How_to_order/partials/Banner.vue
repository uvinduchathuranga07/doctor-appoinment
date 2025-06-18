<template>
    <div class="carousel slide">
          <div class="carousel-inner">
              <div class="carousel-item d-block custom_slide_height">
                  <img src="https://img.freepik.com/free-photo/row-new-cars-port_335224-806.jpg?t=st=1727426503~exp=1727430103~hmac=1a12ca6dca198d5494d3e089325729d9fca166325b642a5d909711e5d3f8f25c&w=1380"
                      class="d-block w-100 swiperImg custom_slide_height" alt="...">
                  <div class="carousel-caption custom_caption_position" style="top: 40%;">
                      <div class="caption">
                          <div class="p-4">
                              <h1 class="main-topic-banner" style="font-size:3.5rem; font-weight:700">HOW TO ORDER</h1>
                              <h5 style="font-weight:600">NIKOBA.COM</h5>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </template>
  
  <script>
  export default {
  
  }
  </script>
  
  <style scoped>
  .custom_slide_height{
    height: 47vh !important;
  }
  
  @media (max-width: 768px){
      .main-topic-banner{
          font-size: 2rem !important;
      }
      .custom_caption_position{
          top: 25% !important;
      }
  }
  </style>