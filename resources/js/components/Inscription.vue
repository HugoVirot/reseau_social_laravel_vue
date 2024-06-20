<template>
  <div class="pt-2 text-center">
    <i class="mt-2 mx-auto fa-5x fa-solid fa-user-plus"></i>
    <h1 class="mt-2 fs-1">Inscription</h1>
  </div>

  <div class="container-fluid p-3 p-lg-5">
    <ValidationErrors :errors="validationErrors" v-if="validationErrors" />
    <div class="row justify-content-center p-2">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header text-center fs-5">
            Quelques secondes suffisent !
          </div>

          <div class="card-body p-5">
            <form @submit.prevent="sendData">
              <!---------------------- politique ------------------------>
              <div class="form-group row mx-2 mb-5">
                <div class="col-md-9 text-end">
                  <label for="politique"
                    >J'ai lu et j'accepte la
                    <router-link
                      to="/politique"
                      class="fw-bold border p-3 rounded m-2"
                      >politique de confidentialité</router-link
                    >
                  </label>
                </div>
                <div class="col-md-1">
                  <input
                    type="checkbox"
                    v-model="politique"
                    id="politique"
                    name="politique"
                  />
                </div>
              </div>

              <!---------------------- pseudo ------------------------>

              <div class="form-group row m-2">
                <label
                  for="pseudo"
                  class="col-md-4 col-form-label text-md-right"
                  >pseudo</label
                >

                <div class="col-md-6">
                  <input
                    v-model="pseudo"
                    id="pseudo"
                    type="text"
                    class="form-control"
                    name="pseudo"
                    required
                    autocomplete="pseudo"
                    autofocus
                  />
                </div>
              </div>

              <!---------------------- e-mail ------------------------>

              <div class="form-group row m-2">
                <label for="email" class="col-md-4 col-form-label text-md-right"
                  >e-mail</label
                >

                <div class="col-md-6">
                  <input
                    v-model="email"
                    id="email"
                    type="email"
                    class="form-control"
                    name="email"
                    required
                    autocomplete="email"
                  />
                </div>
              </div>
              <div id="emailHelp" class="form-text text-center">
                Nous ne partagerons jamais votre e-mail avec des tiers.
              </div>

              <!---------------------- mot de passe ------------------------>

              <div id="infosMdp" class="form-group row my-2">
                <div
                  id="passwordHelpBlock"
                  class="mx-auto p-4 m-3 border border-info"
                >
                  Votre mot de passe doit comporter au moins 8 caractères. Il
                  contenir au moins une lettre, un chiffre, une minuscule, une
                  majuscule et un caractère spécial.
                </div>
              </div>

              <div class="form-group row m-2">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                  >mot de passe</label
                >

                <div class="col-md-6">
                  <input
                    v-model="password"
                    @keyup="checkPassword(password)"
                    id="password"
                    type="password"
                    class="form-control"
                    name="password"
                    required
                    autocomplete="new-password"
                  />
                </div>
              </div>

              <!---------------------- aide dynamique mot de passe (critères) ------------------------>

              <div
                v-if="passwordTyped"
                class="container w-50 text-center p-3"
                id="dynamicPasswordCheck"
              >
                <div class="row">
                  <p>
                    minimum 8 caractères
                    <i
                      v-if="eightCharacters"
                      class="p-2 bg-white rounded-circle greenIcon fa-solid fa-check"
                    ></i>
                    <i
                      v-else
                      class="p-2 bg-white rounded-circle fa-solid fa-xmark"
                    ></i>
                  </p>
                </div>

                <div class="row">
                  <p>
                    minimum 1 lettre
                    <i
                      v-if="oneLetter"
                      class="p-2 bg-white rounded-circle greenIcon fa-solid fa-check"
                    ></i>
                    <i
                      v-else
                      class="p-2 bg-white rounded-circle fa-solid fa-xmark"
                    ></i>
                  </p>
                </div>

                <div class="row">
                  <p>
                    minimum 1 chiffre
                    <i
                      v-if="oneDigit"
                      class="p-2 bg-white rounded-circle greenIcon fa-solid fa-check"
                    ></i>
                    <i
                      v-else
                      class="p-2 bg-white rounded-circle fa-solid fa-xmark"
                    ></i>
                  </p>
                </div>

                <div class="row">
                  <p>
                    minimum 1 majuscule et 1 minuscule
                    <i
                      v-if="oneUppercaseOneLowercase"
                      class="p-2 bg-white rounded-circle greenIcon fa-solid fa-check"
                    ></i>
                    <i
                      v-else
                      class="p-2 bg-white rounded-circle fa-solid fa-xmark"
                    ></i>
                  </p>
                </div>

                <div class="row">
                  <p>
                    minimum 1 caractère spécial
                    <i
                      v-if="oneSpecialCharacter"
                      class="p-2 bg-white rounded-circle greenIcon fa-solid fa-check"
                    ></i>
                    <i
                      v-else
                      class="p-2 bg-white rounded-circle fa-solid fa-xmark"
                    ></i>
                  </p>
                </div>
              </div>

              <div
                v-if="passwordCorrect == true && password.length != 0"
                class="form-group row mx-auto text-center greenBackground rounded mt-2 mb-4 w-50"
              >
                <i class="fa-solid fa-circle-check fa-3x p-2 mb-2"></i>
                <p class="titleIcon fs-5">Mot de passe sécurisé</p>
              </div>

              <div class="form-group row m-2">
                <label
                  for="password_confirmation"
                  class="col-md-4 col-form-label text-md-right"
                  >confirmez le mot de passe</label
                >

                <div class="col-md-6">
                  <input
                    v-model="password_confirmation"
                    id="password_confirmation"
                    type="password"
                    class="form-control"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                  />
                </div>
              </div>

              <div
                v-if="
                  passwordCorrect &&
                  password.length != 0 &&
                  password == password_confirmation
                "
                class="form-group row mx-auto text-center greenBackground rounded mt-3 mb-4 w-50"
              >
                <i class="fa-solid fa-circle-check fa-3x p-2 mb-2"></i>
                <p class="titleIcon fs-5">Confirmation OK</p>
              </div>

              <!---------------------- bouton valider ------------------------>

              <div v-if="politique" class="form-group row mt-3 text-center">
                <div class="col-md-6 offset-md-3">
                  <button
                    type="submit"
                    class="btn btn-lg px-5 rounded-pill text-white"
                  >
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
import axios from "axios";
import ValidationErrors from "./ValidationErrors.vue";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();

