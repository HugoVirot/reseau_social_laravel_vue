<template>
    <div v-if="validationErrors">
        <ul class="alert alert-danger list-unstyled">
            <li v-for="value in validationErrors" :key="value.id">{{ value }}</li>
        </ul>
    </div>
</template>

<script setup>
import { computed } from 'vue';

defineProps(['errors'])

// Instead of a computed property, we can define the same function as a method. For the end result, the two approaches are indeed exactly the same. 
// However, the difference is that computed properties are cached based on their reactive dependencies. A computed property will only re-evaluate
//  when some of its reactive dependencies have changed. This means as long as author.books has not changed, multiple access to 
//  publishedBooksMessage will immediately return the previously computed result without having to run the getter function again.

// on récupère les messages d'erreur à l'intérieur de l'objet errors en props, sous forme de tableau
const validationErrors = computed(() => Object.values(this.errors).flat())
</script>
