<script setup>
import { api } from "@/api";
import PrintableCards from "@/components/PrintableCards.vue";
import QrCode from "@/components/QrCode.vue";
import { ref } from "vue";

const guests = ref([]);

api("guests.index")
    .get()
    .then((data) => (guests.value = data));
</script>

<template>
    <PrintableCards :items="guests">
        <template #item="guest">
            <h1 class="text-center text-xl font-bold">
                {{ guest.name }}
            </h1>
            <h2
                class="text-center font-mono text-xl tracking-widest opacity-50"
            >
                {{ guest.key }}
            </h2>
            <QrCode :value="guest.auth_url" class="mx-auto" :width="120" />
            <div
                class="text-center font-mono text-[6pt] opacity-50"
                style="word-break: break-word"
            >
                {{ guest.auth_url }}
            </div>
        </template>
    </PrintableCards>
</template>
