import { defineStore } from 'pinia'

export const useUserStore = defineStore({
    // id requis pour connecter le store aux devtools
    id: 'UserStore',

    state: () => {
        return {
            pseudo: "",
            email: "",
            id: "",
            role: "",
            userLoggedIn: false,
        }
    },

    actions: { // stocker les infos de l'utilisateur dans le store
        // appelée lors de la connexion et lors de la modif des infos
        storeUserData(userData) {
            this.pseudo = userData.pseudo
            this.email = userData.email
            this.id = userData.id
            this.role = userData.role.role
            this.userLoggedIn = true
        },
    },

    persist: true, // activation du plugin de persistance
})