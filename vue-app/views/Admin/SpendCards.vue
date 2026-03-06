<script setup>
import PrintableCards from "@/components/PrintableCards.vue";
import QrCode from "@/components/QrCode.vue";
import { useArticlesStore } from "@/stores/articles";
import { icon, tr } from "@/translate";
import { computed, ref } from "vue";

const articlesStore = useArticlesStore();

const freeSpendCardCopies = ref(4);

const cards = computed(() => {
    const articleCards = articlesStore.articles
        .filter((a) => a.type === "participation")
        .filter((a) => a.meta?.qrcodes)
        .map((a) => ({
            ...a,
            url: `${location.origin}/spend/tokens/?article=${a.name}`,
            copies: a.meta.qrcodes,
        }));
    const freeSpendCards = ["tokens", "points"].map((currency) => ({
        url: `${location.origin}/spend/${currency}`,
        description: "Dépense de " + tr(currency),
        currency,
        copies: freeSpendCardCopies.value,
    }));
    const all = articleCards.concat(freeSpendCards);
    return all.map((c) => Array(+c.copies).fill(c)).flat();
});
</script>

<template>
    <PrintableCards :items="cards">
        <template #below-header>
            Copies cartes dépense libre:
            <input type="number" v-model="freeSpendCardCopies" />
        </template>
        <template #item="card">
            <h1 class="text text-center font-bold">
                {{ card.description }}
            </h1>
            <h2
                class="mt-2 flex flex-col items-center gap-1 text-xl opacity-50"
            >
                <component
                    v-if="card.currency"
                    :is="icon(card.currency)"
                    class=""
                />
                <span v-if="card.price">
                    -{{ card.price }} {{ tr(card.currency) }}
                </span>
            </h2>
            <QrCode :value="card.url" class="mx-auto" :width="120" />
        </template>
    </PrintableCards>
</template>
