<script setup lang="ts">
import {
    Drawer,
    DrawerClose,
    DrawerContent,
    DrawerDescription,
    DrawerFooter,
    DrawerHeader,
    DrawerTitle,
    DrawerTrigger,
} from "@/components/ui/drawer";
import Button from "./ui/button/Button.vue";
import { ref } from "vue";
import Spinner from "./ui/spinner/Spinner.vue";

const props = defineProps<{
    trigger: string;
    title: string;
    action: Function;
    submitBtn: string;
}>();

const open = ref(false);

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
            <Button> {{ trigger }} </Button>
        </DrawerTrigger>
        <DrawerContent>
            <DrawerHeader>
                <DrawerTitle>{{ title }}</DrawerTitle>
            </DrawerHeader>
            <DrawerFooter>
                <Button @click="submit" :disabled="loading">
                    <Spinner v-if="loading" class="animate-spin" />
                    {{ submitBtn }}
                </Button>
                <DrawerClose as-child>
                    <Button variant="outline"> Annuler </Button>
                </DrawerClose>
            </DrawerFooter>
        </DrawerContent>
    </Drawer>
</template>
