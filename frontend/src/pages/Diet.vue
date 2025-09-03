<template>
  <div class="logout-btn-div">
    <button class="btn btn-primary logout-btn" @click="logout">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        width="24"
        height="24"
      >
        <line
          x1="6"
          y1="6"
          x2="18"
          y2="18"
          stroke="currentColor"
          stroke-width="2.5"
          stroke-linecap="round"
        />
        <line
          x1="18"
          y1="6"
          x2="6"
          y2="18"
          stroke="currentColor"
          stroke-width="2.5"
          stroke-linecap="round"
        />
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
    <h1><span class="text-primary">Diet</span> Routine</h1>
    </div>
    <div class="workout" v-if="workout_exists && workoutData">
      <div class="day1">
        <h1>
          Day 1
        </h1>
        <div class="exercises">
          <div
            class="container-wokrout"
          >
          <LongCard heading="Breakfast" :description="workoutData.day1.breakfast" />
          <LongCard heading="Lunch" :description="workoutData.day1.lunch" />
          <LongCard heading="Dinner" :description="workoutData.day1.dinner" />
          </div>
        </div>
      </div>


      <div class="day2">
        <h1>
          Day 2
        </h1>
        <div class="exercises">
          <div
            class="container-wokrout"
          >
          <LongCard heading="Breakfast" :description="workoutData.day2.breakfast" />
          <LongCard heading="Lunch" :description="workoutData.day2.lunch" />
          <LongCard heading="Dinner" :description="workoutData.day2.dinner" />
          </div>
        </div>
      </div>

      <div class="day3">
        <h1>
          Day 3
        </h1>
        <div class="exercises">
          <div
            class="container-wokrout"
          >
          <LongCard heading="Breakfast" :description="workoutData.day3.breakfast" />
          <LongCard heading="Lunch" :description="workoutData.day3.lunch" />
          <LongCard heading="Dinner" :description="workoutData.day3.dinner" />
          </div>
        </div>
      </div>


      <div class="day4">
        <h1>
          Day 4
        </h1>
        <div class="exercises">
          <LongCard heading="Breakfast" :description="workoutData.day4.breakfast" />
          <LongCard heading="Lunch" :description="workoutData.day4.lunch" />
          <LongCard heading="Dinner" :description="workoutData.day4.dinner" />
        </div>
      </div>




    </div>
</template>
<script>
import axios from "axios";
import Card from "../components/Card.vue";
import LongCard from "../components/LongCard.vue";
import WorkoutCard from "../components/WorkoutCard.vue";
export default {
  name: "WorkoutPage",
  data() {
    return {
      workout: {},
      workoutData: {},
      isLoading: false,
      workout_exists: true,
    };
  },
  components: {
    Card,
    LongCard,
    WorkoutCard,
  },
  async created() {
    await this.loadWorkout();
  },
  methods: {
    formatData(Value) {
      if (!Value) return "";

      // Convert hyphens to spaces and capitalize each word
      return Value.split("-")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
    },
    async loadWorkout() {
      const token = localStorage.getItem("Token");
      this.isLoading = true;
      if (!token) {
        this.$router.push("/login");
        return;
      }
      try {
        const res = await axios.get("http://localhost:8000/api/v1/diet", {
          withCredentials: true,
          headers: {
            Token: token,
          },
        });

        console.log(res);

        this.workout = res.data;
        this.workout_exists = true;

        if (this.workout) {
          this.workoutData = JSON.parse(this.workout.diet);
          this.workoutData = JSON.parse(this.workoutData);
        }
      } catch (err) {
        console.log(err);
        if (err.response && err.response.status === 404) {
          this.workout_exists = false;
          this.$router.push('/workout');
        }
      } finally {
        this.isLoading = false;
      }
    },
    logout() {
      localStorage.clear("Token");
      this.$router.push("/login");
    },
  },
};
</script>
<style scoped>
.logout-btn {
  border-radius: 50%;
  padding: 8px;
  width: 40px;
  height: 40px;
}
.logout-btn-div {
  position: fixed;
  right: 8px;
  bottom: 8px;
}
.card-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 24px;
  padding: 24px;
}
.exercises {
  padding: 24px;
  width: 100%;
  flex-wrap: wrap;
}
.workout h1{
  text-align: center;
}
.day1, .day2, .day3, .day4{
  width: 100%;
}
</style>
