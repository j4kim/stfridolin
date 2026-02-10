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
                <template v-for="x in ['left', 'right']">
                    <template v-for="y in ['top', 'bottom']">
                        <template v-for="type in ['horizontal', 'vertical']">
                            <div
                                class="cut-line"
                                :data-x="x"
                                :data-y="y"
                                :data-type="type"
                            ></div>
                        </template>
                    </template>
                </template>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.card-container {
    --width: 55mm;
    --height: 85mm;
    --margin: 3mm;
    --p: 1mm;
    --s: 2mm;
    break-inside: avoid;
}
.card {
    width: var(--width);
    height: var(--height);
    margin: var(--margin);
    position: relative;
}
.cut-line {
    height: 0.1mm;
    width: 0.1mm;
    background-color: grey;
    position: absolute;

    &[data-type="vertical"] {
        height: var(--s);

        &[data-x="right"] {
            left: var(--width);
        }

        &[data-y="top"] {
            bottom: calc(var(--height) + var(--p));
        }

        &[data-y="bottom"] {
            bottom: calc(-1 * calc(var(--s) + var(--p)));
        }
    }

    &[data-type="horizontal"] {
        width: var(--s);

        &[data-x="left"] {
            left: calc(-1 * calc(var(--s) + var(--p)));
        }

        &[data-x="right"] {
            left: calc(var(--width) + var(--p));
        }

        &[data-y="top"] {
            bottom: calc(var(--height));
        }

        &[data-y="bottom"] {
            bottom: 0;
        }
    }
}
</style>
