<script setup>
import { api } from "@/api";
import QrCode from "@/components/QrCode.vue";
import { onMounted, ref } from "vue";

const vouchers = ref([]);

api("vouchers.index")
    .get()
    .then((data) => (vouchers.value = data));

onMounted(() => {
    document.documentElement.classList.remove("dark");
});

function getUrl(voucher) {
    return `${location.origin}/voucher/${voucher.id}`;
}
</script>

<template>
    <div class="flex flex-wrap">
        <div v-for="voucher in vouchers" class="card-container">
            <div class="card flex flex-col justify-center">
                <img class="mx-auto mb-[4mm] w-[10mm]" src="/favicon.svg" />
                <h1 class="text-center text-xl font-bold">
                    {{ voucher.article.description }}
                </h1>
                <h2 class="text-center text-xl opacity-50">
                    CHF {{ voucher.article.price }}
                </h2>
                <QrCode :value="getUrl(voucher)" :width="120" class="mx-auto" />
            </div>
            <template v-for="x in ['left', 'right']">
                <div
                    v-for="y in ['top', 'bottom']"
                    class="cut-line"
                    :style="{
                        [x]: 0,
                        [y]: 0,
                        [`border-${x}`]: 0,
                        [`border-${y}`]: 0,
                    }"
                ></div>
            </template>
        </div>
    </div>
</template>

<style scoped lang="scss">
.card-container {
    --width: 55mm;
    --height: 85mm;
    --margin: 3mm;
    break-inside: avoid;
    position: relative;
}
.card {
    width: var(--width);
    height: var(--height);
    margin: var(--margin);
}
.cut-line {
    height: var(--margin);
    width: var(--margin);
    border: 1px dashed grey;
    position: absolute;
}
</style>
