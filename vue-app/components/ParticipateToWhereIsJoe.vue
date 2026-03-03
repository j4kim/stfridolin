<script setup>
import Button from "@/components/ui/button/Button.vue";
import { useGamesStore } from "@/stores/games";
import { computed } from "vue";
import ValidationDrawer from "./ValidationDrawer.vue";
import { toast } from "vue-sonner";
import { useRouter } from "vue-router";

const router = useRouter();

const gamesStore = useGamesStore();

const occurrences = computed(() => gamesStore.game?.occurrences || []);

const status = computed(() => occurrences.value[0]?.status);

const buttonText = computed(() => {
    if (status.value === "initial") {
        return "Trop tôt";
    }
    return gamesStore.guestParticipates ? "Tu participes" : "Participer";
});

async function participate() {
    const occId = occurrences.value[0].id;
    await gamesStore.participate(occId, null, "where-is-joe");
    toast.success("Yeah ! Bonne chance !");
    router.push({ name: "race-occurrence", params: { occId } });
}
</script>

<template>
    <div>
        <ValidationDrawer
            v-if="occurrences.length"
            articleName="where-is-joe"
            title="Participer à Où est Joe&nbsp;?"
            :action="participate"
        >
            <template #trigger>
                <Button
                    :disabled="
                        !['open', 'started'].includes(status) ||
                        gamesStore.guestParticipates
                    "
                    class="w-full"
                    v-text="buttonText"
                >
                </Button>
            </template>
        </ValidationDrawer>
    </div>
</template>
