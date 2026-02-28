<script setup>
import Layout from "@/components/Layout.vue";
import Button from "@/components/ui/button/Button.vue";
import Field from "@/components/ui/field/Field.vue";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import { useGamesStore } from "@/stores/games";
import { onUnmounted, ref } from "vue";

const gamesStore = useGamesStore();

gamesStore.gameName = "joes-weight";

gamesStore.fetchGame();

onUnmounted(() => (gamesStore.gameName = null));

const grams = ref(null);
const submitting = ref(false);

async function submit() {
    console.log(grams.value);
}
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4">{{ gamesStore.game?.title }}</h2>

        <form class="space-y-6 px-4">
            <p class="text-sm">
                Tu l'as vu notre beau dauphin à facette ? Devine son poids. La
                personne la plus proche décroche le gros lot.
            </p>

            <Field>
                <Label>Ton pronostique :</Label>
                <div class="flex items-center justify-center gap-2">
                    <Input
                        type="number"
                        class="h-10 text-center text-lg"
                        v-model="grams"
                        required
                    />
                    grammes
                </div>
            </Field>

            <ValidationDrawer
                :title="`Valider ${grams} g&nbsp;?`"
                :action="submit"
                articleName="guess-joes-weight"
            >
                <template #trigger>
                    <Button
                        :disabled="submitting || !grams"
                        size="lg"
                        class="w-full"
                    >
                        Placer le pari
                    </Button>
                </template>
            </ValidationDrawer>
        </form>

        <Spinner v-if="gamesStore.fetching" class="m-4"></Spinner>
    </Layout>
</template>
