<template>
    <div :class="['card',{'disabled': isDisabled, 'completed': isComplete}]">
        <div class="icon">
            <Icon icon = "solar:dumbbell-large-linear" 
            style="
                width: 200px;
                height: 200px;
                font-size: 125px;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 16px;" />
        </div>
        <div class="details">
            <p>{{ exerciseName }}</p>
        </div>
    </div>
</template>
<script>
import { Icon } from '@iconify/vue';
import axios from 'axios';
export default{
    name: "WorkoutCard",
    props:{
        exerciseName: String,  
        isDisabled: Boolean,
        wokrout_id: Number,
        user_id: Number,
        week: Number,
        day: Number
    },
    components:{
        Icon,
    },
    
}
</script>
<style scoped>
.disabled .details{
    display: none;
}
.disabled .check-btn{
    display: none;
}
.btn {
  border-radius: 50%;
  padding: 8px;
  width: 40px;
  height: 40px;
  font-size: 1.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
}
.card{
    width: 300px;
    height: 300px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
p{
    font-size: 1.25rem;
}
.check-btn{
    position: absolute;
    top: 16px;
    right: 16px;
}
.completed {
    opacity: 0.7;
    background-color: #e8f5e9;
}
</style>