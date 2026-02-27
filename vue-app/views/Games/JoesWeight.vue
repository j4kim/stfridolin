<script setup>
import Layout from "@/components/Layout.vue";
import Button from "@/components/ui/button/Button.vue";
import Field from "@/components/ui/field/Field.vue";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { useGamesStore } from "@/stores/games";
import { onUnmounted, ref } from "vue";

const gamesStore = useGamesStore();

gamesStore.gameName = "joes-weight";

gamesStore.fetchGame();

onUnmounted(() => (gamesStore.gameName = null));

const guess = ref(null);
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">{{ gamesStore.game?.title }}</h2>

        <form class="space-y-4 px-4">
            <p class="text-sm">
                Tu l'as vu notre beau dauphin à facette ? Devine son poids. La
                personne la plus proche décroche le gros lot.
            </p>

            <Field>
                <Label>Ton pronostique :</Label>
                <div class="flex items-center justify-center gap-2">
                    <Input
                        type="number"
                        class="h-14 text-center text-xl"
                        v-model="guess"
                        required
                    />
                    grammes
                </div>
            </Field>

            <Button type="submit" size="lg" class="w-full">Valider</Button>
        </form>

        <Spinner v-if="gamesStore.fetching" class="m-4"></Spinner>
    </Layout>
</template>
