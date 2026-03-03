<script setup>
import PrintableCards from "@/components/PrintableCards.vue";
import QrCode from "@/components/QrCode.vue";
import { useArticlesStore } from "@/stores/articles";
import { icon, tr } from "@/translate";
import { computed } from "vue";
import { useLink } from "vue-router";

const articlesStore = useArticlesStore();

const cards = computed(() => {
    const articleCards = articlesStore.articles
        .filter((a) => a.type === "participation")
        .filter((a) => a.meta?.qrcodes)
        .map((a) => ({
            ...a,
            to: {
                name: "spend",
                params: { currency: "tokens" },
                query: { article: a.name },
            },
            copies: a.meta.qrcodes,
        }));
    const freeSpendCards = ["tokens", "points"].map((currency) => ({
        to: { name: "spend", params: { currency } },
        description: "Dépense de " + tr(currency),
        currency,
        copies: 9,
    }));
    const all = articleCards.concat(freeSpendCards).map((c) => {
        const { href } = useLink({ to: c.to });
        c.url = location.origin + href.value;
        return c;
    });
    return all.map((c) => Array(c.copies).fill(c)).flat();
});
</script>

<template>
    <PrintableCards :items="cards">
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
