<script setup>
import titleSvg from "@/title.svg";

const footerLinks = [
    {
        page: "legal",
        text: "Mentions légales",
    },
    {
        page: "conditions",
        text: "Conditions générales",
    },
    {
        page: "remboursement",
        text: "Politique de remboursement",
    },
    {
        page: "confidentialite",
        text: "Politique de confidentialité",
    },
    {
        page: "disclaimer",
        text: "Disclaimer jeu",
    },
];
</script>

<template>
    <div class="mx-auto max-w-xl p-8">
        <RouterLink :to="{ name: 'home' }">
            <img class="mx-auto my-12 w-sm hover:opacity-80" :src="titleSvg" />
        </RouterLink>
        <slot></slot>
        <footer class="prose dark:prose-invert mt-20">
            <hr />
            <p>© 2026 Association Salut Zamme</p>
            <p>contact@estellezamme.com</p>
            <ul>
                <li v-for="{ page, text } in footerLinks">
                    <RouterLink :to="{ name: 'page', params: { page } }">
                        {{ text }}
                    </RouterLink>
                </li>
            </ul>
        </footer>
    </div>
</template>
