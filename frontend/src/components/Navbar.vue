<template>
  <nav class="navbar desktop">
    <div class="left">
      <h1>
        <router-link to="/">
          <span class="text-primary">After</span
          ><span class="text-white">Burn</span>
        </router-link>
      </h1>
    </div>
    <div class="right">
      <ul class="nav-links">
        <li class="link">
          <router-link to="/">Home</router-link>
        </li>
        <li class="link">
          <router-link to="/workout">Workout</router-link>
        </li>
        <li class="link">
          <router-link to="/diet">Diet</router-link>
        </li>
        <li class="link">
          <router-link to="/about">About</router-link>
        </li>
      </ul>
    </div>
  </nav>
  <nav class="navbar mobile">
    <div class="left">
      <h1>
        <router-link to="/">
          <span class="text-primary">After</span
          ><span class="text-white">Burn</span>
        </router-link>
      </h1>
    </div>
    <div class="right">
      <button class="btn" @click="toggleMenu">
        <svg class="menu-icon" viewBox="0 0 24 24" width="24" height="24">
          <rect x="3" y="5" width="18" height="2" rx="1" fill="currentColor" />
          <rect x="3" y="11" width="18" height="2" rx="1" fill="currentColor" />
          <rect x="3" y="17" width="18" height="2" rx="1" fill="currentColor" />
        </svg>
      </button>
    </div>
  </nav>
  <div class="nav-menu" id="menu">
      <ul class="nav-links">
        <button class="btn btn-cross" @click="toggleMenu">
          <svg
            data-v-933e9cdf=""
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="24"
            height="24"
          >
            <line
              data-v-933e9cdf=""
              x1="6"
              y1="6"
              x2="18"
              y2="18"
              stroke="currentColor"
              stroke-width="2.5"
              stroke-linecap="round"
            ></line>
            <line
              data-v-933e9cdf=""
              x1="18"
              y1="6"
              x2="6"
              y2="18"
              stroke="currentColor"
              stroke-width="2.5"
              stroke-linecap="round"
            ></line>
          </svg>
        </button>
      <li class="link">
        <router-link to="/" @click="toggleMenu">Home</router-link>
      </li>
      <li class="link">
        <router-link to="/workout" @click="toggleMenu">Workout</router-link>
      </li>
      <li class="link">
        <router-link to="/diet" @click="toggleMenu">Diet</router-link>
      </li>
      <li class="link">
        <router-link to="/about" @click="toggleMenu">About</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "NavbarComponent",
  methods:{
    toggleMenu(){
        const menu = document.getElementById('menu');
        if(menu.style.display == 'none'){
            menu.style.display = 'block';
        }else{
            menu.style.display = 'none';
        }
    }
  }
};
</script>

<style scoped>
.desktop {
  display: flex;
  justify-content: space-around;
  align-items: center;
}
ul {
  list-style: none;
}
.nav-links {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
  font-size: 1.25rem;
}
.mobile {
  display: none;
  justify-content: space-between;
  align-items: center;
  padding: 8px 32px;
}
.btn {
  background-color: transparent;
  padding: 0;
  margin: 0;
}
.nav-menu{
    display: none;
}
.nav-menu .nav-links {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  flex-direction: column;
  align-items: start;
  padding: 56px 24px;
  width: 100%;
  height: 100vh;
  justify-content: start;
  overflow-y: hidden;
  z-index: 100000;
  transition: all 0.4s ease;
}
.btn-cross{
    position: absolute;
    right: 16px;
    top: 16px;
    z-index: 10;
}
@media screen and (max-width: 550px) {
  .mobile {
    display: flex;
  }
  .desktop {
    display: none;
  }
  .nav-menu .nav-links{
    display: flex;
  }
}
</style>
