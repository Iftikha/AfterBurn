<template>
    <div class="logout-btn-div">
        <button class="btn btn-primary logout-btn" @click="logout">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <line x1="6" y1="6" x2="18" y2="18" 
                    stroke="currentColor" 
                    stroke-width="2.5"
                    stroke-linecap="round"/>
            <line x1="18" y1="6" x2="6" y2="18" 
                    stroke="currentColor" 
                    stroke-width="2.5"
                    stroke-linecap="round"/>
            </svg>
        </button>
    </div>
  <!-- Loader -->

  <div v-if="isLoading" class="loader-container">
    <div class="loader">
      <div class="dots-container">
        <div class="dots">
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
          <span class="dot"></span>
        </div>
        <span class="text">Please wait...</span>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="hero">
        <h1 class="large-heading">
            Welcome, <span class="text-primary">{{ user.name }}</span>!
        </h1>
    </div>
    <h2>Stats</h2>
    <div class="card-container">
        <Card :amount="user.age" heading="Age" />
        <Card :amount="user.weight" heading="Weight" />
        <Card :amount="user.targetweight" heading="Target Weight" />
        <Card :amount="user.height" heading="Height" />
        <Card :amount="user.timeCommitment" heading="Totoal Weeks" />
    </div>
    <div class="card-container-long">
        <LongCard heading="Goal" :description="formatData(user.goal)" />
        <LongCard heading="Difficulty Level" :description="formatData(user.difficultyLevel)" />
        <LongCard heading="Description" :description="formatData(user.description)" />
        <LongCard heading="Workout Type" :description="formatData(user.workoutType)" />
        <LongCard heading="Current Fitness Level" :description="formatData(user.fitnessLevelCurrent)" />
        <LongCard heading="Budget" :description="formatData(user.budget)" />
    </div>
  </div>
</template>

<script>
import axios, { AxiosHeaders } from 'axios';
import Card from '../components/Card.vue';
import LongCard from '../components/LongCard.vue';

export default {
  name: "HomePage",
  components: {
    Card,
    LongCard
  },
  data(){
    return {
        isLoading: false,
        user : {},
    }
  },
  created(){
    this.getUserData();
  },
  methods:{
    formatData(Value) {
        if (!Value) return '';
  
        // Convert hyphens to spaces and capitalize each word
        return Value
        .split('-')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
        .join(' ');
    },
    getUserData(){
        this.isLoading = true;
        const token = localStorage.getItem('Token');
        if(!token){
            this.$router.push('/login');
            this.isLoading = false;
        }
        axios.get('http://localhost:8000/api/v1/user', {
            withCredentials: true,
            headers: {
                'Token': token
            }
        })
        .then(res => {
            this.user = res.data.user;
            this.isLoading = false;
        })
        .catch(err => {
            this.$router.push('/login');
            this.isLoading = false;
        })
    },
    logout(){
        localStorage.clear('Token');
        this.$router.push('/login');
    }
  }
};
</script>

<style scoped>
.card-container{
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
    margin: 40px 24px;
}
.card-container-long{
    margin: 40px 24px;
}
h2{
    text-align: center;
    margin: 24px;
}
.hero{
    height: 30vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.large-heading{
    font-size: 4rem;
    text-align: center;
}
.logout-btn{
    border-radius: 50%;
    padding: 8px;
    width: 40px;
    height: 40px;
}
.logout-btn-div{
    position: fixed;
    right: 8px;
    bottom: 8px;
}
@media screen and (max-width: 768px) {
    .large-heading{
        font-size: 3rem;
    }
    .card-container{
        margin: 40px 16px;
    }
}
@media screen and (max-width: 550px) {
    .large-heading{
        font-size: 2.5rem;
    }
}
</style>
