<script setup>
import Button from "@/components/ui/button/Button.vue";
import { useGamesStore } from "@/stores/games";
import { computed } from "vue";
import ValidationDrawer from "./ValidationDrawer.vue";
import { toast } from "vue-sonner";

const gamesStore = useGamesStore();

const occurrences = computed(() => gamesStore.game?.occurrences || []);

async function participate() {
    await gamesStore.participate(occurrences.value[0].id, null, "where-is-joe");
    toast.success("Yeah ! Bonne chance !");
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
                <Button :disabled="gamesStore.guestParticipates" class="w-full">
                    {{
                        gamesStore.guestParticipates
                            ? "Tu participes"
                            : "Participer"
                    }}
                </Button>
            </template>
        </ValidationDrawer>
    </div>
</template>
