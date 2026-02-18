<script setup>
import PublicLayout from "@/components/PublicLayout.vue";
import Button from "@/components/ui/button/Button.vue";
</script>

<template>
    <PublicLayout>
        <div class="prose lg:prose-lg dark:prose-invert text-white">
            <p>
                Bienvenue sur la page officielle du PMU de soutien de la
                Saint-Fridolin, qui aura lieu le 6 mars 2026 au Bikini Test. Une
                soirée au profit d'Estelle Zamme agrémentée de plein de jeux de
                pari rigolos. Votre participation contribuera aux activités
                artistiques du collectif, notamment à financer la tournée 2026
                et les prochaines sorties musicales.
            </p>
            <p>
                Vous pouvez valider votre inscription en cliquant sur le bouton
                ci-dessous pour payer les frais de 30 CHF par personne.
            </p>
            <p>
                <RouterLink :to="{ name: 'registration-payment' }">
                    <Button class="w-full" size="lg"> Inscription </Button>
                </RouterLink>
            </p>
        </div>
    </PublicLayout>
</template>
