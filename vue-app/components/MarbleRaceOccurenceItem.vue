<script setup>
import Button from "@/components/ui/button/Button.vue";
import {
    Item,
    ItemActions,
    ItemContent,
    ItemDescription,
    ItemTitle,
} from "@/components/ui/item";
import dayjs from "dayjs";
import { computed } from "vue";
import { useRouter } from "vue-router";

const props = defineProps({
    occ: Object,
});

const router = useRouter();

const startAt = computed(() => dayjs(props.occ.start_at).format("HH:mm"));

const betsOpenAt = computed(() =>
    dayjs(props.occ.start_at).subtract(30, "minutes").format("HH:mm"),
);

function goToOcc() {
    router.push({
        name: "marble-race-occurrence",
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
                    Départ à {{ startAt }}<br />
                    Ouverture des paris à {{ betsOpenAt }}
                </ItemDescription>
            </div>
        </ItemContent>
        <ItemActions>
            <Button v-if="occ.status === 'open'" @click="goToOcc">
                Parier
            </Button>
            <Button v-else-if="occ.status === 'closed'" @click="goToOcc">
                Voir les résultats
            </Button>
            <Button v-else disabled> Trop tôt </Button>
        </ItemActions>
    </Item>
</template>
