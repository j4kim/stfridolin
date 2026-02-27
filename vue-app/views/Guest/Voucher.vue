<script setup>
import { api } from "@/api";
import Layout from "@/components/Layout.vue";
import { Button } from "@/components/ui/button";
import { Card, CardFooter, CardHeader } from "@/components/ui/card";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { icon } from "@/translate";
import { computed, ref } from "vue";
import { useRoute } from "vue-router";
import { toast } from "vue-sonner";
import { startCase } from "lodash-es";

const route = useRoute();

const voucher = ref(null);
const loading = ref(true);
const submitting = ref(false);

const currency = computed(
    () =>
        ({
            "points-credit": "points",
            "tokens-package": "tokens",
        })[voucher.value?.article.type],
);

const heading = computed(
    () =>
        ({
            tokens: "Carte prépayée",
            points: "Bon cadeau",
        })[currency.value] ?? "Bon",
);

api("vouchers.get")
    .params(route.params.id)
    .get()
    .then((data) => (voucher.value = data))
    .finally(() => (loading.value = false));

async function submit() {
    submitting.value = true;
    try {
        voucher.value = await api("vouchers.use")
            .params(route.params.id)
            .post();
        toast.success(startCase(currency.value) + " ajoutés");
    } finally {
        submitting.value = false;
    }
}
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">{{ heading }}</h2>
        <div class="px-4">
            <Spinner v-if="loading"></Spinner>
            <Card v-else-if="voucher?.article">
                <CardHeader>
                    <div class="flex items-center gap-1">
                        {{ voucher.article.description }}
                        <component :is="icon(currency)" size="18" />
                    </div>
                    <div v-if="voucher.article.price">
                        <span class="text-2xl font-bold">{{
                            voucher.article.price
                        }}</span>
                        <span class="text-xs"> CHF</span>
                    </div>
                </CardHeader>
                <CardFooter>
                    <Button
                        v-if="!voucher.guest_id"
                        size="lg"
                        class="w-full"
                        :disabled="submitting"
                        @click="submit"
                    >
                        <Spinner v-if="submitting"></Spinner>
                        Utiliser
                    </Button>
                    <Button v-else size="lg" class="w-full" disabled>
                        Cette carte a déjà été utilisée
                    </Button>
                </CardFooter>
            </Card>
        </div>
    </Layout>
</template>
