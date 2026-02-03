import { defineStore } from "pinia";
import { computed, ref } from "vue";
import { groupBy, keyBy } from "lodash-es";

export const useArticlesStore = defineStore("articles", () => {
    const articles = ref(JSON.parse(document.body.dataset.articles));

    const grouped = computed(() => groupBy(articles.value, "type"));
    const byName = computed(() => keyBy(articles.value, "name"));
    const byId = computed(() => keyBy(articles.value, "id"));
    const tokenPackages = computed(() => grouped.value["tokens-package"]);

    return {
        articles,
        grouped,
        byName,
        byId,
        tokenPackages,
    };
});
