<script setup>
import { api } from "@/api";
import Layout from "@/components/Layout.vue";
import { Button } from "@/components/ui/button";
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
} from "@/components/ui/card";
import Spinner from "@/components/ui/spinner/Spinner.vue";
import { CircleStar } from "lucide-vue-next";
import { ref } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const voucher = ref(null);
const loading = ref(true);

api("vouchers.get")
    .params(route.params.id)
    .get()
    .then((data) => (voucher.value = data))
    .finally(() => (loading.value = false));
</script>

<template>
    <Layout>
        <h2 class="my-2 px-4 font-bold">Carte prépayée</h2>
        <div class="px-4">
            <Spinner v-if="loading"></Spinner>
            <Card v-else-if="voucher?.article">
                <CardHeader>
                    <div class="flex items-center gap-1">
                        {{ voucher.article.description }}
                        <CircleStar size="18" />
                    </div>
                    <div>
                        <span class="text-2xl font-bold">{{
                            voucher.article.price
                        }}</span>
                        <span class="text-xs"> CHF</span>
                    </div>
                </CardHeader>
                <CardFooter>
                    <Button v-if="!voucher.guest_id" size="lg" class="w-full">
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
