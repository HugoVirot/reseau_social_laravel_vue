<template>

    <div v-if="!userStore.userLoggedIn" class="text-center fs-5">
        <p>connectez-vous pour poster un message</p>
        <RouterLink to="connexion"><button>connexion</button></RouterLink>
    </div>

    <div v-else class="container-fluid p-2 p-lg-3 mt-2">

        <ValidationErrors :errors="validationErrors" v-if="validationErrors" />
        <div class="row justify-content-center p-2">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center fs-5">
                        <h2 class="mt-2 fs-3">Poster un message</h2>
                    </div>

                    <div class="card-body p-5 fs-5">

                        <form @submit.prevent="sendPost">

                            <!-- contenu du message -->
                            <div class="form-group row m-2">
                                <label for="content" class="col-md-4 col-form-label text-md-right">texte</label>
                                <div class="col-md-6">
                                    <input v-model="content" id="content" type="text" class="form-control"
                                        name="content" required autocomplete="content">
                                </div>
                            </div>

                            <!-- tags du message -->
                            <div class="form-group row m-2">
                                <label for="tags" class="col-md-4 col-form-label text-md-right">tags</label>
                                <div class="col-md-6">
                                    <input v-model="tags" id="tags" type="text" class="form-control" name="tags"
                                        required autocomplete="tags">
                                </div>
                            </div>

                            <div class="form-group row mt-3 text-center">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit" class="">
                                        Valider
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios'
import ValidationErrors from "./ValidationErrors.vue"
import { useUserStore } from '../stores/userStore'
import { ref } from 'vue'
import { RouterLink } from 'vue-router';
import { useRouter } from 'vue-router';
const router = useRouter()

const content = ref("")
const tags = ref("")
const validationErrors = ref("")

const userStore = useUserStore()

const sendPost = async () => {
    // on tente la connexion
    await axios.post('http://localhost:8000/api/posts', { content: content.value, tags: tags.value, user_id: userStore.id })

        .then(response => {
            alert("Message créé avec succès !")
           router.go(0) // force la page à se recharger pour récupérer la nouvelle liste des posts

        }).catch((error) => {
            validationErrors.value = error.response.data.errors
        })
}

</script>

<style scoped lang="scss">
@import '../../sass/style.scss';

h2 {
    color: white
}

.card {
    color: $mainColor !important
}

.card-header {
    color: white;
    background-color: $mainColor;
}

.card-body {
    background-color: $secondColor;
}

input {
    color : $mainColor !important
}
</style>