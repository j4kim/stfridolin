<script setup>
import Layout from "@/components/Layout.vue";
import { QrcodeStream } from "vue-qrcode-reader";
import { toast } from "vue-sonner";
import { route } from "../../../vendor/tightenco/ziggy";

function onDetect(detectedCodes) {
    const rawValue = detectedCodes[0].rawValue;
    const redirectUrl = route("qr-redirect", { rawValue });
    location.assign(redirectUrl);
}

function onError(err) {
    const descriptions = {
        NotAllowedError: "you need to grant camera access permission",
        NotFoundError: "no camera on this device",
        NotSupportedError: "secure context required (HTTPS, localhost)",
        NotReadableError: "is the camera already in use?",
        OverconstrainedError: "installed cameras are not suitable",
        StreamApiNotSupportedError:
            "Stream API is not supported in this browser",
        InsecureContextError:
            "Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.",
    };
    const description = descriptions[err.name] ?? err.message;
    const title = err.name ?? "Qr code stream error";
    toast.error(title, { description });
}
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Scan</h2>
        <div class="px-4">
            <QrcodeStream @detect="onDetect" @error="onError"></QrcodeStream>
        </div>
    </Layout>
</template>
