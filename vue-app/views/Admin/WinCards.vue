<script setup>
import PrintableCards from "@/components/PrintableCards.vue";
import { icon } from "@/translate";
import { ref } from "vue";

const nb = ref(21);
</script>

<template>
    <PrintableCards :items="new Array(nb)">
        <template #below-header>
            Cartes: <input type="number" v-model="nb" />
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
