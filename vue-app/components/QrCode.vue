<script setup>
import { useQRCode } from "@vueuse/integrations/useQRCode";

const props = defineProps({
    value: String,
    width: {
        type: Number,
        default: 400,
    },
});

const qrcode = useQRCode(props.value, { width: props.width });
</script>

<template>
    <img :src="qrcode" />
</template>
