<template>
    <div class="pt-2 text-center">
        <i class="mt-2 mx-auto fa-5x fa-solid fa-user"></i>
        <h1 class="mt-2 fs-1">Connexion</h1>
    </div>

    <div class="container-fluid p-2 p-lg-4">

        <ValidationErrors :errors="validationErrors" v-if="validationErrors" />
        <div class="row justify-content-center p-2">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center fs-5">Entrez vos informations</div>

                    <div class="card-body p-5">

                        <form @submit.prevent="logIn">

                            <div class="form-group row m-2">
                                <label for="email" class="col-md-4 col-form-label text-md-right">e-mail</label>

                                <div class="col-md-6">
                                    <input v-model="email" id="email" type="email" class="form-control" name="email"
                                        required autocomplete="email">
                                </div>
                            </div>

                            <div class="form-group row m-2">
                                <label for="password" class="col-md-4 col-form-label text-md-right">mot de passe</label>

                                <div class="col-md-6">
                                    <input v-model="password" id="password" type="password" class="form-control"
                                        name="password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mt-4 text-center">
                                <div class="col-md-6 offset-md-3">
                                    <button type="submit">
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
const userStore = useUserStore()

import { ref } from 'vue';
const email = ref('')
const password = ref('')
const validationErrors = ref('')

import { useRouter } from 'vue-router';
const router = useRouter()

const logIn = async () => {
    // on initialise la protection CSRF Sanctum via cette route
    axios.get('/sanctum/csrf-cookie')

        .then(() => {
            // on tente la connexion
            axios.post('http://localhost:8000/api/login', { email: email.value, password: password.value })

                .then(response => {
                    console.log(response)
                    // si elle réussit : stockage des données utilisateur reçues dans le localstorage via le userStore
                    userStore.storeUserData(response.data[0])
                    // redirection vers un composant affichant le message de succès "vous êtes connecté"         
                    router.push('/')
                    // si elle échoue : on affiche la ou les erreurs rencontrée(s)

                }).catch((error) => {
                    console.log(error);
                    // validationErrors.value = error.response.data.errors
                })

            // si la requête d'initialisation de la protection CSRF a échoué, on affiche ce message
        }).catch(() => {
            alert("Problème d'authentification'. Merci de recharger la page. Réessayez plus tard ou contactez l'administrateur si le problème persiste.")
        })
}

</script>

<style scoped lang="scss">
@import '../../sass/style.scss';

.card-header {
    color : white;
    background-color: $mainColor;
}

.card-body {
    color: $mainColor;
    background-color: $secondColor;
}


</style>
