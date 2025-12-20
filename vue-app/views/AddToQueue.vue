<script setup>
import Layout from "@/components/Layout.vue";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import Search from "@/spotify/Search.vue";
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">
            Ajouter un morceau à la file d'attente
        </h2>
        <Search>
            <template #actions="{ track }">
                <ValidationDrawer
                    trigger="Ajouter"
                    :title="`Ajouter ${track.name} à la file d'attente ?`"
                    :action="() => console.log(track)"
                    submitBtn="Dépenser 1 jeton"
                ></ValidationDrawer>
            </template>
        </Search>
    </Layout>
</template>
