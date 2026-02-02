import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useArticlesStore = defineStore("articles", () => {
    const articles = ref(JSON.parse(document.body.dataset.articles));

    const tokenPackages = computed(() =>
        articles.value.filter((a) => a.type === "tokens-package"),
    );

    return {
        articles,
        tokenPackages,
    };
});