const pseudo = ref("");
const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const passwordTyped = ref(false);
const eightCharacters = ref(false);
const oneLetter = ref(false);
const oneUppercaseOneLowercase = ref(false);
const oneDigit = ref(false);
const oneSpecialCharacter = ref(false);
const passwordCorrect = ref(false);
const validationErrors = ref("");
const politique = ref(false);

const sendData = async () => {
  axios
    .post("/api/register", {
      pseudo: pseudo.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    })
    .then((response) => {
      alert(response.data.message);
      router.push("/");
    })
    .catch((error) => {
      validationErrors.value = error.response.data.errors;
    });
};

const checkPassword = (password) => {
  passwordTyped.value = true;
  passwordCorrect.value = false;

  password.length >= 8
    ? (eightCharacters.value = true)
    : (eightCharacters.value = false);
  password.match(/[a-z]/)
    ? (oneLetter.value = true)
    : (oneLetter.value = false);
  password.match(/(?=.*[a-z])(?=.*[A-Z])/)
    ? (oneUppercaseOneLowercase.value = true)
    : (oneUppercaseOneLowercase.value = false);
  password.match(/\d/) ? (oneDigit.value = true) : (oneDigit.value = false);
  password.match(/[!@#$%^&*?]/)
    ? (oneSpecialCharacter.value = true)
    : (oneSpecialCharacter.value = false);

  if (
    eightCharacters.value &&
    oneLetter.value &&
    oneUppercaseOneLowercase.value &&
    oneDigit.value &&
    oneSpecialCharacter.value
  ) {
    passwordCorrect.value = true;
  }
};
</script>

<style scoped lang="scss">
@import "../../sass/style.scss";

.greenIcon {
  color: rgb(24, 165, 80) !important;
}

.greenBackground {
  background-color: rgb(64, 189, 72);
}

#passwordHelpBlock {
  max-width: 600px;
}

.fa-xmark {
  color: red;
}

button {
  color: $mainColor !important;
  background-color: $secondColor;
}
</style>
