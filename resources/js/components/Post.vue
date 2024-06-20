<template>
    <div class="card mb-5 p-4">

        <div class="row text-center">
            <h2 id="tags">#{{ post.tags }}</h2>
        </div>
        <div class="card-header row px-5">
            <div class="col-6 text-start">
                posté par <span class="fw-bold">{{ post.user.pseudo }}</span>
            </div>
            <div class="col-6 text-end">
                posté le {{ post.created_at.substring(0, 10) }}
            </div>
        </div>

        <div class="card-body text-center">
            <h5 class="card-title"></h5>

            <div v-if="post.image">
                <img class="w-75" :src="`/images/${post.image}`" alt="image du message">
            </div>

            <p class="mt-4">
                {{ post.content }}
            </p>

            <div v-if="userStore.userLoggedIn && userStore.id == post.id || userStore.role == 'admin'" class="row mt-3">
                <!--********************** bouton modifier => mène à la page de modification du message ********************-->
                <div class="col-6 text-center">
                    <router-link :to="`modifierpost/${post.id}`">
                        <button class="btn btn-info mx-auto">modifier</button>
                    </router-link>
                </div>
                <!--******************************************** bouton supprimer ******************************************-->
                <div class="col-6 text-center">
                    <button @click="deletePost()" class="btn btn-danger">Supprimer</button>
                </div>
            </div>

        </div>

        <CommentsList :comments="post.comments" />
    </div>
</template>

<script setup>
import CommentsList from './CommentsList.vue';
import { useUserStore } from '../stores/userStore';
import { useRouter } from 'vue-router';
const router = useRouter()

const userStore = useUserStore()

const props = defineProps({
    post: {
        type: Object,
        required: true
    }
})

const deletePost = async () => {

    await axios.delete("http://localhost:8000/api/posts/" + props.post.id)
        .then(response => {
            alert("Suppression réussie !")
            router.push('/')
        })
        .catch(error => {
            if (error.response.status == "403") {
                alert("Vous n'avez pas l'autorisation de supprimer ce message !")
                router.push('/')
            } else {
                console.log(error.response)
            }
        })
}

</script>

<style lang="scss">
@import '../../sass/style.scss';

.card {
    color: white !important;
    background-color: $mainColor
}

.card-header {
    color: $mainColor;
    background-color: $secondColor;
}

#tags {
    color:white
}

</style>