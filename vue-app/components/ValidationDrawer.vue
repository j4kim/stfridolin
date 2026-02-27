<script setup lang="ts">
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from "@/components/ui/drawer";
import Button from "./ui/button/Button.vue";
import { computed, ref } from "vue";
import Spinner from "./ui/spinner/Spinner.vue";
import { CircleStar } from "lucide-vue-next";
import { useArticlesStore } from "@/stores/articles";
import { useGuestStore } from "@/stores/guest";

const props = defineProps<{
    trigger: string;
    title: string;
    action: Function;
    articleName?: string;
    disabled?: boolean;
}>();

const open = ref(false);

const articlesStore = useArticlesStore();
const guestStore = useGuestStore();

const article = computed<any>(
    () => props.articleName && articlesStore.byName[props.articleName],
);

const guest = computed<any>(() => guestStore.guest);

const tooShort = computed(
    () => props.articleName && guest.value.tokens < article.value.price,
);

const loading = ref(false);

async function submit() {
    loading.value = true;
    try {
        await props.action();
        open.value = false;
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <Drawer v-model:open="open">
        <DrawerTrigger as-child>
            <Button :disabled> {{ trigger }} </Button>
        </DrawerTrigger>
        <DrawerContent>
            <DrawerHeader>
                <DrawerTitle>{{ title }}</DrawerTitle>
            </DrawerHeader>
            <div v-if="tooShort" class="px-4">
                <p>Vous n'avez pas assez de jetons 😬</p>
                <p>
                    <RouterLink
                        :to="{ name: 'buy-tokens' }"
                        class="text-primary underline underline-offset-4"
                    >
                        Acheter des jetons
                    </RouterLink>
                </p>
            </div>
            <DrawerFooter>
                <Button @click="submit" :disabled="loading || tooShort">
                    <Spinner v-if="loading" class="animate-spin" />
                    <slot name="validation">
                        <CircleStar v-if="!loading" />
                        Dépenser {{ article.price }} jetons
                    </slot>
                </Button>
                <DrawerClose as-child>
                    <Button variant="outline"> Annuler </Button>
                </DrawerClose>
            </DrawerFooter>
        </DrawerContent>
    </Drawer>
</template>
