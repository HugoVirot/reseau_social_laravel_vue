<template>

    <HeaderNav />

    <main class="my-4 mx-2">
        <!-- si la route est différente de / (racine du site) -->
        <!-- on affiche le template du composant concerné par la route -->
        <div v-if="$route.path !== '/'">
            <router-view v-bind:key="$route.fullPath"></router-view>
        </div>

        <!-- si la route est / => on affiche le code de l'accueil-->
        <div v-else class="text-center">
            <i class="my-2 fa-5x fa-solid fa-paper-plane rounded-circle p-5"></i>
            <h1 class="text-center fw-bold">Réseau Social Laravel VueJS</h1>
            <CreerPost />
            <PostsList />
        </div>
    </main>

    <FooterApp />
    
</template>

<script setup>
import PostsList from './components/PostsList.vue'
import HeaderNav from './components/HeaderNav.vue'
import FooterApp from './components/FooterApp.vue'
import CreerPost from './components/CreerPost.vue'
</script>

<style lang="scss">
@import '../sass/style.scss';

h1 {
    font-size: 3em;
}

h1,
h2 {
    font-family: $firstFont;
    color: $mainColor
}

a {
    text-decoration: none;
    color: inherit
}

p {
    font-family: $secondFont
}

header i {
    color: $mainColor
}

i {
    color: white
}

button {
    @include button
}

.fa-paper-plane {
    background-color: $mainColor;
}
</style>