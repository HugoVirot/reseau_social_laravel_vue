<template>
    <div v-if="content">
        <div class="pt-2 text-center">
            <i class="mt-2 mx-auto text-primary fa-5x fa-solid fa-user"></i>
            <h2 class="mt-2 fs-1">Modifier un message</h2>
        </div>

        <div class="container-fluid p-3 p-lg-5">

            <ValidationErrors :errors="validationErrors" v-if="validationErrors" />
            <div class="row justify-content-center p-2">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-white  text-center fs-5">changez les informations
                            souhaitées
                        </div>

                        <div class="card-body bg-info text-white p-5">

                            <form @submit.prevent="editPost">

                                <!-- contenu du message -->
                                <div class="form-group row m-2">
                                    <label for="content" class="col-md-4 col-form-label text-md-right">nouveau
                                        texte</label>
                                    <div class="col-md-6">
                                        <input v-model="content" id="content" type="text" class="form-control"
                                            name="content" required autocomplete="content">
                                    </div>
                                </div>

                                <!-- tags du message -->
                                <div class="form-group row m-2">
                                    <label for="tags" class="col-md-4 col-form-label text-md-right">nouveaux
                                        tags</label>
                                    <div class="col-md-6">
                                        <input v-model="tags" id="tags" type="text" class="form-control" name="tags"
                                            required autocomplete="tags">
                                    </div>
                                </div>

                                <div class="form-group row mt-3 text-center">
                                    <div class="col-md-6 offset-md-3">
                                        <button type="submit"
                                            class="btn btn-lg px-5  rounded-pill text-white">
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
    </div>
</template>

<script setup>
import axios from 'axios'
import ValidationErrors from "./ValidationErrors.vue"
import { useRouter } from 'vue-router';
const router = useRouter()

const content = ref('')
const tags = ref('')
const postId = this.$route.params.id
const validationErrors = ref([])

const editPost = async () => {
    // on tente la connexion
    await axios.put('http://localhost:8000/api/posts/' + this.postId, { content: this.content, tags: this.tags })

        .then(response => {
            alert("Message modifié avec succès !")
            router.push('/')

        }).catch(error => {
            if (error.response.status == "403") {
                alert("Vous n'avez pas l'autorisation de modifier ce message !")
                router.push('/')
            } else {
                validationErrors.value = error.response.data.errors
            }
        })
}

onBeforeMount(() => {
    axios.get('http://localhost:8000/api/posts/' + this.postId)

        .then(response => {
            content.value = response.data.content
            tags.value = response.data.tags

        }).catch(error => console.log(error.response))
})


</script>