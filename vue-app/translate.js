import { CircleStar, Gift } from "lucide-vue-next";

export const translations = document.body.dataset.translations;

export function tr(key) {
    return translations[key] ?? key;
}

export const icons = {
    points: Gift,
    tokens: CircleStar,
};

export function icon(key) {
    return icons[key];
}
