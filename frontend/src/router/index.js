import { createWebHistory, createRouter } from "vue-router";
import Home from "../pages/Home.vue";
import About from "../pages/About.vue";
import Workout from "../pages/Workout.vue";
import WokroutDetail from "../pages/Wokrout-Detail.vue";
import Diet from "../pages/Diet.vue";
import DietDetail from "../pages/Diet-Detail.vue";
import Signup from "../pages/Signup.vue";
import Login from "../pages/Login.vue";

const routes = [
    {
        path: '/',
        name: "Home",
        component: Home
    },
    {
        path: '/about',
        name: "About",
        component: About
    },
    {
        path: '/workout',
        name: "Workout",
        component: Workout
    },
    {
        path: '/workout/:exercise',
        name: "WorkoutDetails",
        component: WokroutDetail,
        props: true,
    },
    {
        path: '/diet',
        name: "Diet",
        component: Diet
    },
    {
        path: '/diet/:food',
        name: "DietDetails",
        component: DietDetail,
        props: true
    },
    {
        path: '/signup',
        name: "Signup",
        component: Signup
    },
    {
        path: '/login',
        name: "Login",
        component: Login
    },
    
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;