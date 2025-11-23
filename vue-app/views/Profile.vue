<script setup>
import { reactive } from "vue";
import { useMainStore } from "../stores/main";

const mainStore = useMainStore();

const form = reactive({
    name: mainStore.user.name,
});
</script>

<template>
    <div>Bienvenue {{ mainStore.user.name }}</div>
    <form @submit.prevent="mainStore.updateUser(form)">
        <p>
            Nom:
            <input v-model="form.name" />
        </p>
        <p>
            <button type="submit">Enregistrer</button>
        </p>
    </form>
    <p class="mt-4">
        <button @click="mainStore.flushSession">Flush</button>
    </p>
    <p class="mt-4">
        <button @click="mainStore.inspire">inspire</button>
    </p>
</template>
