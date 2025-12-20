<script setup>
import Layout from "@/components/Layout.vue";
import Search from "@/spotify/Search.vue";
</script>

<template>
    <Layout>
        <div class="px-4 py-2">
            <h2 class="mb-2 font-bold">
                Ajouter un morceau à la file d'attente
            </h2>
            <Search></Search>
        </div>
    </Layout>
</template>
