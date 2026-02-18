<script setup>
import SvgTitle from "./SvgTitle.vue";

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
        <RouterLink
            :to="{ name: 'home' }"
            class="mx-auto my-12 block max-w-sm hover:opacity-80"
        >
            <SvgTitle />
        </RouterLink>
        <slot></slot>
        <footer class="prose dark:prose-invert prose-sm mt-24">
            <hr />
            <p>© 2026 Association Salut Zamme</p>
            <p>contact@estellezamme.com</p>
            <ul>
                <li v-for="{ page, text } in footerLinks">
                    <RouterLink
                        :to="{ name: 'page', params: { page } }"
                        active-class="no-underline text-white"
                        class="text-inherit"
                    >
                        {{ text }}
                    </RouterLink>
                </li>
            </ul>
        </footer>
    </div>
</template>
