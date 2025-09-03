<template>
<div class="card-long">
    <h3 class="text-primary">{{ heading }}</h3>
    <p class="text-main">{{ description }}</p>
</div>
</template>

<script>
export default{
    name: "LongCard",
    props:{
        heading: String,
        description: String,
    }
}
</script>

<style scoped >
@media screen and (max-width: 550px){
    h3{
        font-size: 1.5rem;
    }
    p{
        font-size: 0.95rem;
    }
}
</style>