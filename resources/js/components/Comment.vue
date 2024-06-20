<template>
    <div class="card mb-3 p-2 w-75 mx-auto">

        <div class="row text-center">
            <h4>#{{ comment.tags }}</h4>
        </div>
        <div class="card-header row px-5 bg-light">
            <div class="col-6 text-start">
                posté par <span class="fw-bold">{{ comment.user.pseudo }}</span>
            </div>
            <div class="col-6 text-end">
                posté le {{ comment.created_at.substring(0, 10) }}
            </div>
        </div>

        <div class="card-body text-center">
            <h5 class="card-title"></h5>

            <div v-if="comment.image">
                <img class="w-50" :src="`/images/${comment.image}`" alt="image du message">
            </div>

            <p class="m-4">
                {{ comment.content }}
            </p>

            <div v-if="userStore.userLoggedIn && userStore.id == comment.id || userStore.role == 'admin'"
                class="row mt-3">
                <!--********************** bouton modifier => mène à la page de modification du message ********************-->
                <div class="col-6 text-center">
                    <button class="btn btn-primary mx-auto">modifier</button>
                </div>
                <!--******************************************** bouton supprimer ******************************************-->
                <div class="col-6 text-center">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { useUserStore } from '../stores/userStore';

defineProps(['comment'])

const userStore = useUserStore()
</script>

<style scoped lang="scss">
@import '../../sass/style.scss';

.card-header {
    background-color: $mainColor !important;
    color: white;
    border: 4px solid white
}

.card {
    color: $mainColor !important;
    background-color: $secondColor;
    border: 4px solid white
}
</style>