<script setup>
import PrintableCards from "@/components/PrintableCards.vue";
import { icon } from "@/translate";
import { ref } from "vue";

const pages = ref(2);
</script>

<template>
    <PrintableCards :items="new Array(9 * pages)">
        <template #below-header>
            Pages: <input type="number" v-model="pages" />
        </template>
        <template #item>
            <div class="mx-auto">
                <component :is="icon('points')" />
            </div>
            <h1 class="text-center text-xl font-bold">Bravo !</h1>
            <h2 class="text-center text-xl opacity-50">Tu as gagné</h2>
            <hr class="mt-16 mb-2" />
            <h2 class="text-center text-xl opacity-50">points</h2>
        </template>
    </PrintableCards>
</template>
