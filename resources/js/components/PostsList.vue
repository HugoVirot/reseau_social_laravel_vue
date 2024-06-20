<template>
    <div class="container mt-5">
        <div v-for="post in postStore.posts" :key="post.id">
            <Post :post="post" />
        </div>
    </div>
</template>

<script setup>
import Post from './Post.vue'
import { usePostStore } from '../stores/postStore'
import { onBeforeMount } from 'vue';

const postStore = usePostStore()

onBeforeMount(async () => {
    await axios.get("http://localhost:8000/api/posts")
        .then(response => postStore.storePosts(response.data.posts))
        .catch(error => console.log(error))
})
</script>