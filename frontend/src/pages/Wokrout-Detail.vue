<template>
<h1>Workout Details Pgae</h1>
<h2>Exercise Name: {{ exercise }}</h2>
</template>

<script>
export default {
    name: "WorkoutDetailsPage",
    props: ['exercise'],
}
</script>