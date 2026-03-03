<script setup>
import { api } from "@/api";
import PrintableCards from "@/components/PrintableCards.vue";
import QrCode from "@/components/QrCode.vue";
import { useArticlesStore } from "@/stores/articles";
import { icon } from "@/translate";
import { computed, ref } from "vue";
import { useLink } from "vue-router";

const articlesStore = useArticlesStore();

const articles = computed(() => {
    return articlesStore.articles
        .filter((a) => a.type === "participation")
        .filter((a) => a.meta?.qrcodes)
        .map((a) => {
            const link = useLink({
                to: {
                    name: "spend",
                    params: { currency: "tokens" },
                    query: { article: a.name },
                },
            });
            a.spendUrl = location.origin + link.href.value;
            return a;
        });
});
</script>

<template>
    <PrintableCards :items="articles">
        <template #item="article">
            <h1 class="text text-center font-bold">
                {{ article.description }}
            </h1>
            <h2
                class="mt-2 flex items-center justify-center gap-1 text-xl opacity-50"
                v-if="article.price"
            >
                <component
                    v-if="article.currency"
                    :is="icon(article.currency)"
                    class=""
                />
                -{{ article.price }} jetons
            </h2>
            <QrCode :value="article.spendUrl" class="mx-auto" :width="120" />
        </template>
    </PrintableCards>
</template>
