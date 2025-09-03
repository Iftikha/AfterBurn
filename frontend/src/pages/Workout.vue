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
    <h1><span class="text-primary">Workout</span> Routine</h1>
    <div class="genWorkoutSection" v-if="!workout_exists">
      <button class="btn btn-primary" @click="generateWorkout">
        Generate Workout
      </button>
    </div>
    <!-- <div class="card-container-long" v-if="workout_exists">
      <div class="card-container">
        <Card heading="Intensity" :amount="formatData(workout.intesity)" />
        <Card
          heading="Total Weeks"
          :amount="formatData(workout.timeCommitment)"
        />
      </div> -->
    <!-- </div> -->
    <div class="workout" v-if="workout_exists && workoutData">
      <div class="day1">
        <h1>
          Day 1
          <span class="text-primary">{{
            workoutData.day1.focus
          }}</span>
        </h1>
        <div class="exercises">
          <div
            class="container-wokrout"
            v-for="(exercise, index) in workoutData.day1.exercises"
            :key="index"
          >
            <WorkoutCard
              :workout_id="workout.id"
              :user_id="workout.user_id"
              :week="currentWeek"
              :day="currentDay"
              :exercise-name="exercise"
            />
          </div>
        </div>
      </div>



      <div class="day2">
        <h1>
          Day 2
          <span class="text-primary">{{
            workoutData.day2.focus
          }}</span>
        </h1>
        <div class="exercises">
          <div
            class="container-wokrout"
            v-for="(exercise, index) in workoutData.day2.exercises"
            :key="index"
          >
            <WorkoutCard
              :workout_id="workout.id"
              :user_id="workout.user_id"
              :week="currentWeek"
              :day="currentDay"
              :exercise-name="exercise"
            />
          </div>
        </div>
      </div>


      <div class="day3">
        <h1>
          Day 3
          <span class="text-primary">{{
            workoutData.day3.focus
          }}</span>
        </h1>
        <div class="exercises">
          <div
            class="container-wokrout"
            v-for="(exercise, index) in workoutData.day3.exercises"
            :key="index"
          >
            <WorkoutCard
              :workout_id="workout.id"
              :user_id="workout.user_id"
              :week="currentWeek"
              :day="currentDay"
              :exercise-name="exercise"
            />
          </div>
        </div>
      </div>


      <div class="day4">
        <h1>
          Day 4
          <span class="text-primary">{{
            workoutData.day4.focus
          }}</span>
        </h1>
        <div class="exercises">
          <div
            class="container-wokrout"
            v-for="(exercise, index) in workoutData.day4.exercises"
            :key="index"
          >
            <WorkoutCard
              :workout_id="workout.id"
              :user_id="workout.user_id"
              :week="currentWeek"
              :day="currentDay"
              :exercise-name="exercise"
            />
          </div>
        </div>
      </div>

      <!-- <div class="day5">
        <h1>
          Day 5
          <span class="text-primary">{{
            workoutData.day5.focus
          }}</span>
        </h1>
        <div class="exercises">
          <div
            class="container-wokrout"
            v-for="(exercise, index) in workoutData.day5.exercises"
            :key="index"
          >
            <WorkoutCard
              :workout_id="workout.id"
              :user_id="workout.user_id"
              :week="currentWeek"
              :day="currentDay"
              :exercise-name="exercise"
            />
          </div>
        </div>
      </div> -->


      <!-- <div class="day6">
        <h1>
          Day 6
          <span class="text-primary">{{
            workoutData.day6.focus
          }}</span>
        </h1>
        <div class="exercises">
          <div
            class="container-wokrout"
            v-for="(exercise, index) in workoutData.day6.exercises"
            :key="index"
          >
            <WorkoutCard
              :workout_id="workout.id"
              :user_id="workout.user_id"
              :week="currentWeek"
              :day="currentDay"
              :exercise-name="exercise"
            />
          </div>
        </div>
      </div> -->


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
        const res = await axios.get("http://localhost:8000/api/v1/workout", {
          withCredentials: true,
          headers: {
            Token: token,
          },
        });
        this.workout = res.data;
        this.workout_exists = true;

        if (this.workout) {
          this.workoutData = JSON.parse(this.workout.workout);
          this.workoutData = JSON.parse(this.workoutData);
        }
      } catch (err) {
        console.log(err);
        if (err.response && err.response.status === 404) {
          this.workout_exists = false;
        }
      } finally {
        this.isLoading = false;
      }
    },
    logout() {
      localStorage.clear("Token");
      this.$router.push("/login");
    },
    async generateWorkout() {
      const token = localStorage.getItem("Token");
      this.isLoading = true;
      if (!token) {
        this.$router.push("/login");
        return;
      }
      try {
        const res = await axios.post(
          "http://localhost:8000/api/v1/workout",
          {}, // POST data (empty object if no data)
          {
            withCredentials: true,
            headers: {
              Token: token,
            },
          }
        );
        this.workout = res.data;
        this.workout_exists = true;
          this.isLoading = false;
        if (this.workout) {
          this.workoutData = JSON.parse(this.workout.workout);
          this.workoutData = JSON.parse(this.workoutData);
        }
      } catch (err) {
        console.log(err);
      } finally {
        this.isLoading = false;
      }
    },
  },
};
</script >
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
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 24px;
  padding: 24px;
  flex-wrap: wrap;
}
.workout h1{
  text-align: center;
}
.workout{
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 80px;
}
</style>
