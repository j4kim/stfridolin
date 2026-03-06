<script setup>
import Textarea from "@/components/ui/textarea/Textarea.vue";
import { useQRCode } from "@vueuse/integrations/useQRCode";
import { shallowRef } from "vue";

const text = shallowRef("text-to-encode");
const qrcode = useQRCode(text, { width: 400 });
</script>

<template>
    <div class="p-4">
        <Textarea v-model="text" class="mb-4"></Textarea>
        <img :src="qrcode" alt="QR Code" />
    </div>
</template>
