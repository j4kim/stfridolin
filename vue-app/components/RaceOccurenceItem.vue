<script setup>
import Button from "@/components/ui/button/Button.vue";
import {
    Item,
    ItemActions,
    ItemContent,
    ItemDescription,
    ItemTitle,
} from "@/components/ui/item";
import { useRouter } from "vue-router";
import { computed } from "vue";
import { useMainStore } from "@/stores/main";

const props = defineProps({
    occ: Object,
    showBetsOpenAt: {
        type: Boolean,
        default: true,
    },
});

const router = useRouter();

const mainStore = useMainStore();

const disabled = computed(
    () =>
        !mainStore.user && ["initial", "cancelled"].includes(props.occ.status),
);
const buttonText = computed(() => {
    return (
        {
            initial: "Trop tôt",
            open: "Parier",
            started: "En cours",
            ranked: "Voir les résultats",
            cancelled: "Annulé",
        }[props.occ.status] || "Voir"
    );
});

function goToOcc() {
    router.push({
        name: "race-occurrence",
        params: { occId: props.occ.id },
    });
}
</script>

<template>
    <Item>
        <ItemContent>
            <div>
                <ItemTitle>{{ occ.title }}</ItemTitle>
                <ItemDescription>
                    <div>Départ à {{ occ.start_at_time }}</div>
                    <div v-if="showBetsOpenAt">
                        Ouverture des paris à {{ occ.bets_open_at_time }}
                    </div>
                </ItemDescription>
            </div>
        </ItemContent>
        <ItemActions>
            <slot name="actions" v-bind="{ goToOcc, disabled, buttonText }">
                <Button :disabled @click="goToOcc">
                    {{ buttonText }}
                </Button>
            </slot>
        </ItemActions>
    </Item>
</template>
