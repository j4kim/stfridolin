<script setup>
import Layout from "@/components/Layout.vue";
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert";
import Button from "@/components/ui/button/Button.vue";
import Field from "@/components/ui/field/Field.vue";
import Input from "@/components/ui/input/Input.vue";
import Label from "@/components/ui/label/Label.vue";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import ValidationDrawer from "@/components/ValidationDrawer.vue";
import { useGamesStore } from "@/stores/games";
import { useGuestStore } from "@/stores/guest";
import { CheckCircle2Icon } from "lucide-vue-next";
import { computed, onUnmounted, ref } from "vue";
import { toast } from "vue-sonner";

const gamesStore = useGamesStore();
const guestStore = useGuestStore();

const articleName = "guess-joes-weight";

gamesStore.gameName = "joes-weight";

onUnmounted(() => (gamesStore.gameName = null));

gamesStore.fetchGame();

const occurrence = computed(() => gamesStore.game?.occurrences[0]);

const isfinished = computed(() =>
    ["finished", "cancelled"].includes(occurrence.value?.status),
);

const existingBets = computed(() => {
    return guestStore.movements.filter(
        (m) => m.occurrence_id === occurrence.value?.id,
    );
});

const grams = ref(null);
const submitting = ref(false);

const alreadyTried = computed(() => {
    return existingBets.value.some((b) => b.meta.prediction == grams.value);
});

async function submit() {
    if (alreadyTried.value) {
        return toast.error("Tu as déjà placé ce pari");
    }
    if (grams.value < 1) {
        return toast.error("Entre un nombre positif");
    }
    const meta = { prediction: grams.value };
    submitting.value = true;
    const result = await gamesStore
        .participate(occurrence.value, meta, articleName)
        .finally(() => (submitting.value = false));
    grams.value = null;
    toast.success(result.message);
}
</script>

<template>
    <Layout>
        <h2 class="my-2 space-x-1 px-4 font-bold">
            {{ gamesStore.game?.title }}
        </h2>

        <div class="mb-12 space-y-6 px-4">
            <p class="text-sm">
                Tu l'as vu notre beau dauphin à facette ? Devine son poids. La
                personne la plus proche décroche le gros lot.
            </p>

            <Alert v-if="existingBets.length">
                <CheckCircle2Icon />
                <AlertTitle v-if="existingBets.length === 1">
                    Ta prédiction
                </AlertTitle>
                <AlertTitle v-else>Tes prédictions</AlertTitle>
                <div class="prose prose-invert col-start-2">
                    <ul>
                        <li v-for="bet in existingBets">
                            {{ bet.meta.prediction / 1000 }} kg
                        </li>
                    </ul>
                </div>
                <AlertDescription>
                    Tu peux placer d'autres paris dans une limite de 10.
                </AlertDescription>
            </Alert>

            <template v-if="!isFinished && existingBets.length < 10">
                <Field>
                    <Label>Ta prédiction :</Label>
                    <div class="flex items-center justify-center gap-2">
                        <Input
                            type="number"
                            class="h-10 text-center text-lg"
                            v-model="grams"
                            required
                            min="1"
                            step="1"
                        />
                        grammes
                    </div>
                </Field>

                <ValidationDrawer
                    :title="`Valider ${grams / 1000} kg&nbsp;?`"
                    :action="submit"
                    :articleName
                >
                    <template #trigger>
                        <Button
                            :disabled="submitting || !occurrence"
                            size="lg"
                            class="w-full"
                        >
                            Placer le pari
                        </Button>
                    </template>
                </ValidationDrawer>
            </template>
        </div>

        <Spinner v-if="gamesStore.fetching" class="m-4"></Spinner>
    </Layout>
</template>
