<script setup>
import { api } from "@/api";
import QrCode from "@/components/QrCode.vue";
import { onMounted, ref } from "vue";

const guests = ref([]);

api("guests.index")
    .get()
    .then((data) => (guests.value = data));

onMounted(() => {
    document.documentElement.classList.remove("dark");
});

function guetAuthUrl(guest) {
    return `${location.origin}/guest/${guest.key}`;
}
</script>

<template>
    <div class="mx-auto flex max-w-md flex-col">
        <div v-for="guest in guests">
            <h1 class="mt-8 mb-4 text-center text-4xl">
                {{ guest.name }}
            </h1>
            <h2
                class="text-center font-mono text-3xl tracking-widest opacity-50"
            >
                {{ guest.key }}
            </h2>
            <QrCode :value="guetAuthUrl(guest)" class="mx-auto" />
            <div class="-mt-4 mb-8 text-center font-mono opacity-50">
                {{ guetAuthUrl(guest) }}
            </div>
        </div>
    </div>
</template>
