<template>
<h1>Diet Details Pgae</h1>
<h2>Diet name: {{ food }}</h2>
</template>

<script>
export default {
    name: "DietDetailsPage",
    props: ['food']
}
</script>