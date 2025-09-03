<template>
    
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
                        <span class="text">Logging in...</span>
                    </div>
                </div>
            </div>
    <div class="container">

        <!-- Form -->
       <form class="signupForm" @submit.prevent="Login">
        <h1>
            <span class="text-accent">After</span><span class="text">Burn</span>
        </h1>

        <div class="form-part" id="part-1">
            <div class="input">
                <label for="email">Email: </label>
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
                <label for="password">Password: </label>
                <input 
                type="password" 
                :class="['inp', {'error': incompleteFields == 'password' || passMissMatched }]"
                name="password"
                v-model="password" 
                id="password"
                required
                >
                <p :class="['err-msg', {'show': incompleteFields == 'confirmPassword'}]">Please fill this field.</p>
                <p :class="['err-msg', {'show': passMissMatched}]">{{ error_msg }}</p>
            </div>
            <p class="already">Don't have an account? <router-link to="/signup">Sign up</router-link></p>
            <button type="submit" class="btn btn-primary btn-full">Log in</button>
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
            email : '',
            password : '',
            incompleteFields : 'none',
            passMissMatched: false,
            isLoading: false,
            error_msg: '',
        }
    },
    methods: {
        Login(){
            this.isLoading = true;
            if(!this.email.trim()){
                this.incompleteFields = 'email';
                this.isLoading = false;
                return
            }else if(!this.password.trim()){
                this.incompleteFields = 'password'
                this.isLoading = false;
                return;
            }
            const request = {
                "email" : this.email.trim(),
                "password" : this.password.trim(),
            }
            axios.post('http://localhost:8000/api/v1/auth/login', request)
            .then(res => {
                const token = res.data.token;
                localStorage.setItem('Token', token);
                this.$router.push('/');  
                this.isLoading = false;
            })
            .catch(err => {
                console.log(err);
                this.error_msg = err.response.data.message;
                this.passMissMatched = true;
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