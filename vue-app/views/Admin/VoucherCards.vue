<script setup>
import { api } from "@/api";
import PrintableCards from "@/components/PrintableCards.vue";
import QrCode from "@/components/QrCode.vue";
import { icon } from "@/translate";
import { ref } from "vue";

const vouchers = ref([]);

api("vouchers.index")
    .get()
    .then((data) => (vouchers.value = data));
</script>

<template>
    <PrintableCards :items="vouchers">
        <template #item="voucher">
            <div class="mx-auto">
                <component
                    v-if="voucher.article.meta?.type"
                    :is="icon(voucher.article.meta.type)"
                />
            </div>
            <h1 class="text-center text-xl font-bold">
                {{ voucher.article.description }}
            </h1>
            <h2
                class="text-center text-xl opacity-50"
                v-if="voucher.article.price"
            >
                CHF {{ voucher.article.price }}
            </h2>
            <QrCode :value="voucher.url" :width="120" class="mx-auto" />
            <div class="text-center font-mono text-[7pt] opacity-50">
                {{ voucher.id }}
            </div>
            <div class="text-center text-[7pt] opacity-50">
                (Code à usage unique)
            </div>
        </template>
    </PrintableCards>
</template>
