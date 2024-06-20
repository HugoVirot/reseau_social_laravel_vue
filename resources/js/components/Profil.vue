<template>
    <div>
        <h1 class="text-center text-primary fw-bold">Profil de {{ user.pseudo }}</h1>
    </div>
    <p>{{ user.posts.length }} messages postés</p>

    <PostsList :posts="user.posts" />
</template>

<script setup>

import axios from "axios";
import { onBeforeMount } from "vue";
import PostsList from './PostsList.vue'

const user = ref(null)

onBeforeMount(() => {
    axios.get("http//localhost/api/users/" + this.$route.params.id)
        .then(response => user.value = response.data)
        .catch(error => console.log(error.response));
})
</script>
