<template>
    <div class="card">
        <p class="large-thin-stat-text text-primary">{{ amount }}</p>
        <h3>{{ heading }}</h3>
    </div>
</template>

<script>
export default {
    props:{
        amount: {String},
        heading: {String},
    },  
    name: "CardComponent",
}
</script>

<style scoped>
.large-thin-stat-text{
    font-size: 2.5rem;
    font-weight: 200;
}
h3{
    padding: 0;
    margin: 0;
    font-size: 1.5rem;
    font-weight: 400;
}
p{
    padding: 0;
    margin: 0;
    line-height: 2.75rem;
}
.card{
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: 200px;
    height: 150px;
}
@media screen and (max-width: 550px) {
    .card{
        width: 125px;
        height: 94px;
    }
    .large-thin-stat-text{
        font-size: 1.25rem;
    }
    h3{
        font-size: 1rem;
    }
}
</style>