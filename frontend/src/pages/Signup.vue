<template>
    <div class="container">

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
                    <span class="text">Signing up..</span>
                </div>
            </div>
        </div>

        <!-- Form -->
       <form class="signupForm" @submit.prevent="Register">
        <h1>
            <span class="text-accent">After</span><span class="text">Burn</span>
        </h1>

        <div class="form-part" id="part-1">
            <div class="input">
                <label for="name">Name: </label>
                <input 
                    type="text" 
                    :class="['inp', {'error': incompleteFields == 'name' }]"
                    name="name"
                    v-model="name" 
                    id="name"
                    required
                    >
                <p :class="['err-msg', {'show': incompleteFields == 'name'}]">Please fill this field.</p>
            </div>
            <div class="input">
                <label for="name">Email: </label>
                <input 
                type="email" 
                :class="['inp', {'error': incompleteFields == 'email' }]"
                name="email"
                v-model="email" 
                id="email"
                required
                >
                <p :class="['err-msg', {'show': incompleteFields == 'email'}]">Please fill this field.</p>
            </div>
            <div class="input">
                <label for="name">Password: </label>
                <input 
                type="password" 
                :class="['inp', {'error': incompleteFields == 'password' || passMissMatched }]"
                name="password"
                v-model="password" 
                id="password"
                required
                >
                <p :class="['err-msg', {'show': incompleteFields == 'password'}]">Please fill this field.</p>
            </div>
            <div class="input">
                <label for="name">Confirm Password: </label>
                <input 
                type="password" 
                :class="['inp', {'error': incompleteFields == 'confirmPassword' || passMissMatched}]"
                name="confirmPassword"
                v-model="confirmPassword" 
                id="confirmPassword"
                required
                >
                <p :class="['err-msg', {'show': incompleteFields == 'confirmPassword'}]">Please fill this field.</p>
                <p :class="['err-msg', {'show': passMissMatched}]">Passwords Mismatched.</p>
            </div>
            <p class="already">Already have an account? <router-link to="/login">Log in</router-link></p>
            <button type="button" class="btn btn-primary btn-full" @click="showPart2">Next</button>
        </div>
        
        <div class="form-part hidden" id="part-2">
            <div class="inputs">
                <div class="input">
                    <label for="name">Age(yrs): </label>
                    <input 
                    type="number" 
                    :class="['inp', {'error': incompleteFields == ' age'}]"
                    name="age"
                    v-model="age" 
                    id="age"
                    min="13"
                    max="55"
                    required
                    >
                    <p :class="['err-msg', {'show': incompleteFields == ' age'}]">Please fill this field.</p>
                </div>
                <div class="input">
                    <label for="name">Weight(kg): </label>
                    <input 
                    type="number" 
                    :class="['inp', {'error': incompleteFields == 'weight'}]"
                    name="weight"
                    v-model="weight" 
                    id="weight"
                    min="25"
                    max="250"
                    required
                    >
                    <p :class="['err-msg', {'show': incompleteFields == 'weight'}]">Please fill this field.</p>
                </div>
                <div class="input">
                    <label for="name">Target Weight(kg): </label>
                    <input 
                    type="number" 
                    :class="['inp', {'error': incompleteFields == 'targetWeight'}]"
                    name="targetWeight"
                    v-model="targetWeight" 
                    id="targetWeight"
                    min="25"
                    max="250"
                    required
                    >
                    <p :class="['err-msg', {'show': incompleteFields == 'targetWeight'}]">Please fill this field.</p>
                </div>
            </div>
            <div class="inputs">
                <div class="input">
                    <label for="name">Gender: </label>
                    <select name="gender" id="gender" :class="['input-selector', {'error': incompleteFields == ' gender'}]" v-model="gender">
                        <option value="" selected disabled>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <p :class="['err-msg', {'show': incompleteFields == ' gender'}]">Please fill this field.</p>
                </div>
                <div class="input">
                    <label for="name">Height(cm): </label>
                    <input 
                    type="number" 
                    :class="['inp', {'error': incompleteFields == ' height'}]"
                    name="height"
                    v-model="height" 
                    id="height"
                    min="50"
                    max="250"
                    required
                    >
                    <p :class="['err-msg', {'show': incompleteFields == 'height'}]">Please fill this field.</p>
                </div>
                <div class="input">
                    <label for="name">Goal: </label>
                    <select name="goal" id="goal" :class="['input-selector', {'error': incompleteFields == 'goal'}]" v-model="goal">
                        <option value="" selected disabled>Select A Goal</option>
                        <option value="weight-loss">Weight Loss</option>
                        <option value="weight-gain">Weight Gain</option>
                        <option value="muscle-building">Muscle Building</option>
                        <option value="toning">Body Toning</option>
                        <option value="strength">Strength Training</option>
                        <option value="endurance">Endurance Building</option>
                        <option value="flexibility">Flexibility Improvement</option>
                        <option value="general">General Fitness</option>
                        <option value="athletic">Athletic Performance</option>
                        <option value="rehab">Rehabilitation</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="recomp">Body Recomposition</option>
                    </select>
                    <p :class="['err-msg', {'show': incompleteFields == 'goal'}]">Please fill this field.</p>
                </div>
            </div>
            <div class="buttons-container">
                <button type="button" class="btn btn-accent btn-full" @click="showPart1">Prev</button>
                <button type="button" class="btn btn-primary btn-full" @click="showPart3">Next</button>
            </div>
        </div>

        <div class="form-part hidden" id="part-3">
            <div class="inputs">
                <div class="input">
                    <label for="name">Difficulty Level: </label>
                    <select name="difficultyLevel" id="difficultyLevel" :class="['input-selector', {'error': incompleteFields == 'difficultyLevel'}]" v-model="difficultyLevel">
                        <option value="" selected disabled>Select Difficulty Level</option>
                        <option value="beginner" >Beginner</option>
                        <option value="intermediate" >Intermediate</option>
                        <option value="advanced" >Advanced</option>
                        <option value="extreme" >Extreme</option>
                        <option value="deadly insane" >Deadly Insane</option>
                        
                    </select>
                    <p :class="['err-msg', {'show': incompleteFields == 'difficultyLevel'}]">Please fill this field.</p>
                </div>
                <div class="input">
                    <label for="name">Total weeks: </label>
                    <input 
                        type="number" 
                        :class="['input-selector', {'error': incompleteFields == 'timeCommitment'}]"
                        name="timeCommitment"
                        id="timeCommitment"
                        v-model="timeCommitment"
                        min="2"
                        required
                        >
                    <p :class="['err-msg', {'show': incompleteFields == 'timeCommitment'}]">Please fill this field.</p>
                </div>
                <div class="input">
                    <label for="name">Total budget: </label>
                    <input 
                        type="text" 
                        :class="['inp', {'error': incompleteFields == 'budget'}]"
                        name="budget"
                        id="budget"
                        v-model="budget"
                        required
                        >
                    <p :class="['err-msg', {'show': incompleteFields == 'budget'}]">Please fill this field.</p>
                </div>
            </div>
            <div class="inputs">
                <div class="input">
                    <label for="name">Workout Type: </label>
                    <select name="workoutType" id="workoutType" :class="['input-selector', {'error': incompleteFields == 'workoutType'}]" v-model="workoutType">
                        <option value="" selected disabled>Select Workout Type</option>
                        <option value="home workout" >Home Workout</option>
                        <option value="gym wokrout" >Gym Workout</option>
                        <option value="calisthenics" >Calisthenics</option>
                    </select>
                    <p :class="['err-msg', {'show': incompleteFields == 'workoutType'}]">Please fill this field.</p>
                </div>
                <div class="input">
                    <label for="name">Current Fitness Level: </label>
                    <input 
                        type="text" 
                        class="inp"
                        id="fitnessLevelCurrent"
                        name="fitnessLevelCurrent"
                        v-model="fitnessLevelCurrent"
                        required
                        >
                    <p :class="['err-msg', {'show': incompleteFields == 'fitnessLevelCurrent'}]">Please fill this field.</p>
                </div>
            </div>
                <div class="input">
                    <label for="name">Additional Notes: </label>
                    <textarea 
                        name="description" 
                        id="description" 
                        :class="['input-selector', { 'error': incompleteFields == 'descripiton'}]"
                        v-model="description"
                        placeholder="Describe more about your interests, routine, and reasons so that we can make a perfect workout for you..."
                        >
                    </textarea>
                    <p :class="['err-msg', {'show': incompleteFields == 'fitnessLevelCurrent'}]">Please fill this field.</p>
                </div>

                <div class="buttons-container">
                <button type="button" class="btn btn-accent btn-full" @click="showPart2">Prev</button>
                <button type="submit" class="btn btn-primary btn-full">Submit</button>
            </div>
        </div>

       </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "SignupPage",
    data(){
        return {
            name: '',
            email : '',
            password : '',
            confirmPassword: '',
            age: 0,
            gender: '',
            weight: 0,
            targetWeight: 0,
            height: 0,
            goal: '',
            incompleteFields : 'none',
            passMissMatched: false,
            difficultyLevel: '',
            timeCommitment: 0,
            budget: '',
            workoutType: '',
            fitnessLevelCurrent: '',
            description: '',
            isLoading: false,
        }
    },
    methods: {
        showPart1(){
            this.isLoading = true;
            this.passMissMatched= false;
            this.incompleteFields= 'none';
            const part1 = document.getElementById('part-1');
            part1.classList.remove('hidden');
            const part2 = document.getElementById('part-2');
            part2.classList.add('hidden');
            this.isLoading = false;
            return;
        },
        showPart2(){
            this.isLoading = true;
            if(!this.name.trim()){
                this.passMissMatched= false;
                this.incompleteFields = 'name';
                this.isLoading = false;
                return;
            }else if(!this.email.trim()){
                this.incompleteFields = 'email';
                this.passMissMatched= false;
                this.isLoading = false;
                return;
            }else if(!this.password.trim()){
                this.incompleteFields = 'password';
                this.isLoading = false;
                this.passMissMatched= false;
                return;
            }else if(!this.confirmPassword.trim()){
                this.incompleteFields = 'confirmPassword';
                this.passMissMatched= false;
                this.isLoading = false;
                return;
            }else if(this.password.trim() != this.confirmPassword.trim()){
                this.incompleteFields= 'none';
                this.passMissMatched= true;
                this.isLoading = false;
                return;
            }else{
                this.passMissMatched= false;
                this.incompleteFields= 'none';
                const part1 = document.getElementById('part-1');
                part1.classList.add('hidden');
                const part3 = document.getElementById('part-3');
                part3.classList.add('hidden');
                const part2 = document.getElementById('part-2');
                part2.classList.remove('hidden');
                this.isLoading = false;
                return;
            }
        },
        showPart3(){
            this.isLoading = true;
            if(this.age == 0){
                this.incompleteFields = 'age';
                this.isLoading = false;
                return;
            }else if(this.weight == 0){
                this.incompleteFields = 'weight';
                this.isLoading = false;
                return;
            }else if(this.targetWeight == 0){
                this.incompleteFields = 'targetWeight';
                this.isLoading = false;
                return;
            }else if(!this.gender){
                this.incompleteFields = 'gender';
                this.isLoading = false;
                return;
            }else if(this.height == 0){
                this.incompleteFields= 'height';
                this.isLoading = false;
                return;
            }else if(!this.goal){
                this.incompleteFields= 'goal';
                this.isLoading = false;
                return;
            }else{
                this.incompleteFields= 'none';
                const part3 = document.getElementById('part-3');
                part3.classList.remove('hidden');
                const part2 = document.getElementById('part-2');
                part2.classList.add('hidden');
                const part1 = document.getElementById('part-2');
                part1.classList.add('hidden');
                this.isLoading = false;
                return;
            }
        },
        Register(){
            this.isLoading = true;
            const request = {
                "name" : this.name.trim(),
                "email" : this.email.trim(),
                "password" : this.password.trim(),
                "confirmPassword" : this.confirmPassword.trim(),
                "age" : `${this.age} years`,
                "gender" : this.gender.trim(),
                "weight" : `${this.weight} kg`,
                "targetWeight" : `${this.targetWeight} kg`,
                "height": `${this.height} cm`,
                "goal": this.goal.trim(),
                "difficultyLevel" : this.difficultyLevel.trim(),
                "timeCommitment" : `${this.timeCommitment} weeks`,
                "budget": this.budget.trim(),
                "workoutType" : this.workoutType.trim(),
                "fitnessLevelCurrent" : this.fitnessLevelCurrent.trim(),
                "description" : this.description.trim(),
            }

            axios.post('http://localhost:8000/api/v1/auth/register', request)
            .then(res => {
                const token = res.data.token;
                localStorage.setItem('Token', token);
                this.$router.push('/');                
                this.isLoading = false;
            })
            .catch(err => {
                console.log(err);
                this.isLoading = false;
            })

        }
    }
}
</script>

<style scoped>
.form-part{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 50vw;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 16px;
}
.input{
    width: 100%;
}
.hidden{
    display: none;
}
.buttons-container{
    display: flex;
    justify-content: space-around;
    width: 100%;
    gap: 16px;
}
.inputs{
    display: flex;
    gap: 16px;
    width: 100%;
}
.err-msg{
    display: none;
}
.show{
    display: block;
}

@media screen and (max-width: 768px) {
  .form-part{
    width: 75vw;
  }
}
@media screen and (max-width: 500px) {
  .form-part{
    width: 100vw;
    position: relative;
    transform: translate(0%, 0%);
    top: 0;
    left: 0;
  }
  .inputs{
    flex-direction: column;
  }
}
h1{
    padding: 16px;
}
.already{
    width: 100%;
    text-align: left;
}
</style>