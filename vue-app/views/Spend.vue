<script setup>
import Layout from "@/components/Layout.vue";
import { useRoute } from "vue-router";

const route = useRoute();
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">
            Dépenser des {{ route.params.currency }}
        </h2>
        <div class="px-4"></div>
    </Layout>
</template>
